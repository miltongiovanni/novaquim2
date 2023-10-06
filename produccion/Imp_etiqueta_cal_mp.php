<?php
session_start();
require '../includes/fpdf.php';
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$id = $_POST['id'];
$calMatPrimaOperador = new CalMatPrimaOperaciones();
$calidadMPrima = $calMatPrimaOperador->getControlCalidadById($id);
class PDF extends FPDF
{
//Cabecera de página
    function Header()
    {
        //Logo
        $this->Image('../images/LogoNova1.jpg', 12, 10, 24, 12);
        //Arial bold 15
//        $this->SetFont('Arial', 'B', 16);
//        //Movernos a la derecha
//        $this->SetXY(70, 45);
//        //Título
//        $this->Cell(70, 10, 'ORDEN DE ENVASADO', 0, 0, 'C');
//        //Salto de línea
//        $this->Ln(20);
    }

//Pie de página
    function Footer()
    {
        //Posición: a 1,5 cm del final
        $this->SetY(-15);
        //Arial italic 8
        $this->SetFont('Arial', '', 10);
        //Número de página
        $this->Cell(0, 10, utf8_decode('Aprobó: __________________________________'), 0, 0, 'C');
    }
}

$pdf = new PDF('P', 'mm', 'Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 8);
$pdf->SetXY(10, 10);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(28, 15, '', 1, 0, 'C');
$pdf->Cell(54, 5, utf8_decode('DEPARTAMENTO DE PRODUCCIÓN'), 1, 0, 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(38, 5, utf8_decode('CÓDIGO: DP-OEE-01'), 1, 0, 'C');
$pdf->SetXY(38, 15);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(54, 10, utf8_decode('IDENTIFICACIÓN DE MATERIA PRIMA'), 1, 0, 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(38, 5, utf8_decode('VERSIÓN: 1.00'), 1, 0, 'C');
$encabfecha = date('Y-m-d');
date_default_timezone_set('America/Bogota');
$pdf->SetXY(92, 20);
$pdf->Cell(38, 5, utf8_decode('Fecha Emisión: ') . $encabfecha, 1, 0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->SetXY(10, 25);
$pdf->Cell(120, 5, utf8_decode('Nombre: '. $calidadMPrima['nomMPrima']) , 1, 1, 'L');
$pdf->Cell(80, 5, utf8_decode('Nombre interno: '. $calidadMPrima['aliasMPrima']) , 1, 0, 'L');
$pdf->Cell(40, 5, utf8_decode('No. lote: '. $calidadMPrima['lote_mp']) , 1, 1, 'L');
$pdf->Cell(120, 5, utf8_decode('Proveedor: '. $calidadMPrima['nomProveedor']) , 1, 1, 'L');
$pdf->Cell(60, 5, utf8_decode('Fecha de recepción: '. $calidadMPrima['f_recepcion']) , 1, 0, 'L');
$pdf->Cell(60, 5, utf8_decode('Cantidad Total: '. $calidadMPrima['cantidad'].' Kg') , 1, 1, 'L');
$pdf->Cell(60, 5, utf8_decode('Fecha de vencimiento: '. $calidadMPrima['fecha_vencimiento']) , 1, 0, 'L');
$pdf->Cell(60, 5, utf8_decode('Fecha de análisis: '. $calidadMPrima['fecha_analisis']) , 1, 1, 'L');
$pdf->Cell(12, 5, utf8_decode('Estado: ') , 0, 0, 'L');
$pdf->SetFont('Arial', '', 16);
$pdf->Cell(100, 10, utf8_decode( strtoupper($calidadMPrima['descripcion'])) , 0, 1, 'L');
$pdf->Output();
?>
