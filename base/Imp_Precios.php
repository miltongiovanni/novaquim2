<?php
include "includes/valAcc.php";
?><?php
require('fpdf.php');
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
class PDF extends FPDF
{
  //Cabecera de página
  function Header()
  {
	   if($this->PageNo()==1)
	  {
		  //Logo
		  //{$this->Image('images/LogoNova.jpg',15,15, 15, 65);}
		  //$this->Image('images/LogoNova1.jpg',15,15,65);
		  //Arial bold 15
		  /*$this->SetFont('Arial','B',16);
		  //Movernos a la derecha
		  $this->SetXY(70,45);
		  //Título
		  $this->Cell(70,10,'ORDEN DE PEDIDO',0,0,'C');
		  //Salto de línea
		  $this->Ln(20);*/
	  }
  }

  //Pie de página
  function Footer()
  {
	  //Posición: a 1,5 cm del final
	  $this->SetY(-15);
	  //Arial italic 8
	  $this->SetFont('Arial','',8);
	  //Número de página
	  $this->Cell(0,10,'Dirección: Bogotá D.C. Calle 35 C Sur No. 26 F - 40  PBX: 2039484 - 2022912  Website:www.novaquim.com   E-mail: info@novaquim.com',0,0,'C');
  }
}

//Creación del objeto de la clase heredada
include "includes/conect.php";
$link=conectarServidor();
$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(15,4,"LISTA DE PRECIOS INDUSTRIAS NOVAQUIM  VIGENCIA HASTA ENERO 31 DE 2015",0,0,'L');
$pdf->Ln(4);
$pdf->Cell(15,4,"Código",1,0,'C');
$pdf->Cell(80,4,"Producto",1,0,'C');
$opciones = explode(",", $opciones_prec1);
$b=count($opciones);
for ($k = 0; $k < $b; $k++) 
{
	$pdf->Cell(20,4,$opciones[$k],1,0,'C');
} 
$pdf->Ln(4);
$pdf->SetFont('Arial','',9);
$result=mysqli_query($link,$query);
$fields=mysqli_num_fields($result);
$i=1;
while($row=mysqli_fetch_array($result))
{
	$cod=$row[0]; 
	$producto=$row[1];  
	$pdf->Cell(15,3.5,$cod,1,0,'C');
	$pdf->Cell(80,3.5,$producto,1,0,'L');
	
	for ($j = 4; $j < $fields; $j++) 
	{
		$pdf->Cell(20,3.5,'$ '.number_format($row[$j]),1,0,'R');
	} 
	$pdf->Ln(3.5);
}
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
$pdf->Output();


?>
