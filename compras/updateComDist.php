<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html lang="es">
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
	$qryinv="update det_compras set Cantidad=$cantidad, Precio=$Precio where idCompra=$factura and Codigo=$codigo";
	echo $qryinv;
	echo'<form action="detCompradist.php" method="post" name="formulario">';
	$link=conectarServidor();
	$result=mysqli_query($link,$qryinv);
	$qryinv="select codDistribucion, invDistribucion from inv_distribucion WHERE codDistribucion=$codigo;";
	$resultinv=mysqli_query($link,$qryinv);
	$rowinv=mysqli_fetch_array($resultinv);
	$inv=$rowinv['inv_dist'];		
	$dif=$cantidad-$cant_ant;
	$inv=$inv+$dif;
	$qryup="update inv_distribucion set invDistribucion=$inv where codDistribucion=$codigo;";
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
	
	mysqli_free_result($resultinv);
	mysqli_close($link);
?>
</body>
</html>