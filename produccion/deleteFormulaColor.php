<?php
include "../../../includes/valAcc.php";
$idFormulaColor = $_POST['idFormulaColor'];
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Eliminar fórmula de solución de color</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
$FormulaColorOperador = new FormulasColorOperaciones();
try {
    $FormulaColorOperador->deleteFormulaColor($idFormulaColor);
    $ruta = "../menu.php";
    $mensaje = "Fórmula de color eliminada con éxito";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "deleteFormulaColorForm.php";
    $mensaje = "Error al eliminar la fórmula de color";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
