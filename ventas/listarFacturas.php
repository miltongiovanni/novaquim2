<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lista de Facturas de Venta</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <link rel="stylesheet" href="../css/datatables.css">
    <style>
        #example {
            table-layout: fixed;
        }

        .width1 {
            width: 2%;
        }

        .width2 {
            width: 5%;
        }

        .width3 {
            width: 10%;
        }

        .width4 {
            width: 10%;
        }

        .width5 {
            width: 30%;
        }

        .width6 {
            width: 8%;
        }

        .width7 {
            width: 10%;
        }

        .width8 {
            width: 5%;
        }

        .width9 {
            width: 7%;
        }
    </style>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>
    <script src="../js/dataTables.buttons.js"></script>
    <script src="../js/jszip.js"></script>
    <script src="../js/pdfmake.js"></script>
    <script src="../js/vfs_fonts.js"></script>
    <script src="../js/buttons.html5.js"></script>
    <script>
        /* Formatting function for row details - modify as you need */
        function format(d) {
            // `d` is the original data object for the row
            rep = '<table cellpadding="5" cellspacing="0" border="0"  class="display compact formatoDatos" style="padding-left:50px;width:50%;margin:inherit;">' +
                '<thead>' +
                '<tr>' +
                '<th align="center">Código</th>' +
                '<th align="center">Producto</th>' +
                '<th align="center">Cantidad</th>' +
                '<th align="center">Precio Venta</th>' +
                '</thead>';
            for (i = 0; i < d.detFactura.length; i++) {
                rep += '<tr>' +
                    '<td align="center">' + d.detFactura[i].codigo + '</td>' +
                    '<td align="left">' + d.detFactura[i].producto + '</td>' +
                    '<td align="center">' + d.detFactura[i].cantProducto + '</td>' +
                    '<td align="center">' + d.detFactura[i].precioProducto + '</td>' +
                    '</tr>'
            }

            rep += '</table>';

            return rep;
        }

        $(document).ready(function () {
            var table = $('#example').DataTable({
                "columns": [
                    {
                        "className": 'details-control',
                        "orderable": false,
                        "data": null,
                        "defaultContent": ''
                    },
                    {
                        "data": "idFactura",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "idPedido",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "idRemision",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "nomCliente",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "fechaFactura",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "fechaVenc",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "totalFactura",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "estadoFactura",
                        "className": 'dt-body-center'
                    },
                ],
                "order": [[1, 'desc']],
                "deferRender": true,  //For speed
                "dom": 'Blfrtip',
                "buttons": [
                    'copyHtml5',
                    'excelHtml5'
                ],
                "lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
                "language": {
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
                "ajax": "ajax/listaFacturas.php",
            });
            // Add event listener for opening and closing details
            $('#example tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    row.child(format(row.data())).show();
                    tr.addClass('shown');
                }
            });
        });
    </script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1"><h4>LISTA DE FACTURAS DE VENTA</h4></div>
    <div class="row flex-end mb-3">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-100">
        <table id="example" class="display compact formatoDatos">
            <thead>
            <tr>
                <th class="width1"></th>
                <th class="width2">Factura</th>
                <th class="width3">Pedido</th>
                <th class="width4">Remision</th>
                <th class="width5">Cliente</th>
                <th class="width6">Fecha Factura</th>
                <th class="width7">Fecha Vencimiento</th>
                <th class="width8">Total</th>
                <th class="width9">Estado</th>
            </tr>
            </thead>
        </table>
    </div>

    <div class="row">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span>
            </button>
        </div>
    </div>
</div>
</body>
</html>