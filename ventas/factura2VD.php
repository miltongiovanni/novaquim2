<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Factura de Venta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script  src="../js/validar.js"></script>
	<script  src="scripts/block.js"></script>
    <link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue2.css" title="blue" />
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
<table align="center">
     <?php
	 	include "includes/conect.php";
		foreach ($_POST as $nombre_campo => $valor) 
		{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
		}  
		$link=conectarServidor();
		$bd="novaquim";
		$qry="select Factura, Nit_cliente, nomCliente, fechaFactura, fechaVenc, codVendedor, nom_personal, tipPrecio, tipo_precio, ordenCompra, Descuento, idPedido, Observaciones 
			from factura, clientes,	personal, tip_precio 
			WHERE factura.Nit_cliente=nitCliente and codVendedor=Id_personal and tipPrecio=Id_precio and Factura=$factura";
		$result=mysql_db_query($bd,$qry);
		$row=mysql_fetch_array($result);
		if ($row)
		{
			$estado=$row['Estado'];
			mysql_close($link);
		}
		else
		{
			mysql_close($link);
			mover("crearFactura.php","No existe la Orden de Pedido");
		}
	
		function mover($ruta,$mensaje)
		{
			//Funcion que permite el redireccionamiento de los usuarios a otra pagina 
			echo'<script >
			alert("'.$mensaje.'")
			self.location="'.$ruta.'"
			</script>';
		}
	 ?>
         <form method="post" action="det_factura.php" name="form1">	
    <tr>
        <td width="173" align="right"><strong>No. de Factura</strong></td>
        <td width="262"><?php echo $row['Factura'];?> </td>
    </tr>
    <tr>
        <td align="right"><strong>Cliente</strong></td>
        <td><?php echo $row['Nom_clien'];?><input type="hidden" name="nit" value="<?php echo $row['Nit_cliente'];?>"></td>
    </tr>
    <tr>
        <td align="right"><strong>Fecha de Venta</strong></td>
        <td><input type="text" name="FchVta" id="sel1" readonly="true" value="<?php echo $row['Fech_fact'];?>" size=20><input type="reset" value=" ... "
        onclick="return showCalendar('sel1', '%Y-%m-%d', '12', true);"></td>
    </tr>
    <tr>
        <td align="right"><strong>Fecha de Vencimiento</strong></td>
        <td><input type="text" name="FchVen" id="sel2" readonly="true" value="<?php echo $row['Fech_venc'];?>" size=20><input type="reset" value=" ... "
        onclick="return showCalendar('sel2', '%Y-%m-%d', '12', true);"></td>
    </tr>
    <tr>
        <td align="right"><strong>Vendedor</strong></td>
        <td><?php echo $row['nom_personal']; ?><input type="hidden" name="cod_vend" value="<?php echo $row['Cod_vendedor'];?>"></td>
    </tr>
    <tr>
        <td align="right"><strong>Tipo de Precio</strong></td>
        <td><input type="text" name="tip_prec" value="<?php echo $row['tip_precio'];?>"></td>
    </tr>
    <tr>
        <td align="right"><strong>Orden de Compra</strong></td>
        <td><input name="ord_comp" type="text" size=20 onKeyPress="return aceptaNum(event)"  value="<?php echo $row['Ord_compra'];?>"/></td>
    </tr>
    <tr>
        <td align="right"><strong>Descuento</strong></td>
        <td><input name="descuento" type="text" size=20 onKeyPress="return aceptaNum(event)" value="<?php echo $row['Descuento']*100;?>" /></td>
    </tr>
    <tr>
        <td align="right"><strong>Observaciones</strong></td>
        <td><textarea name="observa" id="textarea" cols="40" rows="5" ><?php echo $row['Observaciones'];?>
        </textarea></td>
    </tr>
    <tr><td colspan="2"><div align="center">&nbsp;</div></td></tr> 
    <tr>
        <td>&nbsp;</td>
        <td><div align="right"><input name="button" type="button" onClick="return Enviar(this.form);" value="Continuar"></div></td>
    </tr><input type="hidden" name="Crear" value="5"><input type="hidden" name="pedido" value="<?php echo $row['Id_pedido'] ;?>"><input type="hidden" name="factura" value="<?php echo $row['Factura'] ;?>">
    <tr><td colspan="2"><div align="center">&nbsp;</div></td></tr>
    <tr><td colspan="2"><div align="center">&nbsp;</div></td></tr>
    <tr><td colspan="2"> <div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="  Ir al Menú  "></div></td></tr>
</form> 
</table>
</div>
</body>
</html>