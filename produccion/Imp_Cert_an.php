<?php
include "includes/valAcc.php";
?>
<?php
require('fpdf.php');

class PDF extends FPDF
{
//Cabecera de p�gina
function Header()
{
	//Logo
	$this->Image('images/LogoNova.jpg',22,12,46,23);
	//Arial bold 15
	$this->SetFont('Arial','B',16);
	//Movernos a la derecha
	$this->SetXY(70,55);
	//T�tulo
	$this->Cell(70,10,'CERTIFICADO DE AN�LISIS',0,0,'C');
	//Salto de l�nea
	$this->Ln(20);
}

//Pie de p�gina
function Footer()
{
	//Posici�n: a 1,5 cm del final
	$this->SetY(-12);
	//Arial italic 8
	$this->SetFont('Arial','',8);
	//N�mero de p�gina
	$this->Cell(0,10,'Calle 35 C sur No. 26 F - 40 Bogot� D.C. Colombia - Tel�fono: (571) 2039484 - (571) 2022912 e-mail: info@novaquim.com',0,0,'C');
}
}

//Creaci�n del objeto de la clase heredada
include "includes/conect.php";
$link=conectarServidor();
$Lote=$_POST['Lote'];
$qryord="select Lote, Fch_prod, Cant_kg, Cod_persona, ord_prod.Cod_prod as Codigo, Nom_produc, Nom_form, nom_personal, Den_min, Den_max ,pH_min, pH_max, Fragancia, Color, Apariencia, venc 
		from ord_prod, formula, productos, personal
		WHERE ord_prod.Id_form=formula.Id_form and formula.Cod_prod=productos.Cod_produc
		and ord_prod.Cod_persona=personal.Id_personal and Lote=$Lote;";
$resultord=mysqli_query($link,$qryord);
$roword=mysqli_fetch_array($resultord);
$cod_prod=$roword['Codigo'];
$qrycal="select den_prod,ph_prod,ol_prod,col_prod,ap_prod,Obs_prod from cal_producto where Lote=$Lote;";
$resultcal=mysqli_query($link,$qrycal);
$rowcal=mysqli_fetch_array($resultcal);




$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
$pdf->SetXY(20,10);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(50,30,'',1,0,'C');
$pdf->Cell(65,10,'GERENCIA DE CALIDAD',1,0,'C');
$pdf->SetFont('Arial','B',11);
$pdf->Cell(65,10,'C�DIGO: FT-CA-01',1,0,'C');
$pdf->SetXY(70,20);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(65,20,'CERTIFICADO DE AN�LISIS',1,0,'C');
$pdf->SetFont('Arial','B',11);
$pdf->Cell(65,10,'Fecha Expedici�n: '.$roword['Fch_prod'],1,0,'C');
$encabfecha=date('Y-m-d');
date_default_timezone_set('America/Bogota');
$pdf->SetXY(135,30);
$pdf->Cell(65,10,'Fecha Impresi�n: '.$encabfecha,1,0,'C');






$pdf->SetXY(10,80);
$pdf->SetLeftMargin(20);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(42,6,'No. de Lote: ',0,0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(30,6,$roword['Lote'],0,1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(42,6,'Producto : ',0,0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(100,6,$roword['Nom_produc'],0,1,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(42,6,'Cantidad (Kg): ',0,0, 'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(30,6,$roword['Cant_kg'],0,1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(42,6,'Fecha de Producci�n : ',0,0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(75,6,$roword['Fch_prod'],0,1,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(42,6,'Fecha de Vencimiento : ',0,0,'R');
$pdf->SetFont('Arial','',10);

$fechap=$roword['Fch_prod'];
$venc=$roword['venc'];
$nuevafecha = strtotime ( '+'.$venc.' day' , strtotime ( $fechap ) ) ;
$nuevafecha = date ( 'Y-m-j' , $nuevafecha );
$pdf->Cell(75,6,$nuevafecha,0,1,'L');



$pdf->SetXY(20,125);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(50,5,'AN�LISIS','B',0,'C');
$pdf->Cell(80,5,'ESPECIFICACIONES', 'B',0,'C');
$pdf->Cell(50,5,'RESULTADO', 'B',1,'C');
$pdf->SetFont('Arial','',10);
$pdf->Cell(50,5,'APARIENCIA ','B',0,'C');
$pdf->Cell(80,5,$roword['Apariencia'], 'B',0,'C');
if($rowcal['ap_prod']==0) 
	$ap="CUMPLE";
else
	$ap="NO CUMPLE";
$pdf->Cell(50,5,$ap, 'B',1,'C');
$pdf->Cell(50,5,'OLOR ','B',0,'C');
$pdf->Cell(80,5,$roword['Fragancia'], 'B',0,'C');
if($rowcal['ol_prod']==0) 
	$ol="CUMPLE";
else
	$ol="NO CUMPLE";
$pdf->Cell(50,5,$ol, 'B',1,'C');
$pdf->Cell(50,5,'COLOR ','B',0,'C');
$pdf->Cell(80,5,$roword['Color'], 'B',0,'C');
if($rowcal['col_prod']==0) 
	$col="CUMPLE";
else
	$col="NO CUMPLE";
$pdf->Cell(50,5,$col, 'B',1,'C');
$pdf->Cell(50,5,'pH','B',0,'C');
$pdf->Cell(80,5,$roword['pH_min'].' - '.$roword['pH_max'], 'B',0,'C');
$pdf->Cell(50,5,$rowcal['ph_prod'], 'B',1,'C');
$pdf->Cell(50,5,'DENSIDAD (g/ml)','B',0,'C');
$pdf->Cell(80,5,$roword['Den_min'].' - '.$roword['Den_max'], 'B',0,'C');
$pdf->Cell(50,5,$rowcal['den_prod'], 'B',1,'C');

$qrycc="select CONCAT(Nombre,' ',Apellido) as nombre, Descripcion from tblusuarios, tblperfiles where EstadoUsuario=2 and tblusuarios.IdPerfil=tblperfiles.IdPerfil and tblusuarios.IdPerfil=9 ;";
$resultcc=mysqli_query($link,$qrycc);
$rowcc=mysqli_fetch_array($resultcc);
$nom=$rowcc['nombre'];
$pefil=$rowcc['Descripcion'];




$pdf->SetXY(20,175);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,5,'Observaciones:', 0,1);
$pdf->Cell(180,5,$rowcal['Obs_prod'], 0,1);
$pdf->Image('images/calidad.gif',22,200,46,23);
$pdf->SetXY(20,220);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(60,5,'I.Q. '.$nom, 'T',1);
$pdf->Cell(60,5,$pefil, 0,1);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(20,240);
$pdf->MultiCell(0,3,'La informaci�n facilitada en este documento se considera v�lida desde la fecha de su emisi�n y hasta su sustituci�n por otra nueva.  Est� basada en nuestros conocimientos y experiencias actuales y se refiere �nicamente al producto especificado.
Sin embargo, dados los numerosos factores que est�n fuera de nuestro control y que pueden afectar la manipulaci�n y empleo de los producto, INDUSTRIAS NOVAQUIM S.A.S. no asume ninguna responsabilidad ni obligaci�n por las recomendaciones efectuadas, ya sea en cuanto a los resultados obtenidos o por los prejuicios o da�os que se derivaran de su utilizaci�n.', 0,1);


mysqli_free_result($resultord);
/* cerrar la conexi�n */
mysqli_close($link);
$pdf->Output();
?>