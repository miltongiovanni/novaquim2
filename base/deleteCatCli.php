<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$idCatClien = $_POST['idCatClien'];
$catsCliOperador = new CategoriasCliOperaciones();
try {
    $catsCliOperador->deleteCatCli($idCatClien);
    $ruta = "listarCatCli.php";
    $mensaje = "Categoría de cliente eliminada correctamente";

} catch (Exception $e) {
    $ruta = "deleteCatCliForm.php";
    $mensaje = "Error al eliminar la categoría de cliente";
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
