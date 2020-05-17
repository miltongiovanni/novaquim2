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
//UNIDADES QUE FUERON FACTURADAS Y SE VAN A DEVOLVER AL INVENTARIO
$qry="select Cod_producto, Can_producto, Lote_producto from det_remision, remision, factura 
where det_remision.Id_remision=remision.Id_remision and factura.Id_remision=det_remision.Id_remision and Factura=$factura;";
echo $qry."<br>";
if($result=mysqli_query($link,$qry))
{
	while($row=mysqli_fetch_array($result))
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
			$resultinv=mysqli_query($link,$qryinv);
			$rowinv=mysqli_fetch_array($resultinv);
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
			$resultupt=mysqli_query($link,$qryupt);
		}
		else
		{
			$qryinv="select codDistribucion, invDistribucion from inv_distribucion WHERE codDistribucion=$cod_producto;";
			echo $qryinv."<br>";
			$resultinv=mysqli_query($link,$qryinv);
			$rowinv=mysqli_fetch_array($resultinv);
			$invt=$rowinv['inv_dist'];
			if ($invt==NULL)
		  	{
			$qryupt="insert into inv_distribucion (codDistribucion, invDistribucion) values ($cod_producto, $cantidad)";
			$resultupt=mysqli_query($link,$qryupt);
		  	}
			else
			{
				$invt= $invt + $unidades;
				/*SE ACTUALIZA EL INVENTARIO*/
				$qryupt="update inv_distribucion set invDistribucion=$invt where codDistribucion=$cod_producto";
				$resultupt=mysqli_query($link,$qryupt);
			}
			
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
	$result=mysqli_query($link,$qry);
	$qryrem="select remision.Id_remision as remision, Factura from remision, factura where remision.Id_pedido=factura.Id_pedido and Factura=$factura;";
	echo $qryrem;
	$resultrem=mysqli_query($link,$qryrem);
	$rowrem=mysqli_fetch_array($resultrem);
	$id_rem=$rowrem['remision'];	
	/*ELIMINAR EL DETALLE DE LA FACTURA Y REMISION*/
	$qry="DELETE from det_factura WHERE Id_fact=$factura;";
	$result=mysqli_query($link,$qry);
	$qry1="DELETE from det_remision WHERE Id_remision=$id_rem;";
	$result1=mysqli_query($link,$qry1);
	$ruta="listarFacturas.php";
    mover_pag($ruta,"Factura Anulada con Éxito");
	mysqli_close($link);
	

?>

</body>
</html>
