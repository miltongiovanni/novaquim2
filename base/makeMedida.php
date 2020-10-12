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

$PresentacionOperador = new PresentacionesOperaciones();
$codPresentacion = ($codProducto * 100) + $codMedida;
$valida = $PresentacionOperador->validarPresentacion($codPresentacion);
if ($valida == 0) {
    $datos = array($codPresentacion, $presentacion, $codProducto, $codMedida, $codEnvase, $codTapa, $codEtiq, $codigoGen, $stockPresentacion, 3, $cotiza, 1, $codSiigo);
    try {
        $lastcodPresentacion = $PresentacionOperador->makePresentacion($datos);
        $ruta = "listarmed.php";
        $mensaje = "Presentación creada correctamente";

    } catch (Exception $e) {
        $ruta = "crearMedida.php";
        $mensaje = "Error al crear la presentación";
    } finally {
        unset($conexion);
        unset($stmt);
        mover_pag($ruta, $mensaje);
    }

} else {
    $ruta = "crearMedida.php";
    $mensaje = "Código de Presentación existente";
    mover_pag($ruta, $mensaje);
}


