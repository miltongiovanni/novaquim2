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
	include "includes/MedObj.php";
	$cod_pres=$_POST['IdProdPre'];
	$ProdPr=new ProdPre();
	$result=$ProdPr->deleteMed($cod_pres);
	if($result==1)
	{
		$link=conectarServidor();
		$qryinv="delete from inv_prod where Cod_prese=$cod_pres";
		$result=mysqli_query($link,$qryinv);
		mysqli_close($link);//Cerrar la conexion
		/******LOG DE CREACION *********/
		//$IdUser=$IdUsuario;
		//$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
        //$Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
   		//$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','BORRADO DE USUARIO')";
		//$ResutLog=mysql_db_query("users",$qryAcces);
	    /*********FIN DEL LOG CREACION*****/
		$ruta="listarmed.php";
		mover_pag($ruta,"Presentación de Producto eliminada correctamente");
	}
	else
		$ruta="menu.php";
		mover_pag($ruta,"No se logr eliminar la Presentacin de Producto");

	
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
