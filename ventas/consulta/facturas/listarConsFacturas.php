<?php
include "../../../includes/valAcc.php";
include "../../../includes/calcularDias.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if (is_array($valor)) {
        //echo $nombre_campo . print_r($valor) . '<br>';
    } else {
        //echo $nombre_campo . '=' . ${$nombre_campo} . '<br>';
    }
}
$facturaOperador = new FacturasOperaciones();
$facturas = $facturaOperador->getTotalesFacturasPorFecha($fechaIni, $fechaFin);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Listado de facturas por fecha</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <link rel="stylesheet" href="../../../css/datatables.css">
    <style>
        #example {
            table-layout: fixed;
        }

        .width1 {
            width: 5%;
        }

        .width2 {
            width: 7%;
        }

        .width3 {
            width: 23%;
        }

        .width4 {
            width: 6%;
        }

        .width5 {
            width: 6%;
        }

        .width6 {
            width: 6%;
        }

        .width7 {
            width: 6%;
        }

        .width8 {
            width: 6%;
        }

        .width9 {
            width: 6%;
        }

        .width10 {
            width: 6%;
        }

        .width11 {
            width: 6%;
        }

        .width12 {
            width: 6%;
        }

        .width13 {
            width: 6%;
        }

        .width14 {
            width: 6%;
        }
    </style>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>
    

    <script>



        $(document).ready(function () {
            var fechaIni = '<?= $fechaIni ?>';
            var fechaFin = '<?= $fechaFin ?>';
            var table = $('#example').DataTable({
                "columns": [
                    {
                        "data": "idFactura",
                        "className": 'dt-body-center',
                        width: '5%'
                    },
                    {
                        "data": "nitCliente",
                        "className": 'dt-body-center',
                        width: '7%'
                    },
                    {
                        "data": "nomCliente",
                        "className": 'dt-body-left',
                        width: '23%'
                    },
                    {
                        "data": "fechaFactura",
                        "className": 'dt-body-left',
                        width: '6%'
                    },
                    {
                        "data": "tipoPrecio",
                        "className": 'dt-body-left',
                        width: '6%'
                    },
                    {
                        "data": "subtotal",
                        "className": 'dt-body-right pe-4',
                        width: '6%'
                    },
                    {
                        "data": "descuentoF",
                        "className": 'dt-body-right pe-4',
                        width: '6%'
                    },
                    {
                        "data": "iva",
                        "className": 'dt-body-right pe-4',
                        width: '6%'
                    },
                    {
                        "data": "retencionFte",
                        "className": 'dt-body-right pe-4',
                        width: '6%'
                    },
                    {
                        "data": "retencionIva",
                        "className": 'dt-body-right pe-4',
                        width: '6%'
                    },
                    {
                        "data": "retencionIca",
                        "className": 'dt-body-right pe-4',
                        width: '6%'
                    },
                    {
                        "data": "total",
                        "className": 'dt-body-right pe-4',
                        width: '6%'
                    },
                    {
                        "data": "totalR",
                        "className": 'dt-body-right pe-4',
                        width: '6%'
                    },
                    {
                        "data": "ultimaCompra",
                        "className": 'dt-body-left',
                        width: '6%'
                    },
                ],
                "order": [[5, 'asc']],
                "deferRender": true,  //For speed
                initComplete: function (settings, json) {
                    $('#example thead th').removeClass('pe-4');
                },
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
                "ajax": "../ajax/listaConsFacturas.php?fechaIni=" + fechaIni+ '&fechaFin=' + fechaFin
            });

        });
    </script>
</head>
<body>
<?php
$fechaActual = hoy();
$rangoFechas = Calc_Dias($fechaFin, $fechaIni);

if ($rangoFechas >= 0) {
    ?>
    <div id="contenedor" class="container-fluid">
        <div id="saludo1">
            <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>LISTADO DE FACTURAS DE VENTA POR
                FECHA (<?= $fechaIni.' - '.$fechaFin.')' ?></h4></div>
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
                    <th class="">Factura</th>
                    <th class="text-center">NIT</th>
                    <th class="text-center">Cliente</th>
                    <th class="text-center">Fecha factura</th>
                    <th class="text-center">Precio</th>
                    <th class="text-center">Subtotal</th>
                    <th class="text-center">Descuento</th>
                    <th class="text-center">Iva</th>
                    <th class="text-center">Retefuente</th>
                    <th class="text-center">Reteiva</th>
                    <th class="text-center">Reteica</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Total Real</th>
                    <th class="text-center">Última compra</th>
                </tr>
                </thead>
            </table>
        </div>
        <div class="row formatoDatos5">
            <div class="col-11">
                <div class="text-end text-bold formatoDatos5">Subtotal período</div>
            </div>
            <div class="col-1">
                <div class="text-start text-bold formatoDatos5"><?=$facturas['subtotalPeriodo']?></div>
            </div>
        </div>
        <div class="row formatoDatos5">
            <div class="col-11">
                <div class="text-end text-bold formatoDatos5">Descuento período</div>
            </div>
            <div class="col-1">
                <div class="text-start text-bold formatoDatos5"><?=$facturas['descuentoPeriodo']?></div>
            </div>
        </div>
        <div class="row formatoDatos5">
            <div class="col-11">
                <div class="text-end text-bold formatoDatos5">Iva período</div>
            </div>
            <div class="col-1">
                <div class="text-start text-bold formatoDatos5"><?=$facturas['ivaPeriodo']?></div>
            </div>
        </div>
        <div class="row formatoDatos5">
            <div class="col-11">
                <div class="text-end text-bold formatoDatos5">Reteiva período</div>
            </div>
            <div class="col-1">
                <div class="text-start text-bold formatoDatos5"><?=$facturas['reteivaPeriodo']?></div>
            </div>
        </div>
        <div class="row formatoDatos5">
            <div class="col-11">
                <div class="text-end text-bold formatoDatos5">Retefuente período</div>
            </div>
            <div class="col-1">
                <div class="text-start text-bold formatoDatos5"><?=$facturas['retefuentePeriodo']?></div>
            </div>
        </div>
        <div class="row formatoDatos5">
            <div class="col-11">
                <div class="text-end text-bold formatoDatos5">Reteica período</div>
            </div>
            <div class="col-1">
                <div class="text-start text-bold formatoDatos5"><?=$facturas['reteicaPeriodo']?></div>
            </div>
        </div>
        <div class="row">
            <div class="col-1">
                <button class="button" type="button" onclick="window.location='../../../menu.php'">
                    <span><STRONG>Ir al Menú</STRONG></span>
                </button>
            </div>
        </div>
    </div>
    <?php
} else {
    $ruta = "../facturas/";
    $mensaje = "La fecha final no puede ser menor que la inicial";
    $icon = "error";
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
