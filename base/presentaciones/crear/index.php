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
    <link href="../../../node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">
    <title>Creación de Presentación de Productos</title>
    <meta charset="utf-8">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../node_modules/select2/dist/js/select2.min.js"></script>
    <script src="../../../node_modules/select2/dist/js/i18n/es.js"></script>
    <script>
        $(document).ready(function () {
            $('#codProducto').select2({
                placeholder: 'Seleccione el producto',
                language: "es"
            });
            $('#codigoGen').select2({
                placeholder: 'Seleccione el código general',
                language: "es"
            });
            $('#codMedida').select2({
                placeholder: 'Seleccione la medida',
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
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>CREACIÓN DE PRESENTACIÓN DE PRODUCTO</h4></div>
    <form name="form2" method="POST" action="makeMedida.php">
        <div class="mb-3 row">
            <div class="col-3">
                <label class="form-label " for="codMedida"><strong>Medida</strong></label>
                <select name="codMedida" id="codMedida" data-error="Por favor seleccione la medida" style="width: 100%" required>
                    <option></option>

                    <?php
                    $MedidasOperador = new MedidasOperaciones();
                    $medidas = $MedidasOperador->getMedidas();
                    $filas = count($medidas);
                    for ($i = 0; $i < $filas; $i++) :
                        ?>
                        <option value="<?= $medidas[$i]["idMedida"] ?>"><?= $medidas[$i]['desMedida'] ?></option>
                    <?php
                    endfor;
                    ?>
                </select>
            </div>
            <div class="col-3">
                <label class="form-label " for="codProducto"><strong>Producto</strong></label>
                <select name="codProducto" id="codProducto" data-error="Por favor seleccione el producto" class="" onchange="document.getElementById('presentacion').value = this.options[this.selectedIndex].text; " style="width: 100%" required>
                    <option></option>
                    <?php
                    $ProductoOperador = new ProductosOperaciones();
                    $productos = $ProductoOperador->getProductos(true);
                    $filas = count($productos);
                    for ($i = 0; $i < $filas; $i++) :
                        ?>
                        <option value="<?= $productos[$i]["codProducto"] ?>"><?= $productos[$i]['nomProducto'] ?></option>
                    <?php
                    endfor;
                    ?>

                </select>
            </div>
            <?php
            $link = Conectar::conexion();
            $qry = "SELECT MAX(siigo) maxsiigo FROM (SELECT MAX(codSiigo) siigo FROM distribucion  WHERE CodIva=3
                    union
                    SELECT MAX(codSiigo) siigo FROM prodpre  WHERE CodIva=3
                    union
                    SELECT MAX(codSiigo) siigo FROM servicios  WHERE CodIva=3
                    ) AS a";
            $stmt = $link->prepare($qry);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="col-1">
                <label class="form-label " for="codSiigo"><strong>Código Siigo</strong></label>
                <input type="text" name="codSiigo" id="codSiigo" class="form-control "
                       onkeydown="return aceptaNum(event)" value="<?= ($row['maxsiigo'] + 1) ?>"/>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-3">
                <label class="form-label " for="codEnvase"><strong>Envase</strong></label>
                <select name="codEnvase" id="codEnvase" data-error="Por favor seleccione el envase" style="width: 100%" required>
                    <option></option>
                    <?php
                    $EnvasesOperador = new EnvasesOperaciones();
                    $envases = $EnvasesOperador->getEnvases();
                    $filas = count($envases);
                    for ($i = 0; $i < $filas; $i++) :
                        ?>
                        <option value="<?= $envases[$i]["codEnvase"] ?>"><?= $envases[$i]['nomEnvase'] ?></option>
                    <?php
                    endfor;
                    ?>
                </select>
            </div>
            <div class="col-4">
                <label class="form-label " for="presentacion"><strong>Presentación</strong></label>
                <input name="presentacion" id="presentacion" class="form-control " type="text" value="" required/>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-1">
                <label class="form-label " for="stockPresentacion"><strong>Stock Mínimo</strong></label>
                <input name="stockPresentacion" id="stockPresentacion" type="text" value="" class="form-control "
                       onkeydown="return aceptaNum(event)" required/>
            </div>
            <div class="col-2">
                <label class="form-label " for="cotiza"><strong>Cotizar</strong></label>
                <select name="cotiza" id="cotiza" class="form-select">
                    <option value="0" selected>No</option>
                    <option value="1">Si</option>
                </select>
            </div>
            <div class="col-4">
                <label class="form-label " for="codigoGen"><strong>Código General</strong></label>
                <select name="codigoGen" id="codigoGen" data-error="Por favor seleccione el código general" style="width: 100%" required>
                    <option></option>
                    <?php
                    $PrecioOperador = new PreciosOperaciones();
                    $precios = $PrecioOperador->getPrecios(1);
                    $filas = count($precios);
                    for ($i = 0; $i < $filas; $i++) :
                        ?>
                        <option value="<?= $precios[$i]["codigoGen"] ?>"><?= $precios[$i]['producto'] ?></option>
                    <?php
                    endfor;
                    ?>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-3">
                <label class="form-label " for="codTapa"><strong>Tapa</strong></label>
                <select name="codTapa" id="codTapa" data-error="Por favor seleccione la tapa" style="width: 100%" required>
                    <option></option>
                    <?php
                    $TapasOperador = new TapasOperaciones();
                    $tapas = $TapasOperador->getTapas();
                    $filas = count($tapas);
                    echo '';
                    echo '';
                    for ($i = 0; $i < $filas; $i++) :
                        ?>
                        <option value="<?= $tapas[$i]["codTapa"] ?>"><?= $tapas[$i]['tapa'] ?></option>
                    <?php
                    endfor;
                    ?>

                </select>
            </div>
            <div class="col-4">
                <label class="form-label " for="codEtiq"><strong>Etiqueta</strong></label>
                <select name="codEtiq" id="codEtiq" data-error="Por favor seleccione la etiqueta" style="width: 100%" required>
                    <option></option>
                    <?php
                    $EtiquetasOperador = new EtiquetasOperaciones();
                    $etiquetas = $EtiquetasOperador->getEtiquetas();
                    $filas = count($etiquetas);
                    for ($i = 0; $i < $filas; $i++) :
                        ?>
                        <option value="<?= $etiquetas[$i]["codEtiqueta"] ?>"><?= $etiquetas[$i]['nomEtiqueta'] ?></option>
                    <?php
                    endfor;
                    ?>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-1 text-center">
                <button class="button" onclick="$('#codProducto').val(null).trigger('change');$('#codigoGen').val(null).trigger('change');$('#codMedida').val(null).trigger('change');$('#codEnvase').val(null).trigger('change');$('#codTapa').val(null).trigger('change');$('#codEtiq').val(null).trigger('change');" type="reset"><span>Reiniciar</span></button>
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