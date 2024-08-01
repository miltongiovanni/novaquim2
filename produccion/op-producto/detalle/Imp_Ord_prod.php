<?php
session_start();
require '../../../includes/fpdf.php';
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');
$lote=$_POST['lote'];
$OProdOperador = new OProdOperaciones();
$DetOProdOperador = new DetOProdOperaciones();
$OProd = $OProdOperador->getOProd($lote);
$detOProd=$DetOProdOperador->getTableDetOProd($lote);

class PDF extends FPDF
{
//Cabecera de página
    function Header()
    {
        //Logo
        $this->Image('../../../images/LogoNova1.jpg',15, 12, 38, 19);
        //Arial bold 15
//        $this->SetFont('Arial','B',16);
//        //Movernos a la derecha
//        $this->SetXY(70,45);
//        //Título
//        $this->Cell(70,10,iconv('UTF-8', 'windows-1252', 'ORDEN DE PRODUCCIÓN'),0,0,'C');
//        //Salto de línea
//        $this->Ln(15);
    }

//Pie de página
    function Footer()
    {
        //Posición: a 1,5 cm del final
        $this->SetY(-15);
        //Arial italic 8
        $this->SetFont('Arial','',10);
        //Número de página
        $this->Cell(0,10,iconv('UTF-8', 'windows-1252', 'Verificó: ______________________________________   Aprobó: __________________________________'),0,0,'C');
    }
}

//Creación del objeto de la clase heredada
$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 11);
$pdf->SetXY(10, 10);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(50, 24, '', 1, 0, 'C');
$pdf->Cell(80, 8, iconv('UTF-8', 'windows-1252', 'DEPARTAMENTO DE PRODUCCIÓN'), 1, 0, 'C');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(65, 8, iconv('UTF-8', 'windows-1252', 'CÓDIGO: DP-OPC-01'), 1, 0, 'C');
$pdf->SetXY(60, 18);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(80, 16, iconv('UTF-8', 'windows-1252', 'ORDEN DE PRODUCCIÓN Y CONTROL'), 1, 0, 'C');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(65, 8, iconv('UTF-8', 'windows-1252', 'Fecha Expedición: ') . $OProd['fechProd'], 1, 0, 'C');
$encabfecha = date('Y-m-d');
date_default_timezone_set('America/Bogota');
$pdf->SetXY(140, 26);
$pdf->Cell(65, 8, iconv('UTF-8', 'windows-1252', 'Fecha Impresión: ') . $encabfecha, 1, 0, 'C');
$pdf->SetFont('Arial','',11);
$pdf->SetXY(10,36);
$pdf->Cell(45,6,iconv('UTF-8', 'windows-1252', 'Fecha de Producción : '));
$pdf->Cell(25,6,$OProd['fechProd']);
$pdf->Cell(35,6,iconv('UTF-8', 'windows-1252', 'Tanque utilizado : '));
$pdf->Cell(45,6,'____________________');
$pdf->Cell(25,6,'No. de Lote: ');
$pdf->Cell(20,6,$OProd['lote'],0,1);
$pdf->Cell(20,6,'Producto : ');
$pdf->Cell(100,6,iconv('UTF-8', 'windows-1252', $OProd['nomProducto']));
$pdf->Cell(30,6,'Responsable : ');
$pdf->Cell(40,6,iconv('UTF-8', 'windows-1252', $OProd['nomPersonal']),0,1);
$pdf->Cell(20,6,iconv('UTF-8', 'windows-1252', 'Fórmula : '));
$pdf->Cell(100,6,iconv('UTF-8', 'windows-1252', $OProd['nomFormula']));
$pdf->Cell(30,6,'Cantidad (Kg): ');
$pdf->Cell(30,6,$OProd['cantidadKg'],0,1);
$pdf->SetXY(15,57);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,5,'Orden', 0,0,'C');
$pdf->Cell(20,5,iconv('UTF-8', 'windows-1252', 'Código'), 0,0,'C');
$pdf->Cell(60,5,'Materia Prima ', 0,0,'C');
$pdf->Cell(20,5,'Lote M Prima ', 0,0,'C');
$pdf->Cell(40,5,'Cantidad (Kg)',0,0,'C');
$pdf->Cell(40,5,'Cantidad Usada(Kg)',0,1,'C');
$pdf->SetFont('Arial','',10);
$pdf->SetXY(10,62);
for($i=0; $i<count($detOProd); $i++)
{
    $codmp=$detOProd[$i]['codMPrima'];
    $mprima=$detOProd[$i]['aliasMPrima'];
    $gasto=$detOProd[$i]['cantidadMPrima'];
    $lote_mp=$detOProd[$i]['loteMP'];
    $pdf->Cell(5);
    $pdf->Cell(10,5,$i+1,0,0,'C');
    $pdf->Cell(20,5,$codmp,0,0,'C');
    $pdf->Cell(60,5,iconv('UTF-8', 'windows-1252', $mprima),0,0,'C');
    $pdf->Cell(20,5,$lote_mp,0,0,'C');
    $pdf->Cell(40,5,$gasto,0,0,'C');
    $pdf->Cell(40,5,'________________',0,0,'C');
    $pdf->Ln(5);
}

$pdf->SetXY(10,127);
$pdf->Cell(0,10,iconv('UTF-8', 'windows-1252', 'Elaboró: ______________________________________'),0,0,'L');
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(70,137);
$pdf->Cell(70,10,'CONTROL DE CALIDAD DURANTE EL PROCESO',0,0,'C');
$pdf->SetFont('Arial','',10);
$pdf->SetXY(10,146);
$pdf->Cell(20,5,iconv('UTF-8', 'windows-1252', ''),0,0,'C');
$pdf->Cell(95,5,iconv('UTF-8', 'windows-1252', 'Se evidenció cambios de viscosidad?'),0,0,'L');
$pdf->Cell(10,5,iconv('UTF-8', 'windows-1252', 'SI'),0,0,'C');
$pdf->Cell(5,5,'',1,0,'C');
$pdf->Cell(10,5,iconv('UTF-8', 'windows-1252', 'NO'),0,0,'C');
$pdf->Cell(5,5,'',1,0,'C');
$pdf->Cell(30,5,iconv('UTF-8', 'windows-1252', 'NO APLICA'),0,0,'C');
$pdf->Cell(5,5,'',1,1);
$pdf->Cell(20,5,iconv('UTF-8', 'windows-1252', ''),0,0,'C');
$pdf->Cell(95,5,iconv('UTF-8', 'windows-1252', 'Se realizó la purga respectiva?'),0,0,'L');
$pdf->Cell(10,5,iconv('UTF-8', 'windows-1252', 'SI'),0,0,'C');
$pdf->Cell(5,5,'',1,0,'C');
$pdf->Cell(10,5,iconv('UTF-8', 'windows-1252', 'NO'),0,0,'C');
$pdf->Cell(5,5,'',1,0,'C');
$pdf->Cell(30,5,iconv('UTF-8', 'windows-1252', 'NO APLICA'),0,0,'C');
$pdf->Cell(5,5,'',1,1);
$pdf->Cell(20,5,iconv('UTF-8', 'windows-1252', ''),0,0,'C');
$pdf->Cell(95,5,iconv('UTF-8', 'windows-1252', 'Se hizo la prueba de brillo?'),0,0,'L');
$pdf->Cell(10,5,iconv('UTF-8', 'windows-1252', 'SI'),0,0,'C');
$pdf->Cell(5,5,'',1,0,'C');
$pdf->Cell(10,5,iconv('UTF-8', 'windows-1252', 'NO'),0,0,'C');
$pdf->Cell(5,5,'',1,0,'C');
$pdf->Cell(30,5,iconv('UTF-8', 'windows-1252', 'NO APLICA'),0,0,'C');
$pdf->Cell(5,5,'',1,1);
$pdf->Cell(20,5,iconv('UTF-8', 'windows-1252', ''),0,0,'C');
$pdf->Cell(95,5,iconv('UTF-8', 'windows-1252', 'El tiempo de agitación fue el correcto?'),0,0,'L');
$pdf->Cell(10,5,iconv('UTF-8', 'windows-1252', 'SI'),0,0,'C');
$pdf->Cell(5,5,'',1,0,'C');
$pdf->Cell(10,5,iconv('UTF-8', 'windows-1252', 'NO'),0,0,'C');
$pdf->Cell(5,5,'',1,0,'C');
$pdf->Cell(30,5,iconv('UTF-8', 'windows-1252', 'NO APLICA'),0,0,'C');
$pdf->Cell(5,5,'',1,1);
$pdf->Cell(20,5,iconv('UTF-8', 'windows-1252', ''),0,0,'C');
$pdf->Cell(95,5,iconv('UTF-8', 'windows-1252', 'Se efectuó la prueba de limpieza correspondiente?'),0,0,'L');
$pdf->Cell(10,5,iconv('UTF-8', 'windows-1252', 'SI'),0,0,'C');
$pdf->Cell(5,5,'',1,0,'C');
$pdf->Cell(10,5,iconv('UTF-8', 'windows-1252', 'NO'),0,0,'C');
$pdf->Cell(5,5,'',1,0,'C');
$pdf->Cell(30,5,iconv('UTF-8', 'windows-1252', 'NO APLICA'),0,0,'C');
$pdf->Cell(5,5,'',1,1);
$pdf->Cell(20,5,iconv('UTF-8', 'windows-1252', ''),0,0,'C');
$pdf->Cell(95,5,iconv('UTF-8', 'windows-1252', 'Se hizo la prueba de desempeño?'),0,0,'L');
$pdf->Cell(10,5,iconv('UTF-8', 'windows-1252', 'SI'),0,0,'C');
$pdf->Cell(5,5,'',1,0,'C');
$pdf->Cell(10,5,iconv('UTF-8', 'windows-1252', 'NO'),0,0,'C');
$pdf->Cell(5,5,'',1,0,'C');
$pdf->Cell(30,5,iconv('UTF-8', 'windows-1252', 'NO APLICA'),0,0,'C');
$pdf->Cell(5,5,'',1,1);
$pdf->Cell(20,5,iconv('UTF-8', 'windows-1252', ''),0,0,'C');
$pdf->Cell(95,5,iconv('UTF-8', 'windows-1252', 'Se verificó color y fragancia?'),0,0,'L');
$pdf->Cell(10,5,iconv('UTF-8', 'windows-1252', 'SI'),0,0,'C');
$pdf->Cell(5,5,'',1,0,'C');
$pdf->Cell(10,5,iconv('UTF-8', 'windows-1252', 'NO'),0,0,'C');
$pdf->Cell(5,5,'',1,0,'C');
$pdf->Cell(30,5,iconv('UTF-8', 'windows-1252', 'NO APLICA'),0,0,'C');
$pdf->Cell(5,5,'',1,1);
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(70,186);
$pdf->Cell(70,10,'CONTROL DE CALIDAD ANTES DEL ENVASADO',0,0,'C');
$pdf->SetXY(10,195);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(80,8,'Propiedad', 0,0,'C');
$pdf->Cell(60,8,iconv('UTF-8', 'windows-1252', 'Especificación'), 0,0,'C');
$pdf->Cell(30,8,'Valor ',0,0,'C');
$pdf->Ln(5);
$pdf->SetFont('Arial','',10);
$pdf->Cell(80,8,'pH:', 0,0,'C');
$pdf->Cell(30,8,'Min: '.$OProd['pHmin'],0,0,'C');
$pdf->Cell(30,8,'Max: '.$OProd['pHmax'], 0,0,'C');
$pdf->Cell(30,8,'______________',0,0,'C');
$pdf->Ln(5);
$pdf->Cell(80,8,'Densidad:', 0,0,'C');
$pdf->Cell(30,8, 'Min: '.$OProd['densMin'],0,0,'C');
$pdf->Cell(30,8,'Max: '.$OProd['densMax'], 0,0,'C');
$pdf->Cell(30,8,'______________',0,0,'C');
$pdf->Ln(5);
$pdf->Cell(80,8,'Olor:', 0,0,'C');
$pdf->Cell(60,8, iconv('UTF-8', 'windows-1252', $OProd['fragancia']), 0,0,'C');
$pdf->Cell(30,8,'CUMPLE [  ]',0,0,'C');
$pdf->Ln(5);
$pdf->Cell(80,8,'Color:', 0,0,'C');
$pdf->Cell(60,8, iconv('UTF-8', 'windows-1252', $OProd['color']), 0,0,'C');
$pdf->Cell(30,8,'CUMPLE [  ]',0,0,'C');
$pdf->Ln(5);
$pdf->Cell(80,8,'Apariencia:', 0,0,'C');
$pdf->Cell(60,8, iconv('UTF-8', 'windows-1252', $OProd['apariencia']), 0,0,'C');
$pdf->Cell(30,8,'CUMPLE [  ]',0,0,'C');
$pdf->SetFont('Arial','',10);
$pdf->SetY(-50);
$pdf->Cell(10,8,'Observaciones:');
$pdf->Line(10,240,200,240);
$pdf->Line(10,248,200,248);
$pdf->Line(10,256,200,256);
/* cerrar la conexión */
$pdf->Output();
?>
