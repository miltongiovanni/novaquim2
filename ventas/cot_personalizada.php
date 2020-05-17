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
<div id="saludo"><strong>CREACIÓN DE COTIZACIÓN PERSONALIZADA</strong></div>
<form method="post" action="det_cot_personalizada.php" name="form1">	
  	<table width="451" border="0" align="center">
    <tr>
      	<td width="138" align="right"><strong>Cliente:</strong></td>
   	  <td width="303">
		<?php
			include "includes/conect.php";
			$link=conectarServidor();
			echo'<select name="cliente" id="combo">';
			$result=mysqli_query($link,"select Id_cliente, Nom_clien from clientes_cotiz order BY Nom_clien");
			echo '<option selected value="">-----------------------------------------------------------------------------------</option>';
			while($row=mysqli_fetch_array($result)){
				echo '<option value='.$row['Id_cliente'].'>'.$row['Nom_clien'].'</option>';
			}
			echo'</select>';
			mysqli_close($link);
		?>        </td>
    </tr>
     <tr>
      <td align="right"><strong>Fecha de Cotización</strong></td>
      <td colspan="3"><input type="text" name="FchCot" id="sel1" readonly size=20><input type="reset" value=" ... "
		onclick="return showCalendar('sel1', '%Y-%m-%d', '10', true);"></td>
    </tr>
        <input name="Crear" type="hidden" value="3">
     <tr>
      	<td align="right"><strong>Destino</strong></td>
      	<td colspan="3">
        <input name="Destino" type="radio" id="Destino_0" value="1" checked> 
        Impresión
        <input type="radio" name="Destino" value="2" id="Destino_1"> 
        Correo electrónico</td>
    </tr> 
    <tr>
      <td align="right"><strong>Tipo de Precio</strong></td>
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
				mysqli_close($link);
	   ?>	  </td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>    
    <tr>
   	  <td colspan="2"><div align="center"><input name="button" type="button" onClick="return Enviar(this.form);" value="Continuar"></div></td>
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