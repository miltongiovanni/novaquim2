<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lista de Kits Armados</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
    <style>
        table {
            table-layout: fixed;
        }

        .width1 {
            width: 8%;
        }

        .width2 {
            width: 8%;
        }

        .width3 {
            width: 49%;
        }

        .width4 {
            width: 15%;
        }

        .width5 {
            width: 20%;
        }

    </style>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>
    

    <script>
        $(document).ready(function () {
            $('#example').DataTable({
                "columns": [
                    {
                        /*"className": 'details-control',*/
                        /*"orderable": false,*/
                        "data": "idArmado",
                        /*"defaultContent": ''*/
                    },
                    {
                        "data": "codigo",
                    },
                    {
                        "data": "producto",
                    },
                    {
                        "data": "cantArmado",
                    },
                    {
                        "data": "fechArmado",
                    },
                ],
                "columnDefs":
                    [{
                        "targets": [0, 1, 2, 3, 4],
                        "className": 'dt-body-center'
                    }
                    ],
                "dom": 'Blfrtip',
                "buttons": [
                    'copyHtml5',
                    'excelHtml5'
                ],
                "order": [[0, "desc"]],
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
                "ajax": "ajax/listaArmKits.php"
            });
        });
    </script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>LISTADO KIT ARMADOS</h4></div>
    <div class="row flex-end">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-50">
        <table id="example" class="display compact formatoDatos">
            <thead>
            <tr>
                <th class="width1">Id</th>
                <th class="width2">Código</th>
                <th class="width3">Producto</th>
                <th class="width4">Cantidad</th>
                <th class="width5">Fecha</th>
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

</div>
</body>
</html>