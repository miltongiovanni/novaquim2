<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lista de Órdenes de Producción de Color</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../../css/datatables.css">
    <style>
        table {
            table-layout: fixed;
        }

        .width1 {
            width: 5%;
        }

        .width2 {
            width: 10%;
        }

        .width3 {
            width: 25%;
        }

        .width4 {
            width: 20%;
        }

        .width5 {
            width: 25%;
        }

        .width6 {
            width: 15%;
        }
    </style>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>


    <script>


        /* Formatting function for row details - modify as you need */
        function format(d) {
            // `d` is the original data object for the row
            rep = '<table  class="formatoDatos table table-sm table-striped" style="padding-left:50px;width:80%;margin:inherit;">' +
                '<thead>' +
                '<tr>' +
                '<th class="text-center">Código</th>' +
                '<th class="text-center">Materia Prima</th>';
            rep += '<th class="text-center">Lote MP</th>' +
                '<th class="text-center">Cantidad</th>' +
                '</tr>' +
                '</thead>';
            for (i = 0; i < d.detOProdColor.length; i++) {
                rep += '<tr>' +
                    '<td class="text-center">' + d.detOProdColor[i].codMPrima + '</td>' +
                    '<td class="text-center">' + d.detOProdColor[i].aliasMPrima + '</td>';
                rep += '<td class="text-center">' + d.detOProdColor[i].cantMPrima + '</td>' +
                    '<td class="text-center">' + d.detOProdColor[i].loteMPrima + '</td>' +
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
                        "data": "loteColor",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nomMPrima",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "fechProd",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nomPersonal",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": function (row) {
                            let rep = row.cantKg + ' Kg'
                            return rep;
                        },
                        "className": 'dt-body-center'
                    },
                ],
                "order": [[1, 'desc']],
                "dom": 'Blfrtip',
                "paging": true,
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
                "ajax": "../ajax/listaOProdColor.php",
                "deferRender": true,  //For speed
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
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>LISTA DE ÓRDENES DE PRODUCCIÓN DE COLOR</h4></div>
    <div class="row flex-end">
        <div class="col-1">
            <button class="button" onclick="window.location='../../../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-50">
        <table id="example" class="formatoDatos table table-sm table-striped formatoDatos">
            <thead>
            <tr>
                <th class="width1"></th>
                <th class="width2 text-center">Lote</th>
                <th class="width3 text-center">Solución de color</th>
                <th class="width4 text-center">Fecha producción</th>
                <th class="width5 text-center">Responsable</th>
                <th class="width6 text-center">Cantidad (Kg)</th>
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