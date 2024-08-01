<?php
// Función para cargar las clases
include "valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');


/*function findFormulaByProd()
{
    $codProducto = $_POST['codProducto'];
    $FormulaOperador = new FormulasOperaciones();
    $formulas = $FormulaOperador->getFormulaByProd($codProducto);
    if (count($formulas) == 0) {
        echo '<input type="text" class="form-control col-2" value="No hay sugerencias" readOnly>';
    } else {
        echo '<select name="idFormula" id="idFormula" class="form-select col-12">';
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
*/
function findInvMPrimaXLote()
{
    $codMPrima = $_POST['codMPrima'];
    $loteMP = $_POST['loteMP'];
    $InvMPrimaOperador = new InvMPrimasOperaciones();
    $inv = $InvMPrimaOperador->getInvMPrimaByLote($codMPrima, $loteMP);
    echo json_encode($inv);
}

function findInvProdTerminadoXLote()
{
    $codPresentacion = $_POST['codPresentacion'];
    $loteProd = $_POST['loteProd'];
    $InvProdTerminadoOperador = new InvProdTerminadosOperaciones();
    $inv = $InvProdTerminadoOperador->getInvProdTerminadoByLote($codPresentacion, $loteProd);
    echo json_encode($inv);
}

function findInvProdDistribucion()
{
    $codDistribucion = $_POST['codDistribucion'];
    $invProdDistribucionOperador = new InvDistribucionOperaciones();
    $inv = $invProdDistribucionOperador->getInvDistribucion($codDistribucion);
    echo json_encode($inv);
}

function findInvEnvase()
{
    $codEnvase = $_POST['codEnvase'];
    $invEnvaseOperador = new InvEnvasesOperaciones();
    $inv = $invEnvaseOperador->getInvEnvase($codEnvase);
    echo json_encode($inv);
}

function findInvTapa()
{
    $codTapa = $_POST['codTapa'];
    $invTapaOperador = new InvTapasOperaciones();
    $inv = $invTapaOperador->getInvTapas($codTapa);
    echo json_encode($inv);
}

function findInvEtiqueta()
{
    $codEtiqueta = $_POST['codEtiqueta'];
    $invEtiquetaOperador = new InvEtiquetasOperaciones();
    $inv = $invEtiquetaOperador->getInvEtiqueta($codEtiqueta);
    echo json_encode($inv);
}

function findLotesMPrima()
{
    $codMPrima = $_POST['codMPrima'];
    $InvMPrimaOperador = new InvMPrimasOperaciones();
    $lotes = $InvMPrimaOperador->getLotesMPrima($codMPrima);
    echo json_encode($lotes);
}

function findAllLotesMPrima()
{
    $codMPrima = $_POST['codMPrima'];
    $InvMPrimaOperador = new InvMPrimasOperaciones();
    $lotes = $InvMPrimaOperador->getAllLotesMPrima($codMPrima);
    echo json_encode($lotes);
}

function findLotesPresentacion()
{
    $codPresentacion = $_POST['codPresentacion'];
    $InvProdOperador = new InvProdTerminadosOperaciones();
    $inv = $InvProdOperador->getLotesPresentacion($codPresentacion);
    echo json_encode($inv);
}

function findAllLotesPresentacion()
{
    $codPresentacion = $_POST['codPresentacion'];
    $InvProdOperador = new InvProdTerminadosOperaciones();
    $inv = $InvProdOperador->getAllLotesPresentacion($codPresentacion);
    echo json_encode($inv);
}

/*function selectionarTipoKit()
{
    $tipo = $_POST['tipo'];
    $rep='';
    if($tipo==1){
        $PresentacionOperador = new PresentacionesOperaciones();
        $kitsXCrear = $PresentacionOperador->getKitsXCrear();
        $rep .='<label class="form-label col-2" for="codigo"><strong>Kit Novaquim</strong></label>';
        $rep .= '<select name="codigo" id="codigo" class="form-control col-2">';
        for ($i = 0; $i < count($kitsXCrear); $i++) {
            $rep .= '<option value=' . $kitsXCrear[$i]['codPresentacion'] . '>' . $kitsXCrear[$i]['presentacion'] . '</option>';
        }
        $rep .= '</select>';
    }
    else {
        $DistribucionOperador = new ProductosDistribucionOperaciones();
        $productos = $DistribucionOperador->getProductosDistribucion(true);
        $rep .='<label class="form-label col-2" for="codigo"><strong>Kit Distribución</strong></label>';
        $rep .= '<select name="codigo" id="codigo" class="form-control col-2">';
        for ($i = 0; $i < count($productos); $i++) {
            $rep .= '<option value=' . $productos[$i]['idDistribucion'] . '>' . $productos[$i]['producto'] . '</option>';
        }
        $rep .= '</select>';
    }
    echo $rep;
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
}*/

function eliminarSession()
{
    $variables = explode(',', $_POST['variables']);
    for ($i = 0; $i < count($variables); $i++) {
        unset($_SESSION[$variables[$i]]);
    }

    echo 'OK';
}

/*function ultimaTapa()
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
}*/


//controleur membres
$action = $_POST['action'];
switch ($action) {
    /*    case 'findFormulaByProd':
            findFormulaByProd();
            break;
        case 'findProveedorBytipoCompra':
            findProveedorBytipoCompra();
            break;*/
    case 'findLotesMPrima':
        findLotesMPrima();
        break;
    case 'findAllLotesMPrima':
        findAllLotesMPrima();
        break;
    case 'findLotesPresentacion':
        findLotesPresentacion();
        break;
    case 'findInvMPrimaXLote':
        findInvMPrimaXLote();
        break;
    case 'findInvProdTerminadoXLote':
        findInvProdTerminadoXLote();
        break;
    case 'findInvProdDistribucion':
        findInvProdDistribucion();
        break;
    case 'findInvEnvase':
        findInvEnvase();
        break;
    case 'findInvTapa':
        findInvTapa();
        break;
    case 'findInvEtiqueta':
        findInvEtiqueta();
        break;
    case 'findAllLotesPresentacion':
        findAllLotesPresentacion();
        break;
    case 'eliminarSession':
        eliminarSession();
        break;
    /* case 'updateEstadoOProd':
         updateEstadoOProd();
         break;*/
}