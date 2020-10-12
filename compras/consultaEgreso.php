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
$egresoOperador= new EgresoOperaciones();
if (!$egresoOperador->isValidIdEgreso($idEgreso)) {
    echo ' <script >
				alert("El número del egreso no es válido, vuelva a intentar de nuevo");
				history.back();
			</script>';
} else {

    $_SESSION['idEgreso'] = $idEgreso;
    header("Location: egreso.php");
    exit;
}



?>
