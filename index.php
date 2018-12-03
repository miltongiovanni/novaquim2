<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
  <title>Sistema de Información de Industrias Novaquim S.A.S.</title>


  <script type="text/javascript" src="js/validar.js"></script>
  <script type="text/javascript" src="js/block.js"></script>

</head>

<body>
  <div id="contenedor">
    <div id="saludo"><strong>BIENVENIDO AL SISTEMA DE INFORMACIÓN DE INDUSTRIAS NOVAQUIM S.A.S.</strong></div>
    <form method="POST" action="login.php">
      <div style="overflow-x:auto;">
        <table id="loginTable">
          <tr>
            <td class="label">
              <div style="text-align: right;"><label for="Nombre"><b>Usuario:</b></label></div>
            </td>
            <td>
              <div style="text-align: left;"><input type="text" name="Nombre" id="Nombre" size=19 maxlength="10" placeholder="Ingrese el usuario"
                  autofocus></div>
            </td>
          </tr>
          <tr>
            <td class="label">
              <div style="text-align: right;"><label for="Password"><b>Contrase&ntilde;a:</b></label></div>
            </td>
            <td colspan="2">
              <div style="text-align: left;"><input type="password" name="Password" id="Password" size=19 maxlength="15" placeholder="Contraseña"></div>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>
              <div style="text-align: left;"><button class="button" style="vertical-align:middle" onclick="return Enviar(this.form)"><span>Continuar</span></button>
                <button class="button" style="vertical-align:middle" type="reset"><span>Borrar</span></button></div>
            </td>
          </tr>

        </table>
      </div>
    </form>

  </div>
</body>

</html>