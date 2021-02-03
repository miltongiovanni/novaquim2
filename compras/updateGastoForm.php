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
$GastoOperador = new GastosOperaciones();
if (!$GastoOperador->isValidIdGasto($idGasto)) {
    echo ' <script >
				alert("El número de gasto no es válido, vuelva a intentar de nuevo");
				history.back();
			</script>';
} else {

    $gasto = $GastoOperador->getGastoById($idGasto);

    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
        <title>Actualización de gastos</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    </head>
    <body>
    <div id="contenedor">
        <div id="saludo"><strong>ACTUALIZACIÓN GASTOS</strong></div>
        <form name="form2" method="POST" action="updateGasto.php">
            <div class="form-group row">
                <label class="col-form-label col-2 text-right" for="idGasto"><strong>Id gasto</strong></label>
                <input type="text" class="form-control col-2" name="idGasto" id="idGasto"
                       value="<?= $gasto['idGasto'] ?>"
                       readonly>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-2" for="busProv"><strong>Proveedor</strong></label>
                <?php
                $ProveedorOperador = new ProveedoresOperaciones();
                $proveedores = $ProveedorOperador->getAllProveedoresGastos();
                echo '<select name="idProv" id="idProv" class="form-control col-2" required>';
                echo '<option selected value=' . $gasto['idProv'] . '>' . $gasto['nomProv'] . '</option>';
                for ($i = 0; $i < count($proveedores); $i++) {
                    if ($gasto['idProv'] != $proveedores[$i]['idProv']) {
                        echo '<option value=' . $proveedores[$i]['idProv'] . '>' . $proveedores[$i]['nomProv'] . '</option>';
                    }
                }
                echo '</select>';
                ?>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-2 text-right" for="numFact"><strong>Número de Factura</strong></label>
                <input type="text" class="form-control col-2" name="numFact" id="numFact"
                       value="<?= $gasto['numFact'] ?>"
                       onKeyPress="return aceptaNum(event)">
            </div>
            <div class="form-group row">
                <label class="col-form-label col-2 text-right" for="fechGasto"><strong>Fecha de compra</strong></label>
                <input type="date" class="form-control col-2" name="fechGasto" id="fechGasto"
                       value="<?= $gasto['fechGasto'] ?>">
            </div>
            <div class="form-group row">
                <label class="col-form-label col-2 text-right" for="fechVenc"><strong>Fecha de
                        vencimiento</strong></label>
                <input type="date" class="form-control col-2" name="fechVenc" id="fechVenc"
                       value="<?= $gasto['fechVenc'] ?>">
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
