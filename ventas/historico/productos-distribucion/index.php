<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Ventas por familia de productos distribuidos por mes</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>VENTAS POR FAMILIA DISTRIBUCIÓN POR MES</h4></div>
    <form method="post" action="vtas_dist_tot_mes.php" name="form1">
        <div class="mb-3 row">
            <div class="col-2">
                <label class="form-label" for="year"><strong>Año</strong></label>
                <select name="year" id="year" class="form-select" required>
                    <?php
                    $year = intval(date("Y"));
                    for ($i = $year; $i >= 2011; $i--) : ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                    <?php
                    endfor;
                    ?>
                </select>
            </div>
            <div class="col-2">
                <label class="form-label" for="year"><strong>Tipo</strong></label>
                <select name="type" id="type" class="form-select" required>
                    <option value="1">Unidades</option>
                    <option value="2">Valores</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            
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