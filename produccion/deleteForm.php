<?php
	include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Borrado de Productos</title>
</head>
<body>
<?php
	include "includes/conect.php";
	$IdForm = $_POST['IdForm'];
	$link=conectarServidor();
	$qrydet="delete from det_formula where idFormula=$IdForm";
	$qryform="delete from formula where idFormula=$IdForm";
	if($result1=mysqli_query($link,$qrydet))
	{
		if($result1=mysqli_query($link,$qryform))
		{
			mysqli_close($link);//Cerrar la conexion
			/******LOG DE CREACION *********/
			//$IdUser=$IdUsuario;
			//$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
			//$Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
			//$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','BORRADO DE USUARIO')";
			//$ResutLog=mysql_db_query("users",$qryAcces);
			/*********FIN DEL LOG CREACION*****/
			$ruta="deleteFormula.php";
			mover_pag($ruta,"Formulación eliminada correctamente");
		}
	
	
	
	}
	else
		$ruta="menu.php";
		mover_pag($ruta,"No fue permitido eliminar la Materia Prima");

	

?>
</body>
</html>
