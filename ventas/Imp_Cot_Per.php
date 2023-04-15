<?php
session_start();
require('../includes/fpdf.php');
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idCotPersonalizada = $_POST['idCotPersonalizada'];
$iva = $_POST['iva'];
$cotizacionOperador = new CotizacionesPersonalizadasOperaciones();
$cotizacion = $cotizacionOperador->getCotizacionPForPrint($idCotPersonalizada);

//echo "destino=".$destino;

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
        //Arial italic 8
        $this->SetFont('Arial', '', 8);
        //Número de página
        $this->Cell(182, 10, utf8_decode('Dirección: Bogotá D.C. Calle 35 C Sur No. 26 F - 40  PBX: 2039484 - 2022912  Website:www.novaquim.com   E-mail: info@novaquim.com'), 0, 0, 'C');
    }
}

//Creación del objeto de la clase heredada

$Nom_clien = utf8_decode($cotizacion['nomCliente']);
$Contacto = utf8_decode($cotizacion['contactoCliente']);
$Cargo = utf8_decode($cotizacion['cargoContacto']);
$Fech_Cotizacion = $cotizacion['fechaCotizacion'];
$precio = $cotizacion['tipoPrecio'];
$Ciudad = utf8_decode($cotizacion['ciudad']);
$nom_personal = utf8_decode($cotizacion['nomPersonal']);
$cel_personal = $cotizacion['celPersonal'];
$Eml_personal = $cotizacion['emlPersonal'];
$cargo_personal = utf8_decode($cotizacion['cargo']);
$destino = $cotizacion['destino'];
$pdf = new PDF('P', 'mm', 'Letter');
$pdf->AliasNbPages();
$pdf->SetMargins(25, 55, 20);
$pdf->AddFont('Baker', '', 'Baker.php');
$pdf->AddPage();
$pdf->SetFont('Baker', '', 11);
if ($destino == 2)
    $pdf->Image('../images/borde.jpg', 10, 10, 195, 255);

$pdf->Write(4, $Ciudad);
$fecha = time();
$pdf->Cell(30, 4, FechaFormateada($fecha), 0, 1);
$pdf->Ln(4);
$pdf->Cell(60, 4, utf8_decode('Señores:'), 0, 1);
$pdf->Cell(60, 4, $Nom_clien, 0, 1);
$pdf->Cell(60, 4, 'Atn. ' . $Contacto, 0, 1);
$pdf->Cell(60, 4, $Cargo, 0, 1);
$pdf->Cell(60, 4, 'E.    S.    D.', 0, 1);
$pdf->Ln(1);
$pdf->Cell(0, 5, utf8_decode('Cotización No. ') . $idCotPersonalizada . ' - ' . date("y"), 0, 1, 'C');
$pdf->Ln(2);
$pdf->MultiCell(0, 5, utf8_decode('Tenemos el gusto de poner a su consideración nuestra propuesta comercial para su servicio.'));
//PRODUCTOS
$detCotPersonalizadaOperador = new DetCotizacionPersonalizadaOperaciones();
$detalle = $detCotPersonalizadaOperador->getTableDetCotPersonalizada($idCotPersonalizada);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(8, 3, "Item", 1, 0, 'C');
$pdf->Cell(110, 3, 'Producto', 1, 0, 'C');
$pdf->Cell(15, 3, 'Cantidad', 1, 0, 'C');
$pdf->Cell(19, 3, 'Precio', 1, 0, 'C');
$pdf->Cell(19, 3, 'Subtotal', 1, 0, 'C');
$pdf->Ln(3);
$pdf->SetFont('helvetica', '', 8);
$totalIva=0;
$totalSinIva=0;
for ($i = 0; $i < count($detalle); $i++) {
    $totalIva += $detalle[$i]['subtotal'];
    $totalSinIva += $detalle[$i]['subtotalSinIva'];
    $precioProducto = $iva == 1 ? $detalle[$i]['precioProducto'] : $detalle[$i]['precioProductoSinIva'];
    $subTotal = $iva == 1 ? $detalle[$i]['subtotal'] : $detalle[$i]['subtotalSinIva'];
    $pdf->Cell(8, 3.5, ($i + 1), 1, 0, 'C');
    $pdf->Cell(110, 3.5, utf8_decode($detalle[$i]['producto']), 1, 0, 'L');
    $pdf->Cell(15, 3.5, $detalle[$i]['canProducto'], 1, 0, 'C');
    $pdf->Cell(19, 3.5, '$'.number_format($precioProducto), 1, 0, 'R');
    $pdf->Cell(19, 3.5, '$'.number_format($subTotal), 1, 0, 'R');
    $pdf->Ln(3.5);
}
$pdf->SetFont('helvetica', 'B', 8);
$total = $iva == 1 ? $totalIva : $totalSinIva;
$pdf->Cell(152, 3, utf8_decode('TOTAL COTIZACIÓN'), 0, 0, 'R');
$pdf->Cell(19, 3,  '$'.number_format($total), 0, 1, 'R');
$pdf->SetFont('Baker', '', 11);
$fileName = $iva == 1 ? 'cotiza_iva.txt' : 'cotiza_sin_iva.txt';
$f = fopen('../textos/'.$fileName, 'r');
$txt = fread($f, filesize('../textos/'.$fileName));
fclose($f);
$pdf->MultiCell(0, 5, $txt);
$pdf->Ln(2);
$pdf->Cell(60, 4, $nom_personal, 0, 1);
$pdf->Cell(60, 4, $cargo_personal, 0, 1);
$pdf->Cell(60, 4, 'Industrias Novaquim S.A.S.', 0, 1);
$pdf->Cell(60, 4, 'Cel: ' . $cel_personal, 0, 1);
$pdf->Cell(60, 4, 'E-mail: ' . $Eml_personal, 0, 1);
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
