<?php
include "../includes/valAcc.php";
include "../includes/utilTabla.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');
$codEnvase = $_POST['codEnvase'];
$EnvaseOperador = new EnvasesOperaciones();
$envase = $EnvaseOperador->getEnvase($codEnvase);
?>
<!DOCTYPE html>
<html>

<head>
  <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
  <meta charset="utf-8">
  <title>Actualizar datos de Envase</title>
  <script type="text/javascript" src="../js/validar.js"></script>
</head>

<body>
  <div id="contenedor">
    <div id="saludo"><strong>ACTUALIZACIÓN DE ENVASE</strong></div>
    <form id="form1" name="form1" method="post" action="updateEnv.php">
      <div class="form-group row">
        <label class="col-form-label col-1" style="text-align: right;" for="codEnvase"><strong>Código</strong></label>
        <input type="text" class="form-control col-2" name="codEnvase" id="codEnvase" maxlength="50" value="<?=$envase['codEnvase'];?>" readonly>
      </div>
      <div class="form-group row">
        <label class="col-form-label col-1" style="text-align: right;" for="nomEnvase"><strong>Envase</strong></label>
        <input type="text" class="form-control col-2" name="nomEnvase" id="nomEnvase" value="<?=$envase['nomEnvase'];?>" maxlength="50">
      </div>
      <div class="form-group row">
        <label class="col-form-label col-1" style="text-align: right;" for="stockEnvase"><strong>Stock Envase</strong></label>
        <input type="text" class="form-control col-2" name="stockEnvase" id="stockEnvase" onKeyPress="return aceptaNum(event)" value="<?=$envase['stockEnvase'];?>">
        <input type="hidden" class="form-control col-2" name="codIva" id="codIva" value="3">
      </div>
      <div class="form-group row">
        <div class="col-1" style="text-align: center;">
          <button class="button" style="vertical-align:middle"
            onclick="return Enviar(this.form)"><span>Continuar</span></button>
        </div>
        <div class="col-1" style="text-align: center;">
          <button class="button" style="vertical-align:middle" type="reset"><span>Reiniciar</span></button>
        </div>
      </div>
    </form>
    <div class="row">
      <div class="col-1"><button class="button1" id="back" style="vertical-align:middle"
          onClick="history.back()"><span>VOLVER</span></button></div>
    </div>
  </div>
</body>

</html>