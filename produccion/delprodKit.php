<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
//ESTOS SON LOS DATOS QUE RECIBE PARA CREAR EL KIT
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
    <title>Detalle de Kit</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
$DetKitOperador = new DetKitsOperaciones();
try {
    $DetKitOperador->deleteDetKit($idKit, $codProducto);
    $_SESSION['idKit'] = $idKit;
    $ruta = "det_kits.php";
    $mensaje = "Detalle de Kit eliminado correctamente";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "../menu.php";
    $mensaje = "Error al eliminar el detalle de kit";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>