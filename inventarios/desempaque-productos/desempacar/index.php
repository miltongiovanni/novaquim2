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
    <title>Convertir Pacas de Producto a Unidades</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25">
        <h4>DESEMPACAR PACAS A UNIDADES</h4>
    </div>
    <form id="form1" name="form1" method="post" action="unpack.php">
        <div class="mb-3 row">
            <div class="col-4">
                <label class="form-label" for="codPaca"><strong>Producto de Distribución Empacado:</strong></label>
                <select class="form-select" name="codPaca" id="codPaca" required>
                    <option selected disabled value="">Seleccione una opción</option>
                    <?php
                    $invDistribucionOperador = new InvDistribucionOperaciones();
                    $pacas = $invDistribucionOperador->getProdPorDesempacar();
                    for ($i = 0; $i < count($pacas); $i++):
                        ?>
                        <option value="<?= $pacas[$i]['idDistribucion'] ?>"><?= $pacas[$i]['producto'] ?></option>
                    <?php
                    endfor;
                    ?>
                </select>
            </div>
            <div class="col-1">
                <label class="form-label" for="cantidadPacas"><strong>Cantidad:</strong></label>
                <input type="text" class="form-control" name="cantidadPacas" id="cantidadPacas"
                       onkeydown="return aceptaNum(event)" required>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-1 text-center">
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div>
            <div class="col-1 text-center">
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Desempacar</span></button>
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
	   