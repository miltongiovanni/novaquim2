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
    <title>Seleccionar Vendedor y periodo a revisar comisiones</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25">
        <h4>SELECCIÓN DE VENDEDOR Y PERÍODO PARA REVISAR COMISIONES</h4>
    </div>
    <form method="post" action="comis_vend.php" name="form1">
        <div class="mb-3 row">
            <div class="col-4">
                <label class="form-label" for="idPersonal"><strong>Vendedor</strong></label>
                <select name="idPersonal" class="form-select" required>
                    <option selected disabled value="">Seleccione una opción</option>
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
        </div>
        <div class="mb-3 row">
            <div class="col-2">
                <label class="form-label" for="fechaInicial"><strong>Fecha inicial</strong></label>
                <input type="date" class="form-control" name="fechaInicial" id="fechaInicial" required>
            </div>
            <div class="col-2">
                <label class="form-label" for="fechaFinal"><strong>Fecha final</strong></label>
                <input type="date" class="form-control" name="fechaFinal" id="fechaFinal" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-1">
                <button class="button" type="button" onclick="return Enviar(this.form)"> <span>Continuar</span></button>
            </div>
        </div>
    </form>

    <div class="row mb-3">
        <div class="col-1">
            <button class="button" onclick="history.back()">
                <span>VOLVER</span></button>
        </div>
    </div>
</body>
</html>