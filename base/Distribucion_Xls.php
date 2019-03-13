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
							 ->setTitle("Productos")
							 ->setSubject("Lista de Facturas")
							 ->setDescription("Lista de Facturas por período")
							 ->setKeywords("Lista Facturas")
							 ->setCategory("Lista");
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', iconv("iso-8859-1", "UTF-8", 'Código'))
            ->setCellValue('B1', 'Producto')
			->setCellValue('C1', 'Precio')
            ->setCellValue('D1',iconv("iso-8859-1", "UTF-8", 'Categoría'));
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Productos de Distribucion');
$link=conectarServidor();
$bd="novaquim";
$sql="	SELECT Id_distribucion as Código, Producto, precio_vta as Precio, tasa as 'Iva', Des_cat_dist as 'Categoría' 
			FROM  distribucion, tasa_iva, cat_dist
			WHERE distribucion.Cod_iva=tasa_iva.Id_tasa and distribucion.Id_Cat_dist=cat_dist.Id_cat_dist and Activo=0 and Cotiza=0
			ORDER BY cat_dist.Id_Cat_dist , Producto";
$result=mysqli_query($link,$sql) or die("Error al conectar a la base de datos.");
$i=2;
while($row= mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$row['Código']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i,iconv("iso-8859-1", "UTF-8", $row['Producto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i,iconv("iso-8859-1", "UTF-8", $row['Precio']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i++, iconv("iso-8859-1", "UTF-8",$row['Categoría']));
} 
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Distribucion.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>








