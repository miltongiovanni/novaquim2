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
							 ->setDescription("Lista de Facturas por per�odo")
							 ->setKeywords("Lista Facturas")
							 ->setCategory("Lista");
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Codigo')
			->setCellValue('B1', 'Producto')
			->setCellValue('C1', 'Costo')
			->setCellValue('D1', 'Cantidad')
			->setCellValue('E1', 'Entrada')
			->setCellValue('F1', 'Salida');
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Inventario MP');
$link=conectarServidor();
$sql="SELECT inv_prod.Cod_prese as Codigo, Nombre, sum(inv_prod) as inventario, ROUND(fabrica/(1.16*1.55),2) as Costo  
FROM inv_prod, prodpre, productos, medida
where inv_prod.Cod_prese=prodpre.Cod_prese AND medida.Id_medida=prodpre.Cod_umedid and productos.Cod_produc=prodpre.Cod_produc and prod_activo=0 
group by Codigo ORDER BY Nom_produc;
";
$result=mysqli_query($link,$sql) or die("Error al conectar a la base de datos.");
$i=2;
while($row= mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$prod=$row['Codigo'];
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$row['Codigo']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i,iconv("iso-8859-1", "UTF-8", $row['Nombre']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, iconv("iso-8859-1", "UTF-8",$row['Costo']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i,iconv("iso-8859-1", "UTF-8", $row['inventario']));
	$sqle1="select SUM(Can_prese) as entrada1 from envasado, ord_prod where envasado.Lote=ord_prod.Lote and Fch_prod>'$Fch' and Con_prese=$prod;";
	$resulte1=mysqli_query($link,$sqle1);
	$rowe1=mysqli_fetch_array($resulte1, MYSQLI_BOTH);
	if($rowe1['entrada1']==NULL)
		$entrada1=0;
	else
		$entrada1=$rowe1['entrada1'];
	$sqle2="select Sum(Can_prese_nvo) as entrada2 from cambios, det_cambios2 where cambios.Id_cambio=det_cambios2.Id_cambio and Fech_cambio>'$Fch' and Cod_prese_nvo=$prod;";
	$resulte2=mysqli_query($link,$sqle2);
	$rowe2=mysqli_fetch_array($resulte2, MYSQLI_BOTH);
	if($rowe2['entrada2']==NULL)
		$entrada2=0;
	else
		$entrada2=$rowe2['entrada2'];
	$sqle3="select sum(Cantidad) as entrada3 from arm_kit, kit where Cod_kit=Id_kit and Fecha_arm>'$Fch' AND Codigo=$prod;";
	$resulte3=mysqli_query($link,$sqle3);
	$rowe3=mysqli_fetch_array($resulte3, MYSQLI_BOTH);
	if($rowe3['entrada3']==NULL)
		$entrada3=0;
	else
		$entrada3=$rowe3['entrada3'];
	$entrada=$entrada1 + $entrada2 + $entrada3;
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i, $entrada);
$sqls1="select sum(Can_producto) as salida1 from det_remision, remision 
where remision.Id_remision=det_remision.Id_remision and Fech_remision>'$Fch' and Cod_producto=$prod;";
	$results1=mysqli_query($link,$sqls1);
	$rows1=mysqli_fetch_array($results1, MYSQLI_BOTH);
	if($rows1['salida1']==NULL)
		$salida1=0;
	else
		$salida1=$rows1['salida1'];
	$sqls2="select SUM(Can_prese_ant) as salida2 from cambios, det_cambios where cambios.Id_cambio=det_cambios.Id_cambio and Fech_cambio>'$Fch' and Cod_prese_ant=$prod";	
	$results2=mysqli_query($link,$sqls2);
	$rows2=mysqli_fetch_array($results2, MYSQLI_BOTH);
	if($rows2['salida2']==NULL)
		$salida2=0;
	else
		$salida2=$rows2['salida2'];
	$sqls3="select sum(Cantidad) as salida3 from arm_kit, kit, det_kit where Cod_kit=kit.Id_kit and kit.Id_kit=det_kit.Id_kit and Fecha_arm>'$Fch' and Cod_producto=$prod";	
	$results3=mysqli_query($link,$sqls3);
	$rows3=mysqli_fetch_array($results3, MYSQLI_BOTH);
	if($rows3['salida3']==NULL)
		$salida3=0;
	else
		$salida3=$rows3['salida3'];
	$sqls4="select sum(Can_producto) as salida4 from det_remision1, remision1 where remision1.Id_remision=det_remision1.Id_remision and Fech_remision>'$Fch' and Cod_producto=$prod;";
	$results4=mysqli_query($link,$sqls4);
	$rows4=mysqli_fetch_array($results4, MYSQLI_BOTH);
	if($rows4['salida4']==NULL)
		$salida4=0;
	else
		$salida4=$rows4['salida4'];
	$salida=$salida1 + $salida2 + $salida3+$salida4;
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $i++, $salida);
} 
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client�s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Inv_Prod.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
mysqli_free_result($result);
mysqli_free_result($resulte1);
mysqli_free_result($resulte2);
mysqli_free_result($resulte3);
mysqli_free_result($results1);
mysqli_free_result($results2);
mysqli_free_result($results3);
mysqli_free_result($results4);

/* cerrar la conexi�n */
mysqli_close($link);
exit;
?>







