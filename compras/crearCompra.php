<?php
include "../includes/valAcc.php";
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
    <title>Ingreso de la compra de<?= $titulo ?></title>
    <meta charset="utf-8">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script>
        function findProveedor(idCatProd) {
            let q = document.getElementById("busProv").value;
            let tipoCompra = <?= $tipoCompra ?>;
            $.ajax({
                url: '../includes/controladorCompras.php',
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
    <div id="saludo"><h4>INGRESO DE COMPRA DE<?= $titulo ?></h4></div>
    <form name="form2" method="POST" action="makeCompra.php">
        <input name="tipoCompra" type="hidden" value="<?= $tipoCompra ?>">
        <div class="form-group row">
            <label class="col-form-label col-2" for="busProv"><strong>Proveedor</strong></label>
            <input type="text" class="form-control col-2" id="busProv" name="busProv" onkeyup="findProveedor()"
                   required/>
        </div>
        <div class="form-group row" id="myDiv">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-right" for="numFact"><strong>Número de Factura</strong></label>
            <input type="text" class="form-control col-2" name="numFact" id="numFact"
                   onkeydown="return aceptaNum(event)" required>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-right" for="fechComp"><strong>Fecha de compra</strong></label>
            <input type="date" class="form-control col-2" name="fechComp" id="fechComp" required>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-right" for="fechVenc"><strong>Fecha de vencimiento</strong></label>
            <input type="date" class="form-control col-2" name="fechVenc" id="fechVenc" required>
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

