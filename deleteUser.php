<?php
	include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BORRADO DE USUARIOS</title>
</head>
<body>
<?php
	include "includes/userObj.php";
	$IdUsuario=$_POST['IdUsuario'];
	$user=new user();
	$result=$user->deleteUser($IdUsuario);
	if($result==1)
	{
		/******LOG DE CREACION *********/
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
	{	$ruta="menu.php?perfil=$perfil";
		mover_pag($ruta,"La Operacion no fue exitosa");
	}
	mysqli_free_result($ResutLog);
/* cerrar la conexión */
mysqli_close($link);
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
