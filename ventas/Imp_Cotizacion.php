<?php
include "../includes/valAcc.php";
?><?php

$Destino="";
foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  
require('fpdf.php');
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
	//$this->SetY(-15);
	//Arial italic 8
	$this->SetFont('Arial','',8);
	//Número de página
	$this->Cell(185,10,'Dirección: Bogotá D.C. Calle 35 C Sur No. 26 F - 40  PBX: 2039484 - 2022912  Website:www.novaquim.com   E-mail: info@novaquim.com',0,0,'C');
}
}

//Creación del objeto de la clase heredada
include "includes/conect.php";
$link=conectarServidor();
$qryord="select Id_Cotizacion, Nom_clien, Dir_clien, Contacto, clientes_cotiz.Cargo, Fech_Cotizacion, precio, presentaciones, productos, distribucion, Ciudad, nom_personal, cel_personal, Eml_personal, cargos_personal.cargo as cargo_personal, desCatClien 
from cotizaciones, clientes_cotiz, personal, cat_clien, cargos_personal, ciudades 
WHERE Id_Cotizacion=$Cotizacion and cliente=Id_cliente AND cod_vend=Id_personal AND Id_cat_clien=idCatClien and cod_vend=Id_personal and cargo_personal=Id_cargo and Ciudad_clien=IdCiudad";
$resultord=mysqli_query($link,$qryord);
$roword=mysqli_fetch_array($resultord);
$Nom_clien=$roword['Nom_clien'];
$Contacto=$roword['Contacto'];
$Cargo=$roword['Cargo'];
$Dir_clien=$roword['Dir_clien'];
$Fech_Cotizacion=$roword['Fech_Cotizacion'];
$precio=$roword['precio'];
$presentaciones=$roword['presentaciones'];
$distribucion=$roword['distribucion'];
$productos_c=$roword['productos'];
$Ciudad=$roword['Ciudad'];
$nom_personal=$roword['nom_personal'];
$cel_personal=$roword['cel_personal'];
$Eml_personal=$roword['Eml_personal'];
$cargo_personal=$roword['cargo_personal'];
$Des_cat_cli=$roword['Des_cat_cli'];
$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->SetMargins(25, 55, 20);
$pdf->AddFont('Baker','','Baker.php');
$pdf->AddPage();
$pdf->SetFont('Baker','',11);
if ($Destino==2)
	$pdf->Image('images/borde.jpg',10,10, 195, 255);

$pdf->Write(5,$roword['Ciudad']);
$fecha = time();
$pdf->Cell(30,5, FechaFormateada($fecha),0,1);
$pdf->Ln(12);
$pdf->Cell(60,5,'Señores:',0,1);
$pdf->Cell(60,5,$roword['Nom_clien'],0,1);
$pdf->Cell(60,5,'Atn. '.$roword['Contacto'],0,1);
$pdf->Cell(60,5,$Cargo,0,1);
$pdf->Cell(100,5,$Dir_clien,0,1);
$pdf->Ln(12);
$pdf->Cell(60,5,'Apreciado(a) Señor(a): ', 0, 1);
$pdf->Ln(12);
//Abrir fichero de texto
$f=fopen('textos/cotiza1.txt','r');
$txt=fread($f,filesize('textos/cotiza1.txt'));
fclose($f);
$pdf->MultiCell(0,5,'Teniendo en cuenta la importancia que su '.$roword['Des_cat_cli'].' '.$txt);
$pdf->Ln(16);
$pdf->Cell(60,5,$roword['nom_personal'],0,1);
$pdf->Cell(60,5,$roword['cargo_personal'],0,1);
$pdf->Cell(60,5,'Industrias Novaquim',0,1);
$pdf->Cell(60,5,'Cel: '.$roword['cel_personal'],0,1);
$pdf->Cell(60,5,'E-mail: '.$roword['Eml_personal'],0,1);
$pdf->SetMargins(30, 30, 20);
$pdf->AddPage();
$pdf->Write(5,$roword['Ciudad']);
$pdf->Cell(30,5, FechaFormateada($fecha),0,1);
$pdf->Ln(5);
$pdf->Cell(60,5,'Señores:',0,1);
$pdf->Cell(60,5,$roword['Nom_clien'],0,1);
$pdf->Ln(5);
$pdf->Cell(0,5,'Cotización No. '.$roword['Id_Cotizacion'].' - '.date("y"),0,1, 'C');
$pdf->Ln(5);
$pdf->MultiCell(0,5,'Tenemos el gusto de poner a su consideración nuestra propuesta comercial para el servicio de su organización.');
//SE DETERMINA A QUE PRECIO SE VA A COTIZAR
if($precio==1)
	$qry="select codigo_ant, producto, cant_medida, Cod_produc, fabrica as precio from precios, (select DISTINCTROW Cod_ant, cant_medida, prodpre.Cod_produc, Id_cat_prod from prodpre, precios, medida, productos where Cod_ant=codigo_ant and Cod_umedid=Id_medida and prodpre.Cod_produc=productos.Cod_produc and pres_activo=0 and Cotiza=0 group by Cod_ant) as tabla  where pres_activa=0 and codigo_ant=Cod_ant";
if($precio==2)
	$qry="select codigo_ant, producto, cant_medida, Cod_produc, distribuidor as precio from precios, (select DISTINCTROW Cod_ant, cant_medida, prodpre.Cod_produc, Id_cat_prod from prodpre, precios, medida, productos where Cod_ant=codigo_ant and Cod_umedid=Id_medida and prodpre.Cod_produc=productos.Cod_produc and pres_activo=0 and Cotiza=0 and Cotiza=0 group by Cod_ant) as tabla  where pres_activa=0 and codigo_ant=Cod_ant ";
if($precio==3)
	$qry="select codigo_ant, producto, cant_medida, Cod_produc, detal as precio from precios, (select DISTINCTROW Cod_ant, cant_medida, prodpre.Cod_produc, Id_cat_prod from prodpre, precios, medida, productos where Cod_ant=codigo_ant and Cod_umedid=Id_medida and prodpre.Cod_produc=productos.Cod_produc and pres_activo=0 and Cotiza=0 group by Cod_ant) as tabla  where pres_activa=0 and codigo_ant=Cod_ant";
if($precio==4)
	$qry="select codigo_ant, producto, cant_medida, Cod_produc, mayor as precio from precios, (select DISTINCTROW Cod_ant, cant_medida, prodpre.Cod_produc, Id_cat_prod from prodpre, precios, medida, productos where Cod_ant=codigo_ant and Cod_umedid=Id_medida and prodpre.Cod_produc=productos.Cod_produc and pres_activo=0 and Cotiza=0 group by Cod_ant) as tabla  where pres_activa=0 and codigo_ant=Cod_ant";
if($precio==5)
	$qry="select codigo_ant, producto, cant_medida, Cod_produc, super as precio from precios, (select DISTINCTROW Cod_ant, cant_medida, prodpre.Cod_produc, Id_cat_prod from prodpre, precios, medida, productos where Cod_ant=codigo_ant and Cod_umedid=Id_medida and prodpre.Cod_produc=productos.Cod_produc and pres_activo=0 and Cotiza=0 group by Cod_ant) as tabla  where pres_activa=0 and codigo_ant=Cod_ant";	
//SELECCIONA EL TIPO DE PRESENTACIONES 1 PARA TODAS, 2 PARA PEQUEÑAS Y 3 PARA GRANDES
if ($presentaciones==1)
	$wh=" and cant_medida<=20000";
if ($presentaciones==2)
	$wh=" and cant_medida<4000";
if ($presentaciones==3)
	$wh=" and cant_medida>3500";
$qry=$qry.$wh."";

$seleccion_p = explode(",", $productos_c);
$b=count($seleccion_p);
$qryp=" and (";
for ($k = 0; $k < $b; $k++) 
{
	$qryp=$qryp." Id_cat_prod=".($seleccion_p[$k]);
	if ($k<=($b-2))
		$qryp=$qryp." or ";	
} 
$qryp=$qryp.")";	
$qry=$qry.$qryp;	
$qry=$qry."  order by Cod_produc,  cant_medida";
//echo $qry;
$resultord=mysqli_query($link,$qryord);
$pdf->Ln(5);
$result=mysqli_query($link,$qry);
$i=1;
$pdf->SetFont('Arial','',8);
while($row=mysqli_fetch_array($result))
{
	$prod=$row[1];
	$cant=$row[4];
	$pdf->Cell(8,3.5,$i++,1,0,'C');
	$pdf->Cell(135,3.5,$prod,1,0,'L');
	$pdf->Cell(4,3.5,'$','LTB',0,'R');
	$pdf->Cell(15,3.5,number_format($cant),'TRB',0,'R');
	$pdf->Ln(3.5);
}

//SELECCIONA LOS PRODUCTOS DE DISTRIBUCIÓN
$qryd="select Id_distribucion, Producto, precio_vta from distribucion where Cotiza=0";
if($distribucion!=NULL)
{
	$seleccion = explode(",", $distribucion);
	$qryd=$qryd." And ( ";	
	$a=count($seleccion);
	for ($j = 0; $j < $a; $j++) 
	{
		$qryd=$qryd."(Id_distribucion > ".($seleccion[$j]*100000)." and Id_distribucion < ".(($seleccion[$j]+1)*100000).")";
		if ($j<=($a-2))
			$qryd=$qryd." or ";	
	} 
	$qryd=$qryd.") order by Producto";	
	$pdf->Ln(5);
	$pdf->SetFont('Baker','',11);
	$resultd=mysqli_query($link,$qryd);
	$rowd=mysqli_fetch_array($resultd);
	//if ($No_dist==0)
	$pdf->Cell(0,5,'PRODUCTOS DE DISTRIBUCIÓN *',0,1, 'C');
	$pdf->SetFont('Arial','',8);
	while($rowd=mysqli_fetch_array($resultd))
	{
		$cod=$rowd[0];
		$prod=$rowd[1];
		$cant=$rowd[2];
		$pdf->Cell(15,3.5,$cod,1,0,'C');
		$pdf->Cell(135,3.5,$prod,1,0,'L');
		$pdf->Cell(4,3.5,'$','LTB',0,'R');
		$pdf->Cell(15,3.5,number_format($cant),'TRB',0,'R');
		$pdf->Ln(3.5);
	}
	$pdf->SetFont('Arial','',8);
	//if ($No_dist==0)
	$pdf->Cell(0,5,'* Estos precios pueden variar sin previo aviso',0,1, 'L');
//	$pdf->Ln(5);
}
else
{
	//echo "no escogió productos de distribución <br>";
}
$pdf->SetFont('Baker','',11);
	$f=fopen('textos/cotiza2.txt','r');
	$txt=fread($f,filesize('textos/cotiza2.txt'));
	fclose($f);
	$pdf->MultiCell(0,5,$txt);
	$pdf->Ln(5);
	$pdf->Cell(60,5,$roword['nom_personal'],0,1);
	$pdf->Cell(60,5,$roword['cargo_personal'],0,1);
	$pdf->Cell(60,5,'Industrias Novaquim S.A.S.',0,1);
	$pdf->Cell(60,5,'Cel: '.$roword['cel_personal'],0,1);
	$pdf->Cell(60,5,'E-mail: '.$roword['Eml_personal'],0,1);


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
