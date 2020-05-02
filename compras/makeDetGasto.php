<?php
include "../includes/valAcc.php";
include "../includes/calcularDias.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

foreach ($_POST as $nombre_campo => $valor) {
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
    //echo $nombre_campo . " = " . $valor . "<br>";
    eval($asignacion);
}
$GastoOperador = new GastosOperaciones();
$DetGastoOperador = new DetGastosOperaciones();
if ($DetGastoOperador->productoExiste($idGasto, $producto)) {
    echo ' <script >
				alert("Producto incluido anteriormente");
				history.back();
			</script>';
} else {
        $datos = array($idGasto, $producto, $cantGasto, $precGasto, $codIva);
    try {
        $DetGastoOperador->makeDetGasto($datos);
        $GastoOperador->updateTotalesGasto(BASE_C, $idGasto);
        $_SESSION['idGasto'] = $idGasto;
        $ruta = "detGasto.php";
        $mensaje = "Detalle de gasto adicionado con éxito";
    } catch (Exception $e) {
        $_SESSION['idGasto'] = $idGasto;
        $ruta = "detGasto.php";
        $ruta = $rutaError;
        $mensaje = "Error al ingresar el detalle de la factura de compra";
    } finally {
        unset($conexion);
        unset($stmt);
        mover_pag($ruta, $mensaje);
    }
}

function mover_pag($ruta, $Mensaje)
{
    echo '<script >
   alert("' . $Mensaje . '")
   self.location="' . $ruta . '"
   </script>';
}

?>
