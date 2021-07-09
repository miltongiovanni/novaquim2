<?php
include "../includes/valAcc.php";

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Ingreso de gastos</title>
    <meta charset="utf-8">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script>
        function findProveedor(idCatProd) {
            let q = document.getElementById("busProv").value;
            $.ajax({
                url: '../includes/controladorCompras.php',
                type: 'POST',
                data: {
                    "action": 'findProveedorGasto',
                    "q": q,
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
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2"><h4>INGRESO DE COMPRA DE GASTOS</h4></div>
    <form name="form2" method="POST" action="makeGasto.php">
        <div class="form-group row">
            <label class="col-form-label col-2" for="busProv"><strong>Proveedor</strong></label>
            <input type="text" class="form-control col-2" id="busProv" name="busProv" onkeyup="findProveedor()"
                   required/>
        </div>
        <div class="form-group row" id="myDiv">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-end" for="numFact"><strong>Número de Factura</strong></label>
            <input type="text" class="form-control col-2" name="numFact" id="numFact"
                   onkeydown="return aceptaNum(event)" required>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-end" for="fechGasto"><strong>Fecha de compra</strong></label>
            <input type="date" class="form-control col-2" name="fechGasto" id="fechGasto" required>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-end" for="fechVenc"><strong>Fecha de vencimiento</strong></label>
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

