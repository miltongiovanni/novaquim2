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
        //echo $nombre_campo . '=' . ${$nombre_campo} . '<br>';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos del Pedido</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>

</head>
<body>
<?php
$detPedidoOperador = new DetPedidoOperaciones();
$datos = array($idPedido, $codProducto);
try {
    $detPedidoOperador->deleteDetPedido($datos);
    $_SESSION['idPedido'] = $idPedido;
    $ruta = "det_pedido.php";
    $mensaje = "Detalle del pedido eliminado con éxito";
    $icon = "success";
} catch (Exception $e) {
    $_SESSION['idPedido'] = $idPedido;
    $ruta = "det_pedido.php";
    $mensaje = "Error al eliminar el detalle del pedido";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
