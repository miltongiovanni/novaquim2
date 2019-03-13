<?php
include "includes/valAcc.php";
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
include "includes/conect.php";
$link=conectarServidor();
$qryord="select Id_cotiz_p, Fech_Cotizacion, Nom_clien, Contacto, clientes_cotiz.Cargo, Tel_clien, Fax_clien, Cel_clien, Dir_clien, Eml_clien, tipo_precio, nom_personal, cel_personal, ciudad, destino, Eml_personal, cargos_personal.cargo as c_vendedor 
from  cot_personalizada, clientes_cotiz, tip_precio, personal, ciudades, cargos_personal 
where Cliente_cot=Id_cliente and tip_precio=Id_precio and cod_vend=Id_personal and Ciudad_clien=Id_ciudad and cargo_personal=Id_cargo and Id_cotiz_p=$cotizacion";
$resultord=mysqli_query($link,$qryord);
$roword=mysqli_fetch_array($resultord);
$destino=$roword['destino'];

?><?php
require('fpdf.php');
//echo "destino=".$destino;

class PDF extends FPDF
{
//Cabecera de página
function Header()
{
	 if($this->PageNo()==1)
    {
		//Logo
		//$this->Image('images/LogoNova1.jpg',15,15,65);
		//Arial bold 15
		/*$this->SetFont('Arial','B',16);
		//Movernos a la derecha
		$this->SetXY(70,45);
		//Título
		$this->Cell(70,10,'ORDEN DE PEDIDO',0,0,'C');
		//Salto de línea
		$this->Ln(20);*/
	}
}

//Pie de página
function Footer()
{
	//Posición: a 1,5 cm del final
	$this->SetXY(15,263);
	//Arial italic 8
	$this->SetFont('Arial','',8);
	//Número de página
	$this->Cell(182,10,'Dirección: Bogotá D.C. Calle 35 C Sur No. 26 F - 40  PBX: 2039484 - 2022912  Website:www.novaquim.com   E-mail: info@novaquim.com',0,0,'C');
}
}

//Creación del objeto de la clase heredada


$Nom_clien=$roword['Nom_clien'];
$Contacto=$roword['Contacto'];
$Cargo=$roword['Cargo'];
$Fech_Cotizacion=$roword['Fech_Cotizacion'];
$precio=$roword['tipo_precio'];
$Ciudad=$roword['ciudad'];
$nom_personal=$roword['nom_personal'];
$cel_personal=$roword['cel_personal'];
$Eml_personal=$roword['Eml_personal'];
$cargo_personal=$roword['c_vendedor'];
$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->SetMargins(25, 55, 20);
$pdf->AddFont('Baker','','Baker.php');
$pdf->AddPage();
$pdf->SetFont('Baker','',11);
if ($destino==2)
	$pdf->Image('images/borde.jpg',10,10, 195, 255);

$pdf->Write(4,$roword['ciudad']);
$fecha = time();
$pdf->Cell(30,4, FechaFormateada($fecha),0,1);
$pdf->Ln(4);
$pdf->Cell(60,4,'Señores:',0,1);
$pdf->Cell(60,4,$roword['Nom_clien'],0,1);
$pdf->Cell(60,4,'Atn. '.$roword['Contacto'],0,1);
$pdf->Cell(60,4,$Cargo,0,1);
$pdf->Cell(60,4,'E.    S.    D.',0,1);
$pdf->Ln(1);
$pdf->Cell(0,5,'Cotización No. '.$roword['Id_cotiz_p'].' - '.date("y"),0,1, 'C');
$pdf->Ln(2);
$pdf->MultiCell(0,5,'Tenemos el gusto de poner a su consideración nuestra propuesta comercial para su servicio.');
//PRODUCTOS NOVAQUIM
$qry="select Cod_producto, Can_producto, Nombre, format(Prec_producto,0) as precio, format(Can_producto* Prec_producto,0) as subtot from det_cot_personalizada, prodpre, cot_personalizada where Cod_producto=Cod_prese and Id_cotiz_p=$cotizacion and Id_cotiz_p=Id_cot_per order by Nombre";
$pdf->Ln(2);
$result=mysqli_query($link,$qry);
$i=1;
$pdf->SetFont('helvetica','B',8);
$pdf->Cell(8,3,"Item",1,0,'C');
$pdf->Cell(110,3, 'Producto',1, 0,'C');
$pdf->Cell(15,3,'Cantidad',1, 0,'C');
$pdf->Cell(19,3,'Precio',1, 0, 'C');
$pdf->Cell(19,3,'Subtotal',1, 0,'C');
$pdf->Ln(3);
$pdf->SetFont('helvetica','',8);
while($row=mysqli_fetch_array($result))
{
	$prod=$row[2];
	$cant=$row[1];
	$prec=$row[3];
	$subtotal=$row[4];
	$pdf->Cell(8,3.5,$i++,1,0,'C');
	$pdf->Cell(110,3.5,$prod,1,0,'L');
	$pdf->Cell(15,3.5,$cant,1,0,'C');
	$pdf->Cell(19,3.5,'$ '.$prec,1,0,'R');
	$pdf->Cell(19,3.5,'$ '.$subtotal,1,0,'R');
	$pdf->Ln(3.5);
}

//PRODUCTOS DE DISTRIBUCIÓN
$qryd="select Cod_producto, Can_producto, Producto, format(Prec_producto,0) as precio, format(Can_producto* Prec_producto,0) as subtot 
from det_cot_personalizada, distribucion, cot_personalizada where Cod_producto=Id_distribucion and Id_cotiz_p=$cotizacion and Id_cotiz_p=Id_cot_per order by Producto";
$resultd=mysqli_query($link,$qryd);
while($rowd=mysqli_fetch_array($resultd))
{
  $prod=$rowd[2];
  $cant=$rowd[1];
  $prec=$rowd[3];
  $subtotal=$rowd[4];
  $pdf->Cell(8,3,$i++,1,0,'C');
  $pdf->Cell(110,3,$prod,1,0,'L');
  $pdf->Cell(15,3,$cant,1,0,'C');
  $pdf->Cell(19,3,'$ '.$prec,1,0,'R');
  $pdf->Cell(19,3,'$ '.$subtotal,1,0,'R');
  $pdf->Ln(3);
}
$qrytot="SELECT SUM(Can_producto*Prec_producto) as Total FROM det_cot_personalizada where Id_cot_per=$cotizacion;";
$resulttot=mysqli_query($link,$qrytot);
$row_tot=mysqli_fetch_array($resulttot);
$total=number_format($row_tot['Total'],0,'.',',');
$pdf->SetFont('helvetica','B',8);

$pdf->Cell(152,3,'TOTAL COTIZACIÓN',0,0,'R');
$pdf->Cell(19,3,'$ '.$total,0,1,'R');
$pdf->SetFont('Baker','',11);
$f=fopen('textos/cotiza2.txt','r');
$txt=fread($f,filesize('textos/cotiza2.txt'));
fclose($f);
$pdf->MultiCell(0,5,$txt);
$pdf->Ln(2);
$pdf->Cell(60,4,$roword['nom_personal'],0,1);
$pdf->Cell(60,4,$roword['c_vendedor'],0,1);
$pdf->Cell(60,4,'Industrias Novaquim S.A.S.',0,1);
$pdf->Cell(60,4,'Cel: '.$roword['cel_personal'],0,1);
$pdf->Cell(60,4,'E-mail: '.$roword['Eml_personal'],0,1);






/*$qry="SELECT Cod_producto, Can_producto, Nombre as Producto from det_pedido, prodpre 
where Cod_producto=Cod_prese and Id_Ped=$pedido and Cod_producto <100000
UNION
select Cod_producto, Can_producto, Producto from det_pedido, distribucion 
where Cod_producto=Id_distribucion and Id_Ped=$pedido and Cod_producto >=100000;";

$i=1;
$pdf->SetXY(10,90);

$pdf->SetFont('Arial','',10);
$pdf->SetY(-35);
$pdf->Cell(10,8,'Observaciones:');
$pdf->Line(10,255,200,255);
$pdf->Line(10,260,200,260);*/
mysqli_close($link);
$pdf->Output();
function FechaFormateada($FechaStamp){
$ano = date('Y',$FechaStamp); //<-- Año
$mes = date('m',$FechaStamp); //<-- número de mes (01-31)
$dia = date('d',$FechaStamp); //<-- Día del mes (1-31)
$dialetra = date('w',$FechaStamp);  //Día de la semana(0-7)
switch($dialetra)
{
case 0: $dialetra="Domingo"; break;
case 1: $dialetra="Lunes"; break;
case 2: $dialetra="Martes"; break;
case 3: $dialetra="Miércoles"; break;
case 4: $dialetra="Jueves"; break;
case 5: $dialetra="Viernes"; break;
case 6: $dialetra="Sábado"; break;
}
switch($mes) {
case '01': $mesletra="Enero"; break;
case '02': $mesletra="Febrero"; break;
case '03': $mesletra="Marzo"; break;
case '04': $mesletra="Abril"; break;
case '05': $mesletra="Mayo"; break;
case '06': $mesletra="Junio"; break;
case '07': $mesletra="Julio"; break;
case '08': $mesletra="Agosto"; break;
case '09': $mesletra="Septiembre"; break;
case '10': $mesletra="Octubre"; break;
case '11': $mesletra="Noviembre"; break;
case '12': $mesletra="Diciembre"; break;
}    
return ", $dia de $mesletra de $ano";
}
?>
