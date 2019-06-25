<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

function cargarClases($classname)
{
require '../clases/'.$classname.'.php';
}
spl_autoload_register('cargarClases');

// Create new Spreadsheet object
$spreadsheet = new Spreadsheet();

// Set document properties
$spreadsheet->getProperties()->setCreator('Milton Giovanni Espitia')
    ->setLastModifiedBy('Milton Giovanni Espitia')
    ->setTitle('Lista de productos')
    ->setSubject('Productos')
    ->setDescription('Lista de productos')
    ->setKeywords('Lista')
    ->setCategory('Productos');

// Add some data
$spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A1', 'Código')
    ->setCellValue('B1', 'Producto')
    ->setCellValue('C1', 'Categoría')
	->setCellValue('D1', 'Dens Min')
	->setCellValue('E1', 'Dens Max')
    ->setCellValue('F1', 'pH Min')
    ->setCellValue('G1', 'pH Max')
	->setCellValue('H1', 'Fragancia')
	->setCellValue('I1', 'Color')
	->setCellValue('J1', 'Apariencia');
	

$ProductoOperador = new ProductosOperaciones();
$productos=$ProductoOperador->getTableProductos();
$j=2;
for($i=0;$i<count($productos);$i++){
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(1, $j, $productos[$i]['Código']);
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $j, $productos[$i]['Producto']);
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(3, $j, $productos[$i]['Categoría']);
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(4, $j, $productos[$i]['Dens Min']);
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(5, $j, $productos[$i]['Dens Max']);
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(6, $j, $productos[$i]['pH Min']);
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(7, $j, $productos[$i]['pH Max']);
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(8, $j, $productos[$i]['Fragancia']);
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(9, $j, $productos[$i]['Color']);
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(10, $j++, $productos[$i]['Apariencia']);
}

// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle('Lista de productos');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Productos.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
exit;

/*
include "includes/conect.php";
error_reporting(E_ALL);
require_once 'Classes/PHPExcel.php';

// Create new PHPExcel object
$spreadsheet = new PHPExcel();
// Set properties
$spreadsheet->getProperties()->setCreator("Industrias Novaquim")
							 ->setLastModifiedBy("Milton Espitia")
							 ->setTitle("Productos")
							 ->setSubject("Lista de Facturas")
							 ->setDescription("Lista de Facturas por per�odo")
							 ->setKeywords("Lista Facturas")
							 ->setCategory("Lista");
// Add some data
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', iconv("iso-8859-1", "UTF-8", 'C�digo'))
            ->setCellValue('B1', 'Producto')
			->setCellValue('C1',iconv("iso-8859-1", "UTF-8", 'Categor�a'))
            ->setCellValue('D1',iconv("iso-8859-1", "UTF-8", 'Dens Min'))
			->setCellValue('E1',iconv("iso-8859-1", "UTF-8", 'Dens Max'))
			->setCellValue('F1',iconv("iso-8859-1", "UTF-8", 'pH Min'))
			->setCellValue('G1',iconv("iso-8859-1", "UTF-8", 'pH Max'))
			->setCellValue('H1',iconv("iso-8859-1", "UTF-8", 'Fragancia'))
			->setCellValue('I1',iconv("iso-8859-1", "UTF-8", 'Color'))
			->setCellValue('J1',iconv("iso-8859-1", "UTF-8", 'Apariencia'));
// Rename sheet
$spreadsheet->getActiveSheet()->setTitle('Lista de Productos');
$link=conectarServidor();
$sql="	SELECT Cod_produc as Codigo, Nom_produc as 'Producto', Des_cat_prod as 'Categoria', Den_min, Den_max , pH_min , pH_max, Fragancia, Color, Apariencia 
			FROM  productos, cat_prod
			WHERE productos.Id_cat_prod=cat_prod.Id_cat_prod 
			ORDER BY Codigo;";
$result=mysqli_query($link,$sql) or die("Error al conectar a la base de datos.");
$i=2;
while($row= mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$row['Codigo']));
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(1, $i,iconv("iso-8859-1", "UTF-8", $row['Producto']));
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $i,iconv("iso-8859-1", "UTF-8", $row['Categoria']));
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(3, $i,iconv("iso-8859-1", "UTF-8", $row['Den_min']));
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(4, $i,iconv("iso-8859-1", "UTF-8", $row['Den_max']));
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(5, $i,iconv("iso-8859-1", "UTF-8", $row['pH_min']));
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(6, $i,iconv("iso-8859-1", "UTF-8", $row['pH_max']));
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(7, $i,iconv("iso-8859-1", "UTF-8", $row['Fragancia']));
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(8, $i,iconv("iso-8859-1", "UTF-8", $row['Color']));
	$spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(9, $i++, iconv("iso-8859-1", "UTF-8",$row['Apariencia']));
} 

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);
// Redirect output to a client�s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Productos.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($spreadsheet, 'Excel5');
$objWriter->save('php://output');
exit;*/
?>








