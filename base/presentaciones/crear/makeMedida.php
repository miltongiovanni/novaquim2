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
    <title>Creación de Presentación de Productos</title>
    <meta charset="utf-8">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>

<body>
<?php
$PresentacionOperador = new PresentacionesOperaciones();
$codPresentacion = ($codProducto * 100) + $codMedida;
$valida = $PresentacionOperador->validarPresentacion($codPresentacion);
if ($valida == 0) {
    $datos = array($codPresentacion, $presentacion, $codProducto, $codMedida, $codEnvase, $codTapa, $codEtiq, $codigoGen, $stockPresentacion, 3, $cotiza, 1, $codSiigo);
    try {
        $lastcodPresentacion = $PresentacionOperador->makePresentacion($datos);
        $ruta = "/base/presentaciones/lista";
        $mensaje = "Presentación creada correctamente";
        $icon = "success";
    } catch (Exception $e) {
        $ruta = "/base/presentaciones/crear";
        $mensaje = "Error al crear la presentación";
        $icon = "error";
    } finally {
        unset($conexion);
        unset($stmt);
        mover_pag($ruta, $mensaje, $icon);
    }

} else {
    $ruta = "crearMedida.php";
    $mensaje = "Código de Presentación existente";
    $icon = "info";
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>

