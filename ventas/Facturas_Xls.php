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
            ->setCellValue('A1', 'Factura')
			->setCellValue('B1', 'Nit Cliente')
			->setCellValue('C1', 'Cliente')
			->setCellValue('D1', 'Fecha Factura')
			->setCellValue('E1', 'Subtotal')
			->setCellValue('F1', 'Total')
			->setCellValue('G1', 'Descuento')
			->setCellValue('H1', 'Codigo')
			->setCellValue('I1', 'Cantidad')
			->setCellValue('J1', 'Precio')
			->setCellValue('K1', 'Tasa Iva')
			->setCellValue('L1', 'Cuenta Contable');
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Lista de Facturas');
$link=conectarServidor();
$sql="	select Factura, Nit_cliente, nomCliente, fechaFactura, Subtotal, Total,  Descuento, det_factura.Cod_producto as Codigo, Can_producto, prec_producto, tasa, Cuenta_cont 
from factura, det_factura, prodpre, tasa_iva, productos, clientes 
where fechaFactura>='$FchIni' and fechaFactura<='$FchFin'  and Factura=Id_fact and Cod_producto<100000 
and Cod_iva=Id_tasa and Cod_producto=Cod_prese and prodpre.Cod_produc=productos.Cod_produc and Nit_cliente=nitCliente
union
select Factura, Nit_cliente, nomCliente, fechaFactura, Subtotal, Total,  Descuento, det_factura.Cod_producto as Codigo, Can_producto, prec_producto, tasa, Cuenta_cont 
from factura, det_factura, distribucion, tasa_iva, clientes 
where fechaFactura>='$FchIni' and fechaFactura<='$FchFin' and Factura=Id_fact and Cod_producto>=100000 
and Cod_iva=Id_tasa and Cod_producto=Id_distribucion and Nit_cliente=nitCliente
union
select Factura, Nit_cliente, nomCliente, fechaFactura, Subtotal, Total,  Descuento, det_factura.Cod_producto as Codigo, Can_producto, prec_producto, tasa, Cuenta_cont 
from factura, det_factura, servicios, tasa_iva, clientes 
where fechaFactura>='$FchIni' and fechaFactura<='$FchFin' and Factura=Id_fact and Cod_producto<100 
and Cod_iva=Id_tasa and Cod_producto=IdServicio and Nit_cliente=nitCliente;";
$result=mysqli_query($link,$sql) or die("Error al conectar a la base de datos.");
$i=2;
while($row= mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$row['Factura']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i,iconv("iso-8859-1", "UTF-8", $row['Nit_cliente']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, iconv("iso-8859-1", "UTF-8",$row['Nom_clien']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i,iconv("iso-8859-1", "UTF-8", $row['Fech_fact']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i, iconv("iso-8859-1", "UTF-8",$row['Subtotal']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $i,iconv("iso-8859-1", "UTF-8", $row['Total']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $i, iconv("iso-8859-1", "UTF-8",$row['Descuento']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $i,iconv("iso-8859-1", "UTF-8", $row['Codigo']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $i, iconv("iso-8859-1", "UTF-8",$row['Can_producto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $i,iconv("iso-8859-1", "UTF-8", $row['prec_producto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $i,iconv("iso-8859-1", "UTF-8", $row['tasa']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $i++, iconv("iso-8859-1", "UTF-8",$row['Cuenta_cont']));
} 

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Facturas.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>








