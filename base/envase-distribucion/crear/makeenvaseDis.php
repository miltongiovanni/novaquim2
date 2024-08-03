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
$datos = array($idDis, $idEnv, $idTapa);
$relEnvDisoperador = new RelEnvDisOperaciones();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Relación Envase con Productos de Distribución</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<?php
try {
    $relDis = $relEnvDisoperador->checkDistribucion($idDis);
    if ($relDis && $relDis['idEnvDis'] != null) {
        $_SESSION['idEnvDis'] = $relDis['idEnvDis'];
        $ruta = "../crear/";
        $mensaje = "Relación existente";
        $icon = "warning";
    } else {
        $lastCodRelEnvDis = $relEnvDisoperador->makeRelEnvDis($datos);
        $ruta = "../lista/";
        $mensaje = "Relación creada con Éxito";
        $icon = "success";
    }


} catch (Exception $e) {
    $ruta = "../crear/";
    $mensaje = "Error al crear la relación";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}


?>
</body>
</html>