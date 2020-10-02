<?php
// Función para cargar las clases
include "nit_verif.php";
include "valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');


function nitCliente()
{
    $tipo = $_POST['tipo'];
    $numero = $_POST['numero'];
    if ($tipo == 1)
        $NIT_F = number_format($numero, 0, '.', '.') . "-" . verifica($numero);
    if ($tipo == 2)
        $NIT_F = number_format($numero, 0, '.', '.');
    echo $NIT_F;
}


function findCliente()
{
    $q = $_POST['q'];
    $clienteOperador = new ClientesOperaciones();
    $clientes = $clienteOperador->getClientesByName($q);
    if (count($clientes) == 0) {
        echo '<input type="text" class="form-control col-2" value="No hay sugerencias" readOnly>';
    } else {
        echo '<br>';
        echo '<select name="idCliente" id="idCliente" class="form-control col-3">';
        for ($i = 0; $i < count($clientes); $i++) {
            echo '<option value=' . $clientes[$i]['idCliente'] . '>' . $clientes[$i]['nomCliente'] . '</option>';
        }
        echo '</select>';
    }
}

function findProveedorBytipoCompra()
{
    $q = $_POST['q'];
    $tipoCompra = $_POST['tipoCompra'];
    $ProveedorOperador = new ProveedoresOperaciones();
    $proveedores = $ProveedorOperador->getProveedoresByNameAndTipoCompra($q, $tipoCompra);
    if (count($proveedores) == 0) {
        echo '<input type="text" class="form-control col-4" value="No hay sugerencias" readOnly>';
    } else {
        echo '<br>';
        echo '<select name="idProv" id="idProv" class="form-control col-4">';
        for ($i = 0; $i < count($proveedores); $i++) {
            echo '<option value=' . $proveedores[$i]['idProv'] . '>' . $proveedores[$i]['nomProv'] . '</option>';
        }
        echo '</select>';
    }
}

function findProveedorGasto()
{
    $q = $_POST['q'];
    $ProveedorOperador = new ProveedoresOperaciones();
    $proveedores = $ProveedorOperador->getProveedoresGastos($q);
    if (count($proveedores) == 0) {
        echo '<input type="text" class="form-control col-4" value="No hay sugerencias" readOnly>';
    } else {
        echo '<br>';
        echo '<select name="idProv" id="idProv" class="form-control col-4">';
        for ($i = 0; $i < count($proveedores); $i++) {
            echo '<option value=' . $proveedores[$i]['idProv'] . '>' . $proveedores[$i]['nomProv'] . '</option>';
        }
        echo '</select>';
    }
}

function updateEstadoCompra()
{
    $idCompra = $_POST['idCompra'];
    $estadoCompra = $_POST['estadoCompra'];
    $CompraOperador = new ComprasOperaciones();
    $datos = array($estadoCompra, $idCompra);
    $CompraOperador->updateEstadoCompra($datos);
    $rep['msg'] = "OK";
    echo json_encode($rep);
}

function updateEstadoGasto()
{
    $idGasto = $_POST['idGasto'];
    $estadoGasto = $_POST['estadoGasto'];
    $GastoOperador = new GastosOperaciones();
    $datos = array($estadoGasto, $idGasto);
    $GastoOperador->updateEstadoGasto($datos);
    $rep['msg'] = "OK";
    echo json_encode($rep);
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
    case 'nitCliente':
        nitCliente();
        break;
    case 'findCliente':
        findCliente();
        break;
    case 'findProveedorBytipoCompra':
        findProveedorBytipoCompra();
        break;
    case 'updateEstadoCompra':
        updateEstadoCompra();
        break;
    case 'findProveedorGasto':
        findProveedorGasto();
        break;
    case 'updateEstadoGasto':
        updateEstadoGasto();
        break;
    case 'eliminarSession':
        eliminarSession();
        break;
}