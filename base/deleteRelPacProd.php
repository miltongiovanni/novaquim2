<?php
include "../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idPacUn = $_POST['idPacUn'];
$relDisEmpOperador = new RelDisEmpOperaciones();

try {
    $relDisEmpOperador->deleteRelDisEmp($idPacUn);
    $ruta = "listarDes.php";
    $mensaje = "Relación paca unidad producto de distribución eliminada correctamente";

} catch (Exception $e) {
    $ruta = "deleteRelPacProdForm.php";
    $mensaje = "No fue permitido eliminar la relación paca unidad producto de distribución";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}

function mover_pag($ruta, $nota)
{
    echo '<script language="Javascript">
	alert("' . $nota . '")
	self.location="' . $ruta . '"
	</script>';
}

?>
