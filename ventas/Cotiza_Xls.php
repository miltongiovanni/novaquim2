<?php
include "includes/conect.php";
/** Error reporting */
error_reporting(E_ALL);
/** PHPExcel */
require_once 'Classes/PHPExcel.php';

foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
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
            ->setCellValue('A1', iconv("iso-8859-1", "UTF-8","Cotización"))
			->setCellValue('B1', iconv("iso-8859-1", "UTF-8","Fecha Cotización"))
			->setCellValue('C1', iconv("iso-8859-1", "UTF-8","Cliente Cotización"))
			->setCellValue('D1', iconv("iso-8859-1", "UTF-8","Tipo de Cliente"))
			->setCellValue('E1', iconv("iso-8859-1", "UTF-8","Precio"))
			->setCellValue('F1', iconv("iso-8859-1", "UTF-8","Contacto"))
			->setCellValue('G1', iconv("iso-8859-1", "UTF-8","Cargo"))
			->setCellValue('H1', iconv("iso-8859-1", "UTF-8","Teléfono"))
			->setCellValue('I1', iconv("iso-8859-1", "UTF-8","Celular"))
			->setCellValue('J1', iconv("iso-8859-1", "UTF-8","Dirección Cliente"))
			->setCellValue('K1', iconv("iso-8859-1", "UTF-8","E-mail Cliente"))
			->setCellValue('L1', iconv("iso-8859-1", "UTF-8","Vendedor"));
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Lista de Cotizaciones');
$link=conectarServidor();
$sql="	
select idCotizacion, fechaCotizacion, nomCliente, desCatClien, tipo_precio,  contactoCliente, cargoContacto, telCliente, celCliente, dirCliente, emailCliente, nom_personal 
from cotizaciones, clientes_cotiz, personal, cat_clien, tip_precio where idCliente=idCliente and codVendedor=Id_personal and idCatCliente=idCatClien and precioCotizacion=Id_precio;";
			
$result=mysqli_query($link,$sql) or die("Error al conectar a la base de datos.");
$i=2;
while($row= mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$row['Id_Cotizacion']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i,iconv("iso-8859-1", "UTF-8", $row['Fech_Cotizacion']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, iconv("iso-8859-1", "UTF-8",$row['Nom_clien']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i,iconv("iso-8859-1", "UTF-8", $row['Des_cat_cli']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i, iconv("iso-8859-1", "UTF-8",$row['tipo_precio']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $i,iconv("iso-8859-1", "UTF-8", $row['Contacto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $i, iconv("iso-8859-1", "UTF-8",$row['Cargo']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $i,iconv("iso-8859-1", "UTF-8", $row['Tel_clien']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $i, iconv("iso-8859-1", "UTF-8",$row['Cel_clien']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $i,iconv("iso-8859-1", "UTF-8", $row['Dir_clien']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $i,iconv("iso-8859-1", "UTF-8", $row['Eml_clien']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $i++,iconv("iso-8859-1", "UTF-8", $row['nom_personal']));
} 

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Cotizaciones.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
exit;
?>








