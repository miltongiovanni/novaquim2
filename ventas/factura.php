<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Factura de Venta</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script  src="../js/validar.js"></script>
	<script  src="scripts/block.js"></script>	
    <link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue2.css" title="blue">
    <script  src="scripts/calendar.js"></script>
    <script  src="scripts/calendar-sp.js"></script>
    <script  src="scripts/calendario.js"></script>
    	<script >
	document.onkeypress = stopRKey; 
	</script>
</head>
<body> 	
<div id="contenedor">
<div id="saludo1"><strong>FACTURA DE VENTA</strong></div> 
<table width="47%" align="center">
     <?php
	 	include "includes/conect.php";
		foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
		$link=conectarServidor();
		$qry="Select nit_cliente, nomCliente, idPedido, fechaPedido, fechaEntrega, codVendedor, nom_personal, tipo_precio, Id_precio, pedido.Estado, nomSucursal, dirSucursal, idSucursal 
		FROM pedido, personal, clientes, tip_precio, clientes_sucursal 
		where codVendedor=Id_personal and idPedido=$pedido and clientes.nitCliente=nit_cliente and Id_precio=tipoPrecio and idSucursal=idSucursal and clientes_sucursal.Nit_clien=nit_cliente";
		$result=mysqli_query($link,$qry);
		$row=mysqli_fetch_array($result);
		if ($row)
		{
			$estado=$row['Estado'];
			if($estado=='F')
			{
				mysqli_close($link);
				mover("crearFactura.php","El Pedido ya fue Facturado");
			}
			if($estado=='A')
			{
				mysqli_close($link);
				mover("crearFactura.php","El Pedido está Anulado");
			}
			if($estado=='P')
			{
				mysqli_close($link);
				echo'<script >
				alert("El pedido no está listo");
				</script>';
				echo '<form method="post" action="inv_ped.php" name="form3">'; 
				echo'<input name="pedido" type="hidden" value="'.$pedido.'">'; 
				echo '</form>';
				echo'<script >
					document.form3.submit();
					</script>';	
			}
		}
		else
		{
			mysqli_close($link);
			mover("crearFactura.php","No existe la Orden de Pedido");
		}
		$qry2="select MAX(factura) as Factura from factura;";
		$result2=mysqli_query($link,$qry2);
		$row2=mysqli_fetch_array($result2);
		$fact=$row2['Factura']+1;	
		mysqli_close($link);
		function mover($ruta,$mensaje)
		{
			//Funcion que permite el redireccionamiento de los usuarios a otra pagina 
			echo'<script >
			alert("'.$mensaje.'")
			self.location="'.$ruta.'"
			</script>';
		}
	 ?>
     <form method="post" action="make_factura.php" name="form1">	
    <tr>
        <td width="46%" align="right"><strong>No. de Factura</strong></td>
        <td width="54%"><input name="factura" type="text" size=10 onKeyPress="return aceptaNum(event)" value="<?php //echo $fact; ?>" ></td>
    </tr>
    <tr>
        <td align="right"><strong>Cliente</strong></td>
        <td><?php echo $row['nom_clien'];?><input type="hidden" name="nit" value="<?php echo $row['nit_cliente'];?>"></td>
    </tr>
    <tr>
        <td align="right"><strong>Lugar de Entrega</strong></td>
        <td><?php echo $row['Nom_sucursal'];?><input type="hidden" name="id_sucursal" value="<?php echo $row['Id_sucurs'];?>"></td>
    </tr>
    <tr>
        <td align="right"><strong>Dirección de Entrega</strong></td>
        <td><?php echo $row['Dir_sucursal'];?></td>
    </tr>
    <tr>
        <td align="right"><strong>Fecha de Venta</strong></td>
        <td><input type="text" name="FchVta" id="sel1" readonly value="<?php echo $row['Fech_entrega'];?>" size=20><input type="reset" value=" ... "
        onclick="return showCalendar('sel1', '%Y-%m-%d', '12', true);"></td>
    </tr>
    <tr>
        <td align="right"><strong>Fecha de Vencimiento</strong></td>
        <td><input type="text" name="FchVen" id="sel2" readonly size=20><input type="reset" value=" ... "
        onclick="return showCalendar('sel2', '%Y-%m-%d', '12', true);"></td>
    </tr>
    <tr>
        <td align="right"><strong>Tipo de Precio</strong></td>
        <td><?php echo $row['tipo_precio']; ?><input type="hidden" name="tip_prec" value="<?php echo $row['Id_precio'];?>"></td>
    </tr>
    <tr>
        <td align="right"><strong>Orden de Compra</strong></td>
        <td><input name="ord_comp" type="text" size=20 onKeyPress="return aceptaNum(event)"  value="0"></td>
    </tr>
    <tr>
        <td align="right"><strong>Descuento</strong></td>
        <td><input name="descuento" type="text" size=20 onKeyPress="return aceptaNum(event)" value="0"></td>
    </tr>
    <tr>
        <td align="right"><strong>Observaciones</strong></td>
        <td><textarea name="observa" id="textarea" cols="45" rows="5"></textarea>
        </td>
    </tr>
        <td>&nbsp;</td>
        <td><div align="center"><input name="button" type="button" onClick="return Enviar(this.form);" value="Continuar"></div></td>
    </tr><input type="hidden" name="Crear" value="5"><input type="hidden" name="pedido" value="<?php echo $row['Id_pedido'] ;?>">
    <tr><td colspan="2"><div align="center">&nbsp;</div></td></tr>
    <tr><td colspan="2"><div align="center">&nbsp;</div></td></tr>
    <tr><td colspan="2"> <div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div></td></tr>
</form> 
</table>
</div>
</body>
</html>