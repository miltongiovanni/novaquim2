<?php
include "../includes/valAcc.php";
?>
<?php
require('fpdf.php');
include "includes/conect.php";
include "includes/num_letra.php";
$mensaje=$_POST['nota'];

class PDF extends FPDF
{
  //Cabecera de página
  function Header()
  {
	  $mensaje=$_POST['nota'];
	  //Logo
	  $yearIni=date("Y");
	  $this->Image('images/LogoNova.jpg',10,05,43);
	  //Arial bold 15
	  $this->SetFont('Arial','B',10);
	  //Movernos a la derecha
	  $this->SetXY(80,14);
	  $this->Cell(40,4,'INDUSTRIAS NOVAQUIM S.A.S.',0,0,'C');
	  $this->SetXY(80,18);
	  $this->Cell(40,4,'NIT 900.419.629-7',0,0,'C');
	  $this->SetXY(80,22);
	  $this->Cell(40,4,'ICA Tarifa 11.04 por Mil',0,0,'C');
	  $this->SetFont('Arial','B',14);
	  //Movernos a la derecha
	  //Título
	  $this->SetXY(135,14);
	  $this->Cell(70,10,'NOTA CRÉDITO No. '.$mensaje.'-'.$yearIni,0,0,'C');
  }
  //Pie de página
  function Footer()
  {
	  //Posición: a 1,5 cm del final
	  $this->SetY(-15);
	//Arial italic 8
	$this->SetFont('Arial','',8);
	//Número de página
	$this->Cell(0,10,'Dirección: Calle 35 C Sur No. 26F - 40  PBX: 2039484 - 2022912  Website:www.novaquim.com   E-mail: info@novaquim.com',0,0,'C');
  }
}



$link=conectarServidor();
$qryenc="select Nota, Nit_cliente, Fecha, Fac_orig, Fac_dest, motivo, Total, Subtotal, IVA, nomCliente, telCliente, dirCliente, Ciudad from nota_c, clientes, ciudades where Nota=$mensaje and Nit_cliente=nitCliente and ciudadCliente=IdCiudad";
$resultenc=mysqli_query($link,$qryenc);
$rowenc=mysqli_fetch_array($resultenc);
$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$pdf->SetXY(10,30);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,3.5,'CLIENTE:',0, 0, 'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(110,3.5,$rowenc['Nom_clien']);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(35,3.5,'FECHA:',0 , 0, 'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(35,3.5,$rowenc['Fecha'],0,1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,3.5,'NIT:',0, 0, 'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(110,3.5,$rowenc['Nit_cliente']);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(35,3.5,'FACT ORIGEN NOTA:',0, 0, 'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(35,3.5,$rowenc['Fac_orig'],0,1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,3.5,'DIRECCIÓN:',0, 0, 'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(110,3.5,$rowenc['Dir_clien']);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(35,3.5,'FACT AFECTA NOTA:',0 , 0, 'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(35,3.5,$rowenc['Fac_dest'],0,1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,3.5,'TELÉFONO:',0, 0, 'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(110,3.5,$rowenc['Tel_clien']);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(35,3.5,'CIUDAD:',0 , 0, 'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(35,3.5,$rowenc['Ciudad'],0,1);
$pdf->SetFont('Arial','B',10);
$motivo=$rowenc['motivo'];
$Fac_orig=$rowenc['Fac_orig'];	
$Fac_dest=$rowenc['Fac_dest'];	
$qryffacor="select fechaFactura as FechFactOr from factura where Factura=$Fac_orig";
$resulffacor=mysqli_query($link,$qryffacor);
$rowffacor=mysqli_fetch_array($resulffacor);
$FechFactOr=$rowffacor['FechFactOr'];

$qryffacde="select fechaFactura as FechFactDe from factura where Factura=$Fac_dest";
$resulffacde=mysqli_query($link,$qryffacde);
$rowffacde=mysqli_fetch_array($resulffacde);
$FechFactDe=$rowffacde['FechFactDe'];

if ($motivo==0)
{
	$orden="Devolución";
	$qry="select det_nota_c.Cod_producto as codigo, Nombre as producto, det_nota_c.Can_producto as cantidad, tasa, Id_tasa, Des_fac_or, prec_producto as precio, (prec_producto*det_nota_c.Can_producto) AS subtotal FROM det_nota_c, nota_c, det_factura, prodpre, 	
	  tasa_iva
	  where Id_Nota=Nota and Id_Nota=$mensaje and det_nota_c.Cod_producto<100000 and Fac_orig=Id_fact AND det_nota_c.Cod_producto=det_factura.Cod_producto AND det_nota_c.Cod_producto=Cod_prese and Cod_iva=Id_tasa 
	  union
	  select det_nota_c.Cod_producto as codigo, Producto as producto, det_nota_c.Can_producto as cantidad, tasa, Id_tasa, Des_fac_or, prec_producto as precio, (prec_producto*det_nota_c.Can_producto) AS subtotal from det_nota_c, nota_c, det_factura, distribucion, 	
	  tasa_iva
	  where Id_Nota=Nota and Id_Nota=$mensaje and det_nota_c.Cod_producto>100000 AND Fac_orig=Id_fact AND det_nota_c.Cod_producto=det_factura.Cod_producto AND det_nota_c.Cod_producto=Id_distribucion and Cod_iva=Id_tasa ";
}
else
{
	$orden="Descuento no aplicado";
	$qry="select Cod_producto as codigo, 0 as Des_fac_or,  CONCAT ('Descuento de ', Can_producto, ' % no concedido en la Factura No. ', Fac_orig) as producto, det_nota_c.Can_producto as cantidad, (select 0) as tasa, Factura.Subtotal*Can_producto/100 AS 	precio,  	  Factura.Subtotal*Can_producto/100 AS subtotal  
	  from det_nota_c, nota_c, factura where Id_Nota=Nota and Id_Nota=$mensaje AND Fac_orig=Factura;";
}
$pdf->Cell(25,3.5,'MOTIVO:',0, 0, 'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(110,3.5,$orden);
/*$pdf->SetFont('Arial','B',10);
$pdf->Cell(35,3.5,$pago,0,1);*/
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(10,51);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,4,'CÓDIGO', 1,0,'C');
$pdf->Cell(100,4,'PRODUCTO ', 1,0,'C');
$pdf->Cell(10,4,'CAN ', 1,0,'C');
$pdf->Cell(10,4,'IVA ', 1,0,'C');
$pdf->Cell(22,4,'VR. UNIT ',1,0,'C');
$pdf->Cell(25,4,'SUBTOTAL ', 1,0,'C');
$pdf->SetFont('Arial','',10);

$result=mysqli_query($link,$qry);
$pdf->SetXY(10,55);
$subtotal=0;
$descuento=0;
$iva10=0;
$iva16=0;
while($row=mysqli_fetch_array($result))
{
$codprod=$row['codigo'];
$prod=$row['producto'];
$cant=$row['cantidad'];
$iva=$row['tasa']*100;
if ($rowenc['motivo']<>0)
{
	$codprod=NULL;
	$cant=NULL;
	$iva=NULL;
	if ($FechFactOr<FECHA_C)
	$iva16=$row['subtotal']*0.16;
	else
	$iva16=$row['subtotal']*0.19;
}
  		  





$subtotal += $row['subtotal'];
$descuento+= $row['cantidad']*$row['precio']*$row['Des_fac_or'];
$Prec=number_format($row['precio'], 0, '.', ',');
$tot=number_format($row['subtotal'], 0, '.', ',');
if ($row['tasa']==0.05)
	$iva10 += $row['cantidad']*$row['precio']*$row['tasa']*(1-$row['Des_fac_or']);
	
	
if ($FechFactOr<FECHA_C)
		{
			if ($row['Id_tasa']==3)
			$iva16 += $row['cantidad']*$row['precio']*0.16*(1-$row['Des_fac_or']);
		}
		else
		{
		if ($row['Id_tasa']==3)
			$iva16 += $row['cantidad']*$row['precio']*$row['tasa']*(1-$row['Des_fac_or']);
		}	  		  
$pdf->Cell(25,4,$codprod,0,0,'C');
$pdf->Cell(100,4,$prod,0,0,'L');
$pdf->Cell(10,4,$cant,0,0,'C');
$pdf->Cell(10,4,"$iva %",0,0,'C');
$pdf->Cell(22,4,"$ $Prec",0,0,'R');
$pdf->Cell(25,4,"$ $tot",0,0,'R');
$pdf->Ln(4);
}
$Iva_10=number_format($iva10, 0, '.', ',');
$Iva_16=number_format($iva16, 0, '.', ',');
$Sub=number_format($subtotal, 0, '.', ',');
$Des=number_format($descuento, 0, '.', ',');
$Total= $subtotal-$descuento+$iva10+$iva16;
$Tot=number_format($Total, 0, '.', ',');
$num_letra=numletra(round($Total));
$pdf->SetFont('Arial','',10);
$pdf->SetXY(10,-42);
$pdf->Cell(140,21,'',1);
$pdf->SetXY(10,-42);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(33,5,'SON:');
$pdf->SetFont('Arial','',10);
$pdf->SetXY(10,-38);
$pdf->MultiCell(135,4,$num_letra,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->SetXY(155,-42);
$pdf->Cell(50,21,'',1);
$pdf->SetXY(155,-42);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,5,'SUBTOTAL',0,0,'R');
$pdf->Cell(25,5,"$ $Sub",0,0,'R');
$pdf->SetXY(155,-38);
$pdf->Cell(25,5,'DESCUENTO',0,0,'R');
$pdf->Cell(25,5,"$ $Des",0,0,'R');
$pdf->SetXY(155,-34);
$pdf->Cell(25,5,'IVA 05%',0,0,'R');
$pdf->Cell(25,5,"$ $Iva_10",0,0,'R');
$pdf->SetXY(155,-30);
if ($FechFactOr<FECHA_C)
$pdf->Cell(25,5,'IVA 16%',0,0,'R');
else
$pdf->Cell(25,5,'IVA 19%',0,0,'R');
$pdf->Cell(25,5,"$ $Iva_16",0,0,'R');
$pdf->SetXY(155,-26);
$pdf->Cell(25,5,'TOTAL',0,0,'R');
$pdf->Cell(25,5,"$ $Tot",0,0,'R');
mysqli_close($link);
$pdf->Output();
?>
