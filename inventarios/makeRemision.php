<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if (is_array($valor)) {
        //echo $nombre_campo.print_r($valor).'<br>';
    } else {
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Remisión de Productos</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
$datos = array($cliente, $fechaRemision, $valor);
$RemisionOperador = new RemisionesOperaciones();

try {
    $lastIdRemision = $RemisionOperador->makeRemision($datos);
    $_SESSION['idRemision'] = $lastIdRemision;
    $ruta = "det_remision.php";
    $mensaje = "Remisión creada con éxito";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "remision.php";
    $mensaje = "Error al crear la remisión";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>