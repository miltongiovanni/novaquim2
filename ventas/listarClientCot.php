<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lista de Clientes de Cotización</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
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
            rep = '<table class="display compact" style="padding-left:50px;width:60%;margin:inherit;">' +
                '<thead>' +
                '<tr>' +
                '<th class="text-center">Dirección</th>' +
                '<th class="text-center">Ciudad</th>' +
                '<th class="text-center">Correo Electrónico</th>' +
                '<th class="text-center">Celular</th>' +
                '<th class="text-center">Vendedor</th>' +
                '</thead>';
            rep += '<tr>' +
                '<td class="text-center">' + d.dirCliente + '</td>' +
                '<td class="text-center">' + d.ciudad + '</td>' +
                '<td class="text-center">' + d.emailCliente + '</td>' +
                '<td class="text-center">' + d.celCliente + '</td>' +
                '<td class="text-center">' + d.nomPersonal + '</td>' +
                '</tr>'
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
                        "data": "idCliente",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nomCliente",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "contactoCliente",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "cargoContacto",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "telCliente",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "desCatClien",
                        "className": 'dt-body-left'
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
                "ajax": "ajax/listaClientesCotizacion.php"
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
        <img src="../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>LISTA DE CLIENTES DE COTIZACIÓN</h4></div>
    <div class="row flex-end mb-3">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-90">
        <table id="example" class="display compact formatoDatos">
            <thead>
            <tr>
                <th></th>
                <th class="text-center">Id</th>
                <th class="text-center">Cliente</th>
                <th class="text-center">Contacto</th>
                <th class="text-center">Cargo Contacto</th>
                <th class="text-center">Teléfono</th>
                <th class="text-center">Actividad</th>
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