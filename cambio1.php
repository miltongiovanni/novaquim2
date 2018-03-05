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
    	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>

</head>
<body> 
<div id="contenedor">

<div id="saludo"><strong>CAMBIO DE CONTRASE&Ntilde;A</strong></div> 
<!--background="../Imagenes/fondo.bmp">-->
<?php
$nombre= $_POST['IdUsuario'];
?>
<form action="change1.php" method="POST" name="Cambio_clave" id="Cambio_clave">
<table width="327" align ="center" id="pass">  
<tr>
	<td width="167"><div align="right"><strong>Nombre de usuario</strong></div></td>
	<td colspan="2"><input name="Nombre" value="<?php echo $nombre ?>" readonly size="20"></td>
</tr>
<tr>
	<td><div align="right"><strong>Contrase&ntilde;a nueva</strong></div></td>
	<td colspan="2"><input type="password" name="NewPass" size="20"></td>
</tr>
<tr>
	<td><div align="right"><strong>Confirmaci&oacute;n </strong></div></td>
	<td colspan="2"><input type="password" name="ConfPass" size="20"></td>
</tr>
<tr><td>&nbsp;</td>
    <td width="68"><input type="button" name="Grabar" value="Cambiar" onClick="return Enviar(this.form);"></td>
	<td width="80"><input type="reset" value="   Borrar   " name="Borrar"></td>
</tr>

<tr>
    <td colspan="3"><div align="center">&nbsp;</div></td>
</tr>
<tr>
    <td colspan="3"><div align="center">&nbsp;</div></td>
</tr>
<tr> 
    <td colspan="3">
    <div align="center"><input type="button" class="resaltado" onClick="history.back()" value="VOLVER"></div>    </td>
</tr>
</table>
</form>
</div>
</body>
</HTML>
