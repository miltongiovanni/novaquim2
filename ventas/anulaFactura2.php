<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Anular Factura</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script  src="../js/validar.js"></script>
    <script  src="scripts/block.js"></script>
    <script >
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
$qry="select codProducto, cantProducto, loteProducto from det_remision, remision, factura 
where det_remision.idRemision=remision.idRemision and factura.idRemision=det_remision.idRemision and Factura=$factura;";
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
			$qryinv="select codPresentacion, loteProd, invProd from inv_prod where codPresentacion=$cod_producto and loteProd=$lote;";
			echo $qryinv."<br>";
			$resultinv=mysql_db_query($bd,$qryinv);
			$rowinv=mysql_fetch_array($resultinv);
			$invt=$rowinv['inv_prod'];
			$invt= $invt + $cantidad;
			if ($invt==NULL)
		  	{
				$qryupt="insert into inv_prod (codPresentacion, loteProd, invProd) values ($cod_producto, $lote, $cantidad)";
		  	}
			else
			{
			/*SE ACTUALIZA EL INVENTARIO*/
			$qryupt="update inv_prod set invProd=$invt where loteProd=$lote and codPresentacion=$cod_producto";
			}
			$resultupt=mysql_db_query($bd,$qryupt);
		}
		else
		{
			$qryinv="select codDistribucion, invDistribucion from inv_distribucion WHERE codDistribucion=$cod_producto;";
			echo $qryinv."<br>";
			$resultinv=mysql_db_query($bd,$qryinv);
			$rowinv=mysql_fetch_array($resultinv);
			$invt=$rowinv['inv_dist'];
			if ($invt==NULL)
		  	{
			$qryupt="insert into inv_distribucion (codDistribucion, invDistribucion) values ($cod_producto, $cantidad)";
		  	}
			else
			{
				$invt= $invt + $unidades;
				/*SE ACTUALIZA EL INVENTARIO*/
				$qryupt="update inv_distribucion set invDistribucion=$invt where codDistribucion=$cod_producto";
			}
			$resultupt=mysql_db_query($bd,$qryupt);
		}
	}
}
else
{
	echo' <script >
	alert("Error al eliminar los productos de la factura")
	</script>';
}
	/*ACTUALIZACIÓN DEL ENCABEZADO DE LA FACTURA*/
	$qry="update factura set Estado='A', Total=0, Subtotal=0, IVA=0, Observaciones='$observa' where Factura=$factura";
	echo $qry;
	$result=mysql_db_query($bd,$qry);
	$qryrem="select remision.idRemision as remision, Factura from remision, factura where remision.idPedido=factura.idPedido and Factura=$factura;";
	echo $qryrem;
	$resultrem=mysql_db_query($bd,$qryrem);
	$rowrem=mysql_fetch_array($resultrem);
	$id_rem=$rowrem['remision'];	
	/*ELIMINAR EL DETALLE DE LA FACTURA Y REMISION*/
	$qry1="DELETE from det_remision WHERE idRemision=$id_rem;";
	$result1=mysql_db_query($bd,$qry1);
	$qry="DELETE from det_factura WHERE Id_fact=$factura;";
	$result=mysql_db_query($bd,$qry);
	$ruta="listarFacturasVD.php";
    mover_pag($ruta,"Factura Anulada con Éxito");
	mysql_close($link);
	

?>

</body>
</html>
