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
							 ->setDescription("Lista de Facturas por período")
							 ->setKeywords("Lista Facturas")
							 ->setCategory("Lista");
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', iconv("iso-8859-1", "UTF-8", 'Id Pago'))
			->setCellValue('B1', iconv("iso-8859-1", "UTF-8", 'Factura'))
			->setCellValue('C1', iconv("iso-8859-1", "UTF-8", 'NIT'))
			->setCellValue('D1', iconv("iso-8859-1", "UTF-8", 'Proveedor'))
			->setCellValue('E1', iconv("iso-8859-1", "UTF-8", 'Fecha de Compra'))
			->setCellValue('F1', iconv("iso-8859-1", "UTF-8", 'Fecha Vencimiento'))
            ->setCellValue('G1', 'Total')
            ->setCellValue('H1',iconv("iso-8859-1", "UTF-8", 'Fecha de Cancelación'))
			->setCellValue('I1', 'Valor Cancelado')
			->setCellValue('J1', 'Forma de Pago');
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Historia de Pagos');
$link=conectarServidor();
$sql="select Id_egreso as Id, nit_prov, Nom_provee, Num_fact, total_fact, pago, Fech_comp, Fech_venc, Fecha, forma_pago 
from egreso, compras, proveedores, form_pago 
WHERE egreso.Id_compra=compras.Id_compra and nit_prov=nitProv and tip_compra<6 and form_pago=Id_fpago and Fecha>='$FchIni' and Fecha<='$FchFin'
union select Id_egreso as Id, nit_prov, Nom_provee, Num_fact as Factura, total_fact, pago, Fech_comp, Fech_venc, Fecha, forma_pago 
from egreso, gastos, proveedores, form_pago 
WHERE egreso.Id_compra=gastos.Id_gasto and nit_prov=nitProv and tip_compra=6 and form_pago=Id_fpago and Fecha>='$FchIni' and Fecha<='$FchFin' order by Id DESC;";

$result=mysqli_query($link,$sql) or die("Error al conectar a la base de datos.");
//$columnas=mysql_num_fields($result);
//$filas = mysql_num_rows($result);
$i=2;
while($row= mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$row['Id']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i,iconv("iso-8859-1", "UTF-8", $row['Num_fact']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, iconv("iso-8859-1", "UTF-8",$row['nit_prov']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i,iconv("iso-8859-1", "UTF-8", $row['Nom_provee']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i, iconv("iso-8859-1", "UTF-8",$row['Fech_comp']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $i,iconv("iso-8859-1", "UTF-8", $row['Fech_venc']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $i, iconv("iso-8859-1", "UTF-8",$row['total_fact']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $i,iconv("iso-8859-1", "UTF-8", $row['Fecha']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $i, iconv("iso-8859-1", "UTF-8",$row['pago']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $i++, iconv("iso-8859-1", "UTF-8",$row['forma_pago']));
} 
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Histo_pagos.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>








