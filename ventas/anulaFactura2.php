<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Anular Factura</title>
    <meta charset="utf-8">
    <link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="scripts/validar.js"></script>
    <script type="text/javascript" src="scripts/block.js"></script>
    <script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body> 
<?php
include "includes/conect.php";
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
$link=conectarServidor();   
$bd="novaquim"; 
//UNIDADES QUE FUERON FACTURADAS Y SE VAN A DEVOLVER AL INVENTARIO
$qry="select Cod_producto, Can_producto, Lote_producto from det_remision, remision, factura 
where det_remision.Id_remision=remision.Id_remision and factura.Id_remision=det_remision.Id_remision and Factura=$factura;";
echo $qry."<br>";
if($result=mysql_db_query($bd,$qry))
{
	while($row=mysql_fetch_array($result))
	{
		$cod_producto=$row['Cod_producto'];
		$cantidad=$row['Can_producto'];
		$lote=$row['Lote_producto'];	
		if ($lote==NULL)
			  $lote=0;
		/*AJUSTE DEL INVENTARIO*/
		$unidades=$cantidad;
		if($cod_producto <100000)
		{
			$qryinv="select Cod_prese, lote_prod, inv_prod from inv_prod where Cod_prese=$cod_producto and lote_prod=$lote;";
			echo $qryinv."<br>";
			$resultinv=mysql_db_query($bd,$qryinv);
			$rowinv=mysql_fetch_array($resultinv);
			$invt=$rowinv['inv_prod'];
			$invt= $invt + $cantidad;
			if ($invt==NULL)
		  	{
				$qryupt="insert into inv_prod (Cod_prese, lote_prod, inv_prod) values ($cod_producto, $lote, $cantidad)";
		  	}
			else
			{
			/*SE ACTUALIZA EL INVENTARIO*/
			$qryupt="update inv_prod set inv_prod=$invt where lote_prod=$lote and Cod_prese=$cod_producto";
			}
			$resultupt=mysql_db_query($bd,$qryupt);
		}
		else
		{
			$qryinv="select Id_distribucion, inv_dist from inv_distribucion WHERE Id_distribucion=$cod_producto;";
			echo $qryinv."<br>";
			$resultinv=mysql_db_query($bd,$qryinv);
			$rowinv=mysql_fetch_array($resultinv);
			$invt=$rowinv['inv_dist'];
			if ($invt==NULL)
		  	{
			$qryupt="insert into inv_distribucion (Id_distribucion, inv_dist) values ($cod_producto, $cantidad)";
		  	}
			else
			{
				$invt= $invt + $unidades;
				/*SE ACTUALIZA EL INVENTARIO*/
				$qryupt="update inv_distribucion set inv_dist=$invt where Id_distribucion=$cod_producto";
			}
			$resultupt=mysql_db_query($bd,$qryupt);
		}
	}
}
else
{
	echo' <script language="Javascript">
	alert("Error al eliminar los productos de la factura")
	</script>';
}
	/*ACTUALIZACI�N DEL ENCABEZADO DE LA FACTURA*/
	$qry="update factura set Estado='A', Total=0, Subtotal=0, IVA=0, Observaciones='$observa' where Factura=$factura";
	echo $qry;
	$result=mysql_db_query($bd,$qry);
	$qryrem="select remision.Id_remision as remision, Factura from remision, factura where remision.Id_pedido=factura.Id_pedido and Factura=$factura;";
	echo $qryrem;
	$resultrem=mysql_db_query($bd,$qryrem);
	$rowrem=mysql_fetch_array($resultrem);
	$id_rem=$rowrem['remision'];	
	/*ELIMINAR EL DETALLE DE LA FACTURA Y REMISION*/
	$qry1="DELETE from det_remision WHERE Id_remision=$id_rem;";
	$result1=mysql_db_query($bd,$qry1);
	$qry="DELETE from det_factura WHERE Id_fact=$factura;";
	$result=mysql_db_query($bd,$qry);
	$ruta="listarFacturasVD.php";
    mover_pag($ruta,"Factura Anulada con �xito");
	mysql_close($link);
	
function mover_pag($ruta,$Mensaje)
{
	echo'<script language="Javascript">
	alert("'.$Mensaje.'")
	self.location="'.$ruta.'"
	</script>';
}
?>

</body>
</html>