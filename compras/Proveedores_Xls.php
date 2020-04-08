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
            ->setCellValue('A1', iconv("iso-8859-1", "UTF-8", 'NIT'))
            ->setCellValue('B1', 'Proveeedor')
			->setCellValue('C1', iconv("iso-8859-1", "UTF-8", 'Dirección'))
			->setCellValue('D1', 'Contacto')
			->setCellValue('E1', iconv("iso-8859-1", "UTF-8", 'Teléfono'))
			->setCellValue('F1', 'Fax')
            ->setCellValue('G1',iconv("iso-8859-1", "UTF-8", 'Categoría'))
			->setCellValue('H1',iconv("iso-8859-1", "UTF-8", 'Correo Electrónico'));
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Productos de Distribucion');
$link=conectarServidor();
$bd="novaquim";
$sql="	SELECT  NIT_provee as 'Nit',
			Nom_provee as 'Proveedor',
			Dir_provee as 'Dir_prov', 
			Nom_contac as 'Contacto',
			Tel_provee as 'Tel',
			Fax_provee as 'Fax',
			Eml_provee as 'email',
			desCatProv as 'Cat'
			FROM proveedores, cat_prov
			where proveedores.Id_cat_prov=cat_prov.idCatProv order by Nom_provee;";
$result=mysqli_query($link,$sql) or die("Error al conectar a la base de datos.");
$i=2;
while($row= mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$row['Nit']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i, iconv("iso-8859-1", "UTF-8", $row['Proveedor']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, iconv("iso-8859-1", "UTF-8", $row['Dir_prov']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i, iconv("iso-8859-1", "UTF-8", $row['Contacto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i, iconv("iso-8859-1", "UTF-8", $row['Tel']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $i, iconv("iso-8859-1", "UTF-8", $row['Fax']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $i, iconv("iso-8859-1", "UTF-8",$row['Cat']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $i++, iconv("iso-8859-1", "UTF-8", $row['email']));
} 

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Proveedores.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>








