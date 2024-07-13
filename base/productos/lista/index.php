<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Lista de Productos</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../../css/datatables.css">
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>


    <script>
        $(document).ready(function () {
            $('#example').DataTable({
                "columns": [
                    {
                        /*"className": 'dt-control',*/
                        /*"orderable": false,*/
                        "data": "codProducto",
                        /*"defaultContent": ''*/
                    },
                    {
                        "data": "nomProducto",
                    },
                    {
                        "data": "catProd",
                    },
                    {
                        "data": "densMin",
                    },
                    {
                        "data": "densMax",
                    },
                    {
                        "data": "pHmin",
                    },
                    {
                        "data": "pHmax",
                    },
                    {
                        "data": "fragancia",
                    },
                    {
                        "data": "color",
                    },
                    {
                        "data": "apariencia",
                    }
                ],
                "columnDefs":
                    [{
                        "targets": [0, 3, 4, 5, 6],
                        "className": 'text-center'
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
                "ajax": "../ajax/listaProd.php"
            });
        });
    </script>
</head>

<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>LISTADO DE PRODUCTOS </h4></div>
    <div class="row justify-content-end">
        <div class="col-1">
            <button class="button" type="button" onclick="window.location='../../../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-100">
        <table id="example" class="formatoDatos5 table table-sm table-striped">
            <thead>
            <tr>
                <th class="text-center">Código</th>
                <th class="text-center">Producto</th>
                <th class="text-center">Categoría</th>
                <th class="text-center">Dens min</th>
                <th class="text-center">Dens máx</th>
                <th class="text-center">pH min</th>
                <th class="text-center">ph máx</th>
                <th class="text-center">Fragancia</th>
                <th class="text-center">Color</th>
                <th class="text-center">Apariencia</th>
            </tr>
            </thead>
        </table>
    </div>


    <div class="row">
        <div class="col-1">
            <button class="button" type="button"
                    onclick="window.location='../../../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
</div>
</body>

</html>