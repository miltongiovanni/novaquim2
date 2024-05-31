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
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Creación de Servicios</title>
    <meta charset="utf-8">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
$idUsuario = $_SESSION['userId'];
$datos = array($idCompra, $tipoCompra, $idUsuario);
$EgresoOperador = new EgresoOperaciones();

try {
    $egresoExist = $EgresoOperador->checkEgreso($idCompra, $tipoCompra);
    if (isset($egresoExist['idEgreso']) && $egresoExist['idEgreso'] != null) {
        $_SESSION['idEgreso'] = $egresoExist['idEgreso'];
        header('Location: egreso.php');
    } else {
        $lastIdEgreso = $EgresoOperador->makeEgreso($datos);
        $_SESSION['idEgreso'] = $lastIdEgreso;
        $ruta = "egreso.php";
        $mensaje = "Egreso creado con éxito";
        $icon = "success";
    }
} catch (Exception $e) {
    $ruta = "factXpagar.php";
    $mensaje = "Error al crear el comprobante de egreso";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
