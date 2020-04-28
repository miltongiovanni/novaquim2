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
            ->setCellValue('A1', 'Id Compra')
			->setCellValue('B1', 'Nit Proveedor')
			->setCellValue('C1', 'Proveedor')
			->setCellValue('D1', 'No. Factura')
			->setCellValue('E1', 'Fecha Compra')
			->setCellValue('F1', 'Total')
			->setCellValue('G1', 'Subtotal')
			->setCellValue('H1', 'IVA')
			->setCellValue('I1', 'Codigo')
			->setCellValue('J1', 'Producto')
			->setCellValue('K1', 'Precio')
			->setCellValue('L1', 'Cantidad')
			->setCellValue('M1', 'Tasa');
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Lista de Facturas');
$link=conectarServidor();
$sql="	select compras.idCompra as Id, tipoCompra, nit_prov, Nom_provee, numFact, fechComp, totalCompra, subtotalCompra, ivaCompra , Codigo, Nom_mprima as Producto, Precio, Cantidad, tasa
from compras, proveedores, det_compras, mprimas, tasa_iva 
where fechComp>='$FchIni' and fechComp<='$FchFin' and nit_prov=nitProv and tipoCompra=1 
AND compras.idCompra=det_compras.idCompra and Codigo=Cod_mprima and Cod_iva=Id_tasa 
union
select compras.idCompra as Id, tipoCompra, nit_prov, Nom_provee, numFact, fechComp, totalCompra, subtotalCompra, ivaCompra , Codigo, Nom_envase as Producto, Precio, Cantidad, tasa
from compras, proveedores, det_compras, envase, tasa_iva 
where fechComp>='$FchIni' and fechComp<='$FchFin' and nit_prov=nitProv and tipoCompra=2
AND compras.idCompra=det_compras.idCompra and Codigo=Cod_envase and Cod_iva=Id_tasa 
union
select compras.idCompra as Id, tipoCompra, nit_prov, Nom_provee, numFact, fechComp, totalCompra, subtotalCompra, ivaCompra , Codigo, Nom_tapa as Producto, Precio, Cantidad, tasa
from compras, proveedores, det_compras, tapas_val, tasa_iva 
where fechComp>='$FchIni' and fechComp<='$FchFin' and nit_prov=nitProv and tipoCompra=2
AND compras.idCompra=det_compras.idCompra and Codigo=Cod_tapa and Cod_iva=Id_tasa 
union
select compras.idCompra as Id, tipoCompra, nit_prov, Nom_provee, numFact, fechComp, totalCompra, subtotalCompra, ivaCompra , Codigo, Producto, Precio, Cantidad, tasa
from compras, proveedores, det_compras, distribucion, tasa_iva 
where fechComp>='$FchIni' and fechComp<='$FchFin' and nit_prov=nitProv and tipoCompra=5
AND compras.idCompra=det_compras.idCompra and Codigo=Id_distribucion and Cod_iva=Id_tasa
union
SELECT compras.idCompra as Id, tipoCompra, nit_prov, Nom_provee, numFact, fechComp, totalCompra, subtotalCompra, ivaCompra, Codigo, Nom_etiq as Producto , Precio, Cantidad, tasa 
FROM compras, proveedores, det_compras, etiquetas, tasa_iva
WHERE fechComp>='$FchIni' and fechComp<='$FchFin'  and nit_prov=nitProv and tipoCompra=4 AND compras.idCompra=det_compras.idCompra and Codigo=Cod_etiq  and Cod_iva=Id_tasa
order BY Id DESC;
";


$result=mysqli_query($link,$sql) or die("Error al conectar a la base de datos.");
$i=2;
while($row= mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$row['Id']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i,iconv("iso-8859-1", "UTF-8", $row['nit_prov']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, iconv("iso-8859-1", "UTF-8",$row['Nom_provee']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i,iconv("iso-8859-1", "UTF-8", $row['Num_fact']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i, iconv("iso-8859-1", "UTF-8",$row['Fech_comp']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $i,iconv("iso-8859-1", "UTF-8", $row['total_fact']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $i, iconv("iso-8859-1", "UTF-8",$row['Subtotal']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $i,iconv("iso-8859-1", "UTF-8", $row['IVA']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $i, iconv("iso-8859-1", "UTF-8",$row['Codigo']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $i,iconv("iso-8859-1", "UTF-8", $row['Producto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $i,iconv("iso-8859-1", "UTF-8", $row['Precio']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $i,iconv("iso-8859-1", "UTF-8", $row['Cantidad']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $i++, iconv("iso-8859-1", "UTF-8",$row['tasa']));
} 

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Compras.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
?>








