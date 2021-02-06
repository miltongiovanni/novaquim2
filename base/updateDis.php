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
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos de Producto de Distribución</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head
<body>
<?php
$datos = array($producto, $codIva, $precioVta, $cotiza, $activo, $stockDis, $idDistribucion);
$ProductoDistribucionOperador = new ProductosDistribucionOperaciones();
echo '<div style="display:none">';
var_dump('');
echo '</div>';
try {
    $ProductoDistribucionOperador->updateProductoDistribucion($datos);
    $ruta = "listarDis.php";
    $mensaje = "Producto de Distribución actualizado correctamente";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "buscarDis.php";
    $mensaje = "Error al actualizar el Producto de Distribución";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
