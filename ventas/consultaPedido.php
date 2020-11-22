<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idPedido = $_POST['idPedido'];
$pedidoOperador = new PedidosOperaciones();
if (!$pedidoOperador->isValidIdPedido($idPedido)) {
    echo ' <script >
				alert("El número del pedido no es válido, vuelva a intentar de nuevo");
				history.back();
			</script>';
} else {
    $_SESSION['idPedido'] = $idPedido;
    header("Location: det_pedido.php");
    exit;
}
