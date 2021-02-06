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
    ${$nombre_campo} = $valor;
    if (is_array($valor)) {
        //echo $nombre_campo . print_r($valor) . '<br>';
    } else {
        //echo $nombre_campo . '=' . ${$nombre_campo} . '<br>';
    }
}
$fechaActual = hoy();
$diasNotaC = Calc_Dias($fechaNotaC, $fechaActual);
$facturaOperador = new FacturasOperaciones();
$facturaOr = $facturaOperador->getFactura($facturaOrigen);


if ($diasNotaC >= 0) {
    $notaCreditoOperador = new NotasCreditoOperaciones();
    $datos = array($idCliente, $fechaNotaC, $facturaOrigen, $facturaDestino, $motivo, $facturaOr['descuento']);

    try {
        $lastIdNotaCr = $notaCreditoOperador->makeNotaC($datos);
        $_SESSION['idNotaC'] = $lastIdNotaCr;
        $ruta = "detalleNotaC.php";
        $mensaje = "Nota crédito creada con éxito";
    } catch (Exception $e) {
        $ruta = "crearNotaC.php";
        $mensaje = "Error al crear la nota crédito";
    } finally {
        unset($conexion);
        unset($stmt);
        mover_pag($ruta, $mensaje, $icon);
    }
} else {
    if ($diasNotaC < 0) {
        echo '<script >
				alert("La fecha de la nota crédito no puede ser menor que la actual");
				self.location="pedido.php";
				</script>';
    }
}

