<?php
include "../includes/valAcc.php";
foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
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
        <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
        <title>Actualización compra de<?= $titulo ?></title>
        <meta charset="utf-8">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    </head>
    <body>
    <div id="contenedor">
        <div id="saludo"><strong>ACTUALIZACIÓN COMPRA DE<?= $titulo ?></strong></div>
        <form name="form2" method="POST" action="updateCompra.php">
            <input name="tipoCompra" type="hidden" value="<?= $tipoCompra ?>">
            <div class="form-group row">
                <label class="col-form-label col-2 text-right" for="idCompra"><strong>Id compra</strong></label>
                <input type="text" class="form-control col-2" name="idCompra" id="idCompra"
                       value="<?= $compra['idCompra'] ?>" readonly>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-2" for="busProv"><strong>Proveedor</strong></label>
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
            <div class="form-group row">
                <label class="col-form-label col-2 text-right" for="numFact"><strong>Número de Factura</strong></label>
                <input type="text" class="form-control col-2" name="numFact" id="numFact"
                       value="<?= $compra['numFact'] ?>" onkeydown="return aceptaNum(event)">
            </div>
            <div class="form-group row">
                <label class="col-form-label col-2 text-right" for="fechComp"><strong>Fecha de compra</strong></label>
                <input type="date" class="form-control col-2" name="fechComp" id="fechComp"
                       value="<?= $compra['fechComp'] ?>">
            </div>
            <div class="form-group row">
                <label class="col-form-label col-2 text-right" for="fechVenc"><strong>Fecha de
                        vencimiento</strong></label>
                <input type="date" class="form-control col-2" name="fechVenc" id="fechVenc"
                       value="<?= $compra['fechVenc'] ?>">
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
<?php
}
?>
