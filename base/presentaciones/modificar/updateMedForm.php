<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$codPresentacion = $_POST['codPresentacion'];
$PresentacionOperador = new PresentacionesOperaciones();
$presentacion = $PresentacionOperador->getPresentacion($codPresentacion);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link href="../../../node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos de Presentación de Producto</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../node_modules/select2/dist/js/select2.min.js"></script>
    <script src="../../../node_modules/select2/dist/js/i18n/es.js"></script>
    <script>
        $(document).ready(function () {
            $('#codigoGen').select2({
                placeholder: 'Seleccione el código general',
                language: "es"
            });
            $('#codEnvase').select2({
                placeholder: 'Seleccione el envase',
                language: "es"
            });
            $('#codTapa').select2({
                placeholder: 'Seleccione la tapa',
                language: "es"
            });
            $('#codEtiq').select2({
                placeholder: 'Seleccione la etiqueta',
                language: "es"
            });
        });
    </script>
</head>

<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>ACTUALIZACIÓN DE PRESENTACIONES DE PRODUCTO</h4></div>
    <form id="form1" name="form1" method="post" action="updateMed.php">
        <div class="mb-3 row">
            <div class="col-1">
                <label class="form-label " for="codPresentacion"><strong>Código</strong></label>
                <input type="text" name="codPresentacion" id="codPresentacion" class="form-control "
                       onkeydown="return aceptaNum(event)" value="<?= $codPresentacion ?>" readonly/>
            </div>
            <div class="col-4">
                <label class="form-label " for="presentacion"><strong>Presentación</strong></label>
                <input name="presentacion" id="presentacion" class="form-control " type="text"
                       value="<?= $presentacion['presentacion'] ?>"/>
            </div>
            <div class="col-1">
                <label class="form-label " for="stockPresentacion"><strong>Stock Mínimo</strong></label>
                <input name="stockPresentacion" id="stockPresentacion" type="text"
                       value="<?= $presentacion['stockPresentacion'] ?>" class="form-control "
                       onkeydown="return aceptaNum(event)"/>
            </div>
            <div class="col-1">
                <label class="form-label " for="cotiza"><strong>Cotizar</strong></label>
                <select name="cotiza" id="cotiza" class="form-select">
                    <?php if ($presentacion['cotiza'] == 0) { ?>
                        <option value="0" selected>No</option>
                        <option value="1">Si</option>
                    <?php } else { ?>
                        <option value="1" selected>Si</option>
                        <option value="0">No</option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-3">
                <label class="form-label " for="codEnvase"><strong>Envase</strong></label>
                <select name="codEnvase" id="codEnvase" style="width: 100%">
                    <option selected value="<?= $presentacion['codEnvase'] ?>"><?= $presentacion['nomEnvase'] ?></option>
                    <?php
                    $EnvasesOperador = new EnvasesOperaciones();
                    $envases = $EnvasesOperador->getEnvases();
                    $filas = count($envases);
                    for ($i = 0; $i < $filas; $i++) :
                        if ($envases[$i]["codEnvase"] != $presentacion['codEnvase']) :
                            ?>
                            <option value="<?= $envases[$i]["codEnvase"] ?>"><?= $envases[$i]['nomEnvase'] ?></option>
                        <?php
                        endif;
                    endfor;
                    ?>
                </select>
            </div>
            <div class="col-4">
                <label class="form-label " for="codigoGen"><strong>Código General</strong></label>
                <select name="codigoGen" id="codigoGen" style="width: 100%">
                    <option selected value="<?= $presentacion['codigoGen'] ?>"><?= $presentacion['producto'] ?></option>
                    <?php
                    $PrecioOperador = new PreciosOperaciones();
                    $precios = $PrecioOperador->getPrecios(1);
                    $filas = count($precios);
                    for ($i = 0; $i < $filas; $i++) :
                        if ($precios[$i]["codigoGen"] != $presentacion['codigoGen']) :
                            ?>
                            <option value="<?= $precios[$i]["codigoGen"] ?>"><?= $precios[$i]['producto'] ?></option>
                        <?php
                        endif;
                    endfor;
                    ?>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-3">
                <label class="form-label " for="codTapa"><strong>Tapa</strong></label>
                <select name="codTapa" id="codTapa" style="width: 100%">
                    <option selected value="<?= $presentacion['codTapa'] ?>"><?= $presentacion['tapa'] ?>'</option>
                    <?php
                    $TapasOperador = new TapasOperaciones();
                    $tapas = $TapasOperador->getTapas();
                    $filas = count($tapas);
                    for ($i = 0; $i < $filas; $i++) :
                        if ($tapas[$i]["codTapa"] != $presentacion['codTapa']) :
                            ?>
                            <option value="<?= $tapas[$i]["codTapa"] ?>"><?= $tapas[$i]['tapa'] ?>'</option>
                        <?php
                        endif;
                    endfor;
                    ?>
                </select>
            </div>
            <div class="col-4">
                <label class="form-label " for="codEtiq"><strong>Etiqueta</strong></label>
                <select name="codEtiq" id="codEtiq" style="width: 100%">
                    <option selected value="<?= $presentacion['codEtiq'] ?>"><?= $presentacion['nomEtiqueta'] ?></option>
                    <?php
                    $EtiquetasOperador = new EtiquetasOperaciones();
                    $etiquetas = $EtiquetasOperador->getEtiquetas();
                    $filas = count($etiquetas);
                    for ($i = 0; $i < $filas; $i++) :
                        if ($etiquetas[$i]["codEtiqueta"] != $presentacion['codEtiq']) :
                            ?>
                            <option value="<?= $etiquetas[$i]["codEtiqueta"] ?>"><?= $etiquetas[$i]['nomEtiqueta'] ?></option>
                        <?php
                        endif;
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
            <button class="button1" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>

</div>
</body>

</html>