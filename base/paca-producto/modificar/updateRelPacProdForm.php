<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
if (isset($_POST['idPacUn'])) {
    $idPacUn = $_POST['idPacUn'];
} else {
    if (isset($_SESSION['idPacUn'])) {
        $idPacUn = $_SESSION['idPacUn'];
        unset($_SESSION['idPacUn']);
    }
}


$relDisEmpOperador = new RelDisEmpOperaciones();
$relacion = $relDisEmpOperador->getRelDisEmp($idPacUn);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Relación Paca Unidad Productos de Distribución</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>ACTUALIZACIÓN RELACIÓN PACA UNIDAD PRODUCTOS DE DISTRIBUCIÓN</h4></div>
    <form method="post" action="updateRelPacProd.php" name="form1">
        <input id="idPacUn" name="idPacUn" type="hidden" value="<?= $idPacUn ?>">
        <div class="form-group row">
            <div class="col-2 text-end">
                <label class="col-form-label " for="codPaca"><strong>Producto empacado</strong></label>
            </div>
            <div class="col-2 px-0">
                <select name="codPaca" id="codPaca" class="form-control " required>
                    <option selected value="<?= $relacion['codPaca'] ?>"><?= $relacion['paca'] ?></option>
                    <?php
                    $ProductoDistribucionOperador = new ProductosDistribucionOperaciones();
                    $productos = $ProductoDistribucionOperador->getProductosDistribucion(true);
                    $filas = count($productos);
                    for ($i = 0; $i < $filas; $i++) {
                        if ($relacion['codPaca'] != $productos[$i]["idDistribucion"]) {
                            echo '<option value="' . $productos[$i]["idDistribucion"] . '">' . $productos[$i]['producto'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-2 text-end">
                <label class="col-form-label " for="codUnidad"><strong>Producto por unidad</strong></label>
            </div>
            <div class="col-2 px-0">
                <select name="codUnidad" id="codUnidad" class="form-control " required>
                    <option selected value="<?= $relacion['codUnidad'] ?>"><?= $relacion['unidad'] ?></option>
                    <?php
                    $ProductoDistribucionOperador = new ProductosDistribucionOperaciones();
                    $productos = $ProductoDistribucionOperador->getProductosDistribucion(true);
                    $filas = count($productos);
                    for ($i = 0; $i < $filas; $i++) {
                        if ($relacion['codUnidad'] != $productos[$i]["idDistribucion"]) {
                            echo '<option value="' . $productos[$i]["idDistribucion"] . '">' . $productos[$i]['producto'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-2 text-end">
                <label class="col-form-label " for="cantidad"><strong>Unidades por empaque</strong></label>
            </div>
            <div class="col-2 px-0">
                <input type="text" class="form-control " name="cantidad" id="cantidad"
                       onkeydown="return aceptaNum(event)" value="<?= $relacion['cantidad'] ?>">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-1">
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
	   