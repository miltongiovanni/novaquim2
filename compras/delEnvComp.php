<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html lang="es">
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
	if ($codigo<100)
	{
		//ELIMINA DE LA COMPRA
		$qryinv="delete from det_compras where idCompra=$Factura and Codigo=$codigo";
		echo $qryinv;
		echo'<form action="detCompraenv.php" method="post" name="formulario">';
		$link=conectarServidor();
		$result=mysqli_query($link, $qryinv);
		//ELIMINA DEL INVENTARIO
		$qryinv="select codEnvase, invEnvase from inv_envase WHERE codEnvase=$codigo;";
		$resultinv=mysqli_query($link, $qryinv);
		$rowinv=mysqli_fetch_array($resultinv);
		$inv=$rowinv['inv_envase'];	
		echo "actual";
		echo $inv;
		echo "<br>";
		echo "despues";
		$inv= $inv-$cantidad;
		echo $inv;
		$qryup="update inv_envase set invEnvase=$inv where codEnvase=$codigo;";
		echo $qryup;
		$resultup=mysqli_query($link, $qryup);
		echo "<br>";
		echo '<input name="Factura" type="hidden" value="'.$Factura.'"/>
		<input name="CrearFactura" type="hidden" value="5"/>
		<input type="submit" name="Submit" value="Cambiar" />';
		if($result==1)
		{
			$ruta="";
			mover_pag($ruta,"Envase eliminado correctamente");
		}
		echo'</form>';
	}
	else
	{
		//ELIMINA DE LA COMPRA
		$qryinv="delete from det_compras where idCompra=$Factura and Codigo=$codigo";
		echo $qryinv;
		echo'<form action="detCompraenv.php" method="post" name="formulario">';
		$link=conectarServidor();
		$result=mysqli_query($link, $qryinv);
		//ELIMINA DEL INVENTARIO
		$qryinv="select codTapa, invTapa from inv_tapas_val WHERE codTapa=$codigo;";
		$resultinv=mysqli_query($link, $qryinv);
		$rowinv=mysqli_fetch_array($resultinv);
		$inv=$rowinv['inv_tapa'];	
		echo "actual";
		echo $inv;
		echo "<br>";
		echo "despues";
		$inv= $inv-$cantidad;
		echo $inv;
		$qryup="update inv_tapas_val set invTapa=$inv where codTapa=$codigo;";
		echo $qryup;
		$resultup=mysqli_query($link, $qryup);
		echo "<br>";
		echo '<input name="Factura" type="hidden" value="'.$Factura.'"/>
		<input name="CrearFactura" type="hidden" value="5"/>
		<input type="submit" name="Submit" value="Cambiar" />';
		if($result==1)
		{
			$ruta="";
			mover_pag($ruta,"Tapa eliminada correctamente");
		}
		echo'</form>';
	}
	
	mysqli_free_result($result);
	mysqli_free_result($resultinv);
	mysqli_close($link);
?>
</body>
</html>