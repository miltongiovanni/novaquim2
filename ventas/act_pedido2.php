<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Creación de Orden de Pedido</title>
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
<div id="saludo"><strong>CREACIÓN DE ORDEN DE PEDIDO</strong></div>
<?php
	include "includes/conect.php";
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	} 
	$link=conectarServidor();
	$result11=mysqli_query($link,"update pedido set Nit_cliente='$Nit_cliente' where idPedido=$pedido");
	
	$qry22="select idPedido, Nit_cliente, fechaPedido, fechaEntrega, tipoPrecio, Estado, idSucursal, tipo_precio, Nom_sucursal from pedido, tip_precio, clientes_sucursal where tipoPrecio=Id_precio and Nit_cliente=Nit_clien and idSucursal=Id_sucursal and idPedido=$pedido";
	$result22=mysqli_query($link, $qry22);
	$row22=mysqli_fetch_array($result22);
?>
<form method="post" action="det_pedido.php" name="form1">	
  	<table align="center" summary="detalle pedido">
     <tr>
      	<td width="170" align="right"><strong>No. Pedido:</strong></td>
   	  <td width="379">
		<input type="text" name="pedido" readonly value="<?php echo $pedido; ?>" size=50></td>
    </tr>
    <tr>
      	<td width="170" align="right"><strong>Cliente</strong></td>
   	  <td width="379">
		<?php
			$link=conectarServidor();
			$result=mysqli_query($link, "select Nit_cliente, nomCliente from pedido, clientes WHERE Nit_cliente=nitCliente and idPedido=$pedido");
			$row=mysqli_fetch_array($result);
			echo '<input type="text" name="nom_cliente" readonly value="'.$row['Nom_clien'].'" size=50>';
			echo '<input type="hidden" name="cliente" readonly value="'.$row['Nit_cliente'].'">';
			mysqli_close($link);
		?>        </td>
    </tr>
    <tr>
      	<td width="170" align="right"><strong>Sucursal</strong></td>
   	  <td width="379">
		<?php
			$link=conectarServidor();
			echo'<select name="sucursal" id="combo">';
			$result=mysqli_query($link, "SELECT Id_sucursal, Nom_sucursal from clientes_sucursal where Nit_clien='$Nit_cliente';");
			$result1=mysqli_query($link, "select Id_sucursal, Nom_sucursal from pedido, clientes, clientes_sucursal WHERE Nit_cliente=clientes.nitCliente and clientes.nitCliente=clientes_sucursal.Nit_clien and idSucursal=Id_sucursal and  idPedido=$pedido;");
			$row1=mysqli_fetch_array($result1);
			echo '<option selected value='.$row1['Id_sucursal'].'>'.$row1['Nom_sucursal'].'</option>';
			while($row=mysqli_fetch_array($result))
			{	
				if($row['Id_sucursal']!=$row1['Id_sucursal'])
				echo '<option value='.$row['Id_sucursal'].'>'.$row['Nom_sucursal'].'</option>';
			}
			echo'</select>';
			mysqli_close($link);
		?>        </td>
    </tr>
     <tr>
      <td align="right"><strong>Fecha de Pedido</strong></td>
      <td><input type="text" name="FchPed" id="sel1" value="<?php echo $row22['Fech_pedido'];?>" readonly size=20><input type="reset" value=" ... "
		onclick="return showCalendar('sel1', '%Y-%m-%d', '12', true);"></td>
    </tr>
    <tr>
      <td align="right"><strong>Fecha de Entrega</strong></td>
      <td><input type="text" name="FchEnt" id="sel2" readonly value="<?php echo $row22['Fech_entrega'];?>" size=20><input type="reset" value=" ... "
		onclick="return showCalendar('sel2', '%Y-%m-%d', '12', true);"></td>
    </tr>
    <tr>
      <td align="right"><strong>Precio Prod Novaquim</strong></td>
      <td>
      <?php
				//include "conect.php";
				$link=conectarServidor();
				echo'<select name="tip_precio">';
				$result=mysqli_query($link, "select Id_precio, tipo_precio from tip_precio;");
				echo '<option selected value="'.$row22['tip_precio'].'">'.$row22['tipo_precio'].'</option>';
				while($row=mysqli_fetch_array($result)){
				if($row['Id_precio']!=$row22['tip_precio'])
					echo '<option value="'.$row['Id_precio'].'">'.$row['tipo_precio'].'</option>';
				}
				echo'</select>';
				mysqli_close($link);
	   ?>	  </td>
    </tr>
    <tr>
      <td align="right"><strong>% de Sobrecosto</strong></td>
      <td><input type="text" name="sobre" size=15 value="0" onKeyPress="return aceptaNum(event)"></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">&nbsp;</div><input name="Crear" type="hidden" value="6"></td>
    </tr>    
    <tr>
   	  <td>&nbsp;</td>
   	  <td><div align="right"><input name="button" type="button" class="formatoBoton1" onClick="return Enviar(this.form);" value="Continuar"></div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="2">
        <div align="center"><input type="button" class="formatoBoton1" onClick="history.back()" value="  VOLVER  "></div>        </td>
    </tr>

  </table>
</form> 
</div>
</body>
</html>