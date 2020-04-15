<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idProv = $_POST['idProv'];
$ProveedorOperador = new ProveedoresOperaciones();
$DetProveedorOperador = new DetProveedoresOperaciones();

try {
    $DetProveedorOperador->deleteAllDetProveedor($idProv);
    $ProveedorOperador->deleteProveedor($idProv);
    $ruta = "listarProv.php";
    $mensaje = "Proveedor borrado correctamente";

} catch (Exception $e) {
    $ruta = "deleteProvForm.php";
    $mensaje = "Error al eliminar el proveedor";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}

function mover_pag($ruta, $nota)
{
    echo '<script >
	alert("' . $nota . '")
	self.location="' . $ruta . '"
	</script>';
}

?>
</body>
</html>
