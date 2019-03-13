<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Seleccionar precio o precios</title>
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
	</script></head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>SELECCIONAR PRECIO O PRECIOS PARA LA LISTA</strong></div>
<form method="post" action="det_lista_precios.php" name="form1">	
  	<table align="center" width="27%">
     <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      	<td width="34%" align="right"><strong>Presentaci&oacute;n</strong></td>
      	<td colspan="2">
        <input name="Presentaciones" type="radio" id="Presentaciones_0" value="1" checked> 
        Todas
        <input type="radio" name="Presentaciones" value="2" id="Presentaciones_1"> 
        Peque&ntilde;as
        <input type="radio" name="Presentaciones" value="3" id="Presentaciones_2"> 
        Grandes		</td>
    </tr>
    <tr>
      	<td align="right" rowspan="5"><strong>Precio</strong></td>
   	  <td width="10%" colspan="1" align="right">F&aacute;brica</td><td width="56%"><input type="checkbox" name="seleccion1[]"  align="right" value="1"></td></tr>
        <tr><td colspan="1" align="right">Distribuidor</td><td><input type="checkbox" name="seleccion1[]"  align="right" value="2"></td></tr>
        <tr><td colspan="1" align="right">Detal</td><td><input type="checkbox" name="seleccion1[]"  align="right" value="3"></td></tr>
        <tr><td colspan="1" align="right">Mayorista</td><td><input type="checkbox" name="seleccion1[]"  align="right" value="4"></td></tr>
        <tr><td colspan="1" align="right">Superetes</td><td><input type="checkbox" name="seleccion1[]"  align="right" value="5"></td></tr>    
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr> 
    <tr>
   	  <td colspan="3"><div align="center"><input name="button" type="button" onClick="return Enviar(this.form);" value="Continuar"></div></td>
    </tr>    
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr> 

    <tr> 
        <td colspan="3">
        <div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div>        </td>
    </tr>
  </table>
</form> 
</div>
</body>
</html>
