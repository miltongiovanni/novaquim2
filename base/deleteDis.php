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
	include "includes/DisObj.php";
	$Id_prod = $_POST['IdDis'];
	$prodd=new distri();
	$result=$prodd->deleteDis($Id_prod);
	if($result==1)
	{
		$link=conectarServidor();
		$qryinv="delete from inv_distribucion where Id_distribucion=$Id_prod";
		$result=mysqli_query($link,$qryinv);
		mysqli_close($link);//Cerrar la conexion
		/******LOG DE CREACION *********/
		//$IdUser=$IdUsuario;
		//$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
        //$Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
   		//$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','BORRADO DE USUARIO')";
		//$ResutLog=mysql_db_query("users",$qryAcces);
	    /*********FIN DEL LOG CREACION*****/
		$ruta="listarDis.php";
		mover_pag($ruta,"Producto de Distribución eliminado correctamente");
	}
	else
		$ruta="menu.php";
		mover_pag($ruta,"No fue permitido eliminar el Producto de Distribución");
	
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
