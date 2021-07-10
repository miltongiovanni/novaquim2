<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$codPresentacion = $_POST['codPresentacion'];
$PresentacionOperador = new PresentacionesOperaciones();
$presentacion = $PresentacionOperador->getPresentacion($codPresentacion);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos de Presentación de Producto</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>

<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>ACTUALIZACIÓN DE PRESENTACIONES DE PRODUCTO</h4></div>
    <form id="form1" name="form1" method="post" action="updateMed.php">
        <div class="form-group row">
            <label class="col-form-label col-1" for="codPresentacion"><strong>Código</strong></label>
            <input type="text" name="codPresentacion" id="codPresentacion" class="form-control col-2"
                   onkeydown="return aceptaNum(event)" value="<?= $codPresentacion ?>" readonly/>

            <label class="col-form-label col-2" for="presentacion"><strong>Presentación</strong></label>
            <input name="presentacion" id="presentacion" class="form-control col-3" type="text"
                   value="<?= $presentacion['presentacion'] ?>"/>

        </div>
        <div class="form-group row">
            <label class="col-form-label col-1" for="codEnvase"><strong>Envase</strong></label>
            <?php
            $EnvasesOperador = new EnvasesOperaciones();
            $envases = $EnvasesOperador->getEnvases();
            $filas = count($envases);
            echo '<select name="codEnvase" id="codEnvase" class="form-control col-2">';
            echo '<option selected value="' . $presentacion['codEnvase'] . '">' . $presentacion['nomEnvase'] . '</option>';
            for ($i = 0; $i < $filas; $i++) {
                if ($envases[$i]["codEnvase"] != $presentacion['codEnvase']) {
                    echo '<option value="' . $envases[$i]["codEnvase"] . '">' . $envases[$i]['nomEnvase'] . '</option>';
                }
            }
            echo '</select>';
            ?>
            <label class="col-form-label col-2" for="codigoGen"><strong>Código General</strong></label>
            <?php
            $PrecioOperador = new PreciosOperaciones();
            $precios = $PrecioOperador->getPrecios(1);
            $filas = count($precios);
            echo '<select name="codigoGen" id="codigoGen" class="form-control col-3">';
            echo '<option selected value="' . $presentacion['codigoGen'] . '">' . $presentacion['producto'] . '</option>';
            for ($i = 0; $i < $filas; $i++) {
                if ($precios[$i]["codigoGen"] != $presentacion['codigoGen']) {
                    echo '<option value="' . $precios[$i]["codigoGen"] . '">' . $precios[$i]['producto'] . '</option>';
                }
            }
            echo '</select>';

            ?>

        </div>
        <div class="form-group row">
            <label class="col-form-label col-1" for="stockPresentacion"><strong>Stock Mínimo</strong></label>
            <input name="stockPresentacion" id="stockPresentacion" type="text"
                   value="<?= $presentacion['stockPresentacion'] ?>" class="form-control col-2"
                   onkeydown="return aceptaNum(event)"/>
            <label class="col-form-label col-2" for="codTapa"><strong>Tapa</strong></label>
            <?php
            $TapasOperador = new TapasOperaciones();
            $tapas = $TapasOperador->getTapas();
            $filas = count($tapas);
            echo '<select name="codTapa" id="codTapa" class="form-control col-3">';
            echo '<option selected value="' . $presentacion['codTapa'] . '">' . $presentacion['tapa'] . '</option>';
            for ($i = 0; $i < $filas; $i++) {
                if ($tapas[$i]["codTapa"] != $presentacion['codTapa']) {
                    echo '<option value="' . $tapas[$i]["codTapa"] . '">' . $tapas[$i]['tapa'] . '</option>';
                }
            }
            echo '</select>';

            ?>

        </div>
        <div class="form-group row">
            <label class="col-form-label col-1" for="cotiza"><strong>Cotizar</strong></label>
            <select name="cotiza" id="cotiza" class="form-control col-2">
                <?php if ($presentacion['cotiza'] == 0) { ?>
                    <option value="0" selected>No</option>
                    <option value="1">Si</option>
                <?php } else { ?>
                    <option value="1" selected>Si</option>
                    <option value="0">No</option>
                <?php } ?>
            </select>
            <label class="col-form-label col-2" for="codEtiq"><strong>Etiqueta</strong></label>
            <?php
            $EtiquetasOperador = new EtiquetasOperaciones();
            $etiquetas = $EtiquetasOperador->getEtiquetas();
            $filas = count($etiquetas);
            echo '<select name="codEtiq" id="codEtiq" class="form-control col-3">';
            echo '<option selected value="' . $presentacion['codEtiq'] . '">' . $presentacion['nomEtiqueta'] . '</option>';
            for ($i = 0; $i < $filas; $i++) {
                if ($etiquetas[$i]["codEtiqueta"] != $presentacion['codEtiq']) {
                    echo '<option value="' . $etiquetas[$i]["codEtiqueta"] . '">' . $etiquetas[$i]['nomEtiqueta'] . '</option>';
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
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Continuar</span></button>
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