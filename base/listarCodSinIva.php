<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Lista de Precios</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
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
            var precioSinIva=1;
            $('#example').DataTable({
                "columns": [
                    {
                        /*"className": 'details-control',*/
                        /*"orderable": false,*/
                        "data": "Código",
                        /*"defaultContent": ''*/
                    },
                    {
                        "data": "Descripción",
                    },
                    {
                        "data": "Precio Super",
                    },
                    {
                        "data": "Precio Fábrica",
                    },
                    {
                        "data": "Precio Mayorista",
                    },
                    {
                        "data": "Precio Distribución",
                    },
                    {
                        "data": "Precio Detal",
                    }
                ],
                "columnDefs":
                    [{
                        "targets": [0],
                        "className": 'dt-body-center'
                    },
                        {
                        "targets": [ 2, 3, 4, 5, 6],
                        "className": 'dt-body-right'
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
                "ajax": "ajax/listaCod.php?precioSinIva=" + precioSinIva
            });
        });
    </script>
</head>

<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>LISTA DE PRECIOS SIN IVA</h4></div>
    <div class="row flex-end">
        <div class="col-2">
            <form action="XlsListaPrecios.php" method="post" target="_blank">
                <input type="hidden" name="precioSinIva" value="1">
                <button class="button" type="submit">
                    <span><STRONG>Exportar a Excel</STRONG></span></button>
            </form>
        </div>
        <div class="col-2">
            <form action="selListaPrecios.php" method="post" target="_blank">
                <input type="hidden" name="precioSinIva" value="1">
                <button class="button" type="submit">
                    <span><STRONG>Imprimir Lista de Precios</STRONG></span></button>
            </form>
        </div>
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-70" style="margin-top: 20px;">
        <table id="example" class="display compact formatoDatos">
            <thead>
            <tr>
                <th>Código</th>
                <th class="text-center">Descripción</th>
                <th class="text-end">Precio Super</th>
                <th class="text-end">Precio Fábrica</th>
                <th class="text-end">Precio Mayorista</th>
                <th class="text-end">Precio Distribución</th>
                <th class="text-end">Precio Detal</th>
            </tr>
            </thead>
        </table>
    </div>

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