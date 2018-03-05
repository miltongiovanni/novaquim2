<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Acualizaci&oacute;n</title>
</head>
<body>
<?php
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  
	//ELIMINA EL PRODUCTO DEL PROVEEDOR
	$qryinv="delete from det_proveedores where NIT_provee='$NIT' and Codigo=$Codigo";
	echo $qryinv;
	echo'<form action="detProveedor.php" method="post" name="formulario">';
	$link=conectarServidor();
	$result=mysqli_query($link,$qryinv);
	echo '<input name="NIT" type="hidden" value="'.$NIT.'"/>
	<input name="Crear" type="hidden" value="0"/>
	<input name="IdCat" type="hidden" value="'.$IdCat.'"/>
	<input type="submit" name="Submit" value="Cambiar" />';
	if($result==1)
	{
		$ruta="";
		mover_pag($ruta,"Pedido Actualizado correctamente");
	}
	echo'</form>';
	function mover_pag($ruta,$nota)
	{
	echo'<script language="Javascript">
	document.formulario.submit();
	</script>';
	}
	mysqli_free_result($result);
	mysqli_close($link);
?>
</body>
</html>