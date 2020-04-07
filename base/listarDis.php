<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Lista de Productos de Distribución</title>
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
                        "data": "idDistribucion",
                        /*"defaultContent": ''*/
                    },
                    {
                        "data": "producto",
                    },
                    {
                        "data": "precio",
                    },
                    {
                        "data": "iva",
                    },
                    {
                        "data": "catDis",
                    },
                    {
                        "data": "coSiigo",
                    },
                ],
                "columnDefs":
                    [{
                        "targets": [0, 1, 2, 3, 4, 5],
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
                "ajax": "ajax/listaProdDis.php"
            });
        });
    </script>
</head>

<body>
<div id="contenedor">
    <div id="saludo1"><strong>LISTADO DE PRODUCTOS DE DISTRIBUCIÓN </strong></div>
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
            <th>Producto</th>
            <th>Precio</th>
            <th>Iva</th>
            <th>Categoría</th>
            <th>Código Siigo</th>
        </tr>
        </thead>
    </table>
    <div class="row">
        <div class="col-1">
            <button class="button"
                    onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
</div>
</body>

</html>
