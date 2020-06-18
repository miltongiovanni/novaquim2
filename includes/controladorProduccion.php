<?php
// Función para cargar las clases
include "valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');


function findFormulaByProd()
{
    $codProducto = $_POST['codProducto'];
    $FormulaOperador = new FormulasOperaciones();
    $formulas = $FormulaOperador->getFormulaByProd($codProducto);
    if (count($formulas) == 0) {
        echo '<input type="text" class="form-control col-2" value="No hay sugerencias" readOnly>';
    } else {
        echo '<select name="idFormula" id="idFormula" class="form-control col-12">';
        for ($i = 0; $i < count($formulas); $i++) {
            echo '<option value=' . $formulas[$i]['idFormula'] . '>' . $formulas[$i]['nomFormula'] . '</option>';
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

function findInvLotePresentacion()
{
    $codPresentacion = $_POST['codPresentacion'];
    $loteProd = $_POST['loteProd'];
    $InvProdTerminadoOperador = new InvProdTerminadosOperaciones();
    $inv = $InvProdTerminadoOperador->getInvByLoteAndProd($codPresentacion, $loteProd);
    echo json_encode($inv);
}

function findLotePresentacion()
{
    $codPresentacion = $_POST['codPresentacion'];
    $InvProdTerminadoOperador = new InvProdTerminadosOperaciones();
    $lotes = $InvProdTerminadoOperador->getLotesByProd($codPresentacion);
    echo json_encode($lotes);
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

function updateEstadoOProd()
{
    $lote = $_POST['lote'];
    $estado = $_POST['estado'];
    $OProdOperador = new OProdOperaciones();
    $datos = array($estado, $lote);
    $OProdOperador->updateEstadoOProd($datos);
    $rep['msg'] = "OK";
    echo json_encode($rep);
}

function eliminarSession()
{
    $variables = explode(',', $_POST['variables']);
    for($i=0;$i<count($variables); $i++){
        unset($_SESSION[$variables[$i]]);
    }

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
    case 'findFormulaByProd':
        findFormulaByProd();
        break;
    case 'findProveedorBytipoCompra':
        findProveedorBytipoCompra();
        break;
    case 'findLotePresentacion':
        findLotePresentacion();
        break;
    case 'findInvLotePresentacion':
        findInvLotePresentacion();
        break;
    case 'updateEstadoGasto':
        updateEstadoGasto();
        break;
    case 'eliminarSession':
        eliminarSession();
        break;
    case 'updateEstadoOProd':
        updateEstadoOProd();
        break;
}