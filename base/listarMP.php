<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Lista de Materias Primas</title>
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
        $(document).ready(function () {
            $('#example').DataTable({
                "columns": [
                    {
                        /*"className": 'details-control',*/
                        /*"orderable": false,*/
                        "data": "codMPrima",
                        /*"defaultContent": ''*/
                    },
                    {
                        "data": "nomMPrima",
                    },
                    {
                        "data": "aliasMPrima",
                    },
                    {
                        "data": "catMP",
                    },
                    {
                        "data": "minStockMprima",
                    },
                    {
                        "data": "aparienciaMPrima",
                    },
                    {
                        "data": "olorMPrima",
                    },
                    {
                        "data": "colorMPrima",
                    },
                    {
                        "data": "pHmPrima",
                    },
                    {
                        "data": "densidadMPrima",
                    },
                    {
                        "data": "codMPrimaAnt",
                    },
                ],
                "columnDefs":
                    [{
                        "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                        "className": 'dt-body-center'
                    }
                    ],
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
                "ajax": "ajax/listaMP.php"
            });
        });
    </script>
</head>

<body>
<div id="contenedor">
    <div id="saludo1"><strong>LISTADO DE MATERIAS PRIMAS</strong></div>
    <div class="row" style="justify-content: right;">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <table id="example" class="display compact formatoDatos" style="width:100%">
        <thead>
        <tr>
            <th>Código</th>
            <th>Materia Prima</th>
            <th>Alias</th>
            <th>Tipo Materia Prima</th>
            <th>Stock min</th>
            <th>Apariencia</th>
            <th>Olor</th>
            <th>Color</th>
            <th>pH</th>
            <th>Densidad</th>
            <th>Código ant</th>
        </tr>
        </thead>
    </table>
    <div class="row">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>

</div>
</body>

</html>