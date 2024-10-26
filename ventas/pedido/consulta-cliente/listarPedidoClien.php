<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idCliente = $_POST['idCliente'];
$clienteOperaciones = new ClientesOperaciones();
$cliente = $clienteOperaciones->getCliente($idCliente);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lista de órdenes de pedido por cliente</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../../css/datatables.css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>
    
    <script>
        /* Formatting function for row details - modify as you need */
        function format(d) {
            // `d` is the original data object for the row
            rep = '<table class="formatoDatos5 table table-sm table-striped" style="padding-left:50px;width:90%;margin:inherit; background-color: white">' +
                '<thead>' +
                '<tr>' +
                '<th class="text-center">Código</th>' +
                '<th class="text-center">Producto</th>' +
                '<th class="text-center">Cantidad</th>' +
                '<th class="text-center">Precio Venta</th>' +
                '</thead>';
            for(i=0; i<d.detPedido.length; i++){
                rep += '<tr>' +
                    '<td class="text-center">' + d.detPedido[i].codProducto + '</td>' +
                    '<td class="text-start">' + d.detPedido[i].Producto + '</td>' +
                    '<td class="text-center">' + d.detPedido[i].cantProducto + '</td>' +
                    '<td class="text-center">' + d.detPedido[i].precioProducto + '</td>' +
                    '</tr>'
            }

            rep += '</table>';

            return rep;
        }

        $(document).ready(function () {
            var perfil = <?=$_SESSION['perfilUsuario']?>;
            let idCliente = '<?=$idCliente?>';
            var table = $('#example').DataTable({
                "columns": [
                    {
                        "className": 'dt-control',
                        "orderable": false,
                        "data": null,
                        "defaultContent": '',
                        width: '3%'
                    },
                    {
                        "data": "idPedido",
                        "className": 'text-center',
                        width: '7%'
                    },
                    {
                        "data": "fechaPedido",
                        "className": 'text-center',
                        width: '10%'
                    },
                    {
                        "data": "fechaEntrega",
                        "className": 'text-center',
                        width: '10%'
                    },
                    {
                        "data": "nomSucursal",
                        "className": 'dt-body-left',
                        width: '20%'
                    },
                    {
                        "data": "dirSucursal",
                        "className": 'text-center',
                        width: '20%'
                    },
                    {
                        "data": "tipoPrecio",
                        "className": 'text-center',
                        width: '10%'
                    },
                    {
                        "data": "estadoPedido",
                        "className": 'text-center',
                        width: '10%'
                    },
                    {
                        "orderable": false,
                        "data": function (row) {
                            let rep = '<form action="../duplicar-pedido/" target="_blank" method="post">' +
                                '          <input name="idPedido" type="hidden" value="' + row.idPedido + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton1"  value="Duplicar pedido">' +
                                '       </form>'
                            return rep;
                        },
                        "className": 'text-center',
                        "visible": (perfil === 1 || perfil === 2),
                        width: '10%'
                    },
                ],
                "order": [[1, 'desc']],
                "deferRender": true,  //For speed
                initComplete: function (settings, json) {
                    $('#example thead th').removeClass('pe-5');
                },
                pagingType: 'simple_numbers',
                layout: {
                    topStart: 'buttons',
                    topStart1: 'search',
                    topEnd: 'pageLength',
                    bottomStart: 'info',
                    bottomEnd: {
                        paging: {
                            numbers: 6
                        }
                    }
                },
                "buttons": [
                    'copyHtml5',
                    'excelHtml5'
                ],
                "lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
                "language": {
                    "emptyTable": "No hay datos disponibles",
                    "lengthMenu": "Mostrando _MENU_ datos por página",
                    "zeroRecords": "Lo siento no encontró nada",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay datos disponibles",
                    "search": "Búsqueda:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "infoFiltered": "(Filtrado de _MAX_ en total)"

                },
                "ajax": "../ajax/listaPedidosCliente.php?idCliente=" + idCliente,
            });
            // Add event listener for opening and closing details
            table.on('click', 'td.dt-control', function (e) {
                var tr = e.target.closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                } else {
                    // Open this row
                    row.child(format(row.data())).show();
                }
            });
        });
    </script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>LISTA DE ÓRDENES DE PEDIDO <?= $cliente['nomCliente'] ?></h4></div>
    <div class="row justify-content-end mb-3">
        <div class="col-1">
            <button class="button" onclick="window.location='../../../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-100">
        <table id="example" class="formatoDatos5 table table-sm table-striped">
            <thead>
            <tr>
                <th class="width1"></th>
                <th class="width2 text-center">Pedido</th>
                <th class="width3 text-center">Fecha Pedido</th>
                <th class="width4 text-center">Fecha Entrega</th>
                <th class="width5 text-center">Lugar Entrega</th>
                <th class="width6 text-center">Dirección Entrega</th>
                <th class="width7 text-center">Precio</th>
                <th class="width8 text-center">Estado</th>
            </tr>
            </thead>
        </table>
    </div>

    <div class="row">
        <div class="col-1">
            <button class="button" onclick="window.location='../../../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span>
            </button>
        </div>
    </div>

</div>
</body>
</html>