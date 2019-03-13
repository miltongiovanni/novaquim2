<?php
	include "includes/valAcc.php";
	include "includes/conect.php" ;
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Borrado de Productos</title>
</head>
<body>
<?php
	$IdServ = $_POST['IdServ'];
	$bd="novaquim";
	$qry="delete from servicios where IdServicio=$IdServ";
	$link=conectarServidor();
	$result=mysqli_query($link,$qry);
/* cerrar la conexión */
mysqli_close($link);
	if($result)
	{
		/******LOG DE CREACION *********/
		//$IdUser=$IdUsuario;
		//$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
        //$Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
   		//$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','BORRADO DE USUARIO')";
		//$ResutLog=mysql_db_query("users",$qryAcces);
	    /*********FIN DEL LOG CREACION*****/
		$ruta="listarServ.php";
		mover_pag($ruta,"Servicio eliminado correctamente");
	}
	else
		$ruta="deleteServForm.php";
		mover_pag($ruta,"No fue permitido eliminar el Servicio");
	
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
