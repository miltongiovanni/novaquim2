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
    <meta charset="utf-8">
    <title>Aplicar Nota Crédito</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script>
        function findFacturasClienteNC(idNotaC) {
            $.ajax({
                url: '../includes/controladorVentas.php',
                type: 'POST',
                data: {
                    "action": 'findFacturasPorPagarByNotaC',
                    "idNotaC": idNotaC
                },
                dataType: 'html',
                success: function (facturasList) {
                    $("#idFacturaDestino").html(facturasList);
                },
                error: function () {
                    alert("Vous avez un GROS problème");
                }
            });
        }
    </script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><div id="h4"><strong>APLICAR NOTA CRÉDITO</strong></div></div>
    <form id="form1" name="form1" method="post" action="aplicaNotaC.php">
        <div class="mb-3 row">
            <label class="form-label col-1" for="idPedido"><strong>Nota crédito</strong></label>
            <select name="idNotaC" id="idNotaC" class="form-select col-4" onchange="findFacturasClienteNC(this.value);"  required>
                <option selected disabled value="">------------------------------------------------------------------------------------------------------</option>
                <?php
                $manager = new NotasCreditoOperaciones();
                $notas = $manager->getNotasCreditoSinDestino();
                for ($i = 0; $i < count($notas); $i++) : ?>
                    <option value="<?= $notas[$i]["idNotaC"] ?>"><?= $notas[$i]["idNotaC"].' - '.$notas[$i]["nomCliente"].' - '.$notas[$i]["totalNota"] ?></option>
                <?php
                endfor;
                ?>
            </select>
        </div>
        <div class="mb-3 row">
            <label class="form-label col-1" for="idFacturaDestino"><strong>Factura Destino</strong></label>
            <select name="idFacturaDestino" id="idFacturaDestino" class="form-select col-4" required>
            </select>
        </div>
        <div class="row mb-3">
            <div class="col-1">
                <button class="button" type="button" onclick="return Enviar(this.form)">
                    <span>Continuar</span></button>
            </div>
        </div>
    </form>
    <div class="row mb-3">
        <div class="col-1">
            <button class="button1" onclick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>
