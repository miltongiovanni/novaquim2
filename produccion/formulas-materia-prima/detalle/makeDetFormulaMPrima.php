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
    <title>Porcentaje de Materias Primas en la Fórmula</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
    <?php
    $DetFormulaMPrimaOperador = new DetFormulaMPrimaOperaciones();
    $datos = array($idFormulaMPrima, $codMPrima, $porcentaje / 100);
    try {
        $DetFormulaMPrimaOperador->makeDetFormulaMPrima($datos);
        $_SESSION['idFormulaMPrima'] = $idFormulaMPrima;
        $ruta = "../detalle/";
        $mensaje = "Detalle de fórmula de materia prima adicionado con éxito";
        $icon = "success";
    } catch (Exception $e) {
        $_SESSION['idFormulaMPrima'] = $idFormulaMPrima;
        $ruta = "../detalle/";
        $mensaje = "Error al ingresar el detalle de la fórmula de materia prima";
        $icon = "error";
    } finally {
        unset($conexion);
        unset($stmt);
        mover_pag($ruta, $mensaje, $icon);
    }
    ?>
</body>
</html>


