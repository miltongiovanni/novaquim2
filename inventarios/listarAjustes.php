<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Histórico ajustes inventario</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
    <style>
        #example {
            table-layout: fixed;
        }

        .width1 {
            width: 3%;
        }

        .width2 {
            width: 8%;
        }

        .width3 {
            width: 8%;
        }
        .width4 {
            width: 15%;
        }
        .width5 {
            width: 20%;
        }
        .width6 {
            width: 8%;
        }

        .width7 {
            width: 8%;
        }

        .width8 {
            width: 8%;
        }
        .width9 {
            width: 22%;
        }

    </style>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>
    <script src="../js/dataTables.buttons.js"></script>
    <script src="../js/jszip.js"></script>
    <script src="../js/pdfmake.js"></script>
    <script src="../js/vfs_fonts.js"></script>
    <script src="../js/buttons.html5.js"></script>

    <script>
        jQuery.extend(jQuery.fn.dataTableExt.oSort, {
            "chinese-string-asc": function (s1, s2) {
                if (s1 != null && s1 != undefined && s2 != null && s2 != undefined) {
                    return s1.localeCompare(s2);
                } else if (s2 == null || s2 == undefined) {
                    return s1;
                } else if (s1 == null || s1 == undefined) {
                    return s2;
                }
            },

            "chinese-string-desc": function (s1, s2) {
                if (s1 != null && s1 != undefined && s2 != null && s2 != undefined) {
                    return s2.localeCompare(s1);
                } else if (s2 == null || s2 == undefined) {
                    return s1;
                } else if (s1 == null || s1 == undefined) {
                    return s2;
                }
            }
        });
        $(document).ready(function () {
            $('#example').DataTable({
                "columns": [
                    {
                        /*"className": 'details-control',*/
                        /*"orderable": false,*/
                        "data": "idAjustes",
                        /*"defaultContent": ''*/
                    },
                    {
                        "data": "tipo",
                    },
                    {
                        "data": "fecha_ajuste",
                    },
                    {
                        "data": "nomPersonal",
                    },
                    {
                        "data": "item",
                    },
                    {
                        "data": "lote",
                    },
                    {
                        "data": "inv_ant",
                    },
                    {
                        "data": "inv_nvo",
                    },
                    {
                        "data": "motivo_ajuste",
                    },
                ],
                "columnDefs":
                    [{
                        "targets": [0, 2, 5, 6, 7],
                        "className": 'dt-body-center'
                    },
                        {
                            type: 'chinese-string',
                            targets: [1, 4]
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
                "ajax": "ajax/listaAjustes.php"
            });
        });
    </script>
</head>

<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>HISTÓRICO AJUSTES INVENTARIO</h4></div>
    <div class="row flex-end">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-100">
        <table id="example" class="display compact formatoDatos">
            <thead>
            <tr>
                <th class="width1 text-center">Id</th>
                <th class="width2 text-center">Tipo</th>
                <th class="width3 text-center">Fecha</th>
                <th class="width4 text-center">Responsable</th>
                <th class="width5 text-center">Item</th>
                <th class="width6 text-center">Lote</th>
                <th class="width7 text-center">Inv anterior</th>
                <th class="width8 text-center">Inv nuevo</th>
                <th class="width9 text-center">Motivo</th>
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