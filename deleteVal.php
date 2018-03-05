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
	include "includes/ValObj.php";
	$cod_val = $_POST['Codigo'];
	$valvu=new valv();
	$result=$valvu->deleteVal($cod_val);
	if($result==1)
	{
		$link=conectarServidor();
		$qryinv="delete from inv_tapas_val where Cod_tapa=$cod_val";
		$result=mysqli_query($link,$qryinv);
		//mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
		/******LOG DE CREACION *********/
		//$IdUser=$IdUsuario;
		//$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
        //$Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
   		//$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','BORRADO DE USUARIO')";
		//$ResutLog=mysql_db_query("users",$qryAcces);
	    /*********FIN DEL LOG CREACION*****/
		$ruta="listarVal.php";
		mover_pag($ruta,"Tapa o Válvula eliminada correctamente");
	}
	else
		$ruta="deleteValForm.php";
		mover_pag($ruta,"No fue permitido eliminar la Tapa o Vlvula");

	
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
