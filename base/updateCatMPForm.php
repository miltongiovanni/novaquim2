<?php
include "../includes/valAcc.php";
function cargarClases($classname)
  {
      require '../clases/' . $classname . '.php';
  }
spl_autoload_register('cargarClases');
$idCatMP=$_POST['idCatMP'];
$catsMPOperador = new CategoriasMPOperaciones();
$categoriaMP=$catsMPOperador->getCatMP($idCatMP);
?>
<!DOCTYPE html>
<html>

<head>
  <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
  <meta charset="utf-8">
  <title>Actualizar datos Categoría Materias Primas</title>
  <script type="text/javascript" src="../js/validar.js"></script>
</head>

<body>
  <div id="contenedor">
    <div id="saludo"><strong>ACTUALIZACIÓN CATEGORÍA DE MATERIAS PRIMAS</strong></div>
    <form id="form1" name="form1" method="post" action="updateCatMP.php">
      <div class="form-group row">
        <label class="col-form-label col-1" style="text-align: right;" for="idCatMP">Código</label>
        <input type="text" class="form-control col-2" name="idCatMP" id="idCatMP" size=30 maxlength="30"
          value="<?= $categoriaMP['idCatMP']; ?>" readonly>
      </div>
      <div class="form-group row">
        <label class="col-form-label col-1" style="text-align: right;" for="catMP"><strong>Categoría</strong></label>
        <input type="text" class="form-control col-2" name="catMP" id="catMP" size=30
          onKeyPress="return aceptaLetra(event)" value="<?= $categoriaMP['catMP']; ?>" maxlength="30">
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
      <div class="col-1"><button class="button1" id="back" style="vertical-align:middle" onClick="history.back()">
          <span>VOLVER</span></button></div>
    </div>
  </div>
</body>

</html>