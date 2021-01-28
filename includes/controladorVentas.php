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

function findClientePedido()
{
    $q = $_POST['q'];
    $clienteOperador = new ClientesOperaciones();
    $clientes = $clienteOperador->getClientesByName($q);
    if (count($clientes) == 0) {
        echo '<input type="text" class="form-control col-12" value="No hay sugerencias" readOnly>';
    } else {
        echo '<select name="idCliente" id="idCliente" class="form-control col-12" onchange="findSucursal(this.value);" required>';
        echo '<option value="" selected disabled>Escoja un cliente</option>';
        for ($i = 0; $i < count($clientes); $i++) {
            echo '<option value=' . $clientes[$i]['idCliente'] . '>' . $clientes[$i]['nomCliente'] . '</option>';
        }
        echo '</select>';
    }
}

function findClienteCotizacion()
{
    $q = $_POST['q'];
    $clienteOperador = new ClientesCotizacionOperaciones();
    $clientes = $clienteOperador->getClientesByName($q);
    if (count($clientes) == 0) {
        echo '<input type="text" class="form-control col-12" value="No hay sugerencias" readOnly>';
    } else {
        echo '<select name="idCliente" id="idCliente" class="form-control col-12" required>';
        for ($i = 0; $i < count($clientes); $i++) {
            echo '<option value=' . $clientes[$i]['idCliente'] . '>' . $clientes[$i]['nomCliente'] . '</option>';
        }
        echo '</select>';
    }
}


function findSucursalesByCliente()
{
    $idCliente = $_POST['idCliente'];
    $sucursalOperador = new ClientesSucursalOperaciones();
    $sucursales = $sucursalOperador->getSucursalesCliente($idCliente);
    for ($i = 0; $i < count($sucursales); $i++) {
        echo '<option value=' . $sucursales[$i]['idSucursal'] . '>' . $sucursales[$i]['nomSucursal'] . '</option>';
    }
}

function cantDetNotaC()
{
    $facturaOrigen = $_POST['facturaOrigen'];
    $codProducto = $_POST['codProducto'];
    $notaCrOperador = new NotasCreditoOperaciones();
    $cantidad = $notaCrOperador->getCantDetProductosNotaC($facturaOrigen,$codProducto );
    for ($i = $cantidad; $i >0; $i--) {
        echo '<option value=' . $i . '>' . $i . '</option>';
    }
}

function findClienteNotaC()
{
    $q = $_POST['q'];
    $clienteOperador = new ClientesOperaciones();
    $clientes = $clienteOperador->getClientesByName($q);
    if (count($clientes) == 0) {
        echo '<input type="text" class="form-control col-12" value="No hay sugerencias" readOnly>';
    } else {
        echo '<select name="idCliente" id="idCliente" class="form-control col-12" onchange="findFacturasCliente(this.value);" required>';
        echo '<option value="" selected disabled>Escoja un cliente</option>';
        for ($i = 0; $i < count($clientes); $i++) {
            echo '<option value=' . $clientes[$i]['idCliente'] . '>' . $clientes[$i]['nomCliente'] . '</option>';
        }
        echo '</select>';
    }
}

function findFacturasByCliente()
{
    $idCliente = $_POST['idCliente'];
    $facturaOperador = new FacturasOperaciones();
    $facturas = $facturaOperador->getFacturasClienteForNotas($idCliente);
    for ($i = 0; $i < count($facturas); $i++) {
        echo '<option value=' . $facturas[$i]['idFactura'] . '>' . $facturas[$i]['idFactura'] . '</option>';
    }
}

function aplicarRetefuente()
{
    $tasaRetencion = $_POST['tasaRetencion'];
    $idFactura = $_POST['idFactura'];
    $facturaOperador = new FacturasOperaciones();
    $factura=$facturaOperador->getFactura($idFactura);
    $datos=array(round($factura['totalR'])-$factura['subtotal']*(1-$factura['descuento'])*$tasaRetencion , $factura['retencionIva'], $factura['retencionIca'], $factura['subtotal']*(1-$factura['descuento'])*$tasaRetencion, $factura['subtotal'], $factura['iva'], round($factura['totalR']), $idFactura);
    $facturaOperador->updateTotalesFactura($datos);
    $rep['msg'] = "OK";
    echo json_encode($rep);
}
function aplicarReteica()
{
    $tasaRetencion = $_POST['tasaRetencion'];
    $idFactura = $_POST['idFactura'];
    $facturaOperador = new FacturasOperaciones();
    $factura=$facturaOperador->getFactura($idFactura);
    $reteica=round($factura['subtotal']*(1-$factura['descuento'])*$tasaRetencion);
    $datos=array(round($factura['totalR'])-$reteica , $factura['retencionIva'], $reteica, $factura['retencionFte'], $factura['subtotal'], $factura['iva'], round($factura['totalR']), $idFactura);
    $facturaOperador->updateTotalesFactura($datos);
    $rep['msg'] = "OK";
    echo json_encode($rep);
}

function prodEmprCantTotalYear()
{
    $year = $_POST['year'];
    $type = $_POST['type'];
    $detFacturaOperador = new DetFacturaOperaciones();
    $totalCant= $detFacturaOperador->getTotalProductosEmpresaPorYear($year);
    if($type==1){
        $prodCant= $detFacturaOperador->getCantTotalProductosEmpresaPorYear($year);
        $rep['cant'] = array_column($prodCant, 'cant');
        $rep['cant'][] = $totalCant['cant'] - array_sum(array_column($prodCant, 'cant'));
        $rep['productos'] = array_column($prodCant, 'producto');
    }else{
        $prodCant= $detFacturaOperador->getValTotalProductosEmpresaPorYear($year);
        $rep['cant'] = array_column($prodCant, 'sub');
        $rep['cant'][] = $totalCant['sub'] - array_sum(array_column($prodCant, 'sub'));
        $rep['productos'] = array_column($prodCant, 'producto');
    }

    $rep['productos'][]= 'Otros productos';
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
    case 'findClientePedido':
        findClientePedido();
        break;
    case 'findClienteCotizacion':
        findClienteCotizacion();
        break;
    case 'findSucursalesByCliente':
        findSucursalesByCliente();
        break;
    case 'findClienteNotaC':
        findClienteNotaC();
        break;
    case 'cantDetNotaC':
        cantDetNotaC();
        break;
    case 'aplicarRetefuente':
        aplicarRetefuente();
        break;
    case 'aplicarReteica':
        aplicarReteica();
        break;
    case 'prodEmprCantTotalYear':
        prodEmprCantTotalYear();
        break;
    case 'eliminarSession':
        eliminarSession();
        break;
}