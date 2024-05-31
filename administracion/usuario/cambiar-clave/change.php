<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<link rel="icon" href="../../../images/favicon.ico" type="image/ico" sizes="16x16">
	<title>Change</title>

	<script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
	<script src="../../../js/validar.js"></script>

</head>
<body>
<?php
function cargarClases($classname)
{
  require '../../../clases/'.$classname.'.php';
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
$usuarioOperador = new UsuariosOperaciones();

//Ejecutamos la sentencia SQL
$usuario1=strtoupper ($username);
$password1=md5(strtoupper ($password));
$row=$usuarioOperador->getUserPassword($usuario1, $password1);
if($row)
{
	$username=$usuario1;
	$id=$row['idUsuario'];

		$antPass=strtoupper ($password);
		$newPass=strtoupper ($newPass);
		$confnewPass= strtoupper ($confPass);
		$longPass=strlen($newPass);
        if(($newPass=='123456')||($newPass==$antPass)||($newPass==$username)||($newPass!=$confnewPass)||($longPass<6))
        {
			$ruta = "/administracion/usuario/clave/cambiarClave.php";
			$mensaje = "Password inadecuado, Recuerde utilizar una longitud mayor a 6 caracteres";
			mover_pag($ruta, $mensaje, 'error');
		}
		else
		{
			//Creamos la sentencia SQL y la ejecutamos
			$fec=Fecha::Hoy();
			$result1=$usuarioOperador->changeClave($newPass, $fec, $username);
			if($result1)
			{
				$ruta = "/administracion/usuario/lista";
				$mensaje = "Cambio Exitoso";
				mover_pag($ruta, $mensaje, 'success');
			}
			else
			{
				$username=$_POST['username'];
				$id=$row['idUsuario'];
				$ruta = "/administracion/usuario/clave/cambiarClave.php";
				$mensaje = "Error al cambiar la clave";
				mover_pag($ruta, $mensaje, 'error');
			}
		}
}
else
{
	$ruta = "/administracion/usuario/clave/cambiarClave.php";
	$mensaje = "Los datos no corresponden";
	mover_pag($ruta, $mensaje, 'error');
}
?>
</body>
</html>