<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$codPresentacion = $_POST['codPresentacion'];
$loteProd = $_POST['loteProd'];
$presentacionOperador = new PresentacionesOperaciones();
$nomPresentacion = $presentacionOperador->getNamePresentacion($codPresentacion);
$envasadoOperador = new EnvasadoOperaciones();
$detOProd = $envasadoOperador->getEnvasado($loteProd, $codPresentacion);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Trazabilidad producto terminado</title>
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
            var codPresentacion = <?= $codPresentacion; ?>;
            var loteProd = '<?= $loteProd; ?>';
            var table2 = $('#salidas').DataTable({
                "columns": [
                    {
                        "data": "fechaRemision",
                        "className": 'dt-body-center',
                        width: '20%'
                    },
                    {
                        "data": "nomCliente",
                        "className": 'dt-body-left',
                        width: '60%'
                    },
                    {
                        "data": "cantProducto",
                        "className": 'dt-body-center',
                        width: '20%'
                    },
                ],
                "columnDefs": [
                    {type: 'chinese-string', targets: 1}
                ],
                "order": [[1, 'asc']],
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
                "paging": true,
                "ordering": false,
                "info": false,
                "searching": false,
                "lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]],
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
                "ajax": "../ajax/listaVentaPresentacionTrazabilidad.php?codPresentacion=" + codPresentacion +'&loteProd='+loteProd ,
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
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>TRAZABILIDAD DE <?= $nomPresentacion; ?> CON
            LOTE <?= $loteProd; ?></h4></div>
    <div class="mb-3 titulo row text-center">
        <strong>Entrada</strong>
    </div>
    <div class="mb-3 row">
        <div class="col-2">
            <strong>Fecha Producción</strong>
            <div class=""><?= $detOProd['fechProd'] ?></div>
        </div>
        <div class="col-2">
            <strong>Unidades</strong>
            <div><?= $detOProd['cantPresentacion']; ?></div>
        </div>
    </div>
    <div class="mb-3 row">
    </div>
    <div class="mb-3 titulo row text-center">
        <strong>Salidas
        </strong>
    </div>
    <div class="tabla-50">
        <table id="salidas" class="formatoDatos5 table table-sm table-striped">
            <thead>
            <tr>
                <th class="text-center">Fecha de venta</th>
                <th class="text-center">Cliente</th>
                <th class="text-center">Unidades</th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="row">
        <div class="col-1">
            <button class="button" type="button" onclick="window.location='../../../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span>
            </button>
        </div>
    </div>
</div>
</body>
</html>
