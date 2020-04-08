<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Actualizaci&oacute;n compra distribuci&oacute;n</title>
</head>
<body>
<?php
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  
	$qryinv="update det_compras set Cantidad=$cantidad, Precio=$Precio where Id_compra=$factura and Codigo=$codigo";
	echo $qryinv;
	echo'<form action="detCompradist.php" method="post" name="formulario">';
	$link=conectarServidor();
	$result=mysqli_query($link,$qryinv);
	$qryinv="select Id_distribucion, inv_dist from inv_distribucion WHERE Id_distribucion=$codigo;";
	$resultinv=mysqli_query($link,$qryinv);
	$rowinv=mysqli_fetch_array($resultinv);
	$inv=$rowinv['inv_dist'];		
	$dif=$cantidad-$cant_ant;
	$inv=$inv+$dif;
	$qryup="update inv_distribucion set inv_dist=$inv where Id_distribucion=$codigo;";
	$resultup=mysqli_query($link,$qryup);
	// ACTUALIZA EL PRECIO 
	$qryup2="update distribucion set precio_com=$Precio where Id_distribucion=$codigo";
	//echo $qryup2;
	$resultup2=mysqli_query($link,$qryup2);  
	echo '<input name="Factura" type="hidden" value="'.$factura.'"/>
	<input name="CrearFactura" type="hidden" value="5"/>
	<input type="submit" name="Submit" value="Cambiar" />';
	if($result==1)
	{
		$ruta="";
		mover_pag($ruta,"Pedido Actualizado correctamente");
	}
	echo'</form>';
	function mover_pag($ruta,$nota)
	{
	echo'<script >
	document.formulario.submit();
	</script>';
	}
	mysqli_free_result($resultinv);
	mysqli_close($link);
?>
</body>
</html>