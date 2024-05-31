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
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Creaci�n de Kits de Productos de Distribuci�n</title>
    <meta charset="utf-8">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
$datos = array($codEnvase, $codigo);
$KitOperador = new KitsOperaciones();
try {
    $idKit = $KitOperador->makeKit($datos);
    $_SESSION['idKit'] = $idKit;
    $ruta = "det_kits.php";
    $mensaje = "Kit creado correctamente";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "../menu.php";
    $mensaje = "Error al crear el kit";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>