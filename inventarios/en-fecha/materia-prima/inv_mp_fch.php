<?php
include "../../../includes/valAcc.php";
$fecha = $_POST['fecha'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Inventario de Materia Prima</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../../css/datatables.css">
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>
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
            var table = $('#example').DataTable({
                "columns": [
                    {
                        "data": "codMP",
                        "className": 'dt-body-center',
                        width: '12%'
                    },
                    {
                        "data": "nomMPrima",
                        "className": 'dt-body-left',
                        width: '40%'
                    },
                    {
                        "data": "invtotal",
                        render: DataTable.render.number(',', '.', 3, ''),
                        "className": 'pe-4',
                        width: '12%'
                    },
                    {
                        "data": "entrada",
                        render: DataTable.render.number(',', '.', 3, ''),
                        "className": 'pe-4',
                        width: '12%'
                    },
                    {
                        "data": "salida",
                        render: DataTable.render.number(',', '.', 3, ''),
                        "className": 'pe-4',
                        width: '12%'
                    },
                    {
                        "data": "inventario",
                        render: DataTable.render.number(',', '.', 3, ''),
                        "className": 'pe-4',
                        width: '12%'
                    },
                ],
                "columnDefs": [
                    {type: 'chinese-string', targets: 1}
                ],
                "order": [[1, 'asc']],
                "paging": true,
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
                "ajax": "../ajax/listaInvMPrimaFecha.php?fecha=<?= $fecha; ?>",
                "deferRender": true,  //For speed
                initComplete: function (settings, json) {
                    $('#example thead th').removeClass('pe-4');
                }
            });
        });
    </script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>INVENTARIO DE MATERIA PRIMA A <?= $fecha; ?></h4></div>
    <div class="row justify-content-end">
        <div class="col-2">
            <form action="XlsInvMPrimaFecha.php" method="post" target="_blank">
                <input type="hidden" name="fecha" value="<?= $fecha; ?>">
                <button class="button" type="submit">
                    <span><STRONG>Exportar a Excel</STRONG></span></button>
            </form>
        </div>
        <div class="col-1">
            <button class="button" onclick="window.location='../../../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-50">
        <table id="example" class="formatoDatos5 table table-sm table-striped">
            <thead>
            <tr>
                <th class="text-center">Código</th>
                <th class="text-center">Materia Prima</th>
                <th class="text-center">Cantidad (Kg)</th>
                <th class="text-center">Entrada</th>
                <th class="text-center">Salida</th>
                <th class="text-center">Inventario</th>
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