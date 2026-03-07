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
function arrondiSup(float $numero, float $significancia = 1): float
{
    if ($significancia == 0) {
        return 0;
    }

    return ceil($numero / $significancia) * $significancia;
}

$distribuidor= (arrondiSup($detal*2*0.8,100))/2;
$mayor= (arrondiSup($detal*2*0.8*0.93,100))/2;
$fabrica= (arrondiSup($detal*2*0.8*0.93*0.96,100))/2;
$super= (arrondiSup($detal*2*0.8*0.93*0.96*0.93,100))/2;

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