<?php
include "../../../includes/valAcc.php";
$idFormula = $_POST['idFormula'];
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
    <title>Eliminar Formulación</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
$FormulaOperador = new FormulasOperaciones();
try {
    $FormulaOperador->deleteFormula($idFormula);
    $_SESSION['idFormula'] = $idFormula;
    $ruta = "../menu.php";
    $mensaje = "Fórmula eliminada con éxito";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "deleteFormulaForm.php";
    $mensaje = "Error al eliminar la fórmula";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
