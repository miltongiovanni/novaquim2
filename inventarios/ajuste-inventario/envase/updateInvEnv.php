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
    <meta charset="utf-8">
    <title>Ajuste de Inventario de Envase</title>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<?php
$datos = array($invEnvase, $codEnvase);
$invEnvaseOperador = new InvEnvasesOperaciones();

$datos2 = array($tipo_inv, $idResponsable, $motivo_ajuste, $inv_ant, $invEnvase, $codEnvase, null );
$invAjustesOperador = new InvAjustesOperaciones();
try {
    $invEnvaseOperador->updateInvEnvase($datos);
    $invAjustesOperador->makeInvAjuste($datos2);
    $ruta = "../menu.php";
    $mensaje = "Inventario actualizado correctamente";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "a_inv_dist.php";
    $mensaje = "Error al actualizar el inventario";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>