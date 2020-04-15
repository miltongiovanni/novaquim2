<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Anular Orden de Producci&oacute;n</title>
    <meta charset="utf-8">
    <link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script  src="scripts/validar.js"></script>
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
//ACTUALIZACIÓN DEL ENCABEZADO DEL PEDIDO
$qry="update pedido set Estado='A' where Id_pedido=$pedido";
$result=mysqli_query($link,$qry);
//ELIMINAR EL DETALLE DE LA FACTURA
$qry="DELETE from det_pedido WHERE Id_ped=$pedido";
$result=mysqli_query($link,$qry);
$ruta="listarPedidoA.php";
mysqli_close($link);
mover_pag($ruta,"Orden de Pedido Anulada con Éxito");

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
