<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$calMatPrimaOperador = new CalMatPrimaOperaciones();
$mprimas = $calMatPrimaOperador->getMPrimaXCalidad();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Control de Calidad Materia Prima</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>BUSCAR MATERIA PRIMA PARA CONTROL DE CALIDAD</h4></div>
    <form id="form1" name="form1" method="post" action="cal_materia_prima.php">
        <div class="form-group row">
            <label class="col-form-label col-1 text-end" for="id"><strong>Materia Prima</strong></label>
            <select name="id" id="id" class="form-control col-4" required>
                <option selected disabled value="">-------------------------------------------------------------------------------------</option>
                <?php
                for ($i = 0; $i < count($mprimas); $i++) : ?>
                    <option value="<?= $mprimas[$i]["id"] ?>"><?= $mprimas[$i]["nomMPrima"].' - Lote:'.$mprimas[$i]["lote_mp"].' - Cantidad: '.$mprimas[$i]["cantidad"].' Kg' ?></option>
                <?php
                endfor;
                ?>
            </select>
        </div>
        <div class="row form-group">
            <div class="col-1">
                <button class="button" type="button" onclick="return Enviar(this.form)">
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
