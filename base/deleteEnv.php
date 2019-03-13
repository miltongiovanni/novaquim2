<?php
	include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Borrado de Productos</title>
</head>
<body>
<?php
	include "includes/EnvObj.php";
	$cod_env = $_POST['Codigo'];
	$enva=new envas();
	$result=$enva->deleteEnv($cod_env);
	if($result==1)
	{
		$link=conectarServidor();
		$qryinv="delete from inv_envase where Cod_envase=$cod_env";
		$result1=mysqli_query($link,$qryinv);
		mysqli_free_result($result1);
/* cerrar la conexión */
mysqli_close($link);
		/******LOG DE CREACION *********/
		//$IdUser=$IdUsuario;
		//$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
        //$Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
   		//$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','BORRADO DE USUARIO')";
		//$ResutLog=mysql_db_query("users",$qryAcces);
	    /*********FIN DEL LOG CREACION*****/
		$ruta="listarEnv.php";
		mover_pag($ruta,"Envase eliminado correctamente");
	}
	else
	{	$ruta="deleteEnvForm.php";
		mover_pag($ruta,"No fue permitido eliminar el Envase");
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
