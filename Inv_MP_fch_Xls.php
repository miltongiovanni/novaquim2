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
            ->setCellValue('A1', 'Codigo')
			->setCellValue('B1', 'Materia Prima')
			->setCellValue('C1', 'Lote')
			->setCellValue('D1', 'Cantidad (Kg)')
			->setCellValue('E1', 'Precio (Kg)')
			->setCellValue('F1', 'Entrada')
			->setCellValue('G1', 'Salida');
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Inventario MP');
$link=conectarServidor();
$bd="novaquim";


$sql="SELECT inv_mprimas.Cod_mprima as Codigo, Nom_mprima, Lote_mp, sum(inv_mp) as inventario, Precio_mp 
FROM inv_mprimas, mprimas
where inv_mprimas.Cod_mprima=mprimas.Cod_mprima group by Codigo order by Nom_mprima;";
$result=mysqli_query($link,$sql) or die("Error al conectar a la base de datos.");
$i=2;
while($row= mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$salida=0;
	$salida1=0;
	$salida2=0;
	$prod=$row['Codigo'];
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, iconv("iso-8859-1", "UTF-8",$row['Codigo']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i,iconv("iso-8859-1", "UTF-8", $row['Nom_mprima']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, iconv("iso-8859-1", "UTF-8",$row['Lote_mp']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i,iconv("iso-8859-1", "UTF-8", $row['inventario']));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i,iconv("iso-8859-1", "UTF-8", $row['Precio_mp']));
	$sqle="select Codigo, sum(Cantidad) as entrada from det_compras, compras where Codigo=$prod and det_compras.Id_compra=compras.Id_compra and compra=1 and Fech_comp>='$Fch' group by Codigo";
	$resulte=mysqli_query($link,$sqle);
	$rowe=mysqli_fetch_array($resulte, MYSQLI_BOTH);
	if($rowe['entrada']==NULL)
		$entrada=0;
	else
		$entrada=$rowe['entrada'];
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $i, $entrada);
	$sqls1="select Cod_mprima, sum(Can_mprima) as salida1 from det_ord_prod, ord_prod where Cod_mprima=$prod and det_ord_prod.Lote=ord_prod.Lote and Fch_prod>='$Fch' group by Cod_mprima;";
	$results1=mysqli_query($link,$sqls1);
	$rows1=mysqli_fetch_array($results1, MYSQLI_BOTH);
	if($rows1['salida1']==NULL)
		$salida1=0;
	else
		$salida1=$rows1['salida1'];
		
	$sqls2="select Codigo_mp, sum(cant_medida*Cantidad*Densidad/1000) as salida2 from rel_dist_mp, env_dist, det_env_dist, medida where Codigo_mp=$prod and Cod_MP=env_dist.Id_env_dist  and Cod_umedid=Id_medida and rel_dist_mp.Cod_dist=det_env_dist.Cod_dist and Fch_env_dist>='$Fch';";	
	$results2=mysqli_query($link,$sqls2);
	$rows2=mysqli_fetch_array($results2, MYSQLI_BOTH);
	if($rows2['salida2']==NULL)
		$salida2=0;
	else
		$salida2=$rows2['salida2'];
	$salida=$salida1+$salida2;
//	echo "  salida No. $i ".$salida;
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $i++, $salida);
} 
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Inv_MP_Fch.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
mysqli_free_result($result);
mysqli_free_result($resulte);
mysqli_free_result($results1);
mysqli_free_result($results2);
mysqli_close($link);//Cerrar la conexion
exit;
?>








