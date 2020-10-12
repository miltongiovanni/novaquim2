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
$OProdMPrimaOperador= new OProdMPrimaOperaciones();
if (!$OProdMPrimaOperador->isValidLote($loteMP)) {
    echo ' <script >
				alert("El número de lote no es válido, vuelva a intentar de nuevo");
				history.back();
			</script>';
} else {

    $_SESSION['loteMP'] = $loteMP;
    header("Location: detO_Prod_mp.php");
    exit;
}



?>
