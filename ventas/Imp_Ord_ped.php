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
	  //$this->SetFont('Arial','B',16);
	  //Movernos a la derecha
	  //$this->SetXY(70,43);
	  //Título
	  //$this->Cell(70,10,'ORDEN DE PEDIDO',0,0,'C');
	  //Salto de línea
	  $this->Ln(10);
  }
  //Pie de página
  function Footer()
  {
	  //Posición: a 1,5 cm del final
	  $this->SetY(-15);
	  //Arial italic 8
	  $this->SetFont('Arial','',10);
	  //Número de página
	  $this->Cell(0,10,'Elaboró: ______________________________________   Aprobó: __________________________________',0,0,'C');
  }
}

//Creación del objeto de la clase heredada
include "includes/conect.php";
$link=conectarServidor();
$pedido=$_POST['pedido'];
$qryord="Select nom_clien, Id_pedido, Fech_pedido, Fech_entrega, Cod_vend, nom_personal, tipo_precio, pedido.Estado, Nom_sucursal, Dir_sucursal, Tel_clien 
		FROM pedido, personal, clientes, tip_precio, clientes_sucursal 
		where Cod_vend=Id_personal and Id_pedido=$pedido and clientes.nit_clien=nit_cliente and Id_precio=tip_precio and Id_sucurs=Id_sucursal and clientes_sucursal.Nit_clien=Nit_cliente";
$resultord=mysqli_query($link,$qryord);
$roword=mysqli_fetch_array($resultord);
//$cod_prod=$roword['Codigo'];
$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetXY(10, 10);
$pdf->SetFont('Arial','',8);
$encabfecha='USUARIO: '.$_SESSION['User'].'     |   FECHA: '.date('d-m-Y  h:i:s');
date_default_timezone_set('America/Bogota');
$pdf->Cell(90,10,$encabfecha,0,0,'L');


$pdf->SetXY(70, 43);
$pdf->SetFont('Arial','B',16);
$pdf->Cell(70,10,'ORDEN DE PEDIDO No.'.$pedido,0,0,'C');
$pdf->SetFont('Arial','',10);
$pdf->SetXY(10,55);
$pdf->Cell(35,5,'Cliente: ');
$pdf->Cell(90,5,$roword['nom_clien']);
$pdf->Cell(30,5,'Teléfono: ');
$pdf->Cell(30,5,$roword['Tel_clien'],0,1);
$pdf->Cell(35,5,'Lugar de Entrega: ');
$pdf->Cell(90,5,$roword['Nom_sucursal']);
$pdf->Cell(30,5,'Fecha de Pedido: ');
$pdf->Cell(30,5,$roword['Fech_pedido'],0,1);
$pdf->Cell(35,5,'Dirección de Entrega: ');
$pdf->Cell(90,5,$roword['Dir_sucursal']);
$pdf->Cell(30,5,'Fecha de Entrega:');
$pdf->Cell(30,5,$roword['Fech_entrega'],0,1);
$pdf->SetXY(30,75);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,5,'Item', 0,0,'C');
$pdf->Cell(20,5,'Codigo ', 0,0,'R');
$pdf->Cell(100,5,'Producto ', 0,0,'C');
$pdf->Cell(10,5,'Unidades ',0,0,'C');
$pdf->SetFont('Arial','',10);
$qry="SELECT Cod_producto, Can_producto, Nombre as Producto from det_pedido, prodpre 
where Cod_producto=Cod_prese and Id_Ped=$pedido and Cod_producto <100000 and Cod_producto>100 order by Producto";
$result=mysqli_query($link,$qry);
$i=1;
$pdf->SetXY(10,80);
while($row=mysqli_fetch_array($result))
{
$codprod=$row['Cod_producto'];
$prod=$row['Producto'];
$cant=$row['Can_producto'];
$pdf->Cell(20);
$pdf->Cell(10,4,$i,0,0,'C');
$pdf->Cell(20,4,$codprod,0,0,'R');
$pdf->Cell(100,4,$prod,0,0,'L');
$pdf->Cell(10,4,$cant,0,0,'C');
$pdf->Ln(4);
$i= $i+1 ;
}
$qry="select Cod_producto, Can_producto, Producto from det_pedido, distribucion 
where Cod_producto=Id_distribucion and Id_Ped=$pedido and Cod_producto >=100000 order by Producto;";
$result=mysqli_query($link,$qry);
while($row=mysqli_fetch_array($result))
{
$codprod=$row['Cod_producto'];
$prod=$row['Producto'];
$cant=$row['Can_producto'];
$pdf->Cell(20);
$pdf->Cell(10,4,$i,0,0,'C');
$pdf->Cell(20,4,$codprod,0,0,'R');
$pdf->Cell(100,4,$prod,0,0,'L');
$pdf->Cell(10,4,$cant,0,0,'C');
$pdf->Ln(4);
$i= $i+1 ;
}
$qry="select Id_ped, Cod_producto, DesServicio as Producto, Can_producto, Prec_producto as Precio
 from det_pedido, servicios 
 where Cod_producto<100 and Cod_producto=IdServicio and Id_ped=$pedido";
$result=mysqli_query($link,$qry);
while($row=mysqli_fetch_array($result))
{
$codprod=$row['Cod_producto'];
$prod=$row['Producto'];
$cant=$row['Can_producto'];
$pdf->Cell(20);
$pdf->Cell(10,4,$i,0,0,'C');
$pdf->Cell(20,4,$codprod,0,0,'R');
$pdf->Cell(100,4,$prod,0,0,'L');
$pdf->Cell(10,4,$cant,0,0,'C');
$pdf->Ln(4);
$i= $i+1 ;
}
$pdf->SetFont('Arial','',10);
$pdf->SetY(-35);
$pdf->Cell(10,8,'Observaciones:');
$pdf->Line(10,255,200,255);
$pdf->Line(10,260,200,260);
mysqli_close($link);
$pdf->Output();
?>
