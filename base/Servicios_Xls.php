<?php
include "includes/conect.php";
/** Error reporting */
error_reporting(E_ALL);
/** PHPExcel */
require_once 'Classes/PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
// Set properties
$objPHPExcel->getProperties()->setCreator("Industrias Novaquim")
							 ->setLastModifiedBy("Milton Espitia")
							 ->setTitle("Servicios")
							 ->setSubject("Lista de Facturas")
							 ->setDescription("Lista de Servicios ofrecidos")
							 ->setKeywords("Lista Facturas")
							 ->setCategory("Lista");
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', iconv("iso-8859-1", "UTF-8", 'Código'))
            ->setCellValue('B1', 'Servicio')
			->setCellValue('C1', 'Tasa');
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Servicios');
$link=conectarServidor();
$bd="novaquim";
$sql="select IdServicio, DesServicio, tasa from servicios, tasa_iva where Cod_iva=Id_tasa;";
$result=mysqli_query($link,$sql) or die("Error al conectar a la base de datos.");
$i=2;
while($row= mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$row['IdServicio']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i,iconv("iso-8859-1", "UTF-8", $row['DesServicio']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i++,iconv("iso-8859-1", "UTF-8", $row['tasa']));
} 

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Servicios.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
exit;
?>








