<?php
include "../../../includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Acualizaci�n</title>
</head>
<body>
<?php
	foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
	$bd="novaquim";
	//ELIMINA DE LA COMPRA
	$qryinv="delete from det_compras where idCompra=$Factura and Codigo=$codigo";
	echo $qryinv;
	echo'<form action="detCompraval.php" method="post" name="formulario">';
	$link=conectarServidor();
	$result=mysql_db_query($bd,$qryinv);
	//ELIMINA DEL INVENTARIO
	$qryinv="select codTapa, invTapa from inv_tapas_val WHERE codTapa=$codigo;";
	$resultinv=mysql_db_query($bd,$qryinv);
	$rowinv=mysql_fetch_array($resultinv);
	$inv=$rowinv['inv_tapa'];	
	echo "actual";
	echo $inv;
	echo "<br>";
	echo "despues";
	$inv= $inv-$cantidad;
	echo $inv;
	$qryup="update inv_tapas_val set invTapa=$inv where codTapa=$codigo;";
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
	
	mysql_close($link);
?>
</body>
</html>