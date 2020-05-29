<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Listado de Presentaciones de Producto</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script  src="../js/validar.js"></script>
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
                        "data": "codPresentacion",
                        /*"defaultContent": ''*/
                    },
                    {
                        "data": "presentacion",
                    },
                    {
                        "data": "desMedida",
                    },
                    {
                        "data": "nomEnvase",
                    },
                    {
                        "data": "tapa",
                    },
                    {
                        "data": "codigoGen",
                    },
                    {
                        "data": "coSiigo",
                    }
                ],
                "columnDefs":
                    [{
                        "targets": [0, 1, 2, 3, 4, 5, 6],
                        "className": 'dt-body-center'
                    }
                    ],
                "dom": 'Blfrtip',
                "buttons": [
                    'copyHtml5',
                    'excelHtml5'
                ],
                "order": [[0, "asc"]],
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
                "ajax": "ajax/listaMed.php"
            });
        });
    </script>
</head>

<body>
<div id="contenedor">
    <div id="saludo1"><strong>LISTA DE PRESENTACIONES DE PRODUCTO</strong></div>
    <div class="row flex-end">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-80">
        <table id="example" class="display compact formatoDatos">
            <thead>
            <tr>
                <th>Código</th>
                <th>Presentación</th>
                <th>Medida</th>
                <th>Envase</th>
                <th>Tapa</th>
                <th>Cod Anterior</th>
                <th>Cod Siigo</th>
            </tr>
            </thead>
        </table>
    </div>

    <div class="row">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>

</body>

</html>