<?php
	include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Borrado de Categor&iacute;as de Producto</title>
</head>
<body>
<?php
	include "includes/CatObj.php";
	$IdCat=$_POST['IdCat'];
	$categ=new cate();
	$result=$categ->deleteCat($IdCat);
	if($result==1)
	{
		/******LOG DE CREACION *********/
		//$IdUser=$IdUsuario;
		//$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
        //$Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
   		//$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','BORRADO DE USUARIO')";
		//$ResutLog=mysql_db_query("users",$qryAcces);
	    /*********FIN DEL LOG CREACION*****/
		$ruta="listarcateg.php";
		mover_pag($ruta,"Categoria borrada correctamente");
	}
	else
	{
		mysql_close($link);
		$ruta="menu.php?perfil=$perfil";
		mover_pag($ruta,"La Operacion no fue exitosa");
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
