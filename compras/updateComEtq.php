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
	$qryinv="update det_compras set Cantidad=$cantidad, Precio=$Precio where Id_compra=$factura and Codigo=$codigo";
	echo'<form action="detCompraetq.php" method="post" name="formulario">';
	$link=conectarServidor();
	$result=mysqli_query($link,$qryinv);
	$qryinv="select Cod_etiq, inv_etiq from inv_etiquetas WHERE Cod_etiq=$codigo;";
	$resultinv=mysqli_query($link,$qryinv);
	$rowinv=mysqli_fetch_array($resultinv);
	$inv=$rowinv['inv_etiq'];		
	$dif=$cantidad-$cant_ant;
	$inv=$inv+$dif;
	$qryup="update inv_etiquetas set inv_etiq=$inv where Cod_etiq=$codigo;";
	$resultup=mysqli_query($link,$qryup);
	echo '<input name="Factura" type="hidden" value="'.$factura.'"/>
	<input name="CrearFactura" type="hidden" value="5"/>
	<input type="submit" name="Submit" value="Cambiar" />';
	if($result==1)
	{
		$ruta="";
		mysqli_close($link);
		mover_pag($ruta,"Pedido Actualizado correctamente");
	}
	echo'</form>';
	function mover_pag($ruta,$nota)
	{
	echo'<script >
	document.formulario.submit();
	</script>';
	}
	
?>
</body>
</html>