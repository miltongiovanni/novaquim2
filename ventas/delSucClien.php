<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html lang="es">
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
	//ELIMINA LA SUCURSAL DEL CLIENTE
	$qryinv="delete FROM clientes_sucursal where Nit_clien='$NIT' AND Id_sucursal=$Id_sucursal";
	echo $qryinv;
	echo'<form action="detCliente.php" method="post" name="formulario">';
	$link=conectarServidor();
	$result=mysqli_query($link,$qryinv);
	echo '<input name="NIT" type="hidden" value="'.$NIT.'"/>
	<input name="Crear" type="hidden" value="5"/>
	<input type="submit" name="Submit" value="Cambiar" />';
	if($result==1)
	{
		$ruta="";
		mover_pag($ruta,"Cliente Actualizado correctamente");
	}
	echo'</form>';
	
	mysqli_close($link);
?>
</body>
</html>