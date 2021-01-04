<?php
include "../includes/valAcc.php";
function cargarClases($classname){
    require '../clases/'.$classname.'.php';
}

spl_autoload_register('cargarClases');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Seleccionar Vendedor y periodo a revisar comisiones</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../js/validar.js"></script>

</head>
<body>
<div id="contenedor">
    <div id="saludo"><strong>SELECCIÓN DE VENDEDOR Y PERÍODO PARA REVISAR COMISIONES</strong></div>
    <form method="post" action="comis_vend.php" name="form1">
        <div class="form-group row">
            <label class="col-form-label col-1" for="combo"><strong>Personal</strong></label>
            <select name="idPersonal" class="form-control col-2" required>
                <option selected disabled value="">-----------------------------</option>
                <?php
                $manager = new PersonalOperaciones();
                $personal = $manager->getVendedores();
                for ($i = 0; $i < count($personal); $i++):
                    ?>
                    <option value="<?= $personal[$i]["idPersonal"] ?>"><?= $personal[$i]["vendedor"] ?></option>';
                <?php
                endfor;
                ?>

            </select>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1 text-right" for="fechaInicial"><strong>Fecha inicial</strong></label>
            <input type="date" class="form-control col-2" name="fechaInicial" id="fechaInicial" required>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1 text-right" for="fechaFinal"><strong>Fecha final</strong></label>
            <input type="date" class="form-control col-2" name="fechaFinal" id="fechaFinal" required>
        </div>
        <div class="row form-group">
            <div class="col-1">
                <button class="button" onclick="return Enviar(this.form)">
                    <span>Continuar</span></button>
            </div>
        </div>
    </form>

    <div class="row form-group">
        <div class="col-1"><button class="button"  onclick="history.back()">
                <span>VOLVER</span></button></div>
    </div>
</body>
</html>