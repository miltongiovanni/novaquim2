<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Remisi&oacute;n de Productos</title>
    <meta charset="utf-8">
    <link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script  src="scripts/validar.js"></script>
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
<div id="saludo"><strong>REMISI&Oacute;N DE PRODUCTOS</strong></div>
<?php
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
include "includes/conect.php";
$link=conectarServidor();
$result1=mysqli_query($link,"select cliente, Fech_remision, Valor from remision1 where Id_remision=$remision;");
$row1=mysqli_fetch_array($result1);




?>
<form method="post" action="det_remision.php" name="form1">	
<table align="center">
<tr>
      <td align="right"><strong>Remisi&oacute;n</strong></td>
      <td><input type="text" name="remision" size=41 readonly onKeyPress="return aceptaNum(event)" value="<?php echo $remision; ?>"></td>
    </tr>
    <tr>
      	<td width="93" align="right"><strong>Cliente</strong></td>
   	  <td width="380"><input type="text" name="cliente" size=40 value="<?php echo $row1['cliente']; ?>"></td>
    </tr> <tr>
      <td align="right"><strong>Fecha </strong></td>
      <td><input type="text" name="FchRem" id="sel1" readonly size=20 value="<?php echo $row1['Fech_remision']; ?>"><input type="reset" value=" ... "
		onclick="return showCalendar('sel1', '%Y-%m-%d', '12', true);"></td>
    </tr>
    <tr>
      <td align="right"><strong>Valor </strong></td>
      <td><input type="text" name="valor1" size=20 onKeyPress="return aceptaNum(event)" value="<?php echo $row1['Valor']; ?>"><input name="Crear" type="hidden" value="4"></td>
    </tr>
    <tr>
   	  <td>&nbsp;</td>
   	  <td><div align="right"><input name="button" type="button" onClick="return Enviar(this.form);" value="Continuar"></div></td>
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