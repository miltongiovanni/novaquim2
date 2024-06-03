<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$codMPrima = $_POST['codMPrima'];
$loteMP = $_POST['loteMP'];
$mPrimaOperador = new MPrimasOperaciones();
$nomMPrima = $mPrimaOperador->getNomMPrima($codMPrima);
$detComprasMPrimaOperador = new DetComprasOperaciones();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Trazabilidad Materia Prima</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
    <style>
        table {
            table-layout: fixed;
        }

        .width1 {
            width: 10%;
        }

        .width2 {
            width: 20%;
        }

        .width12 {
            width: 30%;
        }
        .width3 {
            width: 50%;
        }
        .width4 {
            width: 20%;
        }

    </style>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>
    <script src="../js/dataTables.buttons.js"></script>
    <script src="../js/jszip.js"></script> <!--Para exportar Excel-->
    <!--<script src="../js/pdfmake.js"></script>-->  <!--Para exportar PDF-->
    <!--<script src="../js/vfs_fonts.js"></script>--> <!--Para exportar PDF-->
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
            var codMPrima = <?= $codMPrima; ?>;
            var loteMP = '<?= $loteMP; ?>';
            var table = $('#entradas').DataTable({
                "columns": [
                    {
                        "data": "fechComp",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nomProv",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "cantidad",
                        "className": 'dt-body-center'
                    },
                ],
                "columnDefs": [
                    {type: 'chinese-string', targets: 1}
                ],
                "order": [[1, 'asc']],
                "paging": false,
                "ordering": false,
                "info": false,
                "searching": false,
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
                "ajax": "../ajax/listaCompraMPTrazabilidad.php?codMPrima=" + codMPrima +'&loteMP='+loteMP ,
                "deferRender": true,  //For speed
            });
            var table2 = $('#salidas').DataTable({
                "columns": [
                    {
                        "data": "lote",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "fechProd",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "nomProducto",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "cantidadMPrima",
                        "className": 'dt-body-center'
                    },
                ],
                "columnDefs": [
                    {type: 'chinese-string', targets: 1}
                ],
                "order": [[1, 'asc']],
                "dom": 'Blfrtip',
                "buttons": [
                    'copyHtml5',
                    'excelHtml5'
                ],
                "paging": true,
                "ordering": false,
                "info": false,
                "searching": false,
                "lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]],
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
                "ajax": "../ajax/listaDetOProdMPTrazabilidad.php?codMPrima=" + codMPrima +'&loteMP='+loteMP ,
                "deferRender": true,  //For speed
            });
        });
    </script>
<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php


?>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>TRAZABILIDAD DE <?=$nomMPrima; ?> CON
            LOTE <?= $loteMP; ?></h4></div>
    <div class="mb-3 titulo row text-center">
        <strong>Entrada</strong>
    </div>
    <div class="tabla-50">
        <table id="entradas" class="display compact formatoDatos">
            <thead>
            <tr>
                <th class="width12 text-center">Fecha Compra</th>
                <th class="width3 text-center">Proveedor</th>
                <th class="width4 text-center">Cantidad (Kg)</th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="mb-3 titulo row text-center">
        <strong>Salidas
        </strong>
    </div>
    <div class="tabla-50">
        <table id="salidas" class="display compact formatoDatos">
            <thead>
            <tr>
                <th class="width1 text-center">Lote</th>
                <th class="width2 text-center">Fecha de producción</th>
                <th class="width3 text-center">Producto</th>
                <th class="width4 text-center">Cantidad (Kg)</th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="row">
        <div class="col-1">
            <button class="button" type="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span>
            </button>
        </div>
    </div>
</div>
</body>
</html>
