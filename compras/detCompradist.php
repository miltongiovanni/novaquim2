<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Ingreso de Compra de Productos de Distribuci&oacute;n</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="scripts/validar.js"></script>
	<script  src="scripts/block.js"></script>
    	<script >
	document.onkeypress = stopRKey; 
	</script>

</head>
<body> 
<div id="contenedor">
<div id="saludo1"><strong>DETALLE COMPRA DE DISTRIBUCI&Oacute;N</strong></div>
<?php
include "includes/conect.php";
include "includes/calcularDias.php";
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
if($CrearFactura!=0)
{
  $link=conectarServidor();
  $qrys="select estadoCompra from compras where idCompra=$Factura";
  $results=mysqli_query($link,$qrys);
  $rows=mysqli_fetch_array($results);
  $estadoc=$rows['estado'];
  mysqli_close($link);
}
if($CrearFactura==2)
{
$link=conectarServidor();
$qryup="update compras set nit_prov='$nit_prov', numFact=$num_fac, fechComp='$FchFactura', fechVenc='$VenFactura' where idCompra=$Factura;";
$resultup=mysqli_query($link,$qryup);
mysqli_close($link);
}
if($CrearFactura==0)
{ 
   //VALIDA QUE LA FACTURA NO HAYA SIDO INGRESADA ANTES
	$link=conectarServidor();   
	$qrybus="Select * from compras WHERE nit_prov='$nit_prov' AND numFact=$num_fac;";
	$resultqrybus=mysqli_query($link,$qrybus);
	if ($row_bus=mysqli_fetch_array($resultqrybus))
	{
		$Factura=$row_bus['Id_compra'];
		echo '<form method="post" action="detCompramp.php" name="form3">';
		echo'<input name="CrearFactura" type="hidden" value="5">'; 
		echo'<input name="Factura" type="hidden" value="'.$Factura.'">'; 
		echo '</form>';
		echo' <script  >
			alert("Factura ingresada anteriormente");
			document.formulario.submit();
			</script>'; 
		mysqli_close($link);
	}
	else
	{
	   	$fecha_actual=date("Y")."-".date("m")."-".date("d"); 
		$dias_v=Calc_Dias($FchFactura,$fecha_actual);
		echo "dias_v".$dias_v;
		$dias_f=Calc_Dias($VenFactura,$FchFactura);
		echo "dias_f".$dias_f;
		if(($dias_v>=-8)&&($dias_v<=0)&&($dias_f>=0))
		{		  
		   $est=2;  
		   /*validacion del valor a pagar"*/
		   $qryFact="insert into compras (nit_prov, numFact, fechComp, fechVenc, estadoCompra, tipoCompra)
		   values  ('$nit_prov', $num_fac, '$FchFactura','$VenFactura',$est, 5)";
		   if($resultfact=mysqli_query($link,$qryFact))
		   {
				$qry="select max(idCompra) as Fact from compras";
				$result=mysqli_query($link,$qry);
				$row=mysqli_fetch_array($result);
				$Factura=$row['Fact'];		
				echo '<form method="post" action="detCompradist.php" name="form3">';
				echo'<input name="CrearFactura" type="hidden" value="5">'; 
				echo'<input name="Factura" type="hidden" value="'.$Factura.'">'; 
				echo '</form>';
				echo'<script  >
					document.form3.submit();
					</script>';	
			}
			else
			{
				mover_pag("compradist.php","Error al ingresar la factura de compra");
			}
			mysqli_close($link);
		}
		else
		{
			if($dias_v>0)
			{
				//echo $dias;
				echo'<script  >
				alert("La fecha de factura de la compra no puede ser de una fecha futura");
				self.location="compradist.php";
				</script>';	
			}
			if($dias_v<-8)
			{
				echo $dias;
				echo'<script  >
				alert("La fecha de factura de la compra no puede ser menor de 8 días de la fecha actual");
				self.location="compradist.php";
				</script>';	
			}
			if($dias_f<0)
			{
				echo'<script  >
				alert("La fecha de vencimiento de la compra no puede ser menor que la de la fecha de compra");
				self.location="compradist.php";
				</script>';	
			}
			
		}
	}
}
function mover_pag($ruta,$nota)
{	
	//Funcion que permite el redireccionamiento de los usuarios a otra pagina 
	echo' <script >
	alert("'.$nota.'")
	self.location="'.$ruta.'"
	</script>';
}
if($CrearFactura==1)
{
 	//echo "ADICIONANDO EL DETALLE DE LA FACTURA";
	$link=conectarServidor();   
	$qrybus="select * from det_compras where idCompra=$Factura AND Codigo=$cod_dist;";
	$resultqrybus=mysqli_query($link,$qrybus);
	$row_bus=mysqli_fetch_array($resultqrybus);
	if ($row_bus['Codigo']==$cod_dist)
	{
		echo' <script  >
			alert("Producto incluido anteriormente");
			document.formulario.submit();
			</script>'; 
		mysqli_close($link);
	}
	else
	{ 
		//SE ACTUALIZA LA TABLA DE INVENTARIOS Y EL PRECIO 
		$qryinv="select codDistribucion, invDistribucion from inv_distribucion where codDistribucion=$cod_dist";
		$resultinv=mysqli_query($link,$qryinv);
		
		
		
		$qryprec="select Id_distribucion, Producto, precio_vta, precio_com from distribucion where Id_distribucion=$cod_dist";
		$resultprec=mysqli_query($link,$qryprec);
		$rowprec=mysqli_fetch_array($resultprec);
		$prec_com=$rowprec['precio_com']; // PRECIO DE COMPRA EN LA BASE DE DATOS
		//$prec_vta=$rowprec['precio_vta']; // PRECIO DE VENTA EN LA BASE DE DATOS
		//if($precio_dist > $prec_com)
			$prec_com=$precio_dist;
		if ($rowinv=mysqli_fetch_array($resultinv))
		{
			$inv=$rowinv['inv_dist'];
			$inv=$inv + $can_dist;
			$qryup="update inv_distribucion set invDistribucion=$inv where codDistribucion=$cod_dist";
			$resultup=mysqli_query($link,$qryup);
		}
		else
		{
			$qryins="insert into inv_distribucion (codDistribucion, invDistribucion) values ($cod_dist, $can_dist)";
			$resultup=mysqli_query($link,$qryins);
		}
		// ACTUALIZA EL PRECIO 
		$qryup2="update distribucion set precio_com=$prec_com where Id_distribucion=$cod_dist";
		//echo $qryup2;
		$resultup2=mysqli_query($link,$qryup2);  
		$qryFact="insert into det_compras (idCompra, Codigo, Cantidad, Precio) values  ($Factura, $cod_dist, $can_dist, $precio_dist)";
		$resultfact=mysqli_query($link,$qryFact);
		mysqli_close($link);
	}
	echo '<form method="post" action="detCompradist.php" name="form3">';
	echo'<input name="CrearFactura" type="hidden" value="5">'; 
	echo'<input name="Factura" type="hidden" value="'.$Factura.'">'; 
	echo '</form>';
	echo'<script  >
		document.form3.submit();
		</script>';			
} 
if($CrearFactura==5)
{	
	$link=conectarServidor();
	$qry="select sum(Cantidad*Precio) as Total, sum(Cantidad*Precio*tasa) as IVA, tasaRetIca
	from det_compras, distribucion, tasa_iva, compras, proveedores, tasa_reteica
	where det_compras.idCompra=$Factura AND Codigo=distribucion.Id_distribucion AND tasa_iva.Id_tasa=distribucion.Cod_iva and compras.idCompra=det_compras.idCompra and nit_prov=nitProv and numtasa_rica=idTasaRetIca";
	$result=mysqli_query($link,$qry);
	$row=mysqli_fetch_array($result);
	$qryc="select ret_provee, regimen_provee from compras, proveedores where nit_prov=nitProv and idCompra=$Factura";
	$resultc=mysqli_query($link,$qryc);
	$rowc=mysqli_fetch_array($resultc);
	$autore=$rowc['ret_provee'];
	$regimen_provee=$rowc['regimen_provee'];
	$SUBTotalFactura=$row['Total'];
	$tasa_reteica=$row['tasa_retica'];
	if ($autore==1)
	{
		$retencion=0;
		$reteica=0;
	}
	else
	{
	  if ($SUBTotalFactura>=BASE_C)
	  {
		  $retencion=round($SUBTotalFactura*0.025,0);
		  $reteica=round($SUBTotalFactura*$tasa_reteica/1000);
	  }
	  else
	  {
			  $retencion=0;
			  $reteica=0;
	  }
	}
	
	if ($regimen_provee==1)
		$Iva_Factura=$row['IVA'];
	else
		$Iva_Factura=0;
	$TotalFactura=$SUBTotalFactura+$Iva_Factura;
	$qryUpFactura="update compras set totalCompra=$TotalFactura, subtotalCompra=$SUBTotalFactura, ivaCompra=$Iva_Factura, retefuenteCompra=$retencion, reteicaCompra=$reteica where idCompra=$Factura";
	if ($estadoc!=7)
	$result=mysqli_query($link,$qryUpFactura);
	mysqli_close($link);
} 
if($CrearFactura==6)
{	
	if($estado==2)
	{
	  $link=conectarServidor();
	  $qryUpEstFactura="update compras set estadoCompra=3 where idCompra=$Factura";
	  $result2=mysqli_query($link,$qryUpEstFactura);
	  mysqli_close($link);
	}
	echo'<script  >
	self.location="menu.php";
	</script>';
} 

?>
<?php
  $link=conectarServidor();
  $Fact=$Factura;
  $qry="select compras.*, Nom_provee, descEstado, regimen_provee
		from compras, proveedores, estados
		where idCompra=$Factura
		and compras.nit_prov=proveedores.nitProv and estadoCompra=idEstado";
  $result=mysqli_query($link,$qry);
  $row=mysqli_fetch_array($result);
  $nit=$row['nit_prov'];
  $regimen_provee=$row['regimen_provee'];
  $des_estado=$row['Des_estado'];
  $estado=$row['estado'];
  mysqli_close($link);
?>
<form method="post" action="detCompradist.php" name="form1">
  <table border="0"  align="center" summary="encabezado" width="74%" cellpadding="0" >
    <tr>
      <td width="28%" colspan="1" ><div align="right"><strong>No. de Compra</strong> </div></td>
      <td width="19%"><div align="left"><?php echo $Factura;?></div></td>
      <td colspan="1" ><div align="right"><strong>No. de Factura</strong></div></td>
      <td width="6%" colspan="1"><div align="left"><?php echo  $row['Num_fact']?></div></td>
      <td width="14%"  align="right"><strong>Estado</strong></td>
      <td width="23%" colspan=2 ><?php echo  $row['Des_estado']?></td>
    </tr>    
    <tr>
      <td align="right"><strong>Proveedor</strong></td>
      <td colspan="3" ><?php echo  $row['Nom_provee']?></td>
      <td width="14%" colspan="1" ><div align="right"><strong>Valor Factura</strong></div></td>
      <td colspan="2"><div align="left"><?php echo '$ <script  > document.write(commaSplit('.$row['total_fact'].'))</script>' ;?> </div></td>
    </tr>
    <tr>
    <td width="28%" colspan="1"><div align="right"><strong>NIT</strong></div></td>
      <td colspan="3"><?php echo  $row['nit_prov']?></td>
      <td width="14%" colspan="1" ><div align="right"><strong>Retenci&oacute;n Cree</strong></div></td>
      <td colspan="2"><div align="left"><?php echo '$ <script  > document.write(commaSplit('.$row['ret_ica'].'))</script>' ;?> </div></td>
     </tr>
    <tr>
      <td align="right"><strong>Fecha de Factura</strong></td>
      <td colspan="3" ><?php echo $row['Fech_comp'];?></td>
      <td width="14%" colspan="1" ><div align="right"><strong>Retenci&oacute;n</strong></div></td>
      <td colspan="2"><div align="left"><?php echo '$ <script  > document.write(commaSplit('.$row['retencion'].'))</script>' ;?> </div></td>
    </tr>
    <tr>
      <td align="right"><strong>Fecha Vencimiento </strong></td>
      <td colspan="3"><?php echo $row['Fech_venc'];?></td>
      <td width="14%" colspan="1" ><div align="right"><strong>Valor a Pagar</strong></div></td>
      <td colspan="2"><div align="left"><?php echo '$ <script  > document.write(commaSplit('.($row['total_fact']-$row['retencion']-$row['ret_ica']).'))</script>' ;?> </div></td>
    </tr>
    <tr>
      <td colspan="7">&nbsp;</td>
    </tr>
    <?php
	if ($estadoc!=7)
	{
	echo '<tr>
      <td colspan="2"><div align="center"><strong>Producto de Distribuci&oacute;n</strong></div></td>
      <td colspan="2"><div align="center"><strong>Cantidad</strong></div></td>
      <td colspan="3"><div align="center"><strong>Precio Unitario (Sin IVA)</strong></div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">'; 
	$link=conectarServidor();
	echo'<select name="cod_dist" >';
	$result=mysqli_query($link,"select * from distribucion, det_proveedores where Id_distribucion=Codigo and Nit_provee='$nit' and Activo=0 order by Producto");
    while($row=mysqli_fetch_array($result))
			{
				echo '<option value='.$row['Id_distribucion'].'>'.$row['Producto'].'</option>';
            }
            echo'</select>';
			mysqli_close($link);
		     
      echo '</div></td>
      <td colspan="2"><div align="center"><input name="can_dist" type="text" size=10></div></td>
      <td colspan="3"><div align="center"><input name="precio_dist" type="text" size=10></div></td>
    </tr>
    <tr>
      <td colspan="7" align="right"><input name="submit" onClick="return Enviar(this.form)" type="submit"  value="Continuar">
    <input name="CrearFactura" type="hidden" value="1">
          <input name="Factura" type="hidden" value="'.$Factura.'">'; ?> </td>
    </tr>
     <?php
	}
	?>
    <tr>
      <td colspan="7">&nbsp;</td>
    </tr>
    <tr>
      <td  colspan="7" class="titulo">Detalle de Factura : </td>
    </tr>
  </table>
</form>
<table border="0" align="center" summary="detalle">
<tr>
   	  <th width="61"></th>
      <th width="55" align="center">C&oacute;digo</th>
            <th width="339" align="center">Producto</th>
      <th width="47" align="center">Iva</th>
            <th width="66" align="center">Cantidad </th>
            <th width="95" align="center">Precio  Un</th>
      <th width="61"></th>
    </tr>
              <tr>
      <td colspan="7"><hr></td>
    </tr>
          <?php
			$link=conectarServidor();
			$Fact=$Factura;
			$qry="SELECT Codigo, Producto, Cantidad, Precio, tasa
				FROM det_compras, distribucion, tasa_iva 
				where idCompra=$Factura and det_compras.Codigo=distribucion.Id_distribucion
				and distribucion.cod_iva=tasa_iva.Id_tasa";
				$result=mysqli_query($link,$qry);
				$c=0;
			while($row=mysqli_fetch_array($result))
			{
			$codigo=$row['Codigo'];
			$cantidad=$row['Cantidad'];
			echo'<tr><td>';
			if ($estadoc!=7)
			{
			echo '<form action="updateCompraDist.php" method="post" name="actualiza'.$c.'">
					<input name="factura" type="hidden" value="'.$Factura.'">
					<input name="codigo" type="hidden" value="'.$codigo.'">
					<input name="cantidad" type="hidden" value="'.$cantidad.'">
					<input type="submit" name="Submit" value="Cambiar">
				</form>';
			}
			echo '</td><td><div align="center">'.$row['Codigo'].'</div></td>
			  <td><div align="left">'.$row['Producto'].'</div></td>';
			  
			  if ($regimen_provee==1)
			  	echo '<td><div align="center">'.$row['tasa']*(100).' %</div></td>';
			  else
			    echo '<td><div align="center">0%</div></td>';
			  
			  echo'<td><div align="center">'.$row['Cantidad'].'</div></td>
			  <td><div align="center">$ <script  > document.write(commaSplit('.$row['Precio'].'))</script></div></td><td>';
			  if ($estadoc!=7)
				{
			  echo '<form action="delDistComp.php" method="post" name="elimina'.$c++.'">
					<input name="factura" type="hidden" value="'.$Factura.'">
					<input name="codigo" type="hidden" value="'.$codigo.'">
					<input name="cantidad" type="hidden" value="'.$cantidad.'">
					<input type="submit" name="Submit" value="Eliminar">
				</form>';
				}
			echo '</td></tr>';
			}
			mysqli_close($link);
			?>
                <tr>
      <td colspan="7"><hr></td>
    </tr>
</table>
<div align="center"><form method="post" action="detCompradist.php" name="form5">
<input name="CrearFactura" type="hidden" value="6"> 
<input name="Factura" type="hidden" value="<?php echo $Factura; ?>"> 
<input name="estado" type="hidden" value="<?php echo $estado; ?>"> 
<input type="submit" class="resaltado"  value="Terminar"></form></div>
</div>
</body>
</html>
