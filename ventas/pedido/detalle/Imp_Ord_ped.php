<?php
session_start();
require('../includes/fpdf.php');
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
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
        $this->Cell(190, 6, iconv('UTF-8', 'windows-1252', 'No. de Envases: _____________________ No. Bolsas: _____________________ Otros: ______________________________________'), 0, 1, 'L');
        $this->Cell(190, 6, iconv('UTF-8', 'windows-1252', 'Resp. alistamiento prod: _____________________ Resp. alistamiento dist: _____________________ Aprobó: _____________________'), 0, 1, 'L');
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
$pdf->Cell(80, 8, iconv('UTF-8', 'windows-1252', 'DEPARTAMENTO DE PRODUCCIÓN'), 1, 0, 'C');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(65, 8, iconv('UTF-8', 'windows-1252', 'CÓDIGO: DP-OPA-01'), 1, 0, 'C');
$pdf->SetXY(60, 18);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(80, 16, iconv('UTF-8', 'windows-1252', 'ORDEN DE PEDIDO Y ALISTAMIENTO'), 1, 0, 'C');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(65, 8, iconv('UTF-8', 'windows-1252', 'VERSIÓN: 1.00'), 1, 0, 'C');
$encabfecha = date('Y-m-d');
date_default_timezone_set('America/Bogota');
$pdf->SetXY(140, 26);
$pdf->Cell(65, 8, Imp_Ord_ped . phpiconv('UTF-8', 'windows-1252', 'Fecha Emisión: ') . $encabfecha, 1, 0, 'C');
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetXY(160, 34);
$pdf->Cell(30, 8, Imp_Ord_ped . phpiconv('UTF-8', 'windows-1252', 'Pedido : ') . $idPedido);

$pdf->SetFont('Arial', '', 10);
$pdf->SetXY(10, 35);
$pdf->Cell(150, 5, 'Cliente: '.iconv('UTF-8', 'windows-1252', $pedido['nomCliente']),0 ,1);
$pdf->Cell(150, 5, 'Lugar entrega: '.iconv('UTF-8', 'windows-1252', $pedido['nomSucursal']));
$pdf->Cell(30, 5, iconv('UTF-8', 'windows-1252', 'Teléfono: '.$pedido['telCliente']), 0, 1);
$pdf->Cell(110, 5, Imp_Ord_ped . phpiconv('UTF-8', 'windows-1252', 'Dir.:') . iconv('UTF-8', 'windows-1252', $pedido['dirSucursal']));
$pdf->Cell(60, 5, 'Fch pedido: '.$pedido['fechaPedido']. '    Fch entrega: '.$pedido['fechaEntrega']);
$pdf->SetXY(10, 52);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 4, 'Item', 0, 0, 'C');
$pdf->Cell(20, 4, iconv('UTF-8', 'windows-1252', 'Código '), 0, 0, 'R');
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
    $pdf->Cell(115, 3.7, iconv('UTF-8', 'windows-1252', $prod), 'B', 0, 'L');
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
