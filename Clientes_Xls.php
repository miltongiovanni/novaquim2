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
							 ->setSubject("Lista de Clentes")
							 ->setDescription("Lista de Facturas por período")
							 ->setKeywords("Lista Facturas")
							 ->setCategory("Lista");
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Nit')
			->setCellValue('B1', 'Cliente')
			->setCellValue('C1', 'Contacto')
			->setCellValue('D1', iconv("iso-8859-1", "UTF-8",'Teléfono'))
			->setCellValue('E1', iconv("iso-8859-1", "UTF-8",'Cargo'))
			->setCellValue('F1', iconv("iso-8859-1", "UTF-8",'Fax'))
			->setCellValue('G1', iconv("iso-8859-1", "UTF-8",'Celular'))
			->setCellValue('H1', iconv("iso-8859-1", "UTF-8",'Dirección'))
			->setCellValue('I1', iconv("iso-8859-1", "UTF-8",'E-mail'))
			->setCellValue('J1', iconv("iso-8859-1", "UTF-8",'Actividad'))
			->setCellValue('K1', iconv("iso-8859-1", "UTF-8",'Vendedor'))
			->setCellValue('L1', iconv("iso-8859-1", "UTF-8",'Ultima compra'));
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Clientes');
$link=conectarServidor();
if ($Estado=='A')
	$sql="select Nit_clien as Nit, Nom_clien as Cliente, Dir_clien as Direccion, Contacto, Cargo, Tel_clien as Tel1, nom_personal as vendor, Des_cat_cli, Fax_clien As Fax, Cel_clien as Cel, Eml_clien as Eml, ciudad, max(Fech_fact) as Ult_compra
from clientes, Personal, cat_clien, ciudades, factura where cod_vend=Id_Personal and Id_cat_clien=Id_cat_cli and Ciudad_clien=Id_ciudad and  Nit_cliente=Nit_clien AND clientes.Estado='A' group by Nit_clien order by Cliente";
if ($Estado=='N')
	$sql="	select Nit_clien as Nit, Nom_clien as Cliente, Dir_clien as Direccion, Contacto, Cargo, Tel_clien as Tel1, nom_personal as vendor, Des_cat_cli, Fax_clien As Fax, Cel_clien as Cel, Eml_clien as Eml, ciudad, max(Fech_fact) as Ult_compra
from clientes, Personal, cat_clien, ciudades, factura where cod_vend=Id_Personal and Id_cat_clien=Id_cat_cli and Ciudad_clien=Id_ciudad and  Nit_cliente=Nit_clien AND clientes.Estado='N' group by Nit_clien order by Cliente;";
$result=mysqli_query($link,$sql) or die("Error al conectar a la base de datos.");
$i=2;
while($row= mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$row['Nit']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i,iconv("iso-8859-1", "UTF-8", $row['Cliente']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, iconv("iso-8859-1", "UTF-8",$row['Contacto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i, iconv("iso-8859-1", "UTF-8",$row['Tel1']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i,iconv("iso-8859-1", "UTF-8", $row['Cargo']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $i, iconv("iso-8859-1", "UTF-8",$row['Fax']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $i, iconv("iso-8859-1", "UTF-8",$row['Cel']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $i,iconv("iso-8859-1", "UTF-8", $row['Direccion']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $i, iconv("iso-8859-1", "UTF-8",$row['Eml']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $i, iconv("iso-8859-1", "UTF-8",$row['Des_cat_cli']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $i, iconv("iso-8859-1", "UTF-8",$row['vendor']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $i++, iconv("iso-8859-1", "UTF-8",$row['Ult_compra']));
} 
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
if ($Estado=='A')
	header('Content-Disposition: attachment;filename="Clientes Activos.xls"');
if ($Estado=='N')
	header('Content-Disposition: attachment;filename="Clientes Inactivos.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
exit;
?>








