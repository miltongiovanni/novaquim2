<?php
include "includes/valAcc.php";
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
	$this->Cell(70,10,'ORDEN DE PRODUCCIÓN',0,0,'C');
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
	$this->Cell(0,10,'Verificó: ______________________________________   Aprobó: __________________________________',0,0,'C');
}
}

//Creación del objeto de la clase heredada
include "includes/conect.php";
$link=conectarServidor();
$Lote=$_POST['Lote'];
$qryord="select Lote, Fch_prod, Cant_kg, Cod_persona,ord_prod.Cod_prod as Codigo, Nom_produc, Nom_form, nom_personal, Den_min, Den_max ,pH_min, pH_max, Fragancia, Color, Apariencia
		from ord_prod, formula, productos, personal
		WHERE ord_prod.Id_form=formula.Id_form and formula.Cod_prod=productos.Cod_produc
		and ord_prod.Cod_persona=personal.Id_personal and Lote=$Lote;";
$resultord=mysqli_query($link,$qryord);
$roword=mysqli_fetch_array($resultord);
$cod_prod=$roword['Codigo'];
$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
$pdf->SetXY(10,55);
$pdf->Cell(45,6,'Fecha de Producción : ');
$pdf->Cell(75,6,$roword['Fch_prod']);
$pdf->Cell(25,6,'No. de Lote: ');
$pdf->Cell(30,6,$roword['Lote'],0,1);
$pdf->Cell(20,6,'Producto : ');
$pdf->Cell(100,6,$roword['Nom_produc']);
$pdf->Cell(30,6,'Responsable : ');
$pdf->Cell(40,6,$roword['nom_personal'],0,1);
$pdf->Cell(20,6,'Fórmula : ');
$pdf->Cell(100,6,$roword['Nom_form']);
$pdf->Cell(30,6,'Cantidad (Kg): ');
$pdf->Cell(30,6,$roword['Cant_kg'],0,1);
$pdf->SetXY(15,75);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,5,'Orden', 0,0,'C');
$pdf->Cell(20,5,'Código', 0,0,'C');
$pdf->Cell(60,5,'Materia Prima ', 0,0,'C');
$pdf->Cell(20,5,'Lote M Prima ', 0,0,'C');
$pdf->Cell(40,5,'Cantidad (Kg)',0,0,'C');
$pdf->Cell(40,5,'Cantidad Usada(Kg)',0,1,'C');
$pdf->SetFont('Arial','',10);
$qry="SELECT Nom_mprima, Can_mprima, det_ord_prod.Cod_mprima as codigo, Lote_MP, Cod_nvo_mprima, alias FROM det_ord_prod, mprimas  where Lote=$Lote AND det_ord_prod.Cod_mprima=mprimas.Cod_mprima order by Orden;";
$result=mysqli_query($link,$qry);
$i=1;
$pdf->SetXY(10,80);
while($row=mysqli_fetch_array($result))
{
$codmp=$row['Cod_nvo_mprima'];
$mprima=$row['alias'];
$gasto=$row['Can_mprima'];
$lote_mp=$row['Lote_MP'];
$pdf->Cell(5);
$pdf->Cell(10,5,$i,0,0,'C');
$pdf->Cell(20,5,$codmp,0,0,'C');
$pdf->Cell(60,5,$mprima,0,0,'C');
$pdf->Cell(20,5,$lote_mp,0,0,'C');
$pdf->Cell(40,5,$gasto,0,0,'C');
$pdf->Cell(40,5,'________________',0,0,'C');
$pdf->Ln(5);
$i= $i+1 ;
}

$pdf->SetXY(10,165);
$pdf->Cell(0,10,'Elaboró: ______________________________________',0,0,'L');
$pdf->SetFont('Arial','B',16);
$pdf->SetXY(70,180);
$pdf->Cell(70,10,'CONTROL DE CALIDAD',0,0,'C');
$pdf->SetXY(10,190);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(80,8,'Propiedad', 0,0,'C');
$pdf->Cell(60,8,'Especificación', 0,0,'C');
$pdf->Cell(30,8,'Valor ',0,0,'C');
$pdf->Ln(5);
$pdf->SetFont('Arial','',10);
$pdf->Cell(80,8,'pH:', 0,0,'C');
$pdf->Cell(30,8,'Max: '.$roword['pH_max'], 0,0,'C');
$pdf->Cell(30,8,'Min: '.$roword['pH_min'],0,0,'C');
$pdf->Cell(30,8,'______________',0,0,'C');
$pdf->Ln(5);
$pdf->Cell(80,8,'Densidad:', 0,0,'C');
$pdf->Cell(30,8,'Max: '.$roword['Den_max'], 0,0,'C');
$pdf->Cell(30,8, 'Min: '.$roword['Den_min'],0,0,'C');
$pdf->Cell(30,8,'______________',0,0,'C');
$pdf->Ln(5);
$pdf->Cell(80,8,'Olor:', 0,0,'C');
$pdf->Cell(60,8, $roword['Fragancia'], 0,0,'C');
$pdf->Cell(30,8,'CUMPLE [  ]',0,0,'C');
$pdf->Ln(5);
$pdf->Cell(80,8,'Color:', 0,0,'C');
$pdf->Cell(60,8,$roword['Color'], 0,0,'C');
$pdf->Cell(30,8,'CUMPLE [  ]',0,0,'C');
$pdf->Ln(5);
$pdf->Cell(80,8,'Apariencia:', 0,0,'C');
$pdf->Cell(60,8, $roword['Apariencia'], 0,0,'C');
$pdf->Cell(30,8,'CUMPLE [  ]',0,0,'C');

$pdf->SetFont('Arial','',10);
$qryenv="SELECT Cod_prese, Nombre FROM prodpre where Cod_produc=$cod_prod and pres_activo=0;";
$resultenv=mysqli_query($link,$qryenv);


/*
while($rowenv=mysqli_fetch_array($resultenv))
{
$cod_pres=$rowenv['Cod_prese'];
$prod_pres=$rowenv['Nombre'];
$pdf->Cell(25);
$pdf->Cell(20,5,$cod_pres,0,0,'C');
$pdf->Cell(100,5,$prod_pres,0,0,'R');
//$pdf->Cell(100,5,'Cera Polimérica Económica Nova Sin Fragancia por 5 Galones',0,0,'R');
$pdf->Cell(40,5,'________________',0,0,'C');
$pdf->Ln(5);
}*/
$pdf->SetY(-50);
$pdf->Cell(10,8,'Observaciones:');
$pdf->Line(10,240,200,240);
$pdf->Line(10,248,200,248);
$pdf->Line(10,256,200,256);
mysqli_free_result($result);
mysqli_free_result($resultord);
mysqli_free_result($resultenv);
/* cerrar la conexión */
mysqli_close($link);
$pdf->Output();
?>
