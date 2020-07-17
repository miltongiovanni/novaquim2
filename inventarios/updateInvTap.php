<?php
include "../includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Actualización</title>
</head>
<body>
<?php
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	} 
	$qryinv="update inv_tapas_val set invTapa=$inv where codTapa=$IdTap;";
	$link=conectarServidor();
	if($result=mysqli_query($link,$qryinv))
	{
		echo'<script >
		alert("Inventario Actualizado Correctamente");
		self.location="menu.php";
		</script>';
	}
	mysqli_close($link);
?>
</body>
</html>