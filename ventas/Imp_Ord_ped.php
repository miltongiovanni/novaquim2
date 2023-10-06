<?php
session_start();
require('../includes/fpdf.php');
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idPedido = $_POST['idPedido'];
$pedidoOperador = new PedidosOperaciones();
$pedido = $pedidoOperador->getPedido($idPedido);
$detPedidoOperador = new DetPedidoOperaciones();
$detalle = $detPedidoOperador->getTableDetPedido($idPedido);

class PDF extends FPDF
{
    //Cabecera de página
    function Header()
    {
        //Logo
        $this->Image('../images/LogoNova1.jpg', 15, 12, 38, 19);
        //Arial bold 15
        //$this->SetFont('Arial','B',16);
        //Movernos a la derecha
        //$this->SetXY(70,43);
        //Título
        //$this->Cell(70,10,'ORDEN DE PEDIDO',0,0,'C');
        //Salto de línea
        $this->Ln(10);
    }

    //Pie de página
    function Footer()
    {
        //Posición: a 1,5 cm del final
        $this->SetY(-17);
        //Arial italic 8
        $this->SetFont('Arial', '', 9);
        //Número de página
        $this->Cell(190, 6, utf8_decode('Responsable alistamiento producción: ______________________________________ No. de Envases: __________ No. Bolsas: _______'), 0, 1, 'L');
        $this->Cell(190, 6, utf8_decode('Responsable alistamiento distribución: ______________________________________ Aprobó: __________________________________'), 0, 1, 'L');
    }
}
$pdf = new PDF('P', 'mm', 'Letter');
$pdf->AliasNbPages();
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(true, 10);//margin bottom
$pdf->AddPage();
$pdf->SetXY(62, 26);
$pdf->SetFont('Arial', '', 8);
date_default_timezone_set('America/Bogota');
$encabfecha = 'USUARIO: ' . $_SESSION['Username'] . '     |   FECHA: ' . date('d-m-Y  h:i:s');
$pdf->Cell(90, 10, $encabfecha, 0, 0, 'L');
$pdf->SetXY(10, 10);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(50, 24, '', 1, 0, 'C');
$pdf->Cell(80, 8, utf8_decode('DEPARTAMENTO DE PRODUCCIÓN'), 1, 0, 'C');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(65, 8, utf8_decode('CÓDIGO: DP-OPA-01'), 1, 0, 'C');
$pdf->SetXY(60, 18);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(80, 16, utf8_decode('ORDEN DE PEDIDO Y ALISTAMIENTO'), 1, 0, 'C');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(65, 8, utf8_decode('VERSIÓN: 1.00'), 1, 0, 'C');
$encabfecha = date('Y-m-d');
date_default_timezone_set('America/Bogota');
$pdf->SetXY(140, 26);
$pdf->Cell(65, 8, utf8_decode('Fecha Emisión: ') . $encabfecha, 1, 0, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->SetXY(10, 35);
$pdf->Cell(35, 5, 'Cliente: ');
$pdf->Cell(110, 5, utf8_decode($pedido['nomCliente']));
$pdf->Cell(30, 5, utf8_decode('Teléfono: '));
$pdf->Cell(30, 5, $pedido['telCliente'], 0, 1);
$pdf->Cell(35, 5, 'Lugar de Entrega: ');
$pdf->Cell(110, 5, utf8_decode($pedido['nomSucursal']));
$pdf->Cell(30, 5, 'Fecha de Pedido: ');
$pdf->Cell(30, 5, $pedido['fechaPedido'], 0, 1);
$pdf->Cell(35, 5, utf8_decode('Dirección de Entrega: '));
$pdf->Cell(110, 5, utf8_decode($pedido['dirSucursal']));
$pdf->Cell(30, 5, 'Fecha de Entrega:');
$pdf->Cell(30, 5, $pedido['fechaEntrega'], 0, 1);
$pdf->SetXY(10, 52);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 4, 'Item', 0, 0, 'C');
$pdf->Cell(20, 4, utf8_decode('Código '), 0, 0, 'R');
$pdf->Cell(115, 4, 'Producto ', 0, 0, 'C');
$pdf->Cell(30, 4, 'Lote ', 0, 0, 'C');
$pdf->Cell(20, 4, 'Unidades ', 0, 0, 'C');
$pdf->SetFont('Arial', '', 9);
$pdf->SetXY(10,57);
for ($i = 0; $i < count($detalle); $i++) {
    $codprod = $detalle[$i]['codProducto'];
    $prod = $detalle[$i]['producto'];
    $cant = $detalle[$i]['cantProducto'];
    $pdf->Cell(10, 3.7, $i + 1, 'B', 0, 'C');
    $pdf->Cell(20, 3.7, $codprod, 'B', 0, 'R');
    $pdf->Cell(115, 3.7, utf8_decode($prod), 'B', 0, 'L');
    $pdf->Cell(30, 3.7, '', 'B', 0, 'C');
    $pdf->Cell(20, 3.7, $cant, 'B', 1, 'C');
}
$pdf->SetFont('Arial', '', 10);
$pdf->SetY(-35);
$pdf->Cell(195, 5, 'OBSERVACIONES:', 'B', 1);
$pdf->Cell(195, 5, '', 'B', 1);
$pdf->Cell(195, 5, '', 'B', 1);
$pdf->Output();
?>
