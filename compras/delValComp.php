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
	$bd="novaquim";
	//ELIMINA DE LA COMPRA
	$qryinv="delete from det_compras where Id_compra=$Factura and Codigo=$codigo";
	echo $qryinv;
	echo'<form action="detCompraval.php" method="post" name="formulario">';
	$link=conectarServidor();
	$result=mysql_db_query($bd,$qryinv);
	//ELIMINA DEL INVENTARIO
	$qryinv="select Cod_tapa, inv_tapa from inv_tapas_val WHERE Cod_tapa=$codigo;";
	$resultinv=mysql_db_query($bd,$qryinv);
	$rowinv=mysql_fetch_array($resultinv);
	$inv=$rowinv['inv_tapa'];	
	echo "actual";
	echo $inv;
	echo "<br>";
	echo "despues";
	$inv= $inv-$cantidad;
	echo $inv;
	$qryup="update inv_tapas_val set inv_tapa=$inv where Cod_tapa=$codigo;";
	echo $qryup;
	$resultup=mysql_db_query($bd,$qryup);
	echo "<br>";
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
	mysql_close($link);
?>
</body>
</html>