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
	
	mysqli_close($link);
?>
</body>
</html>