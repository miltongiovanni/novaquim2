<?php
include "../../../includes/valAcc.php";

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lista de gastos</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <link rel="stylesheet" href="../../../css/datatables.css">
    <style>
        #example {
            table-layout: fixed;
        }

        .width1 {
            width: 2%;
        }

        .width2 {
            width: 6%;
        }

        .width3 {
            width: 9%;
        }

        .width4 {
            width: 21%;
        }

        .width5 {
            width: 6%;
        }

        .width6 {
            width: 8%;
        }

        .width7 {
            width: 7%;
        }

        .width8 {
            width: 8%;
        }
        .width9 {
            width: 8%;
        }
        .width10 {
            width: 8%;
        }

        .width11 {
            width: 9%;
        }
        .width12 {
            width: 8%;
        }
    </style>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>
    

    <script>


        /* Formatting function for row details - modify as you need */
        function format(d) {
            // `d` is the original data object for the row
            rep = '<table  class="formatoDatos table table-sm table-striped" style="padding-left:50px;width:50%;margin:inherit; background-color: white">' +
                '<thead>' +
                '<tr>' +
                '<th class="text-center">Descripción</th>' +
                '<th class="text-center">Cantidad</th>';
            rep += '<th class="text-center">Precio</th>' +
                '<th class="text-center">Iva</th>' +
                '</tr>' +
                '</thead>';
            for (i = 0; i < d.detGasto.length; i++) {
                rep += '<tr>' +
                    '<td class="text-center">' + d.detGasto[i].producto + '</td>' +
                    '<td class="text-center">' + d.detGasto[i].cantGasto + '</td>';
                rep += '<td class="text-center">' + d.detGasto[i].precGasto + '</td>' +
                    '<td class="text-center">' + d.detGasto[i].iva + '</td>' +
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
                        "data": null,
                        "defaultContent": ''
                    },
                    {
                        "data": "idGasto",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nitProv",
                        "className": 'dt-body-right pe-4'
                    },
                    {
                        "data": "nomProv",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "numFact",
                        "className": 'dt-body-right pe-4'
                    },
                    {
                        "data": "fechGasto",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "fechVenc",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "descEstado",
                        "className": ''
                    },
                    {
                        "data": "totalGasto",
                        "className": 'dt-body-right pe-4'
                    },
                    {
                        "data": "retefuenteGasto",
                        "className": 'dt-body-right pe-4'
                    },
                    {
                        "data": "reteicaGasto",
                        "className": 'dt-body-right pe-4'
                    },
                    {
                        "data": "vreal",
                        "className": 'dt-body-right pe-4'
                    },
                ],
                "order": [[1, 'desc']],
                "deferRender": true,  //For speed
                initComplete: function (settings, json) {
                    $('#example thead th').removeClass('pe-4');
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
                "ajax": "../ajax/listaGastos.php"
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
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>LISTA DE GASTOS</h4></div>
    <div class="row justify-content-end">
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
                <th class="width2 text-center">Id Gasto</th>
                <th class="width3 text-center">NIT</th>
                <th class="width4 text-center">Proveedor</th>
                <th class="width5 text-center">Factura</th>
                <th class="width6 text-center">Fech Compra</th>
                <th class="width7 text-center">Fecha Vto</th>
                <th class="width8 text-center">Estado</th>
                <th class="width9 text-center">Valor Factura</th>
                <th class="width10 text-center">Retefuente</th>
                <th class="width11 text-center">Rete Ica</th>
                <th class="width12 text-center">Valor Real</th>
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