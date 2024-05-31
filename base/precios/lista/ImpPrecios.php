<?php
include "../../../includes/valAcc.php";
require '../../../includes/fpdf.php';
foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');
$PrecioOperador = new PreciosOperaciones();
$precios = $PrecioOperador->getTablePreciosPDF($query);
class PDF extends FPDF
{
    //Cabecera de p�gina
    public function Header()
    {
        if ($this->PageNo() == 1) {
            //Logo
            //{$this->Image('images/LogoNova.jpg',15,15, 15, 65);}
            //$this->Image('images/LogoNova1.jpg',15,15,65);
            //Arial bold 15
            /*$this->SetFont('Arial','B',16);
        //Movernos a la derecha
        $this->SetXY(70,45);
        //T�tulo
        $this->Cell(70,10,'ORDEN DE PEDIDO',0,0,'C');
        //Salto de l�nea
        $this->Ln(20);*/
        }
    }

    //Pie de p�gina
    public function Footer()
    {
        //Posici�n: a 1,5 cm del final
        $this->SetY(-15);
        //Arial italic 8
        $this->SetFont('Arial', '', 8);
        //N�mero de p�gina
        $this->Cell(0, 10, iconv('UTF-8', 'windows-1252', 'Dirección: Bogotá D.C. Calle 35 C Sur No. 26 F - 40  PBX: 2039484 - 2022912  Website:www.novaquim.com   E-mail: info@novaquim.com'), 0, 0, 'C');
    }
}

//Creaci�n del objeto de la clase heredada
//include "includes/conect.php";
//$link=conectarServidor();
$year = date("Y");
$pdf = new PDF('P', 'mm', 'Letter');
$pdf->AliasNbPages();
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(15, 4, "LISTA DE PRECIOS INDUSTRIAS NOVAQUIM S.A.S. VIGENCIA DESDE FEBRERO 1 DE " . $year, 0, 0, 'L');
$pdf->Ln(4);
$pdf->Cell(15, 4, iconv('UTF-8', 'windows-1252', "Código"), 1, 0, 'C');
$pdf->Cell(80, 4, "Producto", 1, 0, 'C');
$opciones = explode(",", $opciones_prec1);
$b = count($opciones);
for ($k = 0; $k < $b; $k++) {
    $pdf->Cell(20, 4, iconv('UTF-8', 'windows-1252', $opciones[$k]), 1, 0, 'C');
}
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 9);
/*$result=mysqli_query($link,$query);*/
$campos=$b+2;
$filas=count($precios);
for($i=0; $i<$filas; $i++)
{
	$cod=$precios[$i][0];
	$producto=$precios[$i][1];
	$pdf->Cell(15,3.5,$cod,1,0,'C');
	$pdf->Cell(80,3.5,utf8_decode($producto),1,0,'L');

	for ($j = 2; $j < $campos; $j++)
	{
        if ($precioSinIva == 0){
            $pdf->Cell(20,3.5,'$ '.number_format($precios[$i][$j]),1,0,'R');
        }else{
            $pdf->Cell(20,3.5,'$ '.number_format($precios[$i][$j]/1.19),1,0,'R');
        }
	}
	$pdf->Ln(3.5);
}
$pdf->Output();
?>
