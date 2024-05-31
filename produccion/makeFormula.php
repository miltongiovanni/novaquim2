<?php
include "../../../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Ingreso de Fórmulas de Producto</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
$FormulaOperador = new FormulasOperaciones();
$datos = array($nomFormula, $codProducto);
try {
    $idFormula=$FormulaOperador->makeFormula($datos);
    $_SESSION['idFormula'] = $idFormula;
    $ruta = "detFormula.php";
    $mensaje = "Fórmula creada con éxito";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "formula.php";
    $mensaje = "Error al crear la fórmula";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>

