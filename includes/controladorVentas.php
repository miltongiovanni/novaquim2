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
    $clienteOperador = new ClientesOperaciones();
    $cliente = $clienteOperador->checkNit($NIT_F);
    if($cliente){
        $_SESSION['idCliente'] = $cliente['idCliente'];
        $return = [
            'clienteExiste' => true,
        ];
    }else{
        $return = [
            'clienteExiste' => false,
            'nit' => $NIT_F,
        ];
    }
    echo json_encode($return);
}


function findCliente()
{
    $q = $_POST['q'];
    $clienteOperador = new ClientesOperaciones();
    $clientes = $clienteOperador->getClientesByName($q);
    if (count($clientes) == 0) {
        echo '<div class="col-4"><input type="text" class="form-control" value="No hay sugerencias" readOnly></div>';
    } else {
        echo '<br>';
        echo '<div class="col-4"><select name="idCliente" id="idCliente" class="form-select">';
        for ($i = 0; $i < count($clientes); $i++) {
            echo '<option value=' . $clientes[$i]['idCliente'] . '>' . $clientes[$i]['nomCliente'] . '</option>';
        }
        echo '</select></div>';
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
        echo '<div class="col-12 mb-3"><select name="idCliente" id="idCliente" class="form-select" onchange="findSucursal(this.value);" required>';
        echo '<option value="" selected disabled>Escoja un cliente</option>';
        for ($i = 0; $i < count($clientes); $i++) {
            echo '<option value=' . $clientes[$i]['idCliente'] . '>' . $clientes[$i]['nomCliente'] . '</option>';
        }
        echo '</select></div>';
    }
}

function findClienteParaFacturar()
{
    $q = $_POST['q'];
    $clienteOperador = new ClientesOperaciones();
    $clientes = $clienteOperador->getClientesByName($q);
    if (count($clientes) == 0) {
        echo '<input type="text" class="form-control col-12" value="No hay sugerencias" readOnly>';
    } else {
        echo '<select name="idCliente" id="idCliente" class="form-select col-12" onchange="findPedidosPorFacturar(this.value);" required>';
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
        echo '<select name="idCliente" id="idCliente" class="form-select col-12" required>';
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

function findPedidosPorFacturar()
{
    $idCliente = $_POST['idCliente'];
    $pedidosOperador = new PedidosOperaciones();
    $pedidos = $pedidosOperador->getPedidosPorFacturarCliente($idCliente);
    foreach ($pedidos as  $pedido){

        echo '<option value=' . $pedido['idPedido'] . '>'. $pedido['idPedido'] .' - ' . $pedido['nomSucursal'] . '</option>';
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
        echo '<select name="idCliente" id="idCliente" class="form-select col-12" onchange="findFacturasCliente(this.value);" required>';
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

function findFacturasPorPagarByNotaC()
{
    $idNotaC = $_POST['idNotaC'];
    $notaCreditoOperador = new NotasCreditoOperaciones();
    $notaC= $notaCreditoOperador->getNotaC($idNotaC);
    $facturaOperador = new FacturasOperaciones();
    $facturas = $facturaOperador->getFacturasClienteForNotas($notaC['idCliente']);
    for ($i = 0; $i < count($facturas); $i++) {
        echo '<option value=' . $facturas[$i]['idFactura'] . '>' . $facturas[$i]['idFactura'] .' - ' . $facturas[$i]['totalFactura'] . '</option>';
    }
}

function aplicarRetefuente()
{
    $tasaRetencion = $_POST['tasaRetencion'];
    $idFactura = intval($_POST['idFactura']);
    $facturaOperador = new FacturasOperaciones();
    $factura=$facturaOperador->getFactura($idFactura);
    $subtotal = $factura['subtotal'];
    $descuento = $factura['descuento'];
    $iva = $factura['iva'];
    $reteiva = $factura['retIva'] == 1 ?  $factura['iva']*0.15 : 0;
    $retefuente = $factura['retFte'] == 1 ? $factura['subtotal']*(1-$factura['descuento'])*$tasaRetencion : 0;
    $reteica = $factura['retencionIca'];
    $total = round($subtotal - $factura['descuento'] + $iva)-$factura['subtotal']*(1-$factura['descuento'])*$tasaRetencion;
    $totalR = round($subtotal - $factura['descuento'] + $iva);
    $datos = array($total, $reteiva, $reteica, $retefuente, $subtotal, $iva, $totalR, $idFactura);
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
    $reteiva = $factura['retIva'] == 1 ?  $factura['iva']*0.15 : 0;
    $reteica=round($factura['subtotal']*(1-$factura['descuento'])*$tasaRetencion);
    $datos=array(round($factura['totalR'])-$reteica , $reteiva, $reteica, $factura['retencionFte'], $factura['subtotal'], $factura['iva'], round($factura['totalR']), $idFactura);
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

function prodEmprCantTotalYearVend()
{
    $year = $_POST['year'];
    $type = $_POST['type'];
    $codVendedor = $_POST['codVendedor'];
    $detFacturaOperador = new DetFacturaOperaciones();
    $totalCant= $detFacturaOperador->getTotalProductosEmpresaPorYearVend($year, $codVendedor);
    if($type==1){
        $prodCant= $detFacturaOperador->getCantTotalProductosEmpresaPorYearVend($year, $codVendedor);
        $rep['cant'] = array_column($prodCant, 'cant');
        $rep['cant'][] = $totalCant['cant'] - array_sum(array_column($prodCant, 'cant'));
        $rep['productos'] = array_column($prodCant, 'producto');
    }else{
        $prodCant= $detFacturaOperador->getValTotalProductosEmpresaPorYearVend($year, $codVendedor);
        $rep['cant'] = array_column($prodCant, 'sub');
        $rep['cant'][] = $totalCant['sub'] - array_sum(array_column($prodCant, 'sub'));
        $rep['productos'] = array_column($prodCant, 'producto');
    }
    $rep['productos'][]= 'Otros productos';
    echo json_encode($rep);
}


function prodDistCantTotalYear()
{
    $year = $_POST['year'];
    $type = $_POST['type'];
    $detFacturaOperador = new DetFacturaOperaciones();
    $totalCant= $detFacturaOperador->getTotalProductosDistribucionPorYear($year);
    $rep['productos'] = array_column($totalCant, 'catDis');
    if($type==1){
        $rep['cant'] = array_column($totalCant, 'cant');
    }else{
        $rep['cant'] = array_column($totalCant, 'sub');
    }
    echo json_encode($rep);
}

function prodDistCantTotalYearVend()
{
    $year = $_POST['year'];
    $type = $_POST['type'];
    $codVendedor = $_POST['codVendedor'];
    $detFacturaOperador = new DetFacturaOperaciones();
    $totalCant= $detFacturaOperador->getTotalProductosDistribucionPorYearVend($year, $codVendedor);
    $rep['productos'] = array_column($totalCant, 'catDis');
    if($type==1){
        $rep['cant'] = array_column($totalCant, 'cant');
    }else{
        $rep['cant'] = array_column($totalCant, 'sub');
    }
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

function crearCliente()
{
    foreach ($_POST as $nombre_campo => $valor) {
        ${$nombre_campo} = $valor;
        if (is_array($valor)) {
            //echo $nombre_campo.print_r($valor).'<br>';
        } else {
            //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
        }
    }
    $lastIdCliente = null;
    $estadoCliente = 1;
    $fchCreacionCliente = date("Y-m-d");
    $datos = array($nitCliente, $nomCliente, $contactoCliente, $cargoCliente, $telCliente, $celCliente, $dirCliente, $emailCliente, $estadoCliente, $idCatCliente, $ciudadCliente, $retIva, $retIca, $retFte, $codVendedor, $fchCreacionCliente, 0);
    $clienteOperador = new ClientesOperaciones();
    try {
        $nitExist = $clienteOperador->checkNit($nitCliente);
        if (isset($nitExist['idCliente']) && $nitExist['idCliente'] != null) {
            $mensaje = "Cliente con ese NIT ya existe";
            $icon = "warning";
            $response = [ 'success' => false,  'lastIdCliente' => $lastIdCliente, 'mensaje' => $mensaje, 'icon' => $icon];
        } else {
            $lastIdCliente = $clienteOperador->makeCliente($datos);
            $datosSucursal = array($lastIdCliente, 1, $dirCliente, $ciudadCliente, $telCliente, $nomCliente);
            $clienteSucursalOperador = new ClientesSucursalOperaciones();
            $lastIdSucursal = $clienteSucursalOperador->makeClienteSucursal($datosSucursal);
            $mensaje = "Cliente creado con éxito";
            $icon = "success";
            $response = [ 'success' => true,   'lastIdCliente' => $lastIdCliente,   'lastIdSucursal' => $lastIdSucursal,  'mensaje' => $mensaje, 'icon' => $icon];
        }
    } catch (Exception $e) {
        $mensaje = "Error al crear el Cliente";
        $icon = "error";
        $response = [ 'success' => false,   'lastIdCliente' => $lastIdCliente,  'mensaje' => $mensaje, 'icon' => $icon];
    } finally {
        unset($conexion);
        unset($stmt);
    }
    echo json_encode($response);
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
    case 'findClienteParaFacturar':
        findClienteParaFacturar();
        break;
    case 'findPedidosPorFacturar':
        findPedidosPorFacturar();
        break;
    case 'findFacturasByCliente':
        findFacturasByCliente();
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
    case 'findFacturasPorPagarByNotaC':
        findFacturasPorPagarByNotaC();
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
    case 'prodEmprCantTotalYearVend':
        prodEmprCantTotalYearVend();
        break;
    case 'prodDistCantTotalYear':
        prodDistCantTotalYear();
        break;
    case 'prodDistCantTotalYearVend':
        prodDistCantTotalYearVend();
        break;
    case 'eliminarSession':
        eliminarSession();
        break;
    case 'crearCliente':
        crearCliente();
        break;
}