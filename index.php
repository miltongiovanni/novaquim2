<!DOCTYPE html>
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
<form method="POST" action="login.php">
<table  align="center" summary="cuerpo">	
    <tr>
      <td width="93"><div align="right"><label for="Nombre"><b>Usuario</b></label></div></td>
      <td colspan="2"><input type="text" name="Nombre" id="Nombre" size=19 maxlength="10" placeholder="Ingrese el usuario"></td>
    </tr>
    <tr>
      <td><div align="right"><label for="Password"><b>Contrase&ntilde;a</b></label></div></td>
      <td colspan="2"><input type="password" name="Password" id="Password" size=19 maxlength="15" placeholder="Contraseña"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="66"><button class="button" style="vertical-align:middle" onclick="return Enviar(this.form)"><span>Continuar</span></button></td>
      <td width="66"><button class="button" style="vertical-align:middle" type="reset"><span>Borrar</span></button></td>
    </tr>

</table>
</form>
</div>
</body>
</html>