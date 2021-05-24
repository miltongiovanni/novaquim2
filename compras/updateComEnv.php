<?php
include "../includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Acualización</title>
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
if ($codigo<100)
{
	$qryinv="update det_compras set Cantidad=$cantidad, Precio=$Precio where idCompra=$Factura and Codigo=$codigo";
	echo'<form action="detCompraenv.php" method="post" name="formulario">';
	$link=conectarServidor();
	$result=mysqli_query($link,$qryinv);
	$qryinv="select codEnvase, invEnvase from inv_envase WHERE codEnvase=$codigo;";
	$resultinv=mysqli_query($link,$qryinv);
	$rowinv=mysqli_fetch_array($resultinv);
	$inv=$rowinv['inv_envase'];		
	$dif=$cantidad-$cant_ant;
	$inv=$inv+$dif;
	$qryup="update inv_envase set invEnvase=$inv where codEnvase=$codigo;";
	$resultup=mysqli_query($link,$qryup);
	echo '<input name="Factura" type="hidden" value="'.$Factura.'"/>
	<input name="CrearFactura" type="hidden" value="5"/>
	<input type="submit" name="Submit" value="Cambiar" />';
	if($result==1)
	{
		$ruta="";
		mover_pag($ruta,"Compra actualizada correctamente");
	}
	echo'</form>';
}
else
{
	$qryinv="update det_compras set Cantidad=$cantidad, Precio=$Precio where idCompra=$Factura and Codigo=$codigo";
	echo'<form action="detCompraenv.php" method="post" name="formulario">';
	$link=conectarServidor();
	$result=mysqli_query($link,$qryinv);
	$qryinv="select codTapa, invTapa from inv_tapas_val WHERE codTapa=$codigo;";
	$resultinv=mysqli_query($link,$qryinv);
	$rowinv=mysqli_fetch_array($resultinv);
	$inv=$rowinv['inv_tapa'];		
	$dif=$cantidad-$cant_ant;
	$inv=$inv+$dif;
	$qryup="update inv_tapas_val set invTapa=$inv where codTapa=$codigo;";
	$resultup=mysqli_query($link,$qryup);
	echo '<input name="Factura" type="hidden" value="'.$Factura.'"/>
	<input name="CrearFactura" type="hidden" value="5"/>
	<input type="submit" name="Submit" value="Cambiar" />';
	if($result==1)
	{
		$ruta="";
		mover_pag($ruta,"Pedido Actualizado correctamente");
	}
	echo'</form>';
	mysqli_free_result($result);
	mysqli_free_result($resultinv);
	mysqli_close($link);
	}
	
?>
</body>
</html>