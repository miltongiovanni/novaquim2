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
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos del Proveedor</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<?php
$datos = array($nitProv, $nomProv, $dirProv, $contProv, $telProv, $emailProv, $idCatProv, $autoretProv, $regProv, $idTasaIcaProv, $estProv, $idRetefuente, $idProv);
$ProveedorOperador = new ProveedoresOperaciones();

try {
    $ProveedorOperador->updateProveedor($datos);
    $ruta = "../lista/";
    $mensaje = "Proveedor actualizado correctamente";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "../modificar/";
    $mensaje = "Error al actualizar el proveedor";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>