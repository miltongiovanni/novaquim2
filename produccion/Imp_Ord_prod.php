<?php
include "../includes/valAcc.php";
require '../includes/fpdf.php';
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
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
        $this->Image('../images/LogoNova1.jpg',70,8,63);
        //Arial bold 15
        $this->SetFont('Arial','B',16);
        //Movernos a la derecha
        $this->SetXY(70,45);
        //Título
        $this->Cell(70,10,utf8_decode('ORDEN DE PRODUCCIÓN'),0,0,'C');
        //Salto de línea
        $this->Ln(15);
    }

//Pie de página
    function Footer()
    {
        //Posición: a 1,5 cm del final
        $this->SetY(-15);
        //Arial italic 8
        $this->SetFont('Arial','',10);
        //Número de página
        $this->Cell(0,10,utf8_decode('Verificó: ______________________________________   Aprobó: __________________________________'),0,0,'C');
    }
}

//Creación del objeto de la clase heredada
$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
$pdf->SetXY(10,55);
$pdf->Cell(45,6,utf8_decode('Fecha de Producción : '));
$pdf->Cell(75,6,$OProd['fechProd']);
$pdf->Cell(25,6,'No. de Lote: ');
$pdf->Cell(30,6,$OProd['lote'],0,1);
$pdf->Cell(20,6,'Producto : ');
$pdf->Cell(100,6,utf8_decode($OProd['nomProducto']));
$pdf->Cell(30,6,'Responsable : ');
$pdf->Cell(40,6,utf8_decode($OProd['nomPersonal']),0,1);
$pdf->Cell(20,6,utf8_decode('Fórmula : '));
$pdf->Cell(100,6,$OProd['nomFormula']);
$pdf->Cell(30,6,'Cantidad (Kg): ');
$pdf->Cell(30,6,$OProd['cantidadKg'],0,1);
$pdf->SetXY(15,75);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,5,'Orden', 0,0,'C');
$pdf->Cell(20,5,utf8_decode('Código'), 0,0,'C');
$pdf->Cell(60,5,'Materia Prima ', 0,0,'C');
$pdf->Cell(20,5,'Lote M Prima ', 0,0,'C');
$pdf->Cell(40,5,'Cantidad (Kg)',0,0,'C');
$pdf->Cell(40,5,'Cantidad Usada(Kg)',0,1,'C');
$pdf->SetFont('Arial','',10);
$pdf->SetXY(10,80);
for($i=0; $i<count($detOProd); $i++)
{
    $codmp=$detOProd[$i]['codMPrima'];
    $mprima=$detOProd[$i]['aliasMPrima'];
    $gasto=$detOProd[$i]['cantidadMPrima'];
    $lote_mp=$detOProd[$i]['loteMP'];
    $pdf->Cell(5);
    $pdf->Cell(10,5,$i+1,0,0,'C');
    $pdf->Cell(20,5,$codmp,0,0,'C');
    $pdf->Cell(60,5,utf8_decode($mprima),0,0,'C');
    $pdf->Cell(20,5,$lote_mp,0,0,'C');
    $pdf->Cell(40,5,$gasto,0,0,'C');
    $pdf->Cell(40,5,'________________',0,0,'C');
    $pdf->Ln(5);
}

$pdf->SetXY(10,165);
$pdf->Cell(0,10,utf8_decode('Elaboró: ______________________________________'),0,0,'L');
$pdf->SetFont('Arial','B',16);
$pdf->SetXY(70,180);
$pdf->Cell(70,10,'CONTROL DE CALIDAD',0,0,'C');
$pdf->SetXY(10,190);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(80,8,'Propiedad', 0,0,'C');
$pdf->Cell(60,8,utf8_decode('Especificación'), 0,0,'C');
$pdf->Cell(30,8,'Valor ',0,0,'C');
$pdf->Ln(5);
$pdf->SetFont('Arial','',10);
$pdf->Cell(80,8,'pH:', 0,0,'C');
$pdf->Cell(30,8,'Max: '.$OProd['pHmax'], 0,0,'C');
$pdf->Cell(30,8,'Min: '.$OProd['pHmin'],0,0,'C');
$pdf->Cell(30,8,'______________',0,0,'C');
$pdf->Ln(5);
$pdf->Cell(80,8,'Densidad:', 0,0,'C');
$pdf->Cell(30,8,'Max: '.$OProd['densMax'], 0,0,'C');
$pdf->Cell(30,8, 'Min: '.$OProd['densMin'],0,0,'C');
$pdf->Cell(30,8,'______________',0,0,'C');
$pdf->Ln(5);
$pdf->Cell(80,8,'Olor:', 0,0,'C');
$pdf->Cell(60,8, utf8_decode($OProd['fragancia']), 0,0,'C');
$pdf->Cell(30,8,'CUMPLE [  ]',0,0,'C');
$pdf->Ln(5);
$pdf->Cell(80,8,'Color:', 0,0,'C');
$pdf->Cell(60,8, utf8_decode($OProd['color']), 0,0,'C');
$pdf->Cell(30,8,'CUMPLE [  ]',0,0,'C');
$pdf->Ln(5);
$pdf->Cell(80,8,'Apariencia:', 0,0,'C');
$pdf->Cell(60,8, utf8_decode($OProd['apariencia']), 0,0,'C');
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
