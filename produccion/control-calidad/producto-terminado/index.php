<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Seleccionar orden de producción</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>CONTROL DE CALIDAD PRODUCTO TERMINADO</h4></div>
    <form id="form1" name="form1" method="post" action="consultaCalidad2.php">
        <div class="mb-3 row">
            <div class="col-2">
                <label class="form-label" for="lote"><strong>Orden de producción</strong></label>
                <select name="lote" id="lote" class="form-select" required>
                    <option selected disabled value="">------------</option>
                    <?php
                    $manager = new OProdOperaciones();
                    $ordenes = $manager->getOProdXCalProdTerminado();
                    for ($i = 0; $i < count($ordenes); $i++) : ?>
                        <option value="<?= $ordenes[$i]["lote"] ?>"><?= $ordenes[$i]["lote"] ?></option>
                    <?php
                    endfor;
                    ?>
                </select>
            </div>

        </div>
        <div class="mb-3 row">
            <div class="col-1 text-center">
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div>
            <div class="col-1 text-center">
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Continuar</span></button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-1">
            <button class="button1" id="back" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>
