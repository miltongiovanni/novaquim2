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
	include "includes/empleadObj.php";
	$Id_empleado=$_POST['Id_empleado'];
	$empleado=new emplead();
	//$persona=new person();
	$result=$empleado->deleteEmplead($Id_empleado);
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
		$ruta="listarEmp.php";
		mover_pag($ruta,"Personal borrado correctamente");
	}
	else
	{	$ruta="menu.php";
		mover_pag($ruta,"No se logró Eliminar al Personal Correctamente");
	}
function mover_pag($ruta,$nota)
	{
	echo'<script >
	alert("'.$nota.'")
	self.location="'.$ruta.'"
	</script>';
	}
?>
</body>
</html>
