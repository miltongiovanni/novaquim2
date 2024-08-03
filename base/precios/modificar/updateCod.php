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
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos de Código Genérico</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>

</head>

<body>


<?php
$distribuidor= (round($fabrica*2*1.12,-2))/2;
$detal= (round($fabrica*2*1.4,-2))/2;
$mayor= (round($distribuidor*2*0.93,-2))/2;
$super= (round($fabrica*2*0.93,-2))/2;
$PrecioOperador = new PreciosOperaciones();
$datos = array($producto, $fabrica, $distribuidor, $detal, $mayor, $super, $presActiva, $presLista, $codigoGen );


try {
    $PrecioOperador->updatePrecio($datos);
    $ruta = "../lista/";
    $mensaje =  "Código genérico actualizado correctamente";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "../modificar/";
    $mensaje = "Error al actualizar el código genérico";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}

?>
</body>
</html>