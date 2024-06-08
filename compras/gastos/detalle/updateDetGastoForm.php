<?php
include "../../../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if (is_array($valor)) {
        //echo $nombre_campo.print_r($valor).'<br>';
    } else {
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}


$DetGastoOperador = new DetGastosOperaciones();
$detalle = $DetGastoOperador->getDetGasto($idGasto, $producto);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar detalle del gasto</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>ACTUALIZACIÓN DEL DETALLE DEL GASTO</h4></div>
    <form action="updateDetGasto.php" method="post" name="actualiza">
        <input type="hidden" name="idGasto" id="idGasto" value="<?= $idGasto ?>">
        <div class="mb-3 row">
            <div class="col-2">
                <label class="form-label" for="producto"><strong>Producto</strong></label>
                <input type="text" class="form-control " name="producto" id="producto" readonly
                       value="<?= $detalle['producto'] ?>">
            </div>
            <div class="col-1">
                <label class="form-label" for="cantGasto"><strong>Cantidad</strong></label>
                <input type="text" class="form-control" name="cantGasto" id="cantGasto"
                       value="<?= $detalle['cantGasto'] ?>" onkeydown="return aceptaNum(event)">
            </div>
            <div class="col-1">
                <label class="form-label" for="precGasto"><strong>Precio</strong></label>
                <input type="text" class="form-control" name="precGasto" id="precGasto" value="<?= $detalle['precGasto'] ?>" onkeydown="return aceptaNum(event)">
            </div>
            <div class="col-1">
                <label class="form-label" for="codIva"><strong>Iva</strong></label>
                <?php
                $manager = new TasaIvaOperaciones();
                $tasas = $manager->getTasasIva();
                $filas = count($tasas);
                echo '<select name="codIva" id="codIva" class="form-select">';
                echo '<option selected value="' . $detalle['codIva'] . '">' . $detalle['iva'] . '</option>';
                for ($i = 0; $i < $filas; $i++) {
                    if ($detalle['codIva'] != $tasas[$i]["idTasaIva"]) {
                        echo '<option value="' . $tasas[$i]["idTasaIva"] . '">' . $tasas[$i]['iva'] . '</option>';
                    }
                }
                echo '</select>';
                ?>
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
