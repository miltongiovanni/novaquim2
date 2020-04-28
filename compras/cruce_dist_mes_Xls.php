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
			->setCellValue('A1', iconv("iso-8859-1", "UTF-8",'Código'))
            ->setCellValue('B1', 'Producto')
			->setCellValue('C1', 'Precio Compra')
			->setCellValue('D1', 'Precio Venta')
			->setCellValue('E1', 'Mes')
			->setCellValue('F1', 'Venta Mes')
			->setCellValue('G1', 'Compra Mes');
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle(iconv("iso-8859-1", "UTF-8",'Ventas Compras Dist  por Mes'));
$link=conectarServidor();
$fecha2=explode('-', $FchFin);
$fecha1=explode('-', $FchIni);
$meses=$fecha2[1]-$fecha1[1];
//parametros iniciales que son los que cambiamos
$link=conectarServidor();
$database="novaquim";
//sentencia SQL    tblusuarios.IdUsuario,
$sql="select Id_distribucion, Producto, precio_vta/(1+tasa) as prec_venta, precio_com from distribucion, tasa_iva where Cod_iva=Id_tasa order by Id_distribucion;";
$result=mysqli_query($link,$sql);
$i=2;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$codigo=$row['Id_distribucion'];
	$producto=$row['Producto'];
	$PrComp=$row['precio_com'];
	$PrVta=$row['prec_venta'];
	$mes=$fecha1[1];
	for ($b=0; $b<=$meses; $b++)
	{
	  $sqlv="select sum(Can_producto) as ventames from det_factura, factura where fech_fact>='$FchIni' and fech_fact<='$FchFin' and Factura=Id_fact and Cod_producto=$codigo and MONTH(fech_fact)=$mes ;";
	  $resultv=mysqli_query($link,$sqlv);
	  $rowv=mysqli_fetch_array($resultv, MYSQLI_BOTH);
	  $ventames=$rowv['ventames'];
	  if ($ventames==NULL)
	    $ventames=0;
	  $sqlc="select sum(Cantidad) as comprames from compras, det_compras where compras.idCompra=det_compras.idCompra and compra=5 and Fech_comp>='$FchIni' and Fech_comp<='$FchFin' and Codigo=$codigo and MONTH(Fech_comp)=$mes ;";
	  $resultc=mysqli_query($link, $sqlc);
	  $rowc=mysqli_fetch_array($resultc, MYSQLI_BOTH);
	  $comprames=round($rowc['comprames'], 0);
	  if ($comprames==NULL)
        $comprames=0;
	  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$codigo));
	  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i, iconv("iso-8859-1", "UTF-8",$producto));
	  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i,iconv("iso-8859-1", "UTF-8", $PrComp));
	  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i, iconv("iso-8859-1", "UTF-8",$PrVta));
	  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i,iconv("iso-8859-1", "UTF-8", $mes++));
	  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $i,iconv("iso-8859-1", "UTF-8", $ventames));
	  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $i++,iconv("iso-8859-1", "UTF-8", $comprames));
	}
	
	
}
mysqli_free_result($result);
mysqli_close($link);//Cerrar la conexion

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="CruceDistribucionmes.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>








