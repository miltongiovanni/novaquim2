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
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	} 
?>
<form method="post" action="det_pedido.php" name="form1">	
  	<table align="center" summary="detalle pedido">
    <tr>
      	<td width="170" align="right"><strong>Cliente</strong></td>
   	  <td width="379">
		<?php
			$link=conectarServidor();
			$result=mysqli_query($link,"select nitCliente, nomCliente from clientes where nitCliente='$cliente'");
			$row=mysqli_fetch_array($result);
			echo '<input type="text" name="nom_cliente" readonly value="'.$row['Nom_clien'].'" size=50>';
			echo '<input type="hidden" name="cliente" readonly value="'.$row['Nit_clien'].'">';
			mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
		?>        </td>
    </tr>
    <tr>
      	<td width="170" align="right"><strong>Sucursal</strong></td>
   	  <td width="379">
		<?php
			$link=conectarServidor();
			echo'<select name="sucursal" id="combo">';
			$result=mysqli_query($link,"SELECT idSucursal, nomSucursal from clientes_sucursal where Nit_clien='$cliente';");
			
			while($row=mysqli_fetch_array($result))
			{	
				if($row['Id_sucursal']==1)
				echo '<option selected value="1">'.$row['Nom_sucursal'].'</option>';
				if($row['Id_sucursal']>1)
				echo '<option value='.$row['Id_sucursal'].'>'.$row['Nom_sucursal'].'</option>';
			}
			echo'</select>';
			mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
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
      <td align="right"><strong>Precio Prod Novaquim</strong></td>
      <td>
      <?php
				//include "conect.php";
				$link=conectarServidor();
				echo'<select name="tip_precio">';
				$result=mysqli_query($link,"select Id_precio, tipo_precio from tip_precio;");
				echo '<option selected value="2">Distribuidor</option>';
				while($row=mysqli_fetch_array($result)){
				if($row['Id_precio']!=2)
					echo '<option value='.$row['Id_precio'].'>'.$row['tipo_precio'].'</option>';
				}
				echo'</select>';
				mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
	   ?>	  </td>
    </tr>
    <tr>
      <td align="right"><strong>% de Sobrecosto</strong></td>
      <td><input type="text" name="sobre" size=15 value="0" onKeyPress="return aceptaNum(event)"></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">&nbsp;</div><input name="Crear" type="hidden" value="3"></td>
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