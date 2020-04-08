<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$idCatClien = $_POST['idCatClien'];
$desCatClien = $_POST['desCatClien'];
$datos = array($desCatClien, $idCatClien);
$catsCliOperador = new CategoriasCliOperaciones();

try {
    $catsCliOperador->updateCatCli($datos);
    $ruta = "listarCatCli.php";
    $mensaje = "Categoría de cliente actualizada correctamente";

} catch (Exception $e) {
    $ruta = "buscarCatCli.php";
    $mensaje = "Error al actualizar la categoría de cliente";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}

function mover_pag($ruta, $Mensaje)
{
    echo '<script>
   	alert("' . $Mensaje . '");
   	self.location="' . $ruta . '"
   	</script>';
}

?>
