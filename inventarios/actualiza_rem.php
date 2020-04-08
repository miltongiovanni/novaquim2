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
$link=conectarServidor();   
$bd="novaquim"; 
//revisa el detalle de la remisión
$qry="select Id_remision, Cod_producto, Can_producto, Lote_producto from det_remision where Id_remision>3540 and Cod_producto<100000;";
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
  $qryinv="select Cod_prese, lote_prod, inv_prod from inv_prod where Cod_prese=$codigo and inv_prod >0 order by lote_prod;";
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
		$qryins_p="insert into det_remision (Id_remision, Cod_producto, Can_producto, Lote_producto) values ($id_remision, $cod_producto, $unidades, $lot_prod)";
		echo $qryins_p."<br>";				
		$resultins_p=mysql_db_query($bd,$qryins_p);
		/*SE ACTUALIZA EL INVENTARIO*/
		$qryupt="update inv_prod set inv_prod=$invt where lote_prod=$lot_prod and Cod_prese=$cod_prod";
		$resultupt=mysql_db_query($bd,$qryupt);
		$unidades=0;
	}
	else
	{
		$unidades= $unidades - $invt ;
		/*SE ADICIONA A LA REMISIÓN*/
		$qryupd_r="update det_remision set Can_producto=$unidades, Lote_producto=$lote where Id_remision=$id_remision and Cod_producto=$cod_producto";
		$resultins_p=mysql_db_query($bd,$qryins_p);
		/*SE ACTUALIZA EL INVENTARIO*/
		$qryupt="update inv_prod set inv_prod=0 where lote_prod=$lot_prod and Cod_prese=$cod_prod";
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
