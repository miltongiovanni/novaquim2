<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Sistema de Informaci&oacute;n de Industrias Novaquim S.A.S.</title>
    <meta charset="utf-8">
    <script type="text/javascript" src="scripts/validar.js"></script>
    <script type="text/javascript" src="scripts/block.js"></script>
	<script type="text/javascript">
		document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">

<div id="saludo"><strong>BIENVENIDO AL SISTEMA DE INFORMACI&Oacute;N DE INDUSTRIAS NOVAQUIM S.A.S.</strong></div> 
<form method="POST" action="login1.php">
<table  align="center" summary="cuerpo">	
    <tr>
      <td width="93"><div align="right"><b>Usuario</b></div></td>
      <td colspan="2"><input type="text" name="Nombre" size=19 maxlength="10"></td>
    </tr>
    <tr>
      <td><div align="right"><b>Contrase&ntilde;a</b></div></td>
      <td colspan="2"><input type="password" name="Password" size=19 maxlength="10"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="66"><input name="button" type="button" onClick="return Enviar(this.form)" value="Enviar"></td>
      <td width="66"><input name="reset" type="reset" value="Borrar"></td>
    </tr>

</table>
</form>
</div>
</body>
</html>