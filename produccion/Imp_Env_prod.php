<?php
session_start();
require '../includes/fpdf.php';
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$lote = $_POST['lote'];
$OProdOperador = new OProdOperaciones();
$ordenProd = $OProdOperador->getOProd($lote);
$PresentacionOperador = new PresentacionesOperaciones();
$presentaciones = $PresentacionOperador->getPresentacionesXProd($ordenProd['codProducto']);
class PDF extends FPDF
{
//Cabecera de página
    function Header()
    {
        //Logo
        $this->Image('../images/LogoNova1.jpg', 15, 12, 38, 19);
        $this->Image('../images/LogoNova1.jpg', 13, 157, 38, 19);
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
        $this->Cell(0, 10, iconv('UTF-8', 'windows-1252', 'Aprobó: __________________________________'), 0, 0, 'C');
    }
}

$pdf = new PDF('P', 'mm', 'Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 11);
$pdf->SetXY(10, 10);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(50, 24, '', 1, 0, 'C');
$pdf->Cell(80, 8, iconv('UTF-8', 'windows-1252', 'DEPARTAMENTO DE PRODUCCIÓN'), 1, 0, 'C');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(65, 8, iconv('UTF-8', 'windows-1252', 'CÓDIGO: DP-OEE-01'), 1, 0, 'C');
$pdf->SetXY(60, 18);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(80, 16, iconv('UTF-8', 'windows-1252', 'ORDEN DE ENVASADO Y ETIQUETADO'), 1, 0, 'C');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(65, 8, iconv('UTF-8', 'windows-1252', 'VERSIÓN: 1.00'), 1, 0, 'C');
$encabfecha = date('Y-m-d');
date_default_timezone_set('America/Bogota');
$pdf->SetXY(140, 26);
$pdf->Cell(65, 8, iconv('UTF-8', 'windows-1252', 'Fecha Emisión: ') . $encabfecha, 1, 0, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->SetXY(10, 40);
$pdf->Cell(45, 6, iconv('UTF-8', 'windows-1252', 'Fecha de Producción : '));
$pdf->Cell(75, 6, $ordenProd['fechProd']);
$pdf->Cell(25, 6, 'No. de Lote: ');
$pdf->Cell(30, 6, $ordenProd['lote'], 0, 1);
$pdf->Cell(20, 6, 'Producto : ');
$pdf->Cell(100, 6,  iconv('UTF-8', 'windows-1252', $ordenProd['nomProducto']));
$pdf->Cell(30, 6, 'Cantidad (Kg): ');
$pdf->Cell(30, 6, $ordenProd['cantidadKg'], 0, 1);
$pdf->SetXY(70, 55);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(70, 10, 'ENVASADO', 0, 0, 'C');
$pdf->SetXY(40, 63);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 8, iconv('UTF-8', 'windows-1252', 'Código'), 0, 0, 'C');
$pdf->Cell(100, 8, iconv('UTF-8', 'windows-1252', 'Presentación de Producto '), 0, 0, 'C');
$pdf->Cell(50, 8, 'Cantidad ', 0, 1, 'C');
$pdf->SetFont('Arial', '', 10);
for($j=0; $j<count($presentaciones); $j++) {
    $pdf->Cell(25);
    $pdf->Cell(20, 5, $presentaciones[$j]['codPresentacion'], 0, 0, 'C');
    $pdf->Cell(100, 5, iconv('UTF-8', 'windows-1252', $presentaciones[$j]['presentacion']), 0, 0, 'R');
    $pdf->Cell(40, 5, '__________', 0, 0, 'C');
    $pdf->Ln(5);
}
$etiquetas = $OProdOperador->getEtiquetasXLote($lote);
$pdf->SetXY(70, 110);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(70, 10, 'SOLICITUD ETIQUETAS', 0, 0, 'C');
$pdf->SetXY(40, 120);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 5, 'Id', 0, 0, 'C');
$pdf->Cell(90, 5, 'Etiqueta ', 0, 0, 'C');
$pdf->Cell(20, 5, 'Cantidad ', 0, 0, 'C');
$pdf->SetXY(40, 127);
$pdf->SetLeftMargin(40);
$pdf->SetFont('Arial', '', 10);
for ($i = 0; $i < count($etiquetas); $i++) {
    $pdf->Cell(10, 4, $i + 1, 0, 0, 'C');
    $pdf->Cell(90, 4, iconv('UTF-8', 'windows-1252', $etiquetas[$i]['nomEtiqueta']), 0, 0, 'L');
    $pdf->Cell(20, 4, '______', 0, 1, 'C');
}
$pdf->SetLeftMargin(10);
$pdf->SetXY(10, 140);
$pdf->Cell(0, 10, 'Solicita: ______________________________________   Aprueba: __________________________________', 0, 0, 'C');
$pdf->SetXY(10, 155);

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(45, 24, '', 1, 0, 'C');
$pdf->Cell(95, 8, iconv('UTF-8', 'windows-1252', 'DEPARTAMENTO DE PRODUCCIÓN'), 1, 0, 'C');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(55, 8, iconv('UTF-8', 'windows-1252', 'CÓDIGO: DP-CPT-01'), 1, 0, 'C');
$pdf->SetXY(55, 163);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(95, 16, iconv('UTF-8', 'windows-1252', 'CONTROL DE CALIDAD PRODUCTO TERMINADO'), 1, 0, 'C');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(55, 8, iconv('UTF-8', 'windows-1252', 'VERSIÓN: 1.00') , 1, 0, 'C');
$encabfecha = date('Y-m-d');
date_default_timezone_set('America/Bogota');
$pdf->SetXY(150, 171);
$pdf->Cell(55, 8, iconv('UTF-8', 'windows-1252', 'Fecha emisión: ') . $encabfecha, 1, 0, 'C');
$pdf->SetXY(10, 183);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 5, 'Muestra', 1, 0, 'C');
$pdf->Cell(45, 5, iconv('UTF-8', 'windows-1252', 'Presentación'), 1, 0, 'C');
$pdf->Cell(30, 5, 'Peso (Kg)', 1, 0, 'C');
$pdf->Cell(50, 5, 'Etiquetado', 1, 0, 'C');
$pdf->Cell(50, 5, 'Envasado', 1, 1, 'C');
$pdf->SetFont('Arial', '', 10);
for ($b = 1; $b <= 8; $b++) {
    $pdf->Cell(20, 5, $b, 1, 0, 'C');
    $pdf->Cell(45, 5, '', 1, 0, 'C');
    $pdf->Cell(30, 5, '', 1, 0, 'C');
    $pdf->Cell(50, 5, 'Cumple [  ]  No cumple [  ]', 1, 0, 'C');
    $pdf->Cell(50, 5, 'Cumple [  ]  No cumple [  ]', 1, 1, 'C');
}
$pdf->SetY(-50);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 8, 'Observaciones:');
$pdf->Line(10, 240, 200, 240);
$pdf->Line(10, 248, 200, 248);
$pdf->Line(10, 256, 200, 256);
$pdf->Output();
?>
