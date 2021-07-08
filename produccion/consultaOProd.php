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
    <title>Modificar consumo de Materia Prima por Orden de Producción</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
$OProdOperador= new OProdOperaciones();
if (!$OProdOperador->isValidLote($lote)) {
    $ruta = "buscarOprod.php";
    $mensaje = "El número de lote no es válido, vuelva a intentar de nuevo";
    $icon = "error";
    mover_pag($ruta, $mensaje, $icon);
} else {
    $_SESSION['lote'] = $lote;
    $ruta = "detO_Prod.php";
    $mensaje = "El número de lote es válido";
    $icon = "success";
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>