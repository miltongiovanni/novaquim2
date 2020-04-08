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
	if ($codigo<100)
	{
		//ELIMINA DE LA COMPRA
		$qryinv="delete from det_compras where Id_compra=$Factura and Codigo=$codigo";
		echo $qryinv;
		echo'<form action="detCompraenv.php" method="post" name="formulario">';
		$link=conectarServidor();
		$result=mysqli_query($link, $qryinv);
		//ELIMINA DEL INVENTARIO
		$qryinv="select Cod_envase, inv_envase from inv_envase WHERE Cod_envase=$codigo;";
		$resultinv=mysqli_query($link, $qryinv);
		$rowinv=mysqli_fetch_array($resultinv);
		$inv=$rowinv['inv_envase'];	
		echo "actual";
		echo $inv;
		echo "<br>";
		echo "despues";
		$inv= $inv-$cantidad;
		echo $inv;
		$qryup="update inv_envase set inv_envase=$inv where Cod_envase=$codigo;";
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
		$qryinv="delete from det_compras where Id_compra=$Factura and Codigo=$codigo";
		echo $qryinv;
		echo'<form action="detCompraenv.php" method="post" name="formulario">';
		$link=conectarServidor();
		$result=mysqli_query($link, $qryinv);
		//ELIMINA DEL INVENTARIO
		$qryinv="select Cod_tapa, inv_tapa from inv_tapas_val WHERE Cod_tapa=$codigo;";
		$resultinv=mysqli_query($link, $qryinv);
		$rowinv=mysqli_fetch_array($resultinv);
		$inv=$rowinv['inv_tapa'];	
		echo "actual";
		echo $inv;
		echo "<br>";
		echo "despues";
		$inv= $inv-$cantidad;
		echo $inv;
		$qryup="update inv_tapas_val set inv_tapa=$inv where Cod_tapa=$codigo;";
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
	function mover_pag($ruta,$nota)
	{
	echo'<script >
	document.formulario.submit();
	</script>';
	}
	mysqli_free_result($result);
	mysqli_free_result($resultinv);
	mysqli_close($link);
?>
</body>
</html>