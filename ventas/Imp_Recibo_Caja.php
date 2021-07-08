<?php
session_start();
include "../includes/num_letra.php";
require('../includes/fpdf.php');

$idRecCaja = $_POST['idRecCaja'];
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$recCajaOperador = new RecCajaOperaciones();
$recibo = $recCajaOperador->getRecCaja($idRecCaja);
$pdf = new FPDF('P', 'mm', 'Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(10, 10, 10);
$pdf->Image('../images/LogoNova1.jpg', 20, 14, 44, 22);

$pdf->SetFont('Arial', 'B', 12);
$pdf->SetXY(70, 20);
$pdf->Cell(75, 4, 'INDUSTRIAS NOVAQUIM S.A.S.', 0, 0, 'C');
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetXY(155, 20);
$pdf->Cell(47, 4, 'RECIBO DE CAJA', 0, 0, 'C');
$pdf->SetXY(70, 24);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(75, 4, 'NIT 900.419.629-7', 0, 0, 'C');
$pdf->SetXY(70, 28);
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(75, 3, 'Calle 35 C Sur No. 26 F - 40' . "\n" . 'Tels:2039484 - 2022912' . "\n" . 'www.novaquim.com  info@novaquim.com', 0, 'C');
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetXY(155, 24);
$pdf->Cell(47, 5, $idRecCaja, 0, 0, 'C');
$pdf->SetXY(155, 30);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(47, 4, 'FECHA RECIBO', 0, 0, 'C');
$pdf->SetXY(155, 34);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(47, 4, $recibo['fechaRecCaja'], 0, 0, 'C');

$pdf->SetXY(20, 40);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(140, 5, utf8_decode('Recibí de:'), 'LTR', 0, 'L');
$pdf->SetXY(20, 45);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(140, 5, utf8_decode($recibo['nomCliente']), 'LBR', 0, 'L');
$pdf->SetXY(160, 40);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40, 5, 'N.I.T. / C.C.', 'TR', 0, 'L');
$pdf->SetXY(160, 45);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(40, 5, $recibo['nitCliente'], 'BR', 0, 'L');
$pdf->SetXY(20, 50);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(160, 5, 'La Suma de :', 'LTR', 0, 'L');
$pdf->Cell(20, 5, 'Valor :', 'LTR', 0, 'L');
$pdf->SetXY(20, 55);
$pdf->SetFont('Arial', '', 8);
$cobro = $recibo['cobro'];
$num_letra = numletra(round($cobro));
$pdf->Cell(160, 5, $num_letra, 'LBR', 0, 'L');
$Cob = number_format($cobro, 0, '.', ',');
$pdf->Cell(20, 5, '$ ' . $Cob, 'LBR', 0, 'L');
$pdf->SetXY(20, 60);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(45, 5, 'Por concepto de :', 'LTR', 0, 'L');
$pdf->Cell(25, 5, 'Total Factura :', 'LTR', 0, 'L');
$pdf->Cell(20, 5, 'Subtotal :', 'LTR', 0, 'L');
$pdf->Cell(20, 5, 'I.V.A. :', 'LTR', 0, 'L');
$pdf->Cell(20, 5, 'Retefuente :', 'LTR', 0, 'L');
$pdf->Cell(15, 5, 'Reteiva :', 'LTR', 0, 'L');
$pdf->Cell(15, 5, 'Reteica :', 'LTR', 0, 'L');
$pdf->Cell(20, 5, 'Descuento :', 'LTR', 0, 'L');
$Reten_iva = $recibo['retencionIva'];
$Riva = number_format($Reten_iva, 0, '.', ',');
$Reten_ica = $recibo['retencionIca'];
$Rica = number_format($Reten_ica, 0, '.', ',');
$Reten_fte = $recibo['retencionFte'];
$Rfte = number_format($Reten_fte, 0, '.', ',');
$Total = $recibo['totalR'];
$Tot = number_format($Total, 0, '.', ',');
$Subtotal = $recibo['subtotal'];
$SubTot = number_format($Subtotal, 0, '.', ',');
$IVA = $recibo['iva'];
$IVAP = number_format($IVA, 0, '.', ',');
$Factura = $recibo['idFactura'];
$descuento_f = $recibo['descuento_f'];
$DESC = number_format($descuento_f, 0, '.', ',');


if (($Total - $Reten_fte - $Reten_ica - $Reten_iva) < $cobro)
    $concepto = "Abono a Factura ";
else
    $concepto = utf8_decode("Cancelación de Factura ");
$concepto .= $Factura;
$pdf->SetXY(20, 65);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(45, 5, $concepto, 'LBR', 0, 'L');
$pdf->Cell(25, 5, '$ ' . $Tot, 'LBR', 0, 'L');
$pdf->Cell(20, 5, '$ ' . $SubTot, 'LBR', 0, 'L');
$pdf->Cell(20, 5, '$ ' . $IVAP, 'LBR', 0, 'L');
$pdf->Cell(20, 5, '$ ' . $Rfte, 'LBR', 0, 'L');
$pdf->Cell(15, 5, '$ ' . $Riva, 'LBR', 0, 'L');
$pdf->Cell(15, 5, '$ ' . $Rica, 'LBR', 0, 'L');
$pdf->Cell(20, 5, '$ ' . $DESC, 'LBR', 0, 'L');
$pdf->SetXY(20, 70);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(100, 5, 'FORMA DE PAGO', 'LTR', 0, 'C');
$pdf->SetXY(20, 75);
$pdf->Cell(100, 5, '', 'LBR', 0, 'C');
$pdf->SetXY(20, 75);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(20, 5, 'Cheque No. ', 1, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$NCheque = $recibo['idCheque'];
if ($NCheque > 0)
    $pdf->Cell(20, 5, $NCheque, 1, 0, 'L');
else
    $pdf->Cell(20, 5, '', 1, 0, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(15, 5, 'Banco: ', 1, 0, 'L');
$Cod_banco = $recibo['codBanco'];
$Banco = $recibo['banco'];
$pdf->SetFont('Arial', '', 9);
if ($Cod_banco > 0)
    $pdf->Cell(45, 5, utf8_decode($Banco), 1, 0, 'L');
else
    $pdf->Cell(45, 5, '', 1, 0, 'L');
$pdf->SetXY(20, 80);
$form_pago = $recibo['form_pago'];
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(14, 5, 'Efectivo', 'LBT', 0, 'L');
if ($form_pago == 0)
    $pdf->Cell(5, 5, 'X', 'BTR', 0, 'C');
else
    $pdf->Cell(5, 5, '', 'BTR', 0, 'C');
$pdf->Cell(23, 5, 'Transferencia', 'LBT', 0, 'L');
if ($form_pago == 1)
    $pdf->Cell(5, 5, 'X', 'BTR', 0, 'C');
else
    $pdf->Cell(5, 5, '', 'BTR', 0, 'C');
$pdf->Cell(20, 5, utf8_decode('Nota Crédito'), 'LBT', 0, 'L');
if ($form_pago == 2)
    $pdf->Cell(5, 5, 'X', 'BTR', 0, 'C');
else
    $pdf->Cell(5, 5, '', 'BTR', 0, 'C');
$pdf->Cell(23, 5, utf8_decode('Consignación'), 'LBT', 0, 'L');
if ($form_pago == 3)
    $pdf->Cell(5, 5, 'X', 'BTR', 0, 'C');
else
    $pdf->Cell(5, 5, '', 'BTR', 0, 'C');
$pdf->SetXY(120, 70);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(80, 5, 'Firma y Sello de Beneficiario', 'R', 0, 'C');
$pdf->SetXY(120, 75);
$pdf->Cell(80, 45, '', 'LBR', 0, 'C');
$pdf->SetXY(20, 85);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(80, 5, 'OBSERVACIONES:', 0, 0, 'L');
$pdf->SetXY(20, 85);
$pdf->Cell(100, 35, '', 1, 0, 'L');

$pdf->SetXY(120, 110);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(80, 5, '_________________________________', 0, 0, 'C');
$pdf->SetXY(120, 115);
$pdf->Cell(80, 5, 'C.C. / N.I.T. _______________________', 0, 0, 'C');
$pdf->Image('../images/Cliente.jpg', 201, 70, 3);


// ESTA ES LA PARTE DE ABAJO
/*$pdf->Image('images/LogoNova1.jpg',20,144, 50, 25);
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(70,150);
$pdf->Cell(75,4,'INDUSTRIAS NOVAQUIM S.A.S.',0,0, 'C');
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(155,150);
$pdf->Cell(47,4,'RECIBO DE CAJA',0,0, 'C');
$pdf->SetXY(70,154);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(75,4,'NIT 900.419.629-7',0 , 0, 'C');
$pdf->SetXY(70,158);
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(75,3,'Calle 35 C Sur No. 26 F - 40'."\n".'Tels:2039484 - 2022912'."\n".'www.novaquim.com  info@novaquim.com',0 , 'C');
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(155,154);
$pdf->Cell(47,5,$Recibo,0,0, 'C');

$pdf->SetXY(155,160);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(47,4,'FECHA RECIBO',0,0, 'C');
$pdf->SetXY(155,164);
$pdf->SetFont('Arial','',10);
$pdf->Cell(47,4,$recibo['Fecha'],0,0, 'C');





$pdf->SetXY(20,170);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(140,5,'Recibí de:','LTR', 0, 'L');
$pdf->SetXY(20,175);
$pdf->SetFont('Arial','',9);
$pdf->Cell(140,5,$recibo['Nom_clien'],'LBR',0,'L');
$pdf->SetXY(160,170);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(40,5,'N.I.T. / C.C.','TR', 0, 'L');
$pdf->SetXY(160,175);
$pdf->SetFont('Arial','',9);
$pdf->Cell(40,5,$recibo['Nit_cliente'],'BR',0,'L');
$pdf->SetXY(20,180);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(160,5,'La Suma de :','LTR',0, 'L');
$pdf->Cell(20,5,'Valor :','LTR',0, 'L');
$pdf->SetXY(20,185);
$pdf->SetFont('Arial','',8);
$pdf->Cell(160,5,$num_letra,'LBR', 0, 'L');
$pdf->Cell(20,5,'$ '.$Cob,'LBR', 0, 'L');
$pdf->SetXY(20,190);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(45,5,'Por concepto de :','LTR',0, 'L');
$pdf->Cell(25,5,'Total Factura :','LTR',0, 'L');
$pdf->Cell(20,5,'Subtotal :','LTR',0, 'L');
$pdf->Cell(20,5,'I.V.A. :','LTR',0, 'L');
$pdf->Cell(20,5,'Retefuente :','LTR',0, 'L');
$pdf->Cell(15,5,'Reteiva :','LTR',0, 'L');
$pdf->Cell(15,5,'Reteica :','LTR',0, 'L');
$pdf->Cell(20,5,'Descuento :','LTR',0, 'L');
if (($Total-$Reten_fte-$Reten_ica-$Reten_iva)< $cobro)
$concepto="Abono a Factura ";
else
$concepto="Cancelación de Factura ";
$concepto.= $Factura;
$pdf->SetXY(20,195);
$pdf->SetFont('Arial','',9);
$pdf->Cell(45,5,$concepto,'LBR', 0, 'L');
$pdf->Cell(25,5,'$ '.$Tot,'LBR', 0, 'L');
$pdf->Cell(20,5,'$ '.$SubTot,'LBR', 0, 'L');
$pdf->Cell(20,5,'$ '.$IVAP,'LBR', 0, 'L');
$pdf->Cell(20,5,'$ '.$Rfte,'LBR', 0, 'L');
$pdf->Cell(15,5,'$ '.$Riva,'LBR', 0, 'L');
$pdf->Cell(15,5,'$ '.$Rica,'LBR', 0, 'L');
$pdf->Cell(20,5,'$ '.$DESC,'LBR', 0, 'L');
$pdf->SetXY(20,200);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(100,5,'FORMA DE PAGO','LTR',0, 'C');
$pdf->SetXY(20,205);
$pdf->Cell(100,5,'','LBR',0, 'C');
$pdf->SetXY(20,205);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20,5,'Cheque No. ', 1,0, 'L');
$pdf->SetFont('Arial','',9);
if ($NCheque>0)
$pdf->Cell(20,5,$NCheque, 1,0, 'L');
else
$pdf->Cell(20,5,'', 1,0, 'L');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(15,5,'Banco: ', 1,0, 'L');
$pdf->SetFont('Arial','',9);
if ($Cod_banco>0)
$pdf->Cell(45,5,$Banco, 1,0, 'L');
else
$pdf->Cell(45,5,'', 1,0, 'L');
$pdf->SetXY(20,210);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(14,5,'Efectivo', 'LBT',0, 'L');
if ($form_pago==0)
$pdf->Cell(5,5,'X', 'BTR',0, 'C');
else
$pdf->Cell(5,5,'', 'BTR',0, 'C');
$pdf->Cell(23,5,'Transferencia', 'LBT',0, 'L');
if ($form_pago==1)
$pdf->Cell(5,5,'X', 'BTR',0, 'C');
else
$pdf->Cell(5,5,'', 'BTR',0, 'C');
$pdf->Cell(20,5,'Nota Crédito', 'LBT',0, 'L');
if ($form_pago==2)
$pdf->Cell(5,5,'X', 'BTR',0, 'C');
else
$pdf->Cell(5,5,'', 'BTR',0, 'C');
$pdf->Cell(23,5,'Consignación', 'LBT',0, 'L');
if ($form_pago==3)
$pdf->Cell(5,5,'X', 'BTR',0, 'C');
else
$pdf->Cell(5,5,'', 'BTR',0, 'C');
$pdf->SetXY(120,200);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(80,5,'Firma y Sello de Beneficiario','R',0, 'C');
$pdf->SetXY(120,205);
$pdf->Cell(80,45,'','LBR',0, 'C');
$pdf->SetXY(20,215);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(80,5,'OBSERVACIONES:',0,0, 'L');
$pdf->SetXY(20,215);
$pdf->Cell(100,35,'',1,0, 'L');

$pdf->SetXY(120,240);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(80,5,'_________________________________',0,0, 'C');
$pdf->SetXY(120,245);
$pdf->Cell(80,5,'C.C. / N.I.T. _______________________',0,0, 'C');

$pdf->Image('images/Empresa.jpg',201,200, 3);

*/


$pdf->Output();
?>
