<?php
include "../../../includes/valAcc.php";
include "../../../includes/num_letra.php";
include "../../../includes/ventas.php";
require('../../../includes/fpdf.php');

$idFactura = $_POST['idFactura'];
$facturaOperador = new FacturasOperaciones();
$factura = $facturaOperador->getFactura($idFactura);
$totales = calcularTotalesFactura($idFactura, $factura['descuento']);
$detFacturaOperador = new DetFacturaOperaciones();
$detalle = $detFacturaOperador->getDetFactura($idFactura);
$estadoFactura = $factura['Estado'];
if ($estadoFactura == 'E') {
    $facturaOperador->updateEstadoFactura('P', $idFactura);
}

$pdf = new FPDF('P', 'mm', 'Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 10);//margin bottom
$pdf->SetXY(120, 15);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(75, 3.5, 'Factura No. ' . $idFactura, 0, 0, 'R');
//$pdf->Cell(75,3.5,'Habilita 5700 a 7000 Resol 320001140880 Fecha 13/05/2014',0, 0, R);
$pdf->SetXY(10, 30);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(25, 3.5, 'CLIENTE:', 0, 0, 'R');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(110, 3.5, (iconv('UTF-8', 'windows-1252', $factura['nomCliente'])));
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(35, 3.5, 'FECHA:', 0, 0, 'R');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(35, 3.5, $factura['fechaFactura'], 0, 1);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(25, 3.5, 'NIT:', 0, 0, 'R');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(110, 3.5, $factura['nitCliente']);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(35, 3.5, 'VENCIMIENTO:', 0, 0, 'R');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(35, 3.5, $factura['fechaVenc'], 0, 1);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(25, 3.5, iconv('UTF-8', 'windows-1252', 'DIRECCIÓN:'), 0, 0, 'R');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(110, 3.5, (iconv('UTF-8', 'windows-1252', $factura['dirCliente'])));
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(35, 3.5, 'FORMA DE PAGO:', 0, 0, 'R');
$pdf->SetFont('Arial', '', 9);
if ($factura['fechaFactura'] == $factura['fechaVenc'])
    $pago = "Contado";
else
    $pago = "Crédito";
$pdf->Cell(35, 3.5, iconv('UTF-8', 'windows-1252', $pago), 0, 1);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(25, 3.5, iconv('UTF-8', 'windows-1252', 'TELÉFONO:'), 0, 0, 'R');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(50, 3.5, $factura['telCliente']);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(35, 3.5, iconv('UTF-8', 'windows-1252', 'REMISIÓN(ES):'), 0, 0, 'R');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(95, 3.5, $factura['idRemision'], 0, 1);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(25, 3.5, 'CIUDAD:', 0, 0, 'R');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(50, 3.5, iconv('UTF-8', 'windows-1252', $factura['Ciudad']));
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(35, 3.5, 'PEDIDO(S):', 0, 0, 'R');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(95, 3.5, $factura['idPedido'], 0, 1);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(25, 3.5, 'CORREO:', 0, 0, 'R');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(110, 3.5, iconv('UTF-8', 'windows-1252', $factura['emailCliente']));
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(35, 3.5, 'ORDEN DE COMPRA:', 0, 0, 'R');
$pdf->SetFont('Arial', '', 9);
if ($factura['ordenCompra'] != 0)
    $orden = "";
else
    $orden = $factura['ordenCompra'];
$pdf->Cell(35, 3.5, $orden, 0, 1);
$pdf->SetXY(10, 51);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(25, 4, iconv('UTF-8', 'windows-1252', 'CÓDIGO'), 1, 0, 'C');
$pdf->Cell(100, 4, 'PRODUCTO ', 1, 0, 'C');
$pdf->Cell(10, 4, 'CAN ', 1, 0, 'C');
$pdf->Cell(10, 4, 'IVA ', 1, 0, 'C');
$pdf->Cell(22, 4, 'VR. UNIT ', 1, 0, 'C');
$pdf->Cell(25, 4, 'SUBTOTAL ', 1, 0, 'C');
$pdf->SetFont('Arial', '', 9);
$pdf->SetXY(10, 55);
for ($i = 0; $i < count($detalle); $i++) {
    $codprod = $detalle[$i]['codigo'];
    $prod = $detalle[$i]['producto'];
    $cant = $detalle[$i]['cantProducto'];
    $iva = $detalle[$i]['iva'];
    $precio = $detalle[$i]['precioProducto'];
    $tot = $detalle[$i]['subtotal'];
    $pdf->Cell(25, 4, $codprod, 0, 0, 'C');
    $pdf->Cell(100, 4, iconv('UTF-8', 'windows-1252', $prod), 0, 0, 'L');
    $pdf->Cell(10, 4, $cant, 0, 0, 'C');
    $pdf->Cell(10, 4, "$iva", 0, 0, 'R');
    $pdf->Cell(22, 4, $precio, 0, 0, 'R');
    $pdf->Cell(25, 4, $tot, 0, 0, 'R');
    $pdf->Ln(4);
}
$subtotal = $totales['subtotal'];
$descuento = $totales['descuento'];
$iva10Real = $totales['iva10Real'];
$iva16Real = $totales['iva16Real'];
$iva = $totales['iva'];
$reteiva = $factura['reteiva'];
$retefuente = $factura['retencionFte'];
$reteica = $factura['retencionIca'];


$Iva_05 = number_format($iva10Real, 2, '.', ',');
$Iva_16 = number_format($iva16Real, 2, '.', ',');
$Sub = number_format($subtotal, 2, '.', ',');
$Des = number_format($descuento, 2, '.', ',');

$Ret = number_format($retefuente, 0, '.', ',');
$Retica = number_format($reteica, 0, '.', ',');
$Retiva = number_format($reteiva, 0, '.', ',');
$Total = $subtotal - $descuento + $iva - $retefuente - $reteica;
$Tot = number_format($Total, 0, '.', ',');
$pdf->SetFont('Arial', '', 9);
$pdf->SetXY(10, -46);
$pdf->Cell(140, 16, '', 1); //Borde observaciones
$pdf->SetXY(10, -46);
$pdf->SetFont('Arial', '', 8);
if ($factura['fechaFactura'] < FECHA_C) {
    $pdf->Cell(32, 4, 'BASE GRAVABLE 16%: ');
    $base16 = ($iva16Real) / 0.16;
    $BaseI16 = number_format($iva16Real, 0, '.', ',');
    $pdf->Cell(16, 4, "$ $BaseI16", 0, 0, 'L');
} else {
    $pdf->Cell(32, 4, 'BASE GRAVABLE 19%: ');
    $base16 = ($iva16Real) / 0.19;
    $BaseI16 = number_format($base16, 0, '.', ',');
    $pdf->Cell(16, 4, "$ $BaseI16", 0, 0, 'R');
}
$pdf->Cell(27, 4, 'BASE GRAVABLE 5%: ');
$base5 = ($iva10Real) / 0.05;
$BaseI5 = number_format($base5, 0, '.', ',');
$pdf->Cell(16, 4, "$ $BaseI5", 0, 0, 'R');
$pdf->Cell(26, 4, 'BASE NO GRAVADA: ');
$base0 = round($subtotal - $descuento - $base16 - $base5);
$BaseI0 = 0;
if ($base0 > 0){
    $BaseI0 = number_format($base0, 0, '.', ',');
}
$pdf->Cell(16, 4, "$ $BaseI0", 0, 0, 'R');
$pdf->SetXY(10, -42);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(33, 4, 'OBSERVACIONES: ');
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(105, 4, iconv('UTF-8', 'windows-1252', $factura['observaciones']));
$pdf->SetXY(10, -30);
$pdf->Cell(140, 12, '', 1); //Borde cantidad en letras
$pdf->SetXY(10, -30);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30, 4, 'SON:');
$pdf->SetFont('Arial', '', 9);
$pdf->SetXY(155, -46);
$pdf->Cell(50, 28, '', 1);//Margen total
$pdf->SetXY(155, -46);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(25, 4, 'SUBTOTAL', 0, 0, 'R');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(25, 4, "$ $Sub", 0, 0, 'R');
$pdf->SetXY(155, -42);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(25, 4, 'DESCUENTO', 0, 0, 'R');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(25, 4, "$ $Des", 0, 0, 'R');
$pdf->SetXY(155, -38);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(25, 4, 'RETEFUENTE', 0, 0, 'R');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(25, 4, "$ $Ret", 0, 0, 'R');
$pdf->SetXY(155, -34);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(25, 4, 'RETEICA', 0, 0, 'R');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(25, 4, "$ $Retica", 0, 0, 'R');
$pdf->SetXY(155, -30);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(25, 4, 'IVA 5%', 0, 0, 'R');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(25, 4, "$ $Iva_05", 0, 0, 'R');
$pdf->SetXY(155, -26);
$pdf->SetFont('Arial', 'B', 9);
if ($factura['fechaFactura'] < FECHA_C)
    $pdf->Cell(25, 4, 'IVA 16%', 0, 0, 'R');
else
    $pdf->Cell(25, 4, 'IVA 19%', 0, 0, 'R');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(25, 4, "$ $Iva_16", 0, 0, 'R');
$pdf->SetXY(155, -22);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(25, 4, 'TOTAL', 0, 0, 'R');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(25, 4, "$ $Tot", 0, 0, 'R');
$num_letra = numletra(round($Total));
$pdf->SetXY(20, -30);
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(130, 4, $num_letra, 0, 'L');
$pdf->Output();
?>
