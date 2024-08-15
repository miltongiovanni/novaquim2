<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Seleccionar Proveedor</title>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/findMateriaPrima.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>SELECCIONAR MATERIA PRIMA POR EL CONTROL DE CALIDAD</h4></div>
    <form id="form1" name="form1" method="post" action="../../control-calidad/materia-prima/det_cal_materia_prima.php">
        <div class="mb-3 row">
            <div class="col-2">
                <label class="form-label" for="busMPrima"><strong>Materia Prima</strong></label>
                <input type="text" class="form-control" id="busMPrima" name="busMPrima" onkeyup="findMateriaPrima()" required/>
            </div>
            <div class="col-3 pt-4 d-none" id="materia_prima">
                <div class="mt-2" id="mPrimaSelect"></div>
            </div>
            <div class="col-3 d-none" id="lote_info">
                <label class="form-label" for="id_cal_mp"><strong>Lote</strong></label>
                <select name="id_cal_mp" id="id_cal_mp" class="form-select col-12" required>
                </select>
            </div>
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
            <button class="button1" onclick="history.back()">
                <span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>

