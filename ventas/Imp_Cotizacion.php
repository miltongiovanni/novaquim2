<?php
session_start();
require '../includes/fpdf.php';
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');
$idCotizacion = $_POST['idCotizacion'];
$cotizacionOperador = new CotizacionesOperaciones();
$cotizacion = $cotizacionOperador->getCotizacionForPrint($idCotizacion);
class PDF extends FPDF
{

//Cabecera de página
    function Header()
    {
        if ($this->PageNo() == 1) {
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
        $this->SetXY(15, 263);
        //$this->SetY(-15);
        //Arial italic 8
        $this->SetFont('Arial', '', 8);
        //Número de página
        $this->Cell(185, 10, utf8_decode('Dirección: Bogotá D.C. Calle 35 C Sur No. 26 F - 40  PBX: 2039484 - 2022912  Website:www.novaquim.com   E-mail: info@novaquim.com'), 0, 0, 'C');
    }
}

//Creación del objeto de la clase heredada
$Nom_clien = utf8_decode($cotizacion['nomCliente']);
$contactoCliente = utf8_decode($cotizacion['contactoCliente']);
$Cargo = utf8_decode($cotizacion['cargoContacto']);
$Dir_clien = utf8_decode($cotizacion['dirCliente']);
$Fech_Cotizacion = $cotizacion['fechaCotizacion'];
$precio = $cotizacion['precioCotizacion'];
$presentaciones = $cotizacion['presentaciones'];
$distribucion = $cotizacion['distribucion'];
$productos_c = $cotizacion['productos'];
$destino = $cotizacion['destino'];
$Ciudad = utf8_decode($cotizacion['ciudad']);
$nom_personal = utf8_decode($cotizacion['nomPersonal']);
$cel_personal = $cotizacion['celPersonal'];
$Eml_personal = $cotizacion['emlPersonal'];
$cargo_personal = utf8_decode($cotizacion['cargo']);
$Des_cat_cli = utf8_decode($cotizacion['desCatClien']);
$pdf = new PDF('P', 'mm', 'Letter');
$pdf->AliasNbPages();
$pdf->SetMargins(25, 55, 20);
$pdf->AddFont('Baker', '', 'Baker.php');
$pdf->AddPage();
$pdf->SetFont('Baker', '', 11);
if ($destino == 2)
    $pdf->Image('../images/borde.jpg', 10, 10, 195, 255);

$pdf->Write(5, utf8_decode($cotizacion['ciudad']));
$fecha = time();
$pdf->Cell(30, 5, FechaFormateada($fecha), 0, 1);
$pdf->Ln(12);
$pdf->Cell(60, 5, utf8_decode('Señores:'), 0, 1);
$pdf->Cell(60, 5, $Nom_clien, 0, 1);
$pdf->Cell(60, 5, 'Atn. ' . $contactoCliente, 0, 1);
$pdf->Cell(60, 5, $Cargo, 0, 1);
$pdf->Cell(100, 5, $Dir_clien, 0, 1);
$pdf->Ln(12);
$pdf->Cell(60, 5, utf8_decode('Apreciado(a) Señor(a): '), 0, 1);
$pdf->Ln(12);
//Abrir fichero de texto
$f = fopen('../textos/cotiza1.txt', 'r');
$txt = fread($f, filesize('../textos/cotiza1.txt'));
fclose($f);
$pdf->MultiCell(0, 5, 'Teniendo en cuenta la importancia que su ' . $Des_cat_cli . ' ' . ($txt));
$pdf->Ln(16);
$pdf->Cell(60, 5, $nom_personal, 0, 1);
$pdf->Cell(60, 5, $cargo_personal, 0, 1);
$pdf->Cell(60, 5, 'Industrias Novaquim', 0, 1);
$pdf->Cell(60, 5, 'Cel: ' . $cel_personal, 0, 1);
$pdf->Cell(60, 5, 'E-mail: ' . $Eml_personal, 0, 1);
$pdf->SetMargins(30, 30, 20);
$pdf->AddPage();
$pdf->Write(5, $Ciudad);
$pdf->Cell(30, 5, FechaFormateada($fecha), 0, 1);
$pdf->Ln(5);
$pdf->Cell(60, 5, utf8_decode('Señores:'), 0, 1);
$pdf->Cell(60, 5, $Nom_clien, 0, 1);
$pdf->Ln(5);
$pdf->Cell(0, 5, utf8_decode('Cotización No. ') . $idCotizacion . ' - ' . date("y"), 0, 1, 'C');
$pdf->Ln(5);
$pdf->MultiCell(0, 5, utf8_decode('Tenemos el gusto de poner a su consideración nuestra propuesta comercial para el servicio de su organización.'));
$productos= $cotizacionOperador->getProductosCotizacion($precio, $presentaciones, $productos_c);
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 8);
for ($i=0; $i<count($productos); $i++) {
    $prod = utf8_decode($productos[$i][1]);
    $cant = $productos[$i][2];
    $pdf->Cell(8, 3.5, ($i+1), 1, 0, 'C');
    $pdf->Cell(135, 3.5, $prod, 1, 0, 'L');
    $pdf->Cell(4, 3.5, '$', 'LTB', 0, 'R');
    $pdf->Cell(15, 3.5, $cant, 'TRB', 0, 'R');
    $pdf->Ln(3.5);
}
//SELECCIONA LOS PRODUCTOS DE DISTRIBUCIÓN

$prodDistr= $cotizacionOperador->getProductosDistCotizacion($distribucion);
if (count($prodDistr) > 0){
    $pdf->Ln(5);
    $pdf->SetFont('Baker', '', 11);
    //if ($No_dist==0)
    $pdf->Cell(0, 5, utf8_decode('PRODUCTOS DE DISTRIBUCIÓN *'), 0, 1, 'C');
    $pdf->SetFont('Arial', '', 8);
    for($i=0; $i<count($prodDistr); $i++) {
        $cod = $prodDistr[$i][0];
        $prod = utf8_decode($prodDistr[$i][1]);
        $cant = $prodDistr[$i][2];
        $pdf->Cell(15, 3.5, $cod, 1, 0, 'C');
        $pdf->Cell(135, 3.5, $prod, 1, 0, 'L');
        $pdf->Cell(4, 3.5, '$', 'LTB', 0, 'R');
        $pdf->Cell(15, 3.5, number_format($cant), 'TRB', 0, 'R');
        $pdf->Ln(3.5);
    }
    $pdf->SetFont('Arial', '', 8);
    //if ($No_dist==0)
    $pdf->Cell(0, 5, '* Estos precios pueden variar sin previo aviso', 0, 1, 'L');
    //	$pdf->Ln(5);
}

$pdf->SetFont('Baker', '', 11);
$f = fopen('../textos/cotiza2.txt', 'r');
$txt = fread($f, filesize('../textos/cotiza2.txt'));
fclose($f);
$pdf->MultiCell(0, 5, ($txt));
$pdf->Ln(5);
$pdf->Cell(60, 5, $nom_personal, 0, 1);
$pdf->Cell(60, 5, $cargo_personal, 0, 1);
$pdf->Cell(60, 5, 'Industrias Novaquim S.A.S.', 0, 1);
$pdf->Cell(60, 5, 'Cel: ' . $cel_personal, 0, 1);
$pdf->Cell(60, 5, 'E-mail: ' . $Eml_personal, 0, 1);

$pdf->Output();
function FechaFormateada($FechaStamp)
{
    $ano = date('Y', $FechaStamp); //<-- Año
    $mes = date('m', $FechaStamp); //<-- número de mes (01-31)
    $dia = date('d', $FechaStamp); //<-- Día del mes (1-31)
    $dialetra = date('w', $FechaStamp);  //Día de la semana(0-7)
    switch ($dialetra) {
        case 0:
            $dialetra = "Domingo";
            break;
        case 1:
            $dialetra = "Lunes";
            break;
        case 2:
            $dialetra = "Martes";
            break;
        case 3:
            $dialetra = "Miércoles";
            break;
        case 4:
            $dialetra = "Jueves";
            break;
        case 5:
            $dialetra = "Viernes";
            break;
        case 6:
            $dialetra = "Sábado";
            break;
    }
    switch ($mes) {
        case '01':
            $mesletra = "Enero";
            break;
        case '02':
            $mesletra = "Febrero";
            break;
        case '03':
            $mesletra = "Marzo";
            break;
        case '04':
            $mesletra = "Abril";
            break;
        case '05':
            $mesletra = "Mayo";
            break;
        case '06':
            $mesletra = "Junio";
            break;
        case '07':
            $mesletra = "Julio";
            break;
        case '08':
            $mesletra = "Agosto";
            break;
        case '09':
            $mesletra = "Septiembre";
            break;
        case '10':
            $mesletra = "Octubre";
            break;
        case '11':
            $mesletra = "Noviembre";
            break;
        case '12':
            $mesletra = "Diciembre";
            break;
    }
    return ", $dia de $mesletra de $ano";
}

?>
