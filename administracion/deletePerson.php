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
	include "includes/PersonObj.php";
	$IdPersonal=$_POST['IdPersonal'];
	$persona=new person();
	$result=$persona->deletePerson($IdPersonal);
	if($result==1)
	{
		/*******LOG DE CREACION ********
		$link=conectarServidor();
		$IdUser=$IdUsuario;
		$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
        $Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
   		$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','BORRADO DE USUARIO')";
		$ResutLog=mysql_db_query("users",$qryAcces);
	    /*********FIN DEL LOG CREACION*****/
		$ruta="listarPersonal.php";
		mover_pag($ruta,"Personal borrado correctamente");
	}
	else
	{	$ruta="menu.php";
		mover_pag($ruta,"No se logró Eliminar al Personal Correctamente");
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
