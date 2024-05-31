<?php
// Función para cargar las clases
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

function buscarClienteForm($action)
{

    $rep = '<form id="form1" name="form1" method="post" action="' . $action . '">
        <div class="form-group row">
            <label class="col-form-label col-2" for="busClien"><strong>Cliente</strong></label>
            <input type="text" class="form-control col-2" id="busClien" name="busClien" onkeyup="findCliente()"
                   required/>
        </div>
        <div class="form-group row" id="myDiv">
        
        </div>
        <div class="row form-group">
            <div class="col-1">
                <button class="button" type="button" onclick="return Enviar(this.form)">
                    <span>Continuar</span></button>
            </div>
        </div>
    </form>';
    return $rep;
}

function calcularTotalesFactura($idFactura, $tasaDescuento)
{
    $facturaOperador = new FacturasOperaciones();
    $totalesFactura = $facturaOperador->getTotalesFactura($idFactura);
    if ($totalesFactura){
        $subtotal = $totalesFactura['subtotalfactura'];
        $iva10 = $totalesFactura['iva10factura'];
        $iva16 = $totalesFactura['iva19factura'];
        $descuento = $subtotal * $tasaDescuento;
        $iva10Real = $iva10 * (1 - $tasaDescuento);
        $iva16Real = $iva16 * (1 - $tasaDescuento);
    }
    else{
        $subtotal = 0;
        $iva10 = 0;
        $iva16 = 0;
        $descuento = 0;
        $iva10Real = 0;
        $iva16Real = 0;
    }

    $detCliente = $facturaOperador->getDetClienteFactura($idFactura);
    $ciudadCliente = $detCliente['ciudadCliente'];
    $idCatCliente = $detCliente['idCatCliente'];
    $retIva = $detCliente['retIva'];
    $retIca = $detCliente['retIca'];
    $retFte = $detCliente['retFte'];
    $exenIva = $detCliente['exenIva'];
    if ($exenIva == 1) {
        $iva = 0;
    } else {
        $iva = $iva10Real + $iva16Real;
    }
    if ($retIva == 1) {
        $reteiva = round(($iva10Real + $iva16Real) * 0.15, 2);
    } else {
        $reteiva = 0;
    }
    if (($subtotal >= BASE_C) && ($retFte == 1)) {
        $retefuente = round(($subtotal - $descuento) * 0.025,2);
        if (($ciudadCliente == 1) && ($idCatCliente != 1)) {
            $reteica = round(($subtotal - $descuento) * 0.01104,2);
        } else {
            $reteica = 0;
        }
    } else {
        $retefuente = 0;
        $reteica = 0;
    }
    $rep =[
    'subtotal'=>$subtotal,
    'descuento'=>$descuento,
    'iva10Real'=>$iva10Real,
    'iva16Real'=>$iva16Real,
    'iva'=>$iva,
    'reteiva'=>$reteiva,
    'retefuente'=>$retefuente,
    'reteica'=>$reteica,
];
    return $rep;
}
