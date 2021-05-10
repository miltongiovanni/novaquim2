<!DOCTYPE html>
<html lang="es">
<head>
    <title>Ingreso de Compra de Materia Prima</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script  src="../js/validar.js"></script>
    <script  src="scripts/block.js"></script>
    <script >
		document.onkeydown = stopRKey; 
	</script>
</head>
<body> 
<div align="center"><img src="images/LogoNova.JPG"/></div>
<?php
include "includes/conect.php";
include "includes/calcularDias.php";
$link=conectarServidor();   
$bd="novaquim"; 
//revisa el detalle de la remisión
$qry="select idRemision, codProducto, cantProducto, loteProducto from det_remision where idRemision>3540 and codProducto<100000;";
$result=mysql_db_query($bd,$qry);
//COMIENZA LA TRANSACCIÓN
$trans=mysql_query ("BEGIN"); 
while($row=mysql_fetch_array($result))
{
  $id_remision=$row['Id_remision'];
  $codigo=$rowped['Cod_producto'];
  $cantidad=$rowped['Can_producto'];	
  /*DESCARGA DEL INVENTARIO*/
  $unidades=$cantidad;
  $i=1;
  $qryinv="select codPresentacion, lote_prod, inv_prod from inv_prod where codPresentacion=$codigo and inv_prod >0 order by lote_prod;";
  $resultinv=mysql_db_query($bd,$qryinv);
  while(($rowinv=mysql_fetch_array($resultinv))&&($unidades>0))
  {
	$invt=$rowinv['inv_prod'];
	$i=$i+1;
	$lot_prod=$rowinv['lote_prod'];
	$cod_prod=$rowinv['Cod_prese'];
	if (($invt >= $unidades))
	{
		$invt= $invt - $unidades;
		/*SE ADICIONA A LA REMISIÓN*/
		$qryins_p="insert into det_remision (idRemision, codProducto, cantProducto, loteProducto) values ($id_remision, $cod_producto, $unidades, $lot_prod)";
		echo $qryins_p."<br>";				
		$resultins_p=mysql_db_query($bd,$qryins_p);
		/*SE ACTUALIZA EL INVENTARIO*/
		$qryupt="update inv_prod set invProd=$invt where loteProd=$lot_prod and Cod_prese=$cod_prod";
		$resultupt=mysql_db_query($bd,$qryupt);
		$unidades=0;
	}
	else
	{
		$unidades= $unidades - $invt ;
		/*SE ADICIONA A LA REMISIÓN*/
		$qryupd_r="update det_remision set cantProducto=$unidades, loteProducto=$lote where idRemision=$id_remision and codProducto=$cod_producto";
		$resultins_p=mysql_db_query($bd,$qryins_p);
		/*SE ACTUALIZA EL INVENTARIO*/
		$qryupt="update inv_prod set invProd=0 where loteProd=$lot_prod and Cod_prese=$cod_prod";
		$resultupt=mysql_db_query($bd,$qryupt);	
	}
  }
}
echo'<script >
	alert("funcion terminada");
	</script>';

$roll=mysql_query ("ROLLBACK");  
mysql_close($link);

//$comm=mysql_query ("COMMIT");  


?>
</body>
</html>
