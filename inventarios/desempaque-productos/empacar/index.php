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
    <title>Organizar Unidades en Pacas</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>ORGANIZAR UNIDADES EN PACAS</h4></div>
    <form id="form1" name="form1" method="post" action="pack.php">
        <div class="mb-3 row">
            <label class="form-label col-3 text-end" for="codUnidad"><strong>Unidades de Producto sin
                    empacar:</strong></label>
            <select class="form-select col-3" name="codUnidad" id="codUnidad" required>
                <option selected disabled value="">Seleccione una opción-------------</option>
                <?php
                $invDistribucionOperador = new InvDistribucionOperaciones();
                $unidades = $invDistribucionOperador->getProdPorEmpacar();
                for ($i = 0; $i < count($unidades); $i++):
                    ?>
                    <option value="<?= $unidades[$i]['idDistribucion'] ?>"><?= $unidades[$i]['producto'] ?></option>
                <?php
                endfor;
                ?>
            </select>
        </div>
        <div class="mb-3 row">
            <label class="form-label col-3 text-end" for="unidades"><strong>Cantidad:</strong></label>
            <input type="text" class="form-control col-3" name="unidades" id="unidades"
                   onkeydown="return aceptaNum(event)" required>
        </div>
        <div class="mb-3 row">
            <div class="col-1 text-center">
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div>
            <div class="col-1 text-center">
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Empacar</span></button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-1">
            <button class="button1" onClick="window.location='../../../menu.php'"><span>VOLVER</span></button>
        </div>
    </div>

</div>
</body>
</html>
	   