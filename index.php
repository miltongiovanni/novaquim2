<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
  <title>Sistema de Información de Industrias Novaquim S.A.S.</title>


  <script type="text/javascript" src="js/validar.js"></script>

</head>

<body>
  <div id="contenedor">
    <div id="saludo"><strong>BIENVENIDO AL SISTEMA DE INFORMACIÓN DE INDUSTRIAS NOVAQUIM S.A.S.</strong></div>
    <form method="POST" action="login.php">
      <div class="form-group row">
        <div class="col-1" style="text-align: right;">
          <label class="col-form-label" for="Nombre">Usuario:&nbsp;</label>
        </div>
        <div class="col-1">
          <input type="text" class="form-control" name="Nombre" id="Nombre" maxlength="10" placeholder="Usuario"
            autofocus>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-1" style="text-align: right;"> 
          <label class="col-form-label" for="Password">Contraseña:&nbsp;</label>
        </div>
        <div class="col-1"><input type="password" class="form-control" name="Password" id="Password" maxlength="15"
            placeholder="Contraseña">
        </div>
      </div>
      <div class="form-group row">
        <div class="col-1" style="text-align: center;">
          <button class="button" style="vertical-align:middle" onclick="return Enviar(this.form)"><span>Continuar</span></button>
        </div>
        <div class="col-1" style="text-align: center;">
          <button class="button" style="vertical-align:middle" type="reset"><span>Borrar</span></button>
        </div>
      </div>

    </form>

  </div>
</body>

</html>