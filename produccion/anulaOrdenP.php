<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Anular Orden de Producci&oacute;n</title>
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
//MATERIA PRIMA QUE SE IBA A UTILIZAR Y SE VA A DEVOLVER AL INVENTARIO
$qry="select Lote, Cod_mprima, Lote_MP, Can_mprima from det_ord_prod where Lote=$lote;";
if($result=mysqli_query($link,$qry))
{
	while($row=mysqli_fetch_array($result))
	{
	  $cod_MP=$row['Cod_mprima'];
	  $cantidad=$row['Can_mprima'];
	  $loteMP=$row['Lote_MP'];	
	  /*AJUSTE DEL INVENTARIO*/
	  $qryinv="select Cod_mprima, Lote_mp, inv_mp from inv_mprimas where Cod_mprima=$cod_MP AND Lote_mp='$loteMP'";
	  $resultinv=mysqli_query($link,$qryinv);
	  $rowinv=mysqli_fetch_array($resultinv);
	  $invt=$rowinv['inv_mp'];
	  $invt= $invt + $cantidad;
	  /*SE ACTUALIZA EL INVENTARIO*/
	  $qryupt="update inv_mprimas set inv_mp=$invt where Cod_mprima=$cod_MP AND Lote_mp='$loteMP'";
	  echo $qryupt."<br>";
	  $resultupt=mysqli_query($link,$qryupt);
	}
}
else
{
	echo' <script >
	alert("Error al eliminar los productos de la Orden de Producción");
	</script>';
}
/*ACTUALIZACIÓN DEL ENCABEZADO DE LA FACTURA*/
$qry="update ord_prod set Estado='A', Cant_kg=0 where Lote=$lote";
$result=mysqli_query($link,$qry);
/*ELIMINAR EL DETALLE DE LA FACTURA*/
$qry="DELETE from det_ord_prod WHERE Lote=$lote";
$result=mysqli_query($link,$qry);
$ruta="listarOrProdA.php";
mover_pag($ruta,"Orden de Producción Anulada con Éxito");
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
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
