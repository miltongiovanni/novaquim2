<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<HTML>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Cambio de Contrase&ntilde;a</title>
	<script type="text/javascript" src="scripts/validar.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>	
</head>
<body> 
<div id="contenedor">
	<div id="saludo"><strong>CAMBIO DE CONTRASE&Ntilde;A</strong></div> 
<?php
	$nombre= $_SESSION['User'];
?>
<form action="change.php" method="POST" name="Cambio_clave" id="Cambio_clave">
<table width="327" align ="center" id="pass">  
<tr>
	<td width="167"><div align="right"><label for="Nombre"><b>Nombre de usuario</b></label></div></td>
	<td colspan="2"><input name="Nombre" id="Nombre" value="<?php echo $nombre ?>" readonly size="20"></td>
</tr>
<tr>
	<td><div align="right"><label for="Password"><strong>Contrase&ntilde;a actual</strong></label></div></td>
	<td colspan="2"><input type="password" name="Password" id="Password" size="20"></td>
</tr>
<tr>
	<td><div align="right"><label for="NewPass"><strong>Contrase&ntilde;a nueva</strong></label></div></td>
	<td colspan="2"><input type="password" name="NewPass" id="NewPass" size="20"></td>
</tr>
<tr>
	<td><div align="right"><label for="ConfPass"><strong>Confirmaci&oacute;n </strong></label></div></td>
	<td colspan="2"><input type="password" name="ConfPass" id="ConfPass" size="20"></td>
</tr>
<tr><td>&nbsp;</td>
    <td width="68"><button class="button" style="vertical-align:middle" onclick="return Enviar(this.form)"><span>Cambiar</span></button></td>
	<td width="80"><button class="button" style="vertical-align:middle" type="reset"><span>Borrar</span></button></td>
</tr>

<tr>
    <td colspan="3"><div align="center">&nbsp;</div></td>
</tr>
<tr>
    <td colspan="3"><div align="center">&nbsp;</div></td>
</tr>
<tr> 
    <td colspan="3"><div align="center"><button class="button1" id="back" style="vertical-align:middle" onClick="history.back()"> <span>VOLVER</span></button></div></td>
</tr>
</table>
</form>
</div>
</body>
</HTML>
