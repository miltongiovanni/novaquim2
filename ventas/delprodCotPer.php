<?php
include "../includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Acualización</title>
</head>
<body>
<?php
	foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
	$qryinv="delete from det_cot_personalizada where Id_cot_per=$cotizacion and Cod_producto=$producto";
	echo'<form action="det_cot_personalizada.php" method="post" name="formulario">';
	$link=conectarServidor();
	$result=mysqli_query($link,$qryinv);
	echo '<input name="cotizacion" type="hidden" value="'.$cotizacion.'">
	<input name="Crear" type="hidden" value="5">
	<input type="submit" name="Submit" value="Cambiar" >';
	if($result==1)
	{
		$ruta="";
		mover_pag($ruta,"Cotización Actualizada correctamente");
	}
	echo'</form>';
	
	mysqli_close($link);
?>
</body>
</html>