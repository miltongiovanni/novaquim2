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
			->setCellValue('C1',iconv("iso-8859-1", "UTF-8", 'Categoría'))
            ->setCellValue('D1',iconv("iso-8859-1", "UTF-8", 'Dens Min'))
			->setCellValue('E1',iconv("iso-8859-1", "UTF-8", 'Dens Max'))
			->setCellValue('F1',iconv("iso-8859-1", "UTF-8", 'pH Min'))
			->setCellValue('G1',iconv("iso-8859-1", "UTF-8", 'pH Max'))
			->setCellValue('H1',iconv("iso-8859-1", "UTF-8", 'Fragancia'))
			->setCellValue('I1',iconv("iso-8859-1", "UTF-8", 'Color'))
			->setCellValue('J1',iconv("iso-8859-1", "UTF-8", 'Apariencia'));
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Lista de Productos');
$link=conectarServidor();
$sql="	SELECT Cod_produc as Codigo, Nom_produc as 'Producto', Des_cat_prod as 'Categoria', Den_min, Den_max , pH_min , pH_max, Fragancia, Color, Apariencia 
			FROM  productos, cat_prod
			WHERE productos.Id_cat_prod=cat_prod.Id_cat_prod 
			ORDER BY Codigo;";
$result=mysqli_query($link,$sql) or die("Error al conectar a la base de datos.");
$i=2;
while($row= mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$row['Codigo']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i,iconv("iso-8859-1", "UTF-8", $row['Producto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i,iconv("iso-8859-1", "UTF-8", $row['Categoria']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i,iconv("iso-8859-1", "UTF-8", $row['Den_min']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i,iconv("iso-8859-1", "UTF-8", $row['Den_max']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $i,iconv("iso-8859-1", "UTF-8", $row['pH_min']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $i,iconv("iso-8859-1", "UTF-8", $row['pH_max']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $i,iconv("iso-8859-1", "UTF-8", $row['Fragancia']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $i,iconv("iso-8859-1", "UTF-8", $row['Color']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $i++, iconv("iso-8859-1", "UTF-8",$row['Apariencia']));
} 

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Productos.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>








