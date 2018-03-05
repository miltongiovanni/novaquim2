<?php
	include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Borrado de Categor&iacute;as de Producto</title>
</head>
<body>
<?php
	include "includes/conect.php";
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  
	$link=conectarServidor();  
	$bd="novaquim";
	$qry="delete from cat_mp  where Id_cat_mp=$IdCat;";
	$result=mysqli_query($link,$qry);
	if($result)
	{
		/******LOG DE CREACION *********/
		//$IdUser=$IdUsuario;
		//$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
        //$Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
   		//$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','BORRADO DE USUARIO')";
		//$ResutLog=mysql_db_query("users",$qryAcces);
	    /*********FIN DEL LOG CREACION*****/
		$ruta="listarcateg_MP.php";
		mover_pag($ruta,"Categoria de Materia Prima Borrada Correctamente");
	}
	else
	{
		$ruta="deleteCatForm_MP.php";
		mover_pag($ruta,"No se pudo eliminar la Categoría de Materia Prima");
	}
	mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
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
