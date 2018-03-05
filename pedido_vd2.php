<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Creaci&oacute;n de Orden de Pedido</title>
    <meta charset="utf-8">
    <link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="scripts/validar.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>	
    <link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue2.css" title="blue">
    <script type="text/javascript" src="scripts/calendar.js"></script>
    <script type="text/javascript" src="scripts/calendar-sp.js"></script>
    <script type="text/javascript" src="scripts/calendario.js"></script>
    <script type="text/javascript">
		document.onkeypress = stopRKey; 
	</script>
</head>
<body> 
<div id="contenedor">
<div id="saludo"><strong> ORDEN DE PEDIDO VENTA DIRECTA</strong></div>
<?php
	include "includes/conect.php";
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	} 
?>
<form method="post" action="det_pedidoVD.php" name="form1">	
  	<table align="center" summary="detalle pedido">
    <tr>
      <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
      	<td width="138" align="right"><strong>Distribuidora:</strong></td>
   	  <td width="379"><input type="hidden" name="sucursal" value="1" ><input type="hidden" name="tip_precio" value="6" ><input type="hidden" name="sobre" value="0">
		<?php
			$link=conectarServidor();
			$result=mysql_db_query("novaquim","select Nit_clien, Nom_clien from clientes where Nit_clien='$cliente'");
			$row=mysql_fetch_array($result);
			echo '<input type="text" name="nom_cliente" readonly value="'.$row['Nom_clien'].'" size=50>';
			echo '<input type="hidden" name="cliente" readonly value="'.$row['Nit_clien'].'">';
			mysql_close($link);
		?>        </td>
    </tr>
     <tr>
      <td align="right"><strong>Fecha de Pedido</strong></td>
      <td><input type="text" name="FchPed" id="sel1" readonly size=20><input type="reset" value=" ... "
		onclick="return showCalendar('sel1', '%Y-%m-%d', '12', true);"></td>
    </tr>
    <tr>
      <td align="right"><strong>Fecha de Entrega</strong></td>
      <td><input type="text" name="FchEnt" id="sel2" readonly size=20><input type="reset" value=" ... "
		onclick="return showCalendar('sel2', '%Y-%m-%d', '12', true);"></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">&nbsp;</div><input name="Crear" type="hidden" value="3"></td>
    </tr>    
    <tr>
   	  <td>&nbsp;</td>
   	  <td><div align="right"><input name="button" type="button" onClick="return Enviar(this.form);" value="Continuar"></div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="2">
        <div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div>        </td>
    </tr>

  </table>
</form> 
</div>
</body>
</html>