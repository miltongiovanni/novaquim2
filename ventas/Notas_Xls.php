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
            ->setCellValue('A1', 'Nota')
			->setCellValue('B1', 'Nit Cliente')
			->setCellValue('C1', 'Cliente')
			->setCellValue('D1', 'Fecha Nota')
			->setCellValue('E1', 'Subtotal')
			->setCellValue('F1', 'Total')
			->setCellValue('G1', 'IVA')
			->setCellValue('H1', 'Fac_orig')
			->setCellValue('I1', 'Fac_dest')
			->setCellValue('J1', 'Codigo')
			->setCellValue('K1', 'Producto')
			->setCellValue('L1', 'Cantidad')
			->setCellValue('M1', 'Tasa')
			->setCellValue('N1', 'Precio')
			->setCellValue('O1', 'Cuenta Contable');
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Lista de Facturas');
$link=conectarServidor();
$sql="	select Nota, Nit_cliente, nomCliente,  Fecha, Total, Subtotal, IVA, Fac_orig, Fac_dest, det_nota_c.Cod_producto as Codigo, Nombre as Producto, det_nota_c.Can_producto, tasa, precioProducto as Precio, Cuenta_cont from nota_c, clientes, det_nota_c, prodpre, det_factura, tasa_iva, productos 
where Nit_cliente=nitCliente and Fecha>='$FchIni' and Fecha<='$FchFin' and Nota=Id_nota and det_nota_c.Cod_producto=Cod_prese and idFactura=Fac_orig and det_factura.codProducto=det_nota_c.Cod_producto and Cod_iva=Id_tasa and prodpre.Cod_produc=productos.Cod_produc
union
select Nota, Nit_cliente, nomCliente,  Fecha, Total, Subtotal, IVA, Fac_orig, Fac_dest, det_nota_c.Cod_producto as Codigo, Producto, det_nota_c.Can_producto, tasa, precioProducto as Precio, Cuenta_cont  from nota_c, clientes, det_nota_c, distribucion, det_factura, tasa_iva  
where Nit_cliente=nitCliente and Fecha>='$FchIni' and Fecha<='$FchFin' and Nota=Id_nota and det_nota_c.Cod_producto=Id_distribucion and idFactura=Fac_orig and det_factura.codProducto=det_nota_c.Cod_producto and Cod_iva=Id_tasa order by Nota";
			
$result=mysqli_query($link,$sql) or die("Error al conectar a la base de datos.");
$i=2;
while($row= mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$row['Nota']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i,iconv("iso-8859-1", "UTF-8", $row['Nit_cliente']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, iconv("iso-8859-1", "UTF-8",$row['Nom_clien']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i,iconv("iso-8859-1", "UTF-8", $row['Fecha']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i, iconv("iso-8859-1", "UTF-8",$row['Total']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $i,iconv("iso-8859-1", "UTF-8", $row['Subtotal']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $i, iconv("iso-8859-1", "UTF-8",$row['IVA']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $i,iconv("iso-8859-1", "UTF-8", $row['Fac_orig']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $i, iconv("iso-8859-1", "UTF-8",$row['Fac_dest']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $i,iconv("iso-8859-1", "UTF-8", $row['Codigo']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $i,iconv("iso-8859-1", "UTF-8", $row['Producto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $i,iconv("iso-8859-1", "UTF-8", $row['Can_producto']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $i,iconv("iso-8859-1", "UTF-8", $row['tasa']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $i,iconv("iso-8859-1", "UTF-8", $row['Precio']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $i++, iconv("iso-8859-1", "UTF-8",$row['Cuenta_cont']));
} 

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Notas.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
exit;
?>








