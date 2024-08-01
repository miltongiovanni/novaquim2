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
    <title>Creación de Clientes</title>
    <meta charset="utf-8">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<?php
$estadoCliente = 1;
$fchCreacionCliente = date("Y-m-d");
$datos = array($nitCliente, $nomCliente, $contactoCliente, $cargoCliente, $telCliente, $celCliente, $dirCliente, $emailCliente, $estadoCliente, $idCatCliente, $ciudadCliente, $retIva, $retIca, $retFte, $codVendedor, $fchCreacionCliente, 0);
$clienteOperador = new ClientesOperaciones();
try {
    $nitExist = $clienteOperador->checkNit($nitCliente);
    if (isset($nitExist['idCliente']) && $nitExist['idCliente'] != null) {
        $_SESSION['idCliente'] = $nitExist['idCliente'];
        $ruta = "../detalle/";
        $mensaje = "Cliente ya existe";
        $icon = "warning";
        mover_pag($ruta, $mensaje, $icon);
        exit;
    } else {
        $lastIdCliente = $clienteOperador->makeCliente($datos);
        $datosSucursal = array($lastIdCliente, 1, $dirCliente, $ciudadCliente, $telCliente, $nomCliente);
        $clienteSucursalOperador = new ClientesSucursalOperaciones();
        $clienteSucursalOperador->makeClienteSucursal($datosSucursal);
        $_SESSION['idCliente'] = $lastIdCliente;
        $ruta = "../detalle/";
        $mensaje = "Cliente creado con éxito";
        $icon = "success";
    }
} catch (Exception $e) {
    $ruta = "../crear/";
    $mensaje = "Error al crear el Cliente";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>



