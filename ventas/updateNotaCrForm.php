<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Modificación Nota Crédito</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>

<?php
$idNotaC = $_POST['idNotaC'];
$notaCrOperador = new NotasCreditoOperaciones();
if (!$notaCrOperador->isValidIdNotaC($idNotaC)) {
    $ruta = "buscarNotaC.php";
    $mensaje = "El número de la nota de crédito no es válido, vuelva a intentar de nuevo";
    $icon = "error";
    mover_pag($ruta, $mensaje, $icon);
    exit();
} else {
    $notaC = $notaCrOperador->getNotaC($idNotaC);
    $facturaOperador = new FacturasOperaciones();
    $facturas = $facturaOperador->getFacturasClienteForNotas($notaC['idCliente']);
}
?>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4> NOTA CRÉDITO PARA <?= $notaC['nomCliente'] ?></h4></div>
    <form name="form2" method="POST" action="updateNotaC.php">
        <div class="form-group row">
            <label class="col-form-label col-2" for="idNotaC"><strong>Nota Crédito</strong></label>
            <input name="idNotaC" id="idNotaC" class="form-control col-2" value="<?= $notaC['idNotaC'] ?>" readonly>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2" for="motivo"><strong>Razón de la Nota</strong></label>
            <select name="motivo" size="1" id="motivo" class="form-control col-2">
                <option value="0" <?= $notaC['motivo'] == 0 ? 'selected' : '' ?>>Devolución de Productos</option>
                <option value="1"<?= $notaC['motivo'] == 1 ? 'selected' : '' ?>>Descuento no aplicado</option>
            </select>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2" for="facturaOrigen"><strong>Factura origen de la
                    Nota</strong></label>
            <select name="facturaOrigen" id="facturaOrigen" class="form-control col-2" required>
                <option value="<?= $notaC['facturaOrigen'] ?>" selected><?= $notaC['facturaOrigen'] ?></option>
                <?php
                for ($i = 0; $i < count($facturas); $i++):
                    if ($facturas[$i] != $notaC['facturaOrigen']):
                        ?>
                        <option value="<?= $facturas[$i]['idFactura'] ?>"><?= $facturas[$i]['idFactura'] ?></option>
                    <?php
                    endif;
                endfor;
                ?>
            </select>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2" for="facturaDestino"><strong>Factura destino de la
                    Nota</strong></label>
            <select name="facturaDestino" id="facturaDestino" class="form-control col-2" required>
                <option value="<?= $notaC['facturaDestino'] ?>" selected><?= $notaC['facturaDestino'] ?></option>
                <?php
                for ($i = 0; $i < count($facturas); $i++):
                    if ($facturas[$i] != $notaC['facturaDestino']):
                        ?>
                        <option value="<?= $facturas[$i]['idFactura'] ?>"><?= $facturas[$i]['idFactura'] ?></option>
                    <?php
                    endif;
                endfor;
                ?>
            </select>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-end" for="fechaNotaC"><strong>Fecha Nota Crédito</strong></label>
            <input type="date" class="form-control col-2" name="fechaNotaC" id="fechaNotaC"
                   value="<?= $notaC['fechaNotaC'] ?>" required>
        </div>
        <div class="row form-group">
            <div class="col-1">
                <button class="button" type="button" onclick="return Enviar(this.form)">
                    <span>Continuar</span></button>
            </div>
        </div>
    </form>
    <div class="row form-group">
        <div class="col-1">
            <button class="button1" onclick="history.back()">
                <span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>

