<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$pedidoOperador = new PedidosOperaciones();
$pedidos = $pedidoOperador->getTablePedidosPendientes();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lista de Órdenes de Pedido Pendientes por Facturar</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <script>
        function seleccionar1(form, checkbox_name) {
            var checkboxes = form[checkbox_name];
            for (i = 0; i < checkboxes.length; i++)
                if (form.seleccion1[i].type == "checkbox")
                    if (form.seleccionar.checked == true)
                        form.seleccion1[i].checked = true
                    else if (form.seleccionar.checked == false)
                        form.seleccion1[i].checked = false
        }
    </script>
</head>
<body>
<div id="contenedor">
    <div id="saludo1"><strong>LISTA DE ÓRDENES DE PEDIDO PENDIENTES PARA REVISIÓN</strong></div>
    <form name="revision_pedidos" method="post" action="lista_necesidades.php">
        <div class="row justify-content-between mb-3">
            <div class="col-3 ">
                <input type="checkbox" id="seleccionar" name="seleccionar"
                       onclick='seleccionar1(this.form, "seleccion1[]")'>
                <label for="seleccionar"> Seleccionar Todos/Ninguno</label>
            </div>
            <div class="col-1">
                <button class="button" type="button" onclick="window.location='../menu.php'">
                    <span><STRONG>Ir al Menú</STRONG></span></button>
            </div>
        </div>

        <table>
            <tr class="formatoEncabezados">
                <th></th>
                <th>Pedido</th>
                <th>Cliente</th>
                <th>Fecha Pedido</th>
                <th>Fecha Entrega</th>
                <th>Lugar Entrega</th>
                <th>Dirección Entrega</th>
                <th>Precio</th>
            </tr>
            <?php
            for ($i = 0; $i < count($pedidos); $i++) {
                $idPedido = $pedidos[$i]['idPedido'];
                echo '<tr class="formatoDatos"';
                if (($i % 2) == 0) echo ' bgcolor="#B4CBEF" ';
                echo '>
                    <td class="text-center"><input type="checkbox" id="seleccion1" class=”check” name="seleccion1[]" value="' . $idPedido . '"></td>
                    <td class="text-center">' . $pedidos[$i]['idPedido'] . '</td>
                    <td class="text-left">' . $pedidos[$i]['nomCliente'] . '</td>
                    <td class="text-center">' . $pedidos[$i]['fechaPedido'] . '</td>
                    <td class="text-center">' . $pedidos[$i]['fechaEntrega'] . '</td>
                    <td class="text-left">' . $pedidos[$i]['nomSucursal'] . '</td>
                    <td class="text-left">' . $pedidos[$i]['dirSucursal'] . '</td>
                    <td class="text-center">' . $pedidos[$i]['tipoPrecio'] . '</td>
                    ';
                echo '</tr>';
            }
            ?>
        </table>
        <div class="row form-group">
            <div class="col-1">
                <button class="button" type="button" onclick="return Enviar(this.form)">
                    <span>Consultar</span></button>
            </div>
        </div>
    </form>
    <div class="row form-group">
        <div class="col-1">
            <button class="button1" onclick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>