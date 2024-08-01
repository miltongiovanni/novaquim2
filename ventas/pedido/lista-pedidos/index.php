<?php
include "../../../includes/valAcc.php";
switch ($estadoPedido) {
    case '6':
        $titulo = ' anulados';
        break;
    case '1':
        $titulo = ' pendientes';
        break;
    case 'N':
        $titulo = '';
        break;
    default:
        $titulo = '';
        break;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lista de Órdenes de Pedido<?= $titulo ?></title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../../css/datatables.css">
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>
    <script>
        /* Formatting function for row details - modify as you need */
        function format(d) {
            // `d` is the original data object for the row
            rep = '<table class="formatoDatos5 table table-sm table-striped" style="padding-left:50px;width:50%;margin:inherit; background-color: white">' +
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
                    '<td  class="text-start">' + d.detPedido[i].Producto + '</td>' +
                    '<td class="text-center">' + d.detPedido[i].cantProducto + '</td>' +
                    '<td class="text-center">' + d.detPedido[i].precioProducto + '</td>' +
                    '</tr>'
            }
            rep += '</table>';
            return rep;
        }

        $(document).ready(function () {
            let estadoPedido = '<?=$estadoPedido?>';
            var table = $('#example').DataTable({
                "columns": [
                    {
                        "className": 'dt-control',
                        "orderable": false,
                        "searchable": false,
                        "data": null,
                        "defaultContent": '',
                        width: '2%'
                    },
                    {
                        "data": "idPedido",
                        "className": 'text-center',
                        width: '4%'
                    },
                    {
                        "data": "nomCliente",
                        "className": 'dt-body-left',
                        width: '26%'
                    },
                    {
                        "data": "fechaPedido",
                        "className": 'dt-body-left',
                        width: '5%'
                    },
                    {
                        "data": "fechaEntrega",
                        "className": 'dt-body-left',
                        width: '5%'
                    },
                    {
                        "data": "nomSucursal",
                        "className": 'dt-body-left',
                        width: '26%'
                    },
                    {
                        "data": "dirSucursal",
                        "className": 'dt-body-left',
                        width: '17%'
                    },
                    {
                        "data": "tipoPrecio",
                        "className": 'dt-body-left',
                        width: '7%'
                    },
                    {
                        "data": "estadoPedido",
                        "className": 'dt-body-left',
                        width: '7%'
                    },
                ],
                "order": [[1, estadoPedido==='1'? 'asc':'desc']],
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
                processing: true,
                serverSide: true,
                "ajax": "../ajax/listaPedidos.php?estadoPedido=" + estadoPedido,
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
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>LISTA DE ÓRDENES DE PEDIDO<?= $titulo ?></h4></div>
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
                <th class=""></th>
                <th class="text-center">Pedido</th>
                <th class="text-center">Cliente</th>
                <th class="text-center">Fecha Pedido</th>
                <th class="text-center">Fecha Entrega</th>
                <th class="text-center">Lugar Entrega</th>
                <th class="text-center">Dirección Entrega</th>
                <th class="text-center">Precio</th>
                <th class="text-center">Estado</th>
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