<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ingreso de Compra de Materia Prima</title>
    <meta charset="utf-8">
    <link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="scripts/validar.js"></script>
    <script type="text/javascript" src="scripts/block.js"></script>
    <script type="text/javascript">
		document.onkeypress = stopRKey; 
	</script>
</head>
<body> 
<div align="center"><img src="images/LogoNova.JPG"/></div>
<?php
include "includes/conect.php";
include "includes/calcularDias.php";
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
} 
$fecha_actual=date("Y")."-".date("m")."-".date("d"); 
$dias_v=Calc_Dias($FchVen,$fecha_actual);
$dias_f=Calc_Dias($FchVen,$FchVta);
if(($dias_v>=0)&&($dias_f>=0))
{
	$link=conectarServidor();   
	/*CREACIÓN DEL ENCABEZADO DE LA REMISIÓN*/
	$qryr="insert into remision (Nit_cliente, Fech_remision, Id_pedido, Id_sucurs) values ('$nit','$FchVta', $pedido, $id_sucursal)";
	$resultr=mysqli_query($link,$qryr);
	$qrylot="select max(Id_remision) as rem from remision";
	$resultlot=mysqli_query($link,$qrylot);
	$rowlot=mysqli_fetch_array($resultlot);
	$Id_Rem=$rowlot['rem'];		
	/*CREACIÓN DEL ENCABEZADO DE LA FACTURA*/
	$qry="insert into factura (Factura, Nit_cliente, Fech_fact, Fech_venc, tip_precio, Ord_compra, Id_pedido, Descuento, Estado, Id_remision, Observaciones) values ($factura, '$nit','$FchVta','$FchVen', $tip_prec, $ord_comp, $pedido, $descuento/100, 'E', $Id_Rem, '$observa')";
	$result=mysqli_query($link,$qry);
	//CON BASE EN EL PEDIDO SE LLENA LA FACTURA
	$qryped="select Id_ped, Cod_producto as Producto, Can_producto as Cantidad, Prec_producto as Precio, tasa 
	from det_pedido, prodpre, tasa_iva 
	where Id_ped=$pedido AND Cod_producto=Cod_prese AND Cod_iva=Id_tasa and Cod_producto<100000
	UNION
	select Id_ped, Cod_producto as Producto, Can_producto as Cantidad, Prec_producto as Precio, tasa 
	FROM det_pedido, distribucion, tasa_iva 
	where Id_ped=$pedido and Cod_producto>=100000 and Cod_producto=distribucion.Id_distribucion 
	and Cod_iva=Id_tasa
	union
select Id_ped, Cod_producto as Producto, Can_producto as Cantidad, Prec_producto as Precio, tasa 
 from det_pedido, servicios, tasa_iva 
 where Cod_producto<100 and Cod_producto=IdServicio and Cod_iva=Id_tasa and Id_ped=$pedido;";
	$resultped=mysqli_query($link,$qryped);
	while($rowped=mysqli_fetch_array($resultped))
	{
		$cod_producto=$rowped['Producto'];
		$cantidad=$rowped['Cantidad'];	
		$precio=round(($rowped['Precio']/(1+$rowped['tasa'])),0);
		/*DESCARGA DEL INVENTARIO*/
		$unidades=$cantidad;
		$i=1;
		if(($cod_producto<100000)&&($cod_producto>100))
		{
			$qryinv="select Cod_prese, lote_prod, inv_prod from inv_prod where Cod_prese=$cod_producto and inv_prod >0 order by lote_prod;";
			$resultinv=mysqli_query($link,$qryinv);
			while(($rowinv=mysqli_fetch_array($resultinv))&&($unidades>0))
			{
				  $invt=$rowinv['inv_prod'];
				  $i=$i+1;
				  $lot_prod=$rowinv['lote_prod'];
				  $cod_prod=$rowinv['Cod_prese'];
				  if (($invt >= $unidades))
				  {
					  $invt= $invt - $unidades;
					  /*SE ADICIONA A LA REMISIÓN*/
					  $qryins_p="insert into det_remision (Id_remision, Cod_producto, Can_producto, Lote_producto) values ($Id_Rem, $cod_producto, $unidades, $lot_prod)";
					  echo $qryins_p."<br>";				
					  $resultins_p=mysqli_query($link,$qryins_p);
					  /*SE ACTUALIZA EL INVENTARIO*/
					  $qryupt="update inv_prod set inv_prod=$invt where lote_prod=$lot_prod and Cod_prese=$cod_prod";
					  $resultupt=mysqli_query($link,$qryupt);
					  $unidades=0;
				  }
				  else
				  {
					  $unidades= $unidades - $invt ;
					  /*SE ADICIONA A LA REMISIÓN*/
					  $qryins_p="insert into det_remision (Id_remision, Cod_producto, Can_producto, Lote_producto) values ($Id_Rem, $cod_producto, $invt, $lot_prod)";
					  $resultins_p=mysqli_query($link,$qryins_p);
					  /*SE ACTUALIZA EL INVENTARIO*/
					  $qryupt="update inv_prod set inv_prod=0 where lote_prod=$lot_prod and Cod_prese=$cod_prod";
					  $resultupt=mysqli_query($link,$qryupt);	
				  }
			}
		}
		if($cod_producto>100000)
		{
			$qryinv="select Id_distribucion, inv_dist from inv_distribucion WHERE Id_distribucion=$cod_producto;";
			$resultinv=mysqli_query($link,$qryinv);
			$unidades=$cantidad;
			while($rowinv=mysqli_fetch_array($resultinv))
			{
				$invt=$rowinv['inv_dist'];
				$cod_prod=$rowinv['Id_distribucion'];
				$invt= $invt - $unidades;
				$qryupt="update inv_distribucion set inv_dist=$invt where Id_distribucion=$cod_prod";
				$resultupt=mysqli_query($link,$qryupt);
				/*SE ADICIONA A LA REMISIÓN*/
				$qryins_p="insert into det_remision (Id_remision, Cod_producto, Can_producto) values ($Id_Rem, $cod_producto, $unidades)";
				echo $qryins_p;
				$resultins_p=mysqli_query($link,$qryins_p);
			}
		}
		if($cod_producto<100)
		{
		  /*SE ADICIONA A LA REMISIÓN*/
		  $qryins_p="insert into det_remision (Id_remision, Cod_producto, Can_producto) values ($Id_Rem, $cod_producto, $unidades)";
		  $resultins_p=mysqli_query($link,$qryins_p);			
		}
		/*SE ADICIONA A LA FACTURA*/
		$qrydet="insert into det_factura (Id_fact, Cod_producto, Can_producto, prec_producto) values ($factura, $cod_producto, $cantidad, $precio);";
		$resultdet=mysqli_query($link,$qrydet);
	}
	
	//CALCULA LOS TOTALES DE IVA, DESCUENTO 
	
		$qry="select Factura, Cod_producto, Can_producto, Nombre as Producto, tasa, Id_tasa, prec_producto, Descuento, Ciudad_clien, Id_cat_clien 
		from det_factura, prodpre, tasa_iva, factura, clientes
		where Factura=Id_fact and Factura=$factura and Cod_producto<100000 and Cod_producto=Cod_prese and Cod_iva=Id_tasa  and clientes.Nit_clien=factura.Nit_cliente 
		UNION 
		select Factura, Cod_producto, Can_producto, Producto, tasa, Id_tasa, prec_producto, Descuento, Ciudad_clien, Id_cat_clien 
		from det_factura, distribucion, tasa_iva, factura, clientes 
		where Factura=Id_fact and Factura=$factura and Cod_producto>100000 AND Cod_producto=Id_distribucion AND Cod_iva=Id_tasa  and clientes.Nit_clien=factura.Nit_cliente;";
		$result=mysqli_query($link,$qry);
		$subtotal=0;
		$descuento=0;
		$iva10=0;
		$iva16=0;
		while($row=mysqli_fetch_array($result))
		{
			$subtotal += $row['Can_producto']*$row['prec_producto'];
			$codigo=$row['Cod_producto'];
			$descuento += $row['Can_producto']*$row['prec_producto']*$row['Descuento'] ;
			if ($row['tasa']==0.1)
				$iva10 += $row['Can_producto']*$row['prec_producto']*$row['tasa']*(1-$row['Descuento']);
			if ($row['Id_tasa']==3)
				$iva16 += $row['Can_producto']*$row['prec_producto']*$row['tasa']*(1-$row['Descuento']);
		}
		$qryf="select Factura, Nit_cliente, Nom_clien, Ret_iva, Ret_ica, Ret_fte, Ciudad_clien, Id_cat_clien from factura, clientes where Factura=$factura and Nit_cliente=Nit_clien ;";
		echo $qryf;
		$resultf=mysqli_query($link,$qryf);
		$rowf=mysqli_fetch_array($resultf);
		$Ciudad_clien=$rowf['Ciudad_clien'];
		$Id_cat_clien=$rowf['Id_cat_clien'];
		$reten_iva=$rowf['Ret_iva'];
		$reten_ica=$rowf['Ret_ica'];
		$reten_fte=$rowf['Ret_fte'];
		if ($reten_iva==1)
			$reteiva=round(($iva10 + $iva16)*0.15);
		else
			$reteiva=0;
		if (($subtotal >= BASE_C)||($reten_fte==1))
		{
			$retefuente=round(($subtotal-$descuento)*0.025);
			if (($Ciudad_clien==1)&&($Id_cat_clien!=1))
			$reteica=round(($subtotal-$descuento)*0.01104);
			else
			$reteica=0;
		}
		else
		{
			$retefuente=0;
			$reteica=0;
		}
	$total= $subtotal-$descuento+$iva10+$iva16;
		$sql="update factura 
			SET Total=round($total),
			Subtotal=round($subtotal),
			IVA=round($iva10 + $iva16),
			Reten_iva=round($reteiva),
			Reten_ica=round($reteica),
			Reten_fte=round($retefuente)
			where Factura=$factura;";	
	    echo $sql;
		$result=mysqli_query($link,$sql);
		if($result)
		{  
			$sqlup="update Pedido SET Estado='F' where Id_pedido=(select Id_pedido from factura where Factura=$factura);";
			$resultup=mysqli_query($link,$sqlup);
		}
		else
		{
			$ruta="menu.php";
			mysqli_close($link);
			mover_pag($ruta,"Error al crear la Factura");
		}
		mysqli_close($link);
		echo'<form action="det_factura.php" method="post" name="formulario">';
		echo '<input name="factura" type="hidden" value="'.$factura.'"/><input name="Crear" type="hidden" value="6"/><input type="submit" name="Submit" value="Cambiar" />';
		echo'</form>'; 
		echo' <script > document.formulario.submit(); </script>';		
}
else
{
  if($dias_v<0)
	{
		echo'<script >
		alert("La fecha de vencimiento de la factura no puede ser menor que la fecha actual");
		self.location="crearFactura.php";
		</script>';	
	}
  if($dias_f<0)
	{
		echo'<script >
		alert("La fecha de vencimiento de la factura no puede ser menor que la fecha de la factura");
		self.location="crearFactura.php";
		</script>';	
	}
}
function mover_pag($ruta,$Mensaje)
{
echo'<script >
   alert("'.$Mensaje.'")
   self.location="'.$ruta.'"
   </script>';
}
?>
</body>
</html>
