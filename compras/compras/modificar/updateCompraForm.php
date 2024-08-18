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
$CompraOperador = new ComprasOperaciones();
if (!$CompraOperador->isValidIdCompra($idCompra)) {
    echo ' <script >
				alert("El número de compra no es válido, vuelva a intentar de nuevo");
				history.back();
			</script>';
} else {
    $compra = $CompraOperador->getCompraById($idCompra);
    $tipoCompra = $compra['tipoCompra'];
    switch ($tipoCompra) {
        case 1:
            $titulo = ' materias primas';
            break;
        case 2:
            $titulo = ' envases y/o tapas';
            break;
        case 3:
            $titulo = ' etiquetas';
            break;
        case 5:
            $titulo = ' productos de distribución';
            break;
    }


    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
        <title>Actualización compra de<?= $titulo ?></title>
        <meta charset="utf-8">
        <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
        <script src="../../../js/validar.js"></script>
    </head>
    <body>
    <div id="contenedor" class="container-fluid">
        <div id="saludo">
            <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>ACTUALIZACIÓN COMPRA DE<?= $titulo ?></h4></div>
        <form name="form2" method="POST" action="updateCompra.php">
            <input name="tipoCompra" type="hidden" value="<?= $tipoCompra ?>">
            <div class="mb-3 row">
                <div class="col-1">
                    <label class="form-label " for="idCompra"><strong>Id compra</strong></label>
                    <input type="text" class="form-control" name="idCompra" id="idCompra"
                           value="<?= $compra['idCompra'] ?>" readonly>
                </div>
                <div class="col-2">
                    <label class="form-label" for="numFact"><strong>No. Factura</strong></label>
                    <input type="text" class="form-control" name="numFact" id="numFact"
                           value="<?= $compra['numFact'] ?>" onkeydown="return aceptaNum(event)">
                </div>
                <div class="col-3">
                    <label class="form-label" for="busProv"><strong>Proveedor</strong></label>
                    <?php
                    $ProveedorOperador = new ProveedoresOperaciones();
                    $proveedores = $ProveedorOperador->getProveedoresByTipo($tipoCompra);
                    echo '<select name="idProv" id="idProv" class="form-control col-2" required>';
                    echo '<option selected value=' . $compra['idProv'] . '>' . $compra['nomProv'] . '</option>';
                    for ($i = 0; $i < count($proveedores); $i++) {
                        if ($compra['idProv'] != $proveedores[$i]['idProv']) {
                            echo '<option value=' . $proveedores[$i]['idProv'] . '>' . $proveedores[$i]['nomProv'] . '</option>';
                        }
                    }
                    echo '</select>';
                    ?>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-2">
                    <label class="form-label" for="descuentoCompra"><strong>Descuento</strong></label>
                    <input type="text" class="form-control" name="descuentoCompra" id="descuentoCompra"
                           value="<?= $compra['descuentoCompra'] ?>" onkeydown="return aceptaNum(event)">
                </div>
                <div class="col-2">
                    <label class="form-label" for="fechComp"><strong>Fecha de compra</strong></label>
                    <input type="date" class="form-control" name="fechComp" id="fechComp"
                           value="<?= $compra['fechComp'] ?>">
                </div>
                <div class="col-2">
                    <label class="form-label" for="fechVenc"><strong>Fecha de vencimiento</strong></label>
                    <input type="date" class="form-control" name="fechVenc" id="fechVenc" value="<?= $compra['fechVenc'] ?>">
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
    <?php
}
?>
