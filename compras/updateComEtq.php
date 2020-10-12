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
	$qryinv="update det_compras set Cantidad=$cantidad, Precio=$Precio where idCompra=$factura and Codigo=$codigo";
	echo'<form action="detCompraetq.php" method="post" name="formulario">';
	$link=conectarServidor();
	$result=mysqli_query($link,$qryinv);
	$qryinv="select codEtiq, invEtiq from inv_etiquetas WHERE codEtiq=$codigo;";
	$resultinv=mysqli_query($link,$qryinv);
	$rowinv=mysqli_fetch_array($resultinv);
	$inv=$rowinv['inv_etiq'];		
	$dif=$cantidad-$cant_ant;
	$inv=$inv+$dif;
	$qryup="update inv_etiquetas set invEtiq=$inv where codEtiq=$codigo;";
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
	
	
?>
</body>
</html>