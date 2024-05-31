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
    <meta charset="utf-8">
    <title>Seleccionar Comprobante de egreso a Modificar</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
$egresoOperador = new EgresoOperaciones();
if (!$egresoOperador->isValidIdEgreso($idEgreso)) {
    $ruta = "buscarEgreso.php";
    $mensaje = "El número del egreso no es válido, vuelva a intentar de nuevo";
    $icon = "error";
    mover_pag($ruta, $mensaje, $icon);
} else {
    $_SESSION['idEgreso'] = $idEgreso;
    $ruta = "egreso.php";
    $mensaje = "El número del egreso válido";
    $icon = "success";
    mover_pag($ruta, $mensaje, $icon);
}

?>
</body>
</html>
