<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Ventas por familia de productos Novaquim por mes</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
    <div id="saludo"><strong>VENTAS POR FAMILIA PRODUCTOS NOVA POR MES</strong></div>
    <form method="post" action="vtas_fam_tot_mes.php" name="form1">
        <div class="form-group row">
            <label class="col-form-label col-1" for="year"><strong>Año</strong></label>
            <select name="year" id="year" class="form-control col-1" required>
                <?php
                $year=intval(date("Y"));
                for ($i = $year; $i >= 2011; $i--) : ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                <?php
                endfor;
                ?>
            </select>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1" for="year"><strong>Tipo</strong></label>
            <select name="type" id="type" class="form-control col-1" required>
                    <option value="1">Unidades</option>
                    <option value="2">Valores</option>
            </select>
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
            <button class="button1" onclick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>


</div>
</body>
</html>