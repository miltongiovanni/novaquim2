<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
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
	$qryinv="update det_compras set Cantidad=$cantidad, Precio=$Precio where Id_compra=$Factura and Codigo=$codigo";
	echo'<form action="detCompramp.php" method="post" name="formulario">';
	$link=conectarServidor();
	$result=mysqli_query($link, $qryinv);
	$qryinv="select Cod_mprima, Lote_mp, inv_mp from inv_mprimas WHERE Cod_mprima=$codigo AND Lote_mp='$lote_mp';";
	$resultinv=mysqli_query($link, $qryinv);
	$rowinv=mysqli_fetch_array($resultinv);
	$inv=$rowinv['inv_mp'];		
	$dif=$cantidad-$cant_ant;
	$inv=$inv+$dif;
	$qryup="update inv_mprimas set inv_mp=$inv where Cod_mprima=$codigo AND Lote_mp=$lote_mp;";
	$resultup=mysqli_query($link, $qryup);
	echo '<input name="Factura" type="hidden" value="'.$Factura.'"/>
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
	echo'<script language="Javascript">
	document.formulario.submit();
	</script>';
	}
	mysqli_free_result($resultinv);
	mysqli_close($link);
?>
</body>
</html>