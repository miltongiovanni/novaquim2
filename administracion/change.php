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
			echo'<script >
			alert("Password inadecuado, Recuerde utilizar una longitud mayor a 6 caracteres")
			self.location="cambio.php?Nombre='.$username.'&Id='.$Id.'"
			</script>';
		}
		else
		{
			//Creamos la sentencia SQL y la ejecutamos
			$fec=Fecha::Hoy();
			$result1=$usuarioOperador->changeClave($newPass, $fec, $username);
			if($result1)
			{
				echo'<script >
				alert("Cambio Exitoso")
				self.location="listarUsuarios.php"
				</script>';
			}
			else
			{
				$username=$_POST['username'];
				$id=$row['idUsuario'];
				echo'<script >
				alert("Password inadecuado");
				self.location="cambio.php";
				</script>';
			}
		}
}
else
{
	echo'<script >
	alert("Los datos no corresponden")
	self.location="../index.php"
	</script>';
}
?>
