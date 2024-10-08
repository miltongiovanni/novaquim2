<?php
include "../../../includes/valAcc.php";
foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if (is_array($valor)) {
        //echo $nombre_campo.print_r($valor).'<br>';
    } else {
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$remisionOperador = new RemisionesOperaciones();
if (!$remisionOperador->isValidIdRemision($idRemision)) {
    $ruta = "buscarRemision.php";
    $mensaje = "El número de remisión no es válido, vuelva a intentar de nuevo";
    $icon = "error";
    mover_pag($ruta, $mensaje, $icon);
} else {

    $remision = $remisionOperador->getRemisionById($idRemision);

    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
        <title>Actualización de remisión</title>
        <meta charset="utf-8">
        <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
        <script src="../../../js/validar.js"></script>
    </head>
    <body>
    <div id="contenedor" class="container-fluid">
        <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>ACTUALIZACIÓN REMISIÓN</h4></div>
        <form name="form2" method="POST" action="updateRemision.php">
            <div class="mb-3 row">
                <div class="col-1">
                    <label class="form-label" for="idRemision"><strong>Id remisión</strong></label>
                    <input type="text" class="form-control" name="idRemision" id="idRemision"
                           value="<?= $remision['idRemision'] ?>" readonly>
                </div>
                <div class="col-3">
                    <label class="form-label" for="cliente"><strong>Cliente</strong></label>
                    <input type="text" class="form-control" name="cliente" id="cliente"
                           value="<?= $remision['cliente'] ?>">
                </div>
                <div class="col-2">
                    <label class="form-label" for="fechaRemision"><strong>Fecha</strong></label>
                    <input type="date" class="form-control" name="fechaRemision" id="fechaRemision"
                           value="<?= $remision['fechaRemision'] ?>">
                </div>
                <div class="col-2">
                    <label class="form-label" for="valor"><strong>Valor</strong></label>
                    <input type="text" class="form-control" name="valor" id="valor" value="<?= $remision['valor'] ?>"
                           onkeydown="return aceptaNum(event)">
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-1 text-center">
                    <button class="button" type="reset"><span>Reiniciar</span></button>
                </div>
                <div class="col-1 text-center">
                    <button class="button" type="button" onclick="return Enviar(this.form)"><span>Continuar</span>
                    </button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-1">
                <button class="button1" onClick="history.back()"><span>VOLVER</span></button>
            </div>
        </div>
    </div>
    </body>
    </html>
    <?php
}
?>
