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
        echo '<select name="idFormula" id="idFormula" class="form-control col-12" required>';
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
        echo '<select name="idProv" id="idProv" class="form-control col-4" required>';
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

function selectionarTipoKit()
{
    $tipo = $_POST['tipo'];
    $rep='';
    if($tipo==1){
        $PresentacionOperador = new PresentacionesOperaciones();
        $kitsXCrear = $PresentacionOperador->getKitsXCrear();
        $rep .='<label class="col-form-label col-2" for="codigo"><strong>Kit Novaquim</strong></label>';
        $rep .= '<select name="codigo" id="codigo" class="form-control col-2" required>';
        for ($i = 0; $i < count($kitsXCrear); $i++) {
            $rep .= '<option value=' . $kitsXCrear[$i]['codPresentacion'] . '>' . $kitsXCrear[$i]['presentacion'] . '</option>';
        }
        $rep .= '</select>';
    }
    else {
        $DistribucionOperador = new ProductosDistribucionOperaciones();
        $productos = $DistribucionOperador->getProductosDistribucion(true);
        $rep .='<label class="col-form-label col-2" for="codigo"><strong>Kit Distribución</strong></label>';
        $rep .= '<select name="codigo" id="codigo" class="form-control col-2" required>';
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
    case 'selectionarTipoKit':
        selectionarTipoKit();
        break;
    case 'eliminarSession':
        eliminarSession();
        break;
    case 'updateEstadoOProd':
        updateEstadoOProd();
        break;
}