<?php
include "../includes/valAcc.php";
$idFormula = $_POST['idFormula'];
$codMPrima = $_POST['codMPrima'];
$porcentaje = $_POST['porcentaje'];
$orden = $_POST['orden'];
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos de fórmula</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>

</head>
<body>
<?php
$DetFormulaOperador = new DetFormulaOperaciones();
$datos = array($porcentaje / 100, $orden, $idFormula, $codMPrima);
try {
    $DetFormulaOperador->updateDetFormula($datos);
    $_SESSION['idFormula'] = $idFormula;
    $ruta = "detFormula.php";
    $mensaje = "Detalle de fórmula actualizado con éxito";
    $icon = "success";
} catch (Exception $e) {
    $_SESSION['idFormula'] = $idFormula;
    $ruta = "detFormula.php";
    $mensaje = "Error al actualizar el detalle de la fórmula";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
