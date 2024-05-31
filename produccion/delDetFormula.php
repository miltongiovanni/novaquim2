<?php
include "../../../includes/valAcc.php";
$idFormula = $_POST['idFormula'];
$codMPrima = $_POST['codMPrima'];
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$DetFormulaOperador = new DetFormulaOperaciones();
$datos = array($idFormula, $codMPrima);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Eliminar detalle de fórmula</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>

</head>
<body>
<?php
try {
    $DetFormulaOperador->deleteDetFormula($datos);
    $_SESSION['idFormula'] = $idFormula;
    $ruta = "detFormula.php";
    $mensaje = "Detalle de fórmula eliminado con éxito";
    $icon = "success";
} catch (Exception $e) {
    $_SESSION['idFormula'] = $idFormula;
    $ruta = "detFormula.php";
    $mensaje = "Error al eliminar el detalle de la fórmula";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>

