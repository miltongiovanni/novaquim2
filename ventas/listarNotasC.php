<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lista de Notas Crédito</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
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
            width: 40%;
        }

        .width4 {
            width: 10%;
        }

        .width5 {
            width: 9%;
        }

        .width6 {
            width: 9%;
        }

        .width7 {
            width: 15%;
        }

        .width8 {
            width: 10%;
        }
    </style>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>
    
    <script>
        /* Formatting function for row details - modify as you need */
        function format(d) {
            // `d` is the original data object for the row
            rep = '<table class="display compact formatoDatos" style="padding-left:50px;width:50%;margin:inherit;">' +
                '<thead>' +
                '<tr>' +
                '<th class="text-center">Código</th>' +
                '<th class="text-center">Producto</th>' +
                '<th class="text-center">Cantidad</th>' +
                '</thead>';
            for(i=0; i<d.detNotaCr.length; i++){
                rep += '<tr>' +
                    '<td class="text-center">' + d.detNotaCr[i].codigo + '</td>' +
                    '<td class="text-start">' + d.detNotaCr[i].producto + '</td>' +
                    '<td class="text-center">' + d.detNotaCr[i].cantidad + '</td>' +
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
                        "data": "idNotaC",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nomCliente",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "fechaNotaC",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "facturaOrigen",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "facturaDestino",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "motivo",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "totalNotaC",
                        "className": 'dt-body-right'
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
                "ajax": "ajax/listaNotasCredito.php",
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
        <img src="../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>LISTA DE NOTAS CRÉDITO</h4></div>

    <div class="row flex-end mb-3">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>

    <div class="tabla-80">
        <table id="example" class="display compact formatoDatos">
            <thead>
            <tr>
                <th class="width1"></th>
                <th class="width2 text-center">Nota Crédito</th>
                <th class="width3 text-center">Cliente</th>
                <th class="width4 text-center">Fecha</th>
                <th class="width5 text-center">Factura Origen</th>
                <th class="width6 text-center">Factura Afecta</th>
                <th class="width7 text-center">Motivo</th>
                <th class="width8 text-center">Valor</th>
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