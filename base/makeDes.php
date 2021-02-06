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
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
$datos = array($codPaca, $codUnidad, $cantidad);
$relDisEmpOperador = new RelDisEmpOperaciones();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Relación de Pacas de Productos de Distribución</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
try {
    $relDes = $relDisEmpOperador->checkPaca($codPaca);
    if ($relDes['idPacUn'] != null) {
        $_SESSION['idPacUn'] = $relDes['idPacUn'];
        header('Location: updateRelPacProdForm.php');
    } else {
        $lastCodRelEnvDis = $relDisEmpOperador->makeRelDisEmp($datos);
        $ruta = "listarDes.php";
        $mensaje = "Relación creada con Éxito";
        $icon = "success";
    }

} catch (Exception $e) {
    $ruta = "crearDes.php";
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