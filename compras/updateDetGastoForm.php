<?php
include "../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

foreach ($_POST as $nombre_campo => $valor) {
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
    //echo $nombre_campo . " = " . $valor . "<br>";
    eval($asignacion);
}


$DetGastoOperador = new DetGastosOperaciones();
$detalle = $DetGastoOperador->getDetGasto($idGasto, $producto);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Actualizar detalle del gasto</title>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
    <div id="saludo"><strong>ACTUALIZACIÓN DEL DETALLE DEL GASTO</strong></div>
    <form action="updateDetGasto.php" method="post" name="actualiza">
        <input type="hidden" name="idGasto" id="idGasto" value="<?= $idGasto ?>">
        <div class="form-group row">
            <label class="col-form-label col-1 text-right" for="producto"><strong>Producto</strong></label>
            <input type="text" class="form-control col-2" name="producto" id="producto" readonly
                   value="<?= $detalle['producto'] ?>">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1 text-right" for="cantGasto"><strong>Cantidad</strong></label>
            <input type="text" class="form-control col-2" name="cantGasto" id="cantGasto"
                   value="<?= $detalle['cantGasto'] ?>" onKeyPress="return aceptaNum(event)">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1 text-right" for="precGasto"><strong>Precio</strong></label>
            <input type="text" class="form-control col-2" name="precGasto" id="precGasto"
                   value="<?= $detalle['precGasto'] ?>"
                   onKeyPress="return aceptaNum(event)">

        </div>
        <div class="form-group row">
            <label class="col-form-label col-1 text-right" for="codIva"><strong>Iva</strong></label>
            <?php
            $manager = new TasaIvaOperaciones();
            $tasas = $manager->getTasasIva();
            $filas = count($tasas);
            echo '<select name="codIva" id="codIva" class="form-control col-2">';
            echo '<option selected value="' . $detalle['codIva'] . '">' . $detalle['iva'] . '</option>';
            for ($i = 0; $i < $filas; $i++) {
                if ($detalle['codIva'] != $tasas[$i]["idTasaIva"]) {
                    echo '<option value="' . $tasas[$i]["idTasaIva"] . '">' . $tasas[$i]['iva'] . '</option>';
                }
            }
            echo '</select>';
            ?>

        </div>
        <div class="form-group row">
    <div class="col-1 text-center">
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div>
            <div class="col-1 text-center">
                <button class="button" onclick="return Enviar(this.form)"><span>Continuar</span></button>
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
