<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Acualizaci&oacute;n</title>
</head>
<body>
<?php
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  
	$qryinv="update inv_mprimas set inv_mp=$inv where Cod_mprima=$mprima and Lote_mp='$lote';";
	$link=conectarServidor();
	if($result=mysqli_query($link,$qryinv))
	{
		echo'<script language="Javascript">
		alert("Inventario Actualizado Correctamente");
		self.location="menu.php";
		</script>';
	}
	mysqli_close($link);
?>
</body>
</html>