<?php
include "../includes/num_letra.php";
require('../includes/fpdf.php');
require('../includes/valAcc.php');
$idNotaC = $_POST['idNotaC'];

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$notaCrOperador = new NotasCreditoOperaciones();
$detNotaCrOperador = new DetNotaCrOperaciones();
$notaC = $notaCrOperador->getNotaC($idNotaC);
if ($notaC['motivo'] == 1) {
    $detNotaC = $detNotaCrOperador->getTableDetNotaCrDes($idNotaC);
} else {
    $detNotaC = $detNotaCrOperador->getTableDetNotaCrDev($idNotaC);
}
$totalesNotaC = $notaCrOperador->getTotalesNotaC($idNotaC);

//var_dump($detNotaC); die;
class PDF extends FPDF
{
    //Cabecera de página
    function Header()
    {
        $idNotaC = $_POST['idNotaC'];
        //Logo
        $yearIni = date("Y");
        $this->Image('../images/LogoNova.jpg', 10, 05, 43);
        //Arial bold 15
        $this->SetFont('Arial', 'B', 10);
        //Movernos a la derecha
        $this->SetXY(80, 14);
        $this->Cell(40, 4, 'INDUSTRIAS NOVAQUIM S.A.S.', 0, 0, 'C');
        $this->SetXY(80, 18);
        $this->Cell(40, 4, 'NIT 900.419.629-7', 0, 0, 'C');
        $this->SetXY(80, 22);
        $this->Cell(40, 4, 'ICA Tarifa 11.04 por Mil', 0, 0, 'C');
        $this->SetFont('Arial', 'B', 14);
        //Movernos a la derecha
        //Título
        $this->SetXY(135, 14);
        $this->Cell(70, 10, utf8_decode('NOTA CRÉDITO No. ' . $idNotaC . '-' . $yearIni), 0, 0, 'C');
    }

    //Pie de página
    function Footer()
    {
        //Posición: a 1,5 cm del final
        $this->SetY(-15);
        //Arial italic 8
        $this->SetFont('Arial', '', 8);
        //Número de página
        $this->Cell(0, 10, utf8_decode('Dirección: Calle 35 C Sur No. 26F - 40  PBX: 2039484 - 2022912  Website:www.novaquim.com   E-mail: info@novaquim.com'), 0, 0, 'C');
    }
}

$pdf = new PDF('P', 'mm', 'Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
$pdf->SetXY(10, 30);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(25, 3.5, 'CLIENTE:', 0, 0, 'R');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(110, 3.5, utf8_decode($notaC['nomCliente']));
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(35, 3.5, 'FECHA:', 0, 0, 'R');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(35, 3.5, $notaC['fechaNotaC'], 0, 1);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(25, 3.5, 'NIT:', 0, 0, 'R');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(110, 3.5, $notaC['nitCliente']);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(35, 3.5, 'FACT ORIGEN NOTA:', 0, 0, 'R');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(35, 3.5, $notaC['facturaOrigen'], 0, 1);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(25, 3.5, utf8_decode('DIRECCIÓN:'), 0, 0, 'R');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(110, 3.5, utf8_decode($notaC['dirCliente']));
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(35, 3.5, 'FACT AFECTA NOTA:', 0, 0, 'R');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(35, 3.5, $notaC['facturaDestino'], 0, 1);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(25, 3.5, utf8_decode('TELÉFONO:'), 0, 0, 'R');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(110, 3.5, $notaC['telCliente']);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(35, 3.5, 'CIUDAD:', 0, 0, 'R');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(35, 3.5, utf8_decode($notaC['ciudad']), 0, 1);
$pdf->SetFont('Arial', 'B', 10);
$motivo = $notaC['motivo'];
$facturaOrigen = $notaC['facturaOrigen'];
$facturaDestino = $notaC['facturaDestino'];
$pdf->Cell(25, 3.5, 'MOTIVO:', 0, 0, 'R');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(110, 3.5, utf8_decode($notaC['descMotivo']));
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetXY(10, 51);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(25, 4, utf8_decode('CÓDIGO'), 1, 0, 'C');
$pdf->Cell(100, 4, 'PRODUCTO ', 1, 0, 'C');
$pdf->Cell(10, 4, 'CAN ', 1, 0, 'C');
$pdf->Cell(10, 4, 'IVA ', 1, 0, 'C');
$pdf->Cell(22, 4, 'VR. UNIT ', 1, 0, 'C');
$pdf->Cell(25, 4, 'SUBTOTAL ', 1, 0, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->SetXY(10, 55);
if ($notaC['motivo'] == 0) {
    for ($i = 0; $i < count($detNotaC); $i++) {
        $pdf->Cell(25, 4, $detNotaC[$i]['codProducto'], 0, 0, 'C');
        $pdf->Cell(100, 4, utf8_decode($detNotaC[$i]['producto']), 0, 0, 'L');
        $pdf->Cell(10, 4, $detNotaC[$i]['cantidad'], 0, 0, 'C');
        $pdf->Cell(10, 4, $detNotaC[$i]['iva'], 0, 0, 'C');
        $pdf->Cell(22, 4, $detNotaC[$i]['precioProducto'], 0, 0, 'R');
        $pdf->Cell(25, 4, $detNotaC[$i]['subtotal'], 0, 0, 'R');
        $pdf->Ln(4);
    }
} else {
    $pdf->Cell(25, 4, '', 0, 0, 'C');
    $pdf->Cell(100, 4, utf8_decode($detNotaC['producto']), 0, 0, 'L');
    $pdf->Cell(10, 4, '', 0, 0, 'C');
    $pdf->Cell(10, 4, '19 %', 0, 0, 'C');
    $pdf->Cell(22, 4, $detNotaC['valor'], 0, 0, 'R');
    $pdf->Cell(25, 4, $detNotaC['valor'], 0, 0, 'R');
    $pdf->Ln(4);
}
$num_letra = numletra(round($notaC['totalNotaC']));
$pdf->SetFont('Arial', '', 10);
$pdf->SetXY(10, -42);
$pdf->Cell(140, 21, '', 1);
$pdf->SetXY(10, -42);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(33, 5, 'SON:');
$pdf->SetFont('Arial', '', 10);
$pdf->SetXY(10, -38);
$pdf->MultiCell(135, 4, $num_letra, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->SetXY(155, -42);
$pdf->Cell(50, 21, '', 1);
$pdf->SetXY(155, -42);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(25, 5, 'SUBTOTAL', 0, 0, 'R');
$pdf->Cell(25, 5, $notaC['subtotalNotaC'], 0, 0, 'R');
$pdf->SetXY(155, -38);
$pdf->Cell(25, 5, 'DESCUENTO', 0, 0, 'R');
$pdf->Cell(25, 5, $notaC['descuentoNotaC'], 0, 0, 'R');
$pdf->SetXY(155, -34);
$pdf->Cell(25, 5, 'IVA 05%', 0, 0, 'R');
$pdf->Cell(25, 5, $notaC['motivo'] == 0 ? $totalesNotaC['iva10nota_c'] : '$0', 0, 0, 'R');
$pdf->SetXY(155, -30);
if ($notaC['fechaFactura'] < FECHA_C)
    $pdf->Cell(25, 5, 'IVA 16%', 0, 0, 'R');
else
    $pdf->Cell(25, 5, 'IVA 19%', 0, 0, 'R');
$pdf->Cell(25, 5, $notaC['motivo'] == 0 ? $totalesNotaC['iva19nota_c'] : $notaC['ivaNotaC'], 0, 0, 'R');
$pdf->SetXY(155, -26);
$pdf->Cell(25, 5, 'TOTAL', 0, 0, 'R');
$pdf->Cell(25, 5, $notaC['totalNotaCrFormated'], 0, 0, 'R');

$pdf->Output();
?>
