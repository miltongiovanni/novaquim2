<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$pedidoOperador = new PedidosOperaciones();
$pedidos = $pedidoOperador->getPedidosPorEntregar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Creación de rutero</title>
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
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>LISTA DE ÓRDENES DE PEDIDO
            FACTURADAS LISTAS PARA ENTREGAR</h4></div>
    <form name="revision_pedidos" method="post" action="rutero_diario.php">
        <div class="form-group row">
            <div class="col-2">
                <label for="fechaRutero"> Fecha rutero</label>
                <input type="date" class="form-control" required
                       name="fechaRutero" id="fechaRutero" value="">
            </div>
        </div>
        <div class="row justify-content-between mb-3">
            <div class="col-3 ">
                <input type="checkbox" id="seleccionar" name="seleccionar"
                       onclick='seleccionar1(this.form, "seleccion1[]")'>
                <label for="seleccionar"> Seleccionar Todos/Ninguno</label>
            </div>
            <div class="col-2">
                <button class="button" type="button" onclick="return Enviar(this.form)">
                    <span><STRONG>Generar Rutero</STRONG></span></button>
            </div>
        </div>

        <table>
            <tr class="formatoEncabezados">
                <th></th>
                <th>Pedido</th>
                <th>Factura</th>
                <th>Remisión</th>
                <th>Fecha Pedido</th>
                <th>Fecha Entrega</th>
                <th>Cliente</th>
                <th>Lugar Entrega</th>
                <th>Dirección Entrega</th>
            </tr>
            <?php
            for ($i = 0; $i < count($pedidos); $i++) {
                $idPedido = $pedidos[$i]['idPedido'];
                echo '<tr class="formatoDatos"';
                if (($i % 2) == 0) echo ' bgcolor="#B4CBEF" ';
                echo '>
                    <td class="text-center"><input type="checkbox" id="seleccion1" class=”check” name="seleccion1[]" value="' . $idPedido . '"></td>
                    <td class="text-center">' . $pedidos[$i]['idPedido'] . '</td>
                    <td class="text-center">' . $pedidos[$i]['idFactura'] . '</td>
                    <td class="text-center">' . $pedidos[$i]['idRemision'] . '</td>
                    <td class="text-center">' . $pedidos[$i]['fechaPedido'] . '</td>
                    <td class="text-center">' . $pedidos[$i]['fechaEntrega'] . '</td>
                    <td class="text-start">' . $pedidos[$i]['nomCliente'] . '</td>
                    <td class="text-start">' . $pedidos[$i]['nomSucursal'] . '</td>
                    <td class="text-start">' . $pedidos[$i]['dirSucursal'] . '</td>
                    ';
                echo '</tr>';
            }
            ?>
        </table>
        <div class="row form-group">
            <div class="col-2">
                <button class="button" type="button" onclick="return Enviar(this.form)">
                    <span>Generar Rutero</span></button>
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