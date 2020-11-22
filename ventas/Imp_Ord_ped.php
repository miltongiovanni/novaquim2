<?php
include "../includes/valAcc.php";
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
        $this->Image('../images/LogoNova1.jpg', 80, 10, 55);
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
        $this->SetY(-15);
        //Arial italic 8
        $this->SetFont('Arial', '', 10);
        //Número de página
        $this->Cell(0, 10, utf8_decode('Elaboró: ______________________________________   Aprobó: __________________________________'), 0, 0, 'C');
    }
}

//Creación del objeto de la clase heredada
/*include "includes/conect.php";
$link=conectarServidor();
$pedido=$_POST['pedido'];
$qryord="Select nomCliente, idPedido, fechaPedido, fechaEntrega, codVendedor, nom_personal, tipoPrecio, pedido.Estado, nomSucursal, dirSucursal, telCliente 
		FROM pedido, personal, clientes, tip_precio, clientes_sucursal 
		where codVendedor=Id_personal and idPedido=$pedido and clientes.nitCliente=nit_cliente and idPrecio=tipoPrecio and idSucursal=idSucursal and clientes_sucursal.Nit_clien=Nit_cliente";
$resultord=mysqli_query($link,$qryord);
$pedido=mysqli_fetch_array($resultord);*/
//$cod_prod=$pedido['Codigo'];
$pdf = new PDF('P', 'mm', 'Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetXY(10, 10);
$pdf->SetFont('Arial', '', 8);
$encabfecha = 'USUARIO: ' . $_SESSION['User'] . '     |   FECHA: ' . date('d-m-Y  h:i:s');
date_default_timezone_set('America/Bogota');
$pdf->Cell(90, 10, $encabfecha, 0, 0, 'L');


$pdf->SetXY(70, 43);
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(70, 10, 'ORDEN DE PEDIDO No.' . $idPedido, 0, 0, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->SetXY(10, 55);
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
$pdf->SetXY(30, 75);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 5, 'Item', 0, 0, 'C');
$pdf->Cell(20, 5, utf8_decode('Código '), 0, 0, 'R');
$pdf->Cell(100, 5, 'Producto ', 0, 0, 'C');
$pdf->Cell(10, 5, 'Unidades ', 0, 0, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->SetXY(10,80);
/*$qry="SELECT codProducto, cantProducto, Nombre as Producto from det_pedido, prodpre
where codProducto=Cod_prese and idPedido=$pedido and codProducto <100000 and codProducto>100 order by Producto";
$result=mysqli_query($link,$qry);
$i=1;
while($row=mysqli_fetch_array($result))*/
for ($i = 0; $i < count($detalle); $i++) {
    $codprod = $detalle[$i]['codProducto'];
    $prod = $detalle[$i]['producto'];
    $cant = $detalle[$i]['cantProducto'];
    $pdf->Cell(20);
    $pdf->Cell(10, 4, $i + 1, 0, 0, 'C');
    $pdf->Cell(20, 4, $codprod, 0, 0, 'R');
    $pdf->Cell(100, 4, utf8_decode($prod), 0, 0, 'L');
    $pdf->Cell(10, 4, $cant, 0, 0, 'C');
    $pdf->Ln(4);
}/*
$qry="select codProducto, cantProducto, Producto from det_pedido, distribucion 
where codProducto=Id_distribucion and idPedido=$pedido and codProducto >=100000 order by Producto;";
$result=mysqli_query($link,$qry);
while($row=mysqli_fetch_array($result))
{
$codprod=$row['Cod_producto'];
$prod=$row['Producto'];
$cant=$row['Can_producto'];
$pdf->Cell(20);
$pdf->Cell(10,4,$i,0,0,'C');
$pdf->Cell(20,4,$codprod,0,0,'R');
$pdf->Cell(100,4,$prod,0,0,'L');
$pdf->Cell(10,4,$cant,0,0,'C');
$pdf->Ln(4);
$i= $i+1 ;
}
$qry="select idPedido, codProducto, DesServicio as Producto, cantProducto, precioProducto as Precio
 from det_pedido, servicios 
 where codProducto<100 and codProducto=IdServicio and idPedido=$pedido";
$result=mysqli_query($link,$qry);
while($row=mysqli_fetch_array($result))
{
$codprod=$row['Cod_producto'];
$prod=$row['Producto'];
$cant=$row['Can_producto'];
$pdf->Cell(20);
$pdf->Cell(10,4,$i,0,0,'C');
$pdf->Cell(20,4,$codprod,0,0,'R');
$pdf->Cell(100,4,$prod,0,0,'L');
$pdf->Cell(10,4,$cant,0,0,'C');
$pdf->Ln(4);
$i= $i+1 ;
}*/
$pdf->SetFont('Arial', '', 10);
$pdf->SetY(-35);
$pdf->Cell(10, 8, 'Observaciones:');
$pdf->Line(10, 255, 200, 255);
$pdf->Line(10, 260, 200, 260);
//mysqli_close($link);
$pdf->Output();
?>
