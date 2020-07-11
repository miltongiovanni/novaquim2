<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>OP para Control de Calidad</title>
    <script src="../js/validar.js"></script>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="contenedor">
    <div id="saludo"><strong>BUSCAR ORDEN DE PRODUCCIÓN A PARA CONTROL DE CALIDAD</strong></div>
    <form id="form1" name="form1" method="post" action="cal_produccion.php">
        <div class="form-group row">
            <label class="col-form-label col-2" for="lote"><strong>Orden de producción</strong></label>
            <select name="lote" id="lote" class="form-control col-1">
                <option selected disabled value="">------------</option>
                <?php
                $manager = new OProdOperaciones();
                $ordenes = $manager->getOProdXCalidad();
                for ($i = 0; $i < count($ordenes); $i++) : ?>
                    <option value="<?= $ordenes[$i]["lote"] ?>"><?= $ordenes[$i]["lote"] ?></option>
                <?php
                endfor;
                ?>
            </select>
        </div>
        <div class="row form-group">
            <div class="col-1">
                <button class="button" onclick="return Enviar(this.form)">
                    <span>Continuar</span></button>
            </div>
        </div>
    </form>
    <div class="row form-group">
        <div class="col-1">
            <button class="button1" onclick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>
