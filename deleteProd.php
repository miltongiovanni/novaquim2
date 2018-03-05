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
	include "includes/ProdObj.php";
	$cod_prod = $_POST['IdProd'];
	$prod=new produ();
	$result=$prod->deleteProd($cod_prod);
	if($result==1)
	{
		/******LOG DE CREACION *********/
		//$IdUser=$IdUsuario;
		//$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
        //$Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
   		//$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','BORRADO DE USUARIO')";
		//$ResutLog=mysql_db_query("users",$qryAcces);
	    /*********FIN DEL LOG CREACION*****/
		$ruta="listarProd.php";
		mover_pag($ruta,"Producto eliminado correctamente");
	}
	else
	{	$ruta="menu.php?perfil=$perfil";
		mover_pag($ruta,"No fue permitido eliminar el Producto");
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
