<?php
include "../../../includes/valAcc.php";
$idFormulaMPrima = $_POST['idFormulaMPrima'];
$codMPrima = $_POST['codMPrima'];

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$DetFormulaMPrimaOperador = new DetFormulaMPrimaOperaciones();
$detalle = $DetFormulaMPrimaOperador->getDetFormulaMPrima($idFormulaMPrima, $codMPrima);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar Formulación de MPrima</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>

</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>ACTUALIZACIÓN DE FORMULACIÓN DE MATERIA PRIMA</h4></div>
    <form class="formatoDatos5" action="updateDetFormulaMPrima.php" method="post" name="actualiza">
        <input name="idFormulaMPrima" type="hidden" value="<?= $idFormulaMPrima; ?>">
        <input name="codMPrima" type="hidden" value="<?= $codMPrima; ?>">
        <div class="row mb-3">
            <div class="col-3">
                <label class="form-label" for="codMPrima"><strong>Materia Prima</strong></label>
                <input type="text" class="form-control" name="porcentaje" readonly
                       id="porcentaje" onkeydown="return aceptaNum(event)" value="<?= $detalle['nomMPrima'] ?>">
            </div>
            <div class="col-1">
                <label class="form-label" for="porcentaje"><strong>% en fórmula</strong></label>
                <input type="text" class="form-control" name="porcentaje"
                       id="porcentaje" onkeydown="return aceptaNum(event)" value="<?= $detalle['porcentaje'] * 100 ?>">
            </div>


        </div>
        <div class="mb-3 row">
            <div class="col-2 text-center" style="padding: 0 20px;">
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Actualizar detalle</span></button>
            </div>
        </div>
    </form>
</div>
</body>
</html>
