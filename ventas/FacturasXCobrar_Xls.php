<?php
include "includes/conect.php";
/** Error reporting */
error_reporting(E_ALL);
/** PHPExcel */
require_once 'Classes/PHPExcel.php';

foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
// Set properties
$objPHPExcel->getProperties()->setCreator("Industrias Novaquim")
							 ->setLastModifiedBy("Milton Espitia")
							 ->setTitle("Productos")
							 ->setSubject("Lista de Facturas")
							 ->setDescription("Lista de Facturas por per�odo")
							 ->setKeywords("Lista Facturas")
							 ->setCategory("Lista");
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', 'Factura')
			->setCellValue('B1', 'Cliente')
			->setCellValue('C1', 'Contacto')
			->setCellValue('D1', 'Cargo')
            ->setCellValue('E1', iconv("iso-8859-1", "UTF-8",'Tel�fono'))
			->setCellValue('F1', 'Celular')
			->setCellValue('G1', 'Fecha Factura')
			->setCellValue('H1', 'Fecha Vencimiento')
			->setCellValue('I1', 'Total Factura')
			->setCellValue('J1', 'Valor a Cobrar')
			->setCellValue('K1', 'Valor Cobrado')
			->setCellValue('L1', 'Subtotal');
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle(iconv("iso-8859-1", "UTF-8",'Facturas por Cobrar'));
$link=conectarServidor();
$sql="	select Factura, Nom_clien as Cliente, Contacto, Cargo, Tel_clien as Tel�fono, Cel_clien as Celular, Fech_fact as 'Fecha Factura', Fech_venc as 'Fecha Vmto', Total ,(Total - Reten_iva- Reten_ica - Reten_fte) as 'Valor a Cobrar', Subtotal
from factura, clientes WHERE Nit_cliente=Nit_clien and factura.Estado='P' ;";
$result=mysqli_query($link,$sql) or die("Error al conectar a la base de datos.");
$i=2;
while($row= mysqli_fetch_array($result, MYSQLI_BOTH))
{
	//$factura=$row['Factura'];
	$fecVen=$row['Fecha Vmto'];
	$fact=$row['Factura'];
	$qryp="select sum(cobro) as Parcial from r_caja where Fact=$fact";
	$resultpago=mysqli_query($link,$qryp);
	$rowpag=mysqli_fetch_array($resultpago);
	if($rowpag['Parcial'])
		$parcial=$rowpag['Parcial'];
	else
		$parcial=0;
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$row['Factura']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i, iconv("iso-8859-1", "UTF-8",$row['Cliente']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i,iconv("iso-8859-1", "UTF-8", $row['Contacto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i, iconv("iso-8859-1", "UTF-8",$row['Cargo']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i, iconv("iso-8859-1", "UTF-8",$row['Tel�fono']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $i, iconv("iso-8859-1", "UTF-8",$row['Celular']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $i, iconv("iso-8859-1", "UTF-8",$row['Fecha Factura']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $i, iconv("iso-8859-1", "UTF-8",$row['Fecha Vmto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $i, iconv("iso-8859-1", "UTF-8",$row['Total']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $i,iconv("iso-8859-1", "UTF-8", $row['Valor a Cobrar']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $i,iconv("iso-8859-1", "UTF-8", $parcial));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $i++,iconv("iso-8859-1", "UTF-8", $row['Subtotal']));
} 

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client�s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Cobros.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>







