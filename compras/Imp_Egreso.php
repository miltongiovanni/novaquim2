<?php
include "includes/valAcc.php";
?>
<?php
require('fpdf.php');
include "includes/conect.php";
include "includes/num_letra.php";
$link=conectarServidor();
$egreso=$_POST['egreso'];
$qryenc="select egreso.Id_compra, nit_prov, Num_fact, total_fact, retencion_g as retencion, Nom_provee, Id_egreso, tip_compra, pago, Fecha, descuento_e, egreso.form_pago, forma_pago, ret_ica
from egreso,  gastos, proveedores, form_pago where nit_prov=NIT_provee and Id_egreso=$egreso and egreso.Id_compra=Id_gasto and tip_compra=6 and egreso.form_pago=Id_fpago
union
select egreso.Id_compra, nit_prov, Num_fact, total_fact, retencion, Nom_provee, Id_egreso, tip_compra, pago, Fecha, descuento_e, egreso.form_pago, forma_pago, ret_ica
from egreso,  compras, proveedores, form_pago where nit_prov=NIT_provee and Id_egreso=$egreso and egreso.Id_compra=compras.Id_compra and tip_compra<>6 and egreso.form_pago=Id_fpago;";
$resultenc=mysqli_query($link,$qryenc);
$rowenc=mysqli_fetch_array($resultenc);
$pdf=new FPDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(10, 10, 10);
$pdf->Image('images/LogoNova1.jpg',20,14, 44, 22);
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(70,20);
$pdf->Cell(65,4,'INDUSTRIAS NOVAQUIM S.A.S.',0,0, 'C');
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(145,20);
$pdf->Cell(50,4,'COMPROBANTE DE EGRESO',0,0, 'C');
$pdf->SetXY(70,24);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(65,4,'NIT 900.419.629-7',0 , 0, 'C');
$pdf->SetXY(70,28);
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(65,3,'Calle 35 C Sur No. 26 F - 40'."\n".'Tels:2039484 - 2022912'."\n".'www.novaquim.com  info@novaquim.com',0 , 'C');
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(145,24);
$pdf->Cell(50,5,$egreso,0,0, 'C');
$pdf->SetXY(145,30);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(50,4,'FECHA COMPROBANTE',0,0, 'C');
$pdf->SetXY(145,34);
$pdf->SetFont('Arial','',10);
$pdf->Cell(50,4,$rowenc['Fecha'],0,0, 'C');
$pdf->SetXY(20,40);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(140,5,'Pagado a:','LTR', 0, 'L');
$pdf->SetXY(20,45);
$pdf->SetFont('Arial','',9);
$pdf->Cell(140,5,$rowenc['Nom_provee'],'LBR',0,'L');
$pdf->SetXY(160,40);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(40,5,'N.I.T. / C.C.','TR', 0, 'L');
$pdf->SetXY(160,45);
$pdf->SetFont('Arial','',9);
$pdf->Cell(40,5,$rowenc['nit_prov'],'BR',0,'L');
$pdf->SetXY(20,50);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(160,5,'La Suma de :','LTR',0, 'L');
$pdf->Cell(20,5,'Pago :','LTR',0, 'L');
$pdf->SetXY(20,55);
$pdf->SetFont('Arial','',8);
$pago=$rowenc['pago'];
$num_letra=numletra(round($pago));
$pdf->Cell(160,5,$num_letra,'LBR', 0, 'L');
$Pag=number_format($pago, 0, '.', ',');
$pdf->Cell(20,5,'$ '.$Pag,'LBR', 0, 'L');
$pdf->SetXY(20,60);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(65,5,'Por concepto de :','LTR',0, 'L');
$pdf->Cell(25,5,'Total Factura :','LTR',0, 'L');
$pdf->Cell(20,5,'Retefuente :','LTR',0, 'L');
$pdf->Cell(20,5,'Reteica :','LTR',0, 'L');
$pdf->Cell(20,5,'Descuento :','LTR',0, 'L');
$pdf->Cell(30,5,'Total Pagado :','LTR',0, 'L');
$retencion=$rowenc['retencion'];
$ret_ica=$rowenc['ret_ica'];
$Total=$rowenc['total_fact'];
$Factura=$rowenc['Num_fact'];
$TotalP=$Total-$retencion-$ret_ica;
$descuento_e=$rowenc['descuento_e'];
$DESC=number_format($descuento_e, 0, '.', ',');
if (($Total-$retencion-$ret_ica)< $pago)
$concepto="Abono a Factura ";
else
$concepto="Cancelaci�n de Factura ";
$concepto.= $Factura;
$pdf->SetXY(20,65);
$pdf->SetFont('Arial','',9);
$pdf->Cell(65,5,$concepto,'LBR', 0, 'L');
$RIca=number_format($ret_ica, 0, '.', ',');
$Tot=number_format($Total, 0, '.', ',');
$Rfte=number_format($retencion, 0, '.', ',');
$DESC=number_format($descuento_e, 0, '.', ',');
$TotP=number_format($TotalP, 0, '.', ',');
$pdf->Cell(25,5,'$ '.$Tot,'LBR', 0, 'L');
$pdf->Cell(20,5,'$ '.$Rfte,'LBR', 0, 'L');
$pdf->Cell(20,5,'$ '.$RIca,'LBR', 0, 'L');
$pdf->Cell(20,5,'$ '.$DESC,'LBR', 0, 'L');
$pdf->Cell(30,5,'$ '.$TotP,'LBR', 0, 'L');
$pdf->SetXY(20,70);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(100,5,'FORMA DE PAGO','LTR',0, 'C');
//$pdf->SetXY(20,75);
//$pdf->Cell(100,5,'','LBR',0, 'C');
$pdf->SetXY(20, 75);
$form_pago=$rowenc['form_pago']; 
$pdf->SetFont('Arial','B',9);
$pdf->Cell(14,5,'Efectivo', 'LBT',0, 'L');
if ($form_pago==0)
$pdf->Cell(5,5,'X', 'BTR',0, 'C');
else
$pdf->Cell(5,5,'', 'BTR',0, 'C');
$pdf->Cell(23,5,'Transferencia', 'LBT',0, 'L');
if ($form_pago==1)
$pdf->Cell(5,5,'X', 'BTR',0, 'C');
else
$pdf->Cell(5,5,'', 'BTR',0, 'C');
$pdf->Cell(20,5,'Nota Cr�dito', 'LBT',0, 'L');
if ($form_pago==2)
$pdf->Cell(5,5,'X', 'BTR',0, 'C');
else
$pdf->Cell(5,5,'', 'BTR',0, 'C');
$pdf->Cell(23,5,'Consignaci�n', 'LBT',0, 'L');
if ($form_pago==3)
$pdf->Cell(5,5,'X', 'BTR',0, 'C');
else
$pdf->Cell(5,5,'', 'BTR',0, 'C');
$pdf->SetXY(120,70);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(80,5,'Firma y Sello de Beneficiario','R',0, 'C');
$pdf->SetXY(120,75);
$pdf->Cell(80,45,'','LBR',0, 'C');
$pdf->SetXY(20,80);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(80,5,'OBSERVACIONES:',0,0, 'L');
$pdf->SetXY(20,80);
$pdf->Cell(100,40,'',1,0, 'L');

$pdf->SetXY(20,105);
$pdf->Cell(25,5,'Elaborado:',0,0, 'C');
$pdf->SetXY(20,105);
$pdf->Cell(25,15,'',1,0, 'L');

$pdf->SetXY(45,105);
$pdf->Cell(25,5,'Revisado:',0,0, 'C');
$pdf->SetXY(45,105);
$pdf->Cell(25,15,'',1,0, 'L');

$pdf->SetXY(70,105);
$pdf->Cell(25,5,'Aprobado:',0,0, 'C');
$pdf->SetXY(70,105);
$pdf->Cell(25,15,'',1,0, 'L');

$pdf->SetXY(95,105);
$pdf->Cell(25,5,'Contabilizado:',0,0, 'C');
$pdf->SetXY(95,105);
$pdf->Cell(25,15,'',1,0, 'L');

$pdf->SetXY(120,110);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(80,5,'_________________________________',0,0, 'C');
$pdf->SetXY(120,115);
$pdf->Cell(80,5,'C.C. / N.I.T. _______________________',0,0, 'C');
$pdf->Image('images/Proveedor.jpg',201,70, 3);













/*

$pdf->Image('images/LogoNova1.jpg',20,144, 50, 25);



$pdf->SetFont('Arial','B',12);
$pdf->SetXY(70,150);
$pdf->Cell(75,4,'INDUSTRIAS NOVAQUIM S.A.S.',0,0, 'C');
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(155,150);
$pdf->Cell(47,4,'RECIBO DE CAJA',0,0, 'C');
$pdf->SetXY(70,154);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(75,4,'NIT 900.419.629-7',0 , 0, 'C');
$pdf->SetXY(70,158);
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(75,3,'Calle 35 C Sur No. 26 F - 40'."\n".'Tels:2039484 - 2022912'."\n".'www.novaquim.com  info@novaquim.com',0 , 'C');
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(155,154);
$pdf->Cell(47,5,$Recibo,0,0, 'C');

$pdf->SetXY(155,160);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(47,4,'FECHA RECIBO',0,0, 'C');
$pdf->SetXY(155,164);
$pdf->SetFont('Arial','',10);
$pdf->Cell(47,4,$rowenc['Fecha'],0,0, 'C');





$pdf->SetXY(20,170);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(140,5,'Recib� de:','LTR', 0, 'L');
$pdf->SetXY(20,175);
$pdf->SetFont('Arial','',9);
$pdf->Cell(140,5,$rowenc['Nom_clien'],'LBR',0,'L');
$pdf->SetXY(160,170);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(40,5,'N.I.T. / C.C.','TR', 0, 'L');
$pdf->SetXY(160,175);
$pdf->SetFont('Arial','',9);
$pdf->Cell(40,5,$rowenc['Nit_cliente'],'BR',0,'L');
$pdf->SetXY(20,180);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(160,5,'La Suma de :','LTR',0, 'L');
$pdf->Cell(20,5,'Valor :','LTR',0, 'L');
$pdf->SetXY(20,185);
$pdf->SetFont('Arial','',8);
$pdf->Cell(160,5,$num_letra,'LBR', 0, 'L');
$pdf->Cell(20,5,'$ '.$Cob,'LBR', 0, 'L');
$pdf->SetXY(20,190);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(45,5,'Por concepto de :','LTR',0, 'L');
$pdf->Cell(25,5,'Total Factura :','LTR',0, 'L');
$pdf->Cell(20,5,'Subtotal :','LTR',0, 'L');
$pdf->Cell(20,5,'I.V.A. :','LTR',0, 'L');
$pdf->Cell(20,5,'Retefuente :','LTR',0, 'L');
$pdf->Cell(15,5,'Reteiva :','LTR',0, 'L');
$pdf->Cell(15,5,'Reteica :','LTR',0, 'L');
$pdf->Cell(20,5,'Descuento :','LTR',0, 'L');
if (($Total-$Reten_fte-$Reten_ica-$Reten_iva)< $cobro)
$concepto="Abono a Factura ";
else
$concepto="Cancelaci�n de Factura ";
$concepto.= $Factura;
$pdf->SetXY(20,195);
$pdf->SetFont('Arial','',9);
$pdf->Cell(45,5,$concepto,'LBR', 0, 'L');
$pdf->Cell(25,5,'$ '.$Tot,'LBR', 0, 'L');
$pdf->Cell(20,5,'$ '.$SubTot,'LBR', 0, 'L');
$pdf->Cell(20,5,'$ '.$IVAP,'LBR', 0, 'L');
$pdf->Cell(20,5,'$ '.$Rfte,'LBR', 0, 'L');
$pdf->Cell(15,5,'$ '.$Riva,'LBR', 0, 'L');
$pdf->Cell(15,5,'$ '.$Rica,'LBR', 0, 'L');
$pdf->Cell(20,5,'$ '.$DESC,'LBR', 0, 'L');
$pdf->SetXY(20,200);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(100,5,'FORMA DE PAGO','LTR',0, 'C');
$pdf->SetXY(20,205);
$pdf->Cell(100,5,'','LBR',0, 'C');
$pdf->SetXY(20,205);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20,5,'Cheque No. ', 1,0, 'L');
$pdf->SetFont('Arial','',9);
if ($NCheque>0)
$pdf->Cell(20,5,$NCheque, 1,0, 'L');
else
$pdf->Cell(20,5,'', 1,0, 'L');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(15,5,'Banco: ', 1,0, 'L');
$pdf->SetFont('Arial','',9);
if ($Cod_banco>0)
$pdf->Cell(45,5,$Banco, 1,0, 'L');
else
$pdf->Cell(45,5,'', 1,0, 'L');
$pdf->SetXY(20,210);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(14,5,'Efectivo', 'LBT',0, 'L');
if ($form_pago==0)
$pdf->Cell(5,5,'X', 'BTR',0, 'C');
else
$pdf->Cell(5,5,'', 'BTR',0, 'C');
$pdf->Cell(23,5,'Transferencia', 'LBT',0, 'L');
if ($form_pago==1)
$pdf->Cell(5,5,'X', 'BTR',0, 'C');
else
$pdf->Cell(5,5,'', 'BTR',0, 'C');
$pdf->Cell(20,5,'Nota Cr�dito', 'LBT',0, 'L');
if ($form_pago==2)
$pdf->Cell(5,5,'X', 'BTR',0, 'C');
else
$pdf->Cell(5,5,'', 'BTR',0, 'C');
$pdf->Cell(23,5,'Consignaci�n', 'LBT',0, 'L');
if ($form_pago==3)
$pdf->Cell(5,5,'X', 'BTR',0, 'C');
else
$pdf->Cell(5,5,'', 'BTR',0, 'C');
$pdf->SetXY(120,200);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(80,5,'Firma y Sello de Beneficiario','R',0, 'C');
$pdf->SetXY(120,205);
$pdf->Cell(80,45,'','LBR',0, 'C');
$pdf->SetXY(20,215);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(80,5,'OBSERVACIONES:',0,0, 'L');
$pdf->SetXY(20,215);
$pdf->Cell(100,35,'',1,0, 'L');
$pdf->SetXY(120,240);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(80,5,'_________________________________',0,0, 'C');
$pdf->SetXY(120,245);
$pdf->Cell(80,5,'C.C. / N.I.T. _______________________',0,0, 'C');
$pdf->Image('images/Empresa.jpg',201,200, 3);
*/







mysqli_close($link);
$pdf->Output();
?>