<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Lista de Precios</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script  src="../../../js/validar.js"></script>
    <link rel="stylesheet" href="../../../css/datatables.css">
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>


    <script>
        $(document).ready(function () {
            var precioSinIva=<?= $precioSinIva?>;
            $('#example').DataTable({
                "columns": [
                    {
                        /*"className": 'dt-control',*/
                        /*"orderable": false,*/
                        "data": "Código",
                        width: '8%'
                        /*"defaultContent": ''*/
                    },
                    {
                        "data": "Descripción",
                        width: '32%'
                    },
                    {
                        "data": "Precio Super",
                        width: '12%',
                        className: 'pe-5'
                    },
                    {
                        "data": "Precio Fábrica",
                        width: '12%',
                        className: 'pe-5'
                    },
                    {
                        "data": "Precio Mayorista",
                        width: '12%',
                        className: 'pe-5'
                    },
                    {
                        "data": "Precio Distribución",
                        width: '12%',
                        className: 'pe-5'
                    },
                    {
                        "data": "Precio Detal",
                        width: '12%',
                        className: 'pe-5'
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
                "order": [[0, "asc"]],
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
                "ajax": "../ajax/listaCod.php?precioSinIva=" + precioSinIva
            });
        });
    </script>
</head>

<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>LISTA DE PRECIOS</h4></div>
    <div class="row justify-content-end">
        <div class="col-2">
            <form action="XlsListaPrecios.php" method="post" target="_blank">
                <input type="hidden" name="precioSinIva" value="<?= $precioSinIva?>">
                <button class="button" type="submit">
                    <span><STRONG>Exportar a Excel</STRONG></span></button>
            </form>
        </div>
        <div class="col-2">
            <form action="selListaPrecios.php" method="post" target="_blank">
                <input type="hidden" name="precioSinIva" value="<?= $precioSinIva?>">
                <button class="button" type="submit">
                    <span><STRONG>Imprimir Lista de Precios</STRONG></span></button>
            </form>
        </div>
        <div class="col-1">
            <button class="button" onclick="window.location='../../../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-80" style="margin-top: 20px;">
        <table id="example" class="formatoDatos5 table table-sm table-striped">
            <thead>
            <tr>
                <th class="text-center">Código</th>
                <th class="text-center">Descripción</th>
                <th class="text-center">Precio Super</th>
                <th class="text-center">Precio Fábrica</th>
                <th class="text-center">Precio Mayorista</th>
                <th class="text-center">Precio Distribución</th>
                <th class="text-center">Precio Detal</th>
            </tr>
            </thead>
        </table>
    </div>

    <div class="row">
        <div class="col-1">
            <button class="button"
                    onclick="window.location='../../../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>

</div>
</body>

</html>