<?php
include "includes/valAcc.php";
function chargerClasse($classname)
{
  require 'includes/'.$classname.'.php';
}

spl_autoload_register('chargerClasse');
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BORRADO DE USUARIOS</title>
</head>
<body>
<?php
	//include "includes/userObj.php";
	$idUsuario=$_POST['idUsuario'];
	$manager = new UsersManager();
	$result=$manager->deleteUser($idUsuario);
	if($result==1)
	{
		/******LOG DE CREACION *********
		$link=conectarServidor();
		$IdUser=$IdUsuario;
		$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
        $Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
   		$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','BORRADO DE USUARIO')";
		$ResutLog=mysqli_query($link,$qryAcces);
	    /*********FIN DEL LOG CREACION*****/
		$ruta="listarUsuarios.php";
		mover_pag($ruta,"Usuario borrado correctamente");
	}
	else
	{	$ruta="menu.php";
		mover_pag($ruta,"No se pudo borrar el usuario");
	}
function mover_pag($ruta,$nota)
	{
	echo'<script language="Javascript">
	alert("'.$nota.'")
	self.location="'.$ruta.'"
	</script>';
	}
?>
</body>
</html>
