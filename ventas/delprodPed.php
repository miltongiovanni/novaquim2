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
	$link=conectarServidor(); 
	$qryinv="delete from det_pedido where Id_ped=$pedido and Cod_producto=$producto";
	$result=mysqli_query($link,$qryinv);
	echo'<form action="det_pedido.php" method="post" name="formulario">';
	echo '<input name="pedido" type="hidden" value="'.$pedido.'"><input name="sobre" type="hidden" value="'.$sobre.'">
	<input name="Crear" type="hidden" value="5">
	<input type="submit" name="Submit" value="Cambiar" >';
	if($result==1)
	{
		$ruta="";
		mover_pag($ruta,"Pedido Actualizado correctamente");
	}
	echo'</form>';
	function mover_pag($ruta,$nota)
	{
	echo'<script >
	document.formulario.submit();
	</script>';
	}
	mysqli_close($link);
?>
</body>
</html>