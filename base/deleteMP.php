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
	include "includes/MPObj.php";
	$cod_mp = $_POST['IdMP'];
	$mpri=new mprim();
	$result=$mpri->deleteMP($cod_mp);
	if($result==1)
	{
		$link=conectarServidor();
		$qryinv="delete from inv_mprimas where Cod_mprima=$cod_mp";
		$result=mysqli_query($link,$qryinv);
		/******LOG DE CREACION *********/
		//$IdUser=$IdUsuario;
		//$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
        //$Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
   		//$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','BORRADO DE USUARIO')";
		//$ResutLog=mysql_db_query("users",$qryAcces);
	    /*********FIN DEL LOG CREACION*****/
		$ruta="listarMP.php";
		mover_pag($ruta,"Materia Prima eliminada correctamente");
		mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
	}
	else
		$ruta="menu.php?perfil=$perfil";
		mover_pag($ruta,"No fue permitido eliminar la Materia Prima");

	
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
