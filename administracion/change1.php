<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
  require '../clases/'.$classname.'.php';
}

spl_autoload_register('cargarClases');
foreach ($_POST as $nombre_campo => $valor) {
	${$nombre_campo} = $valor;
	if(is_array($valor)){
		//echo $nombre_campo.print_r($valor).'<br>';
	}else{
		//echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
	}
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<title>Cambio de Contrase&ntilde;a</title>
	<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<meta charset="utf-8">
	<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
	<script  src="../js/validar.js"></script>
</head>

<body>


<?php

$usuarioOperador = new UsuariosOperaciones();
//Convertimos en mayusculas el usuario y md5 a password
$usuario1=strtoupper ($nombre);
$newPass=strtoupper ($newPass);
$ConfNewPass= strtoupper ($confPass);
$longPass=strlen($newPass);
if(($newPass=='123456')||($newPass==$nombre)||($newPass!=$ConfNewPass)||($longPass<6))
{
	$ruta = "buscarUsuario2.php";
	$mensaje = "Password inadecuado, Recuerde utilizar una longitud mayor a 6 caracteres";
	mover_pag($ruta, $mensaje, 'error');

}
else
{
	//Creamos la sentencia SQL y la ejecutamos
	$fec=Fecha::Hoy();
	$result1=$usuarioOperador->changeClave($newPass, $fec, $nombre);
	if($result1)
	{
		$ruta = "listarUsuarios.php";
		$mensaje = "Asignación Exitosa";
		mover_pag($ruta, $mensaje, 'success');
	}
	else
	{
		$nombre=$_POST['nombre'];
		$id=$row['idUsuario'];
		$ruta = "cambio.php";
		$mensaje = "Error al asignar la clave";
		mover_pag($ruta, $mensaje, 'error');
	}

}
?>
</body>
</html>