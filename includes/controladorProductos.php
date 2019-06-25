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

//controleur membres
$action = $_POST['action'];
switch ($action) {
    case 'ultimoProdxCat':
    ultimoProdxCat();
        break;
}