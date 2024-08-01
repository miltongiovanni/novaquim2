<?php
include "../../../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$idCatClien = $_POST['idCatClien'];
$desCatClien = $_POST['desCatClien'];
$datos = array($desCatClien, $idCatClien);
$catsCliOperador = new CategoriasCliOperaciones();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos de Tipo de Cliente</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<?php
try {
    $catsCliOperador->updateCatCli($datos);
    $ruta = "/base/tipo-cliente/lista";
    $mensaje = "Categoría de cliente actualizada correctamente";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "/base/tipo-cliente/modificar";
    $mensaje = "Error al actualizar la categoría de cliente";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
