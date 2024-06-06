<?php
include "../../../includes/valAcc.php";
include "../includes/calcularDias.php";

if(isset($_GET['estadocliente'])){
    $estadoCliente = $_GET['estadocliente'];
}
if ($estadoCliente == 1) {
    $titulo = 'Lista de Clientes Activos';
    $encabezado = 'LISTADO DE CLIENTES ACTIVOS DE INDUSTRIAS NOVAQUIM';
} else {
    $titulo = 'Lista de Clientes No Activos';
    $encabezado = 'LISTADO DE CLIENTES INACTIVOS DE INDUSTRIAS NOVAQUIM';

}


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title><?= $titulo ?></title>


    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>
    
    <script>
        /* Formatting function for row details - modify as you need */
        function format(d) {
            // `d` is the original data object for the row
            rep = '<table class="formatoDatos table table-sm table-striped" style="padding-left:50px;width:80%;margin:inherit;">' +
                '<thead>' +
                '<tr>' +
                '<th class="text-center">Contacto</th>' +
                '<th class="text-center">Cargo Contacto</th>' +
                '<th class="text-center">Teléfono</th>' +
                '<th class="text-center">Ciudad</th>' +
                '<th class="text-center">Celular</th>' +
                '<th class="text-center">Correo Electrónico</th>' +
                '</thead>';
                rep += '<tr>' +
                    '<td class="text-start">' + d.contactoCliente + '</td>' +
                    '<td class="text-start">' + d.cargoCliente + '</td>' +
                    '<td class="text-center">' + d.telCliente + '</td>' +
                    '<td class="text-center">' + d.ciudad + '</td>' +
                    '<td class="text-center">' + d.celCliente + '</td>' +
                    '<td class="text-center">' + d.emailCliente + '</td>' +
                    '</tr>'
            rep += '</table>';

            return rep;
        }
        /* Formatting function for row details - modify as you need */
        function diffDate(fecha) {
            let fechUltCompra = new Date(fecha);
            let hoy = new Date();

            // The number of milliseconds in one day
            const ONE_DAY = 1000 * 60 * 60 * 24;

            // Calculate the difference in milliseconds
            const differenceMs = hoy - fechUltCompra;
            // Convert back to days and return
            return Math.round(differenceMs / ONE_DAY);
        }
        $(document).ready(function () {
            let estadoCliente = <?=$estadoCliente?>;
            var table = $('#example').DataTable({
                "columns": [
                    {
                        "className": 'details-control',
                        "orderable": false,
                        "data": null,
                        "defaultContent": ''
                    },
                    {
                        "data": "nitCliente",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nomCliente",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "dirCliente",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "desCatClien",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "nomPersonal",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "ultimaCompra",
                        "className": 'dt-body-center'
                    },
                ],
                "order": [[2, 'asc']],
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
                "createdRow": function (row, data, dataIndex) {
                if (diffDate(data.ultimaCompra) > 120) {
                    $('td', row).addClass('formatoDataTable1');
                } else if (diffDate(data.ultimaCompra) <= 120 && diffDate(data.ultimaCompra) > 60) {
                    $('td', row).addClass('formatoDataTable2');
                }
            },
                "ajax": "../ajax/listaClientes.php?estadoCliente=" + estadoCliente
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
        <img src="../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4><?= $encabezado ?></h4></div>
    <div class="row flex-end">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-100">
        <table id="example" class="formatoDatos table table-sm table-striped formatoDatos">
            <thead>
            <tr>
                <th class="text-center"></th>
                <th class="text-center">NIT</th>
                <th class="text-center">Cliente</th>
                <th class="text-center">Dirección</th>
                <th class="text-center">Tipo de Cliente</th>
                <th class="text-center">Vendedor</th>
                <th class="text-center">Última compra</th>
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