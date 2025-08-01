<?php
session_start();
require '../../../includes/fpdf.php';
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$lote = $_POST['lote'];
$OProdOperador = new OProdOperaciones();
$ordenProd = $OProdOperador->getOProd($lote);
$ProdOperador = new ProductosOperaciones();
$producto = $ProdOperador->getProducto($ordenProd['codProducto']);
$calProdOperador = new CalProdOperaciones();
$calProd = $calProdOperador->getCalProd($lote);

class PDF extends FPDF
{
//Cabecera de página
    function Header()
    {
        //Logo
        $this->Image('../../../images/LogoNova.jpg', 22, 12, 46, 23);
        //Arial bold 15
        $this->SetFont('Arial', 'B', 16);
        //Movernos a la derecha
        $this->SetXY(70, 55);
        //Título
        $this->Cell(70, 10, iconv('UTF-8', 'windows-1252', 'CERTIFICADO DE ANÁLISIS'), 0, 0, 'C');
        //Salto de línea
        $this->Ln(20);
    }

//Pie de página
    function Footer()
    {
        //Posición: a 1,5 cm del final
        $this->SetY(-12);
        //Arial italic 8
        $this->SetFont('Arial', '', 8);
        //Número de página
        $this->Cell(0, 10, iconv('UTF-8', 'windows-1252', 'Calle 35 C sur No. 26 F - 40 Bogotá D.C. Colombia - Teléfono: (571) 2039484 - (571) 2022912 e-mail: info@novaquim.com'), 0, 0, 'C');
    }
}

$pdf = new PDF('P', 'mm', 'Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);
$pdf->SetXY(20, 10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 30, '', 1, 0, 'C');
$pdf->Cell(65, 10, 'GERENCIA DE CALIDAD', 1, 0, 'C');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(65, 10, iconv('UTF-8', 'windows-1252', 'CÓDIGO: FT-CA-01'), 1, 0, 'C');
$pdf->SetXY(70, 20);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(65, 20, iconv('UTF-8', 'windows-1252', 'CERTIFICADO DE ANÁLISIS'), 1, 0, 'C');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(65, 10, iconv('UTF-8', 'windows-1252', 'Fecha Expedición: ') . $ordenProd['fechProd'], 1, 0, 'C');
$encabfecha = date('Y-m-d');
date_default_timezone_set('America/Bogota');
$pdf->SetXY(135, 30);
$pdf->Cell(65, 10, iconv('UTF-8', 'windows-1252', 'Fecha Impresión: ') . $encabfecha, 1, 0, 'C');
$pdf->SetXY(10, 80);
$pdf->SetLeftMargin(20);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(42, 6, 'No. de Lote: ', 0, 0, 'R');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, 6, $ordenProd['lote'], 0, 1);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(42, 6, 'Producto : ', 0, 0, 'R');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(100, 6, iconv('UTF-8', 'windows-1252', $ordenProd['nomProducto']), 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(42, 6, 'Cantidad (Kg): ', 0, 0, 'R');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, 6, $ordenProd['cantidadKg'], 0, 1);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(42, 6, iconv('UTF-8', 'windows-1252', 'Fecha de Producción : '), 0, 0, 'R');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(75, 6, $ordenProd['fechProd'], 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(42, 6, 'Fecha de Vencimiento : ', 0, 0, 'R');
$pdf->SetFont('Arial', '', 10);

$fechap = $ordenProd['fechProd'];
$venc = $ordenProd['vencimiento'];
$nuevafecha = strtotime('+' . $venc . ' day', strtotime($fechap));
$nuevafecha = date('Y-m-j', $nuevafecha);
$pdf->Cell(75, 6, $nuevafecha, 0, 1, 'L');


$pdf->SetXY(20, 125);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(50, 5, iconv('UTF-8', 'windows-1252', 'ANÁLISIS'), 'B', 0, 'C');
$pdf->Cell(80, 5, 'ESPECIFICACIONES', 'B', 0, 'C');
$pdf->Cell(50, 5, 'RESULTADO', 'B', 1, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(50, 5, 'APARIENCIA ', 'B', 0, 'C');
$pdf->Cell(80, 5, iconv('UTF-8', 'windows-1252', $producto['apariencia']), 'B', 0, 'C');
$pdf->Cell(50, 5, $calProd['aparienciaProd'] == 1 ? "CUMPLE" : "NO CUMPLE", 'B', 1, 'C');
$pdf->Cell(50, 5, 'OLOR ', 'B', 0, 'C');
$pdf->Cell(80, 5, iconv('UTF-8', 'windows-1252', $producto['fragancia']), 'B', 0, 'C');
$pdf->Cell(50, 5, $calProd['olorProd'] == 1 ? "CUMPLE" : "NO CUMPLE", 'B', 1, 'C');
$pdf->Cell(50, 5, 'COLOR ', 'B', 0, 'C');
$pdf->Cell(80, 5, iconv('UTF-8', 'windows-1252', $producto['color']), 'B', 0, 'C');
$pdf->Cell(50, 5, $calProd['colorProd'] == 1 ? "CUMPLE" : "NO CUMPLE", 'B', 1, 'C');
$pdf->Cell(50, 5, 'pH', 'B', 0, 'C');
$pdf->Cell(80, 5, number_format($producto['pHmin'], 3, ".") . ' - ' . number_format($producto['pHmax'], 3, "."), 'B', 0, 'C');
$pdf->Cell(50, 5, number_format($calProd['pHProd'], 3, "."), 'B', 1, 'C');
$pdf->Cell(50, 5, 'DENSIDAD (g/ml)', 'B', 0, 'C');
$pdf->Cell(80, 5, number_format($producto['densMin'], 3, ".") . ' - ' . number_format($producto['densMax'], 3, "."), 'B', 0, 'C');
$pdf->Cell(50, 5, number_format($calProd['densidadProd'], 3, "."), 'B', 1, 'C');
$usuarioOperador = new UsuariosOperaciones();
$responsableCalidad = $usuarioOperador->getResponsableCalidad();
$nom = $responsableCalidad['nombre'];
$pefil = $responsableCalidad['descripcion'];
$pdf->SetXY(20, 175);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 5, 'Observaciones:', 0, 1);
$pdf->Cell(180, 5, iconv('UTF-8', 'windows-1252', $calProd['observacionesProd']), 0, 1);
$pdf->Image('../../../images/calidad.gif', 22, 200, 46, 23);
$pdf->SetXY(20, 220);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(60, 5, iconv('UTF-8', 'windows-1252', $nom), 'T', 1);
$pdf->Cell(60, 5, iconv('UTF-8', 'windows-1252', $pefil), 0, 1);
$pdf->SetFont('Arial', '', 8);
$pdf->SetXY(20, 240);
$pdf->MultiCell(0, 3, iconv('UTF-8', 'windows-1252', 'La información facilitada en este documento se considera válida desde la fecha de su emisión y hasta su sustitución por otra nueva.  Está basada en nuestros conocimientos y experiencias actuales y se refiere únicamente al producto especificado.
Sin embargo, dados los numerosos factores que están fuera de nuestro control y que pueden afectar la manipulación y empleo de los producto, INDUSTRIAS NOVAQUIM S.A.S. no asume ninguna responsabilidad ni obligación por las recomendaciones efectuadas, ya sea en cuanto a los resultados obtenidos o por los prejuicios o daños que se derivaran de su utilización.'), 0, 1);

$pdf->Output();
?>
