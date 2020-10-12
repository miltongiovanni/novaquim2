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
$CompraOperador = new ComprasOperaciones();
$datos = array($idProv, $numFact, $fechComp, $fechVenc, $idCompra);

try {
    $CompraOperador->updateCompra($datos);
    $_SESSION['idCompra'] = $idCompra;
    $_SESSION['tipoCompra'] = $tipoCompra;
    $ruta = "detCompra.php";
    $mensaje = "Compra actualizada con éxito";

} catch (Exception $e) {
    switch (intval($tipoCompra)){
        case 1:
            $ruta = "buscarcompramp.php";
            break;
        case 2:
            $ruta = "buscarcompraenv.php";
            break;
        case 3:
            $ruta = "buscarcompraetq.php";
            break;
        case 4:
            $ruta = "buscarcompradist.php";
            break;
    }
    $mensaje = "Error al actualizar la compra";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}



?>
