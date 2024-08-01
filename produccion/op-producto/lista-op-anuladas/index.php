<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lista de Órdenes de Producción Anuladas</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../../css/datatables.css">
    <style>
        table {
            table-layout: fixed;
        }

        .width1 {
            width: 2%;
        }

        .width2 {
            width: 4%;
        }

        .width3 {
            width: 25%;
        }

        .width4 {
            width: 24%;
        }

        .width5 {
            width: 12%;
        }

        .width6 {
            width: 16%;
        }

        .width7 {
            width: 9%;
        }

        .width8 {
            width: 8%;
        }
    </style>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>


    <script>
        $(document).ready(function () {
            var table = $('#example').DataTable({
                "columns": [
                    {
                        "data": "lote",
                        "className": 'dt-body-center',
                        width: '9%'
                    },
                    {
                        "data": "nomProducto",
                        "className": 'dt-body-left',
                        width: '27%'
                    },
                    {
                        "data": "nomFormula",
                        "className": 'dt-body-left',
                        width: '27%'
                    },
                    {
                        "data": "fechProd",
                        "className": 'dt-body-center',
                        width: '12%'
                    },
                    {
                        "data": "nomPersonal",
                        "className": 'dt-body-left',
                        width: '15%'
                    },
                    {
                        "data": "cantidadKg",
                        "className": 'dt-body-center',
                        width: '10%'
                    },
                ],
                "order": [[0, 'desc']],
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
                "paging": true,
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
                "ajax": "../ajax/listaOProdA.php",
                "deferRender": true,  //For speed
                initComplete: function (settings, json) {
                    $('#example thead th').removeClass('pe-5');
                }
            });
        });
    </script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>LISTA DE ÓRDENES DE PRODUCCIÓN ANULADAS</h4></div>
    <div class="row justify-content-end">
        <div class="col-1">
            <button class="button" onclick="window.location='../../../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-80">
        <table id="example" class="formatoDatos5 table table-sm table-striped">
            <thead>
            <tr>
                <th class="text-center">Lote</th>
                <th class="text-center">Producto</th>
                <th class="text-center">Fórmula</th>
                <th class="text-center">Fecha Producción</th>
                <th class="text-center">Responsable</th>
                <th class="text-center">Cantidad (Kg)</th>
            </tr>
            </thead>
        </table>
    </div>

    <div class="row">
        <div class="col-1">
            <button class="button" onclick="window.location='../../../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span>
            </button>
        </div>
    </div>
</div>
</body>
</html>