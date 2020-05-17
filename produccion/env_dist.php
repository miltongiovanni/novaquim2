<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
    <meta charset="utf-8">
    <title>Seleccionar Producto a Envasar</title>
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
<div id="saludo"><strong>ENVASADO DE PRODUCTOS DE DISTRIBUCIÓN</strong></div>
<form id="form1" name="form1" method="post" action="det_env_dist.php">
<table border="0" align="center">	
    <tr>
    	<td width="197"><div align="right"><strong>Producto de Distribución</strong></div></td>
      <td width="221">
      	<div align="center">  
			<?php
				include "includes/conect.php";
				$link=conectarServidor();
				echo'<select name="IdDist">';
				$result=mysqli_query($link,"select Cod_dist, Producto from rel_dist_mp, distribucion where Cod_dist=Id_distribucion;");
				echo '<option value="" selected>--------------------------------------------------------------</option>';
				while($row=mysqli_fetch_array($result))
				{
					echo '<option value='.$row['Cod_dist'].'>'.$row['Producto'].'</option>';
				}
				echo'</select>';
				mysqli_close($link);
			?>
      	</div>      </td>
  	</tr>
    <tr> 
<td><div align="right"><strong>Cantidad</strong></div></td>
<td><input type="text" name="Cantidad" size=15 onKeyPress="return aceptaNum(event)"></td>
    </tr>
    <tr>
      <td><div align="right"><strong>Fecha </strong></div></td>
      <td colspan="2"><input type="text" name="Fecha" id="sel1" readonly size=20><input type="reset" value=" ... "
		onclick="return showCalendar('sel1', '%Y-%m-%d', '12', true);"></td>
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td align="right"></td>
      <td align="left"><input type="reset" value="Restablecer" >&nbsp;&nbsp;<input type="button" value="     Enviar     " onclick="return Enviar(this.form);"></td>
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
