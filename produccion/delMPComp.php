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
		echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  
	//ELIMINA DE LA COMPRA
	$qryinv="delete from det_compras where Id_compra=$Factura and Codigo=$codigo";
	echo $qryinv;
	echo'<form action="detCompramp.php" method="post" name="formulario">';
	$link=conectarServidor();
	$result=mysqli_query($link,$qryinv);
	//ELIMINA DEL INVENTARIO
	$qryinv="select Cod_mprima, inv_mp from inv_mprimas WHERE Cod_mprima=$codigo and Lote_mp='$lote_mp';";
	echo $qryinv;
	$resultinv=mysqli_query($link,$qryinv);
	$rowinv=mysqli_fetch_array($resultinv);
	$inv=$rowinv['inv_mp'];	
	echo "actual";
	echo $inv;
	echo "<br>";
	echo "despues";
	$inv= $inv-$cantidad;
	echo $inv;
	$qryup="update inv_mprimas set inv_mp=$inv where Cod_mprima=$codigo and Lote_mp='$lote_mp';";
	echo $qryup;
	$resultup=mysqli_query($link,$qryup);
	echo "<br>";
	echo '<input name="Factura" type="hidden" value="'.$Factura.'"/>
	<input name="CrearFactura" type="hidden" value="5"/>
	<input type="submit" name="Submit" value="Cambiar" />';
	if($result==1)
	{
		$ruta="";
		mover_pag($ruta,"Compra actualizada correctamente");
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