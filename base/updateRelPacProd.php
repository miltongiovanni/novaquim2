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

$datos = array($codPaca, $codUnidad, $cantidad, $idPacUn);
$relDisEmpOperador = new RelDisEmpOperaciones();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Relación Paca Unidad Productos de Distribución</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
try {
    $relDisEmpOperador->updateRelDisEmp($datos);
    $ruta = "listarDes.php";
    $mensaje = "Relación paca unidad producto de distribución actualizada correctamente";
    $icon = "success";

} catch (Exception $e) {
    $ruta = "buscarRelPacProd.php";
    $mensaje = "Error al actualizar la relación paca unidad producto de distribución";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>