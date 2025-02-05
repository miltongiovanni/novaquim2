<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lista de salidas por Remisión</title>
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
            rep = '<table class="formatoDatos5 table table-sm table-striped" style="padding-left:50px;width:60%;margin:inherit; background-color: white">' +
                '<thead>' +
                '<tr>' +
                '<th class="text-center">Código</th>' +
                '<th class="text-center">Producto</th>' +
                '<th class="text-center">Cantidad</th>' +
                '</thead>';
            for (i = 0; i < d.detRemision.length; i++) {
                rep += '<tr>' +
                    '<td class="text-center">' + d.detRemision[i].codigo + '</td>' +
                    '<td class="text-start">' + d.detRemision[i].producto + '</td>' +
                    '<td class="text-center">' + d.detRemision[i].cantProductoT + '</td>' +
                    '</tr>'
            }

            rep += '</table>';

            return rep;
        }

        $(document).ready(function () {
            var table = $('#example').DataTable({
                "columns": [
                    {
                        "className": 'dt-control',
                        "orderable": false,
                        "searchable": false,
                        "data": null,
                        "defaultContent": '',
                        width: '5%'
                    },
                    {
                        "data": "idRemision",
                        "className": 'text-center',
                        width: '5%'
                    },
                    {
                        "data": "fechaRemision",
                        "className": 'text-center',
                        width: '10%'
                    },
                    {
                        "data": "nomCliente",
                        "className": 'dt-body-left',
                        width: '30%'
                    },
                    {
                        "data": "nomSucursal",
                        "className": 'dt-body-left',
                        width: '30%'
                    },
                    {
                        "data": "idPedido",
                        "className": 'text-center',
                        width: '10%'
                    },
                    {
                        "data": "fechaPedido",
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
                processing: true,
                serverSide: true,
                "ajax": "../ajax/listaRemisiones.php",
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
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>LISTA DE SALIDAS POR REMISIÓN</h4></div>
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
                <th class="text-center">Remisión</th>
                <th class="text-center">Fecha remisión</th>
                <th class="text-center">Cliente</th>
                <th class="text-center">Lugar de entrega</th>
                <th class="text-center">Pedido</th>
                <th class="text-center">Fecha Pedido</th>
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