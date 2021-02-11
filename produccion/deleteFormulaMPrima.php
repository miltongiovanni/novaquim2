<?php
include "../includes/valAcc.php";
$idFormulaMPrima = $_POST['idFormulaMPrima'];
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
    <title>Eliminar fórmula de materia prima</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
$FormulaMPrimaOperador = new FormulasMPrimaOperaciones();
try {
    $FormulaMPrimaOperador->deleteFormulaMPrima($idFormulaMPrima);
    $ruta = "../menu.php";
    $mensaje = "Fórmula de materia prima eliminada con éxito";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "deleteFormulaMPrimaForm.php";
    $mensaje = "Error al eliminar la fórmula de materia prima";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
