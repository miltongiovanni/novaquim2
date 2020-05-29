<?php
include "../includes/valAcc.php";
?>
<?php
require('fpdf.php');

class PDF extends FPDF
{
//Cabecera de página
function Header()
{
	//Logo
	$this->Image('images/LogoNova1.jpg',70,8,70);
	//Arial bold 15
	$this->SetFont('Arial','B',16);
	//Movernos a la derecha
	$this->SetXY(70,45);
	//Título
	$this->Cell(70,10,'ORDEN DE ENVASADO',0,0,'C');
	//Salto de línea
	$this->Ln(20);
}

//Pie de página
function Footer()
{
	//Posición: a 1,5 cm del final
	$this->SetY(-15);
	//Arial italic 8
	$this->SetFont('Arial','',10);
	//Número de página
	$this->Cell(0,10,'Aprobó: __________________________________',0,0,'C');
}
}

//Creación del objeto de la clase heredada
include "includes/conect.php";
$link=conectarServidor();
$Lote=$_POST['Lote'];
$qryord="select Lote, fechProd, cantidadKg, codResponsable,ord_prod.codProducto as Codigo, Nom_produc, nomFormula, nom_personal 
		from ord_prod, formula, productos, personal
		WHERE ord_prod.idFormula=formula.idFormula and formula.codProducto=productos.Cod_produc
		and ord_prod.codResponsable=personal.Id_personal and Lote=$Lote;";
$resultord=mysqli_query($link,$qryord);
$roword=mysqli_fetch_array($resultord);
$cod_prod=$roword['Codigo'];
$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
$pdf->SetXY(10,60);
$pdf->Cell(45,6,'Fecha de Producción : ');
$pdf->Cell(75,6,$roword['Fch_prod']);
$pdf->Cell(25,6,'No. de Lote: ');
$pdf->Cell(30,6,$roword['Lote'],0,1);
$pdf->Cell(20,6,'Producto : ');
$pdf->Cell(100,6,$roword['Nom_produc']);
$pdf->Cell(30,6,'Cantidad (Kg): ');
$pdf->Cell(30,6,$roword['Cant_kg'],0,1);

$i=1;
$qryet="SELECT DISTINCT Nom_etiq from ord_prod, prodpre, etiquetas where Lote=$Lote and codProducto=Cod_produc and pres_activo=0 and prodpre.Cod_etiq=etiquetas.Cod_etiq;";
//echo $qryet;
$resultet=mysqli_query($link,$qryet);
$pdf->SetXY(70,75);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(70,10,'SOLICITUD ETIQUETAS',0,0,'C');
$pdf->SetXY(40,85);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,5,'Id', 0,0,'C');
$pdf->Cell(90,5,'Etiqueta ', 0,0,'C');
$pdf->Cell(20,5,'Cantidad ',0,0,'C');
$pdf->SetXY(40,90);
$pdf->SetLeftMargin(40);

$pdf->SetFont('Arial','',10);
while($rowet=mysqli_fetch_array($resultet))
{
$n_etiq=$rowet['Nom_etiq'];
$pdf->Cell(10,4,$i,0,0,'C');
$pdf->Cell(90,4,$n_etiq,0,0,'L');
$pdf->Cell(20,4,'______',0,1,'C');
$i= $i+1 ;
}
$pdf->SetLeftMargin(10);
$pdf->SetXY(10,105);
$pdf->Cell(0,10,'Solicita: ______________________________________   Aprueba: __________________________________',0,0,'C');
$pdf->SetXY(70,115);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(70,10,'ENVASADO',0,0,'C');
$pdf->SetXY(40,125);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,8,'Código', 0,0,'C');
$pdf->Cell(100,8,'Presentación de Producto ', 0,0,'C');
$pdf->Cell(50,8,'Cantidad ',0,1,'C');
$pdf->SetFont('Arial','',10);
$qryenv="SELECT Cod_prese, Nombre FROM prodpre where Cod_produc=$cod_prod and pres_activo=0;";
$resultenv=mysqli_query($link,$qryenv);
while($rowenv=mysqli_fetch_array($resultenv))
{
$cod_pres=$rowenv['Cod_prese'];
$prod_pres=$rowenv['Nombre'];
$pdf->Cell(25);
$pdf->Cell(20,5,$cod_pres,0,0,'C');
$pdf->Cell(100,5,$prod_pres,0,0,'R');
//$pdf->Cell(100,5,'Cera Polimérica Económica Nova Sin Fragancia por 5 Galones',0,0,'R');
$pdf->Cell(40,5,'__________',0,0,'C');
$pdf->Ln(5);
}
$pdf->SetXY(70,175);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(70,10,'CONTROL DE CALIDAD PRODUCTO TERMINADO',0,0,'C');
$pdf->SetXY(10,185);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,5,'No. Muestra', 1,0,'C');
$pdf->Cell(80,5,'Etiquetado', 1,0,'C');
$pdf->Cell(80,5,'Envasado',1,1,'C');
$pdf->SetFont('Arial','',10);
for ($b = 1; $b <= 8; $b++)
{
  $pdf->Cell(25,5,$b, 1,0,'C');
  $pdf->Cell(80,5,'Cumple [  ]  No cumple [  ]', 1,0,'C');
  $pdf->Cell(80,5,'Cumple [  ]  No cumple [  ]',1,1,'C');
}





$pdf->SetY(-50);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,8,'Observaciones:');
$pdf->Line(10,240,200,240);
$pdf->Line(10,248,200,248);
$pdf->Line(10,256,200,256);
//mysqli_free_result($result);
mysqli_free_result($resultord);
mysqli_free_result($resultenv);
/* cerrar la conexión */
mysqli_close($link);
$pdf->Output();
?>
