<?php
include "../../../includes/valAcc.php";
$idCliente = $_POST['idCliente'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lista de Facturas de Venta</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../../css/datatables.css">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
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
            for (i = 0; i < d.detFactura.length; i++) {
                rep += '<tr>' +
                    '<td class="text-center">' + d.detFactura[i].codigo + '</td>' +
                    '<td class="text-start">' + d.detFactura[i].producto + '</td>' +
                    '<td class="text-center">' + d.detFactura[i].cantProducto + '</td>' +
                    '<td class="text-center">' + d.detFactura[i].precioProducto + '</td>' +
                    '</tr>'
            }

            rep += '</table>';

            return rep;
        }

        $(document).ready(function () {

            let idCliente = <?=$idCliente?>;
            var table = $('#example').DataTable({
                "columns": [
                    {
                        "className": 'dt-control',
                        "orderable": false,
                        "data": null,
                        "defaultContent": '',
                        width: '2%'
                    },
                    {
                        "data": "idFactura",
                        "className": 'text-center',
                        width: '5%'
                    },
                    {
                        "data": "idPedido",
                        "className": 'dt-body-center',
                        width: '5%'
                    },
                    {
                        "data": "idRemision",
                        "className": 'text-center',
                        width: '5%'
                    },
                    {
                        "data": "nomCliente",
                        "className": 'dt-body-left',
                        width: '30%'
                    },
                    {
                        "data": "fechaFactura",
                        "className": 'text-center',
                        width: '10%'
                    },
                    {
                        "data": "fechaVenc",
                        "className": 'text-center',
                        width: '10%'
                    },
                    {
                        "data": "totalFactura",
                        "className": 'dt-body-right pe-5',
                        width: '10%'
                    },
                    {
                        "data": "estadoFactura",
                        "className": 'text-center',
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
                "ajax": "../ajax/listaFacturasCliente.php?idCliente=" + idCliente,
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
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>LISTA DE FACTURAS DE VENTA</h4></div>
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
                <th class="text-center">Factura</th>
                <th class="text-center">Pedido</th>
                <th class="text-center">Remision</th>
                <th class="text-center">Cliente</th>
                <th class="text-center">Fecha Factura</th>
                <th class="text-center">Fecha Vencimiento</th>
                <th class="text-center">Total</th>
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