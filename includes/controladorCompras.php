<?php
// Función para cargar las clases
include "nit_verif.php";
include "valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');


function nitProveedor()
{
    $tipo = $_POST['tipo'];
    $numero = $_POST['numero'];
    if ($tipo==1)
        $NIT_F=number_format($numero, 0, '.', '.')."-".verifica($numero);
    if ($tipo==2)
        $NIT_F=number_format($numero, 0, '.', '.');
    echo $NIT_F;
}


function findProveedor()
{
    $q=$_POST['q'];
    $ProveedorOperador = new ProveedoresOperaciones();
    $proveedores = $ProveedorOperador->getProveedoresByName($q);
    if(count($proveedores)==0){
        echo '<input type="text" class="form-control col-2" value="No hay sugerencias" readOnly>';
    }
    else{
        echo'<br>';
        echo'<select name="idProv" id="idProv" class="form-control col-3">';
        for($i=0;$i<count($proveedores);$i++){
            echo '<option value='.$proveedores[$i]['idProv'].'>'.$proveedores[$i]['nomProv'].'</option>';
        }
        echo'</select>';
    }
}

function ultimaMPxCat()
{
    $idCatMPrima = $_POST['idCatMPrima'];
    $MPrimaOperador = new MPrimasOperaciones();
    $ultimaMP = $MPrimaOperador->getUltimaMPrimaxCat($idCatMPrima);


    $respuesta = array(
        'alias' => $ultimaMP['catMP'] . ((($ultimaMP['codMPrima'] + 1) % 100 < 10) ? "0" . ($ultimaMP['codMPrima'] + 1) % 100 : ($ultimaMP['codMPrima'] + 1) % 100),
        'codigo' => ($ultimaMP['codMPrima'] + 1));
    echo json_encode($respuesta);
}

function eliminarSession()
{
    $variable = $_POST['variable'];
    unset($_SESSION[$variable]);
    echo 'OK';
}

function ultimaTapa()
{
    $TapaOperador = new TapasOperaciones();
    $ultimaTapa = $TapaOperador->getUltimaTapa();
    echo $ultimaTapa + 1;
}

function ultimaEtiqueta()
{
    $EtiquetaOperador = new EtiquetasOperaciones();
    $ultimaEtiqueta = $EtiquetaOperador->getUltimaEtiqueta();
    echo $ultimaEtiqueta + 1;
}

function ultimoProdDisxCat()
{
    $idCatDis = $_POST['idCatDis'];
    $ProductoDisOperador = new ProductosDistribucionOperaciones();
    $ultimoCodProdDisxCat = $ProductoDisOperador->getUltimoProdDisxCat($idCatDis);
    echo $ultimoCodProdDisxCat + 1;
}


//controleur membres
$action = $_POST['action'];
switch ($action) {
    case 'nitProveedor':
        nitProveedor();
        break;
    case 'findProveedor':
        findProveedor();
        break;
    case 'eliminarSession':
        eliminarSession();
        break;
    case 'ultimaTapa':
        ultimaTapa();
        break;
    case 'ultimaEtiqueta':
        ultimaEtiqueta();
        break;
    case 'infoProducto':
        infoProducto();
        break;
    case 'ultimoProdDisxCat':
        ultimoProdDisxCat();
        break;
}