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
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Creación de Proveedores</title>
    <meta charset="utf-8">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
$estProv = 1;
$datos = array(0, $nitProv, $nomProv, $dirProv, $contProv, $telProv, $emailProv, $idCatProv, $autoretProv, $regProv, $idTasaIcaProv, $estProv, $idRetefuente);
$ProveedorOperador = new ProveedoresOperaciones();

try {
    $nitExist = $ProveedorOperador->checkNit($nitProv);
    if (isset($nitExist['idProv']) && $nitExist['idProv'] != null) {
        $_SESSION['idProv'] = $nitExist['idProv'];
        $ruta = "updateProvForm.php";
        $mensaje = "Proveedor existente";
        $icon = "warning";
        mover_pag($ruta, $mensaje, $icon);
    } else {
        $lastIdProv = $ProveedorOperador->makeProveedor($datos);
        $_SESSION['idProv'] = $lastIdProv;
        $ruta = "detProveedor.php";
        $mensaje = "Proveedor creado con éxito";
        $icon = "success";
    }
} catch (Exception $e) {
    $ruta = "makeProvForm.php";
    $mensaje = "Error al crear el Proveedor";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>