<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
  <link rel="icon" href="images/favicon.ico" type="image/ico" sizes="16x16">
  <title>Sistema de Información de Industrias Novaquim S.A.S.</title>


  <script type="text/javascript" src="js/validar.js"></script>

</head>

<body>
  <div id="contenedor">
    <div id="saludo"><h4>BIENVENIDO AL SISTEMA DE INFORMACIÓN DE INDUSTRIAS NOVAQUIM S.A.S.</h4></div>
    <form method="POST" action="administracion/login.php">
      <div class="form-group row">
        <div class="col-1" style="text-align: right;">
          <label class="col-form-label" for="nombre">Usuario</label>
        </div>
        <div class="col-1">
          <input type="text" class="form-control" name="nombre" id="nombre" maxlength="10" placeholder="Usuario"
            autofocus>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-1" style="text-align: right;"> 
          <label class="col-form-label" for="password">Contraseña</label>
        </div>
        <div class="col-1"><input type="password" class="form-control" name="password" id="password" maxlength="15"
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