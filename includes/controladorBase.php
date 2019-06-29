<?php
    // Función para cargar las clases
function cargarClases($classname){
    require '../clases/'.$classname.'.php';
}

spl_autoload_register('cargarClases');




function ultimoProdxCat()
{
    $idCatProd = $_POST['idCatProd'];
    $ProductoOperador = new ProductosOperaciones();
	$ultimoCodProdxCat=$ProductoOperador->getUltimoProdxCat($idCatProd);
    echo $ultimoCodProdxCat+1;
}



function ultimaMPxCat()
{
    $idCatMPrima = $_POST['idCatMPrima'];
    $MPrimaOperador = new MPrimasOperaciones();
    $ultimaMP=$MPrimaOperador->getUltimaMPrimaxCat($idCatMPrima);


    $respuesta = array(
        'alias' => $ultimaMP['catMP'] .((($ultimaMP['codMPrima']+1)%100<10) ? "0".($ultimaMP['codMPrima']+1)%100 : ($ultimaMP['codMPrima']+1)%100),
        'codigo' => ($ultimaMP['codMPrima'] + 1));
    echo json_encode($respuesta);
}
function ultimoEnvase()
{
    $EnvaseOperador = new EnvasesOperaciones();
	$ultimoEnvase=$EnvaseOperador->getUltimoEnvase();
    echo $ultimoEnvase+1;
}

//controleur membres
$action = $_POST['action'];
switch ($action) {
    case 'ultimoProdxCat':
    ultimoProdxCat();
        break;
    case 'ultimaMPxCat':
    ultimaMPxCat();
        break;
    case 'ultimoEnvase':
    ultimoEnvase();
        break;
}