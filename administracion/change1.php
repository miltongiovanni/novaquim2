<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
  require '../clases/'.$classname.'.php';
}

spl_autoload_register('cargarClases');
?>
<?php

foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
$usuarioOperador = new UsuariosOperaciones();
//Convertimos en mayusculas el usuario y md5 a password
$usuario1=strtoupper ($nombre);
$newPass=strtoupper ($newPass);
$ConfNewPass= strtoupper ($confPass);
$longPass=strlen($newPass);
if(($newPass=='123456')||($newPass==$nombre)||($newPass!=$ConfNewPass)||($longPass<6))
{
	echo'<script >
	alert("Password inadecuado, Recuerde utilizar una longitud mayor a 6 caracteres")
	self.location="buscarUsuario2.php"
	</script>';
}
else
{
	//Creamos la sentencia SQL y la ejecutamos
	$fec=Fecha::Hoy();
	$result1=$usuarioOperador->changeClave($newPass, $fec, $nombre);
	if($result1)
	{
		echo'<script >
		alert("Asignación Exitosa")
		self.location="listarUsuarios.php"
		</script>';
	}
	else
	{
		$nombre=$_POST['nombre'];
		$id=$row['idUsuario'];
		echo'<script >
		alert("Password inadecuado");
		self.location="cambio.php";
		</script>';
	}

}
$mysqli->close();
?>
