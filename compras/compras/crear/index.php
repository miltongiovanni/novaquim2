<?php
include "../../../includes/valAcc.php";
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
    <title>Ingreso de la compra de<?= $titulo ?></title>
    <meta charset="utf-8">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script>
        function findProveedor(idCatProd) {
            let q = document.getElementById("busProv").value;
            let tipoCompra = <?= $tipoCompra ?>;
            $.ajax({
                url: '../../../includes/controladorCompras.php',
                type: 'POST',
                data: {
                    "action": 'findProveedorBytipoCompra',
                    "q": q,
                    "tipoCompra": tipoCompra,
                },
                dataType: 'html',
                success: function (provList) {
                    $("#myDiv").html(provList);
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
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>INGRESO DE COMPRA DE<?= $titulo ?></h4></div>
    <form name="form2" method="POST" action="../../compras/crear/makeCompra.php">
        <input name="tipoCompra" type="hidden" value="<?= $tipoCompra ?>">
        <div class="mb-3 row">
            <div class="col-2">
                <label class="form-label " for="busProv"><strong>Proveedor</strong></label>
                <input type="text" class="form-control col-2" id="busProv" name="busProv" onkeyup="findProveedor()" />
            </div>

        </div>
        <div class="mb-3 row">
            <div class="col-6" id="myDiv"></div>
        </div>
        <div class="mb-3 row">
            <div class="col-2">
                <label class="form-label " for="numFact"><strong>Número de Factura</strong></label>
                <input type="text" class="form-control" name="numFact" id="numFact"
                       onkeydown="return aceptaNum(event)" required>
            </div>
            <div class="col-2">
                <label class="form-label " for="fechComp"><strong>Fecha de compra</strong></label>
                <input type="date" class="form-control" name="fechComp" id="fechComp" required>
            </div>
            <div class="col-2">
                <label class="form-label" for="fechVenc"><strong>Fecha de vencimiento</strong></label>
                <input type="date" class="form-control col-2" name="fechVenc" id="fechVenc" required>
            </div>
            <div class="col-2">
                <label class="form-label" for="descuentoCompra"><strong>Descuento</strong></label>
                <input type="text" class="form-control" name="descuentoCompra" id="descuentoCompra"
                       value="0" onkeydown="return aceptaNum(event)">
            </div>
        </div>
        <div class="mb-3 row">

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

