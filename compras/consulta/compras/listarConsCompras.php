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
$CompraOperador = new ComprasOperaciones();
$compras = $CompraOperador->getTotalesComprasPorFecha($fechaIni, $fechaFin);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Listado de compras por fecha</title>
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
            width: 6%;
        }

        .width2 {
            width: 7%;
        }

        .width3 {
            width: 24%;
        }

        .width4 {
            width: 7%;
        }

        .width5 {
            width: 7%;
        }

        .width6 {
            width: 7%;
        }

        .width7 {
            width: 7%;
        }

        .width8 {
            width: 7%;
        }

        .width9 {
            width: 7%;
        }

        .width10 {
            width: 7%;
        }

        .width11 {
            width: 7%;
        }

        .width12 {
            width: 7%;
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
                        "data": "idCompra",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nitProv",
                        "className": 'pe-4'
                    },
                    {
                        "data": "nomProv",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "numFact",
                        "className": 'pe-4'
                    },
                    {
                        "data": "tipoComp",
                        //"className": 'dt-body-center'
                    },
                    {
                        "data": "fechComp",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "subtotalCompra",
                        "className": 'pe-3'
                    },
                    {
                        "data": "ivaCompra",
                        "className": 'pe-3'
                    },
                    {
                        "data": "retefuenteCompra",
                        "className": 'pe-3'
                    },
                    {
                        "data": "reteicaCompra",
                        "className": 'pe-3'
                    },
                    {
                        "data": "totalCompra",
                        "className": 'pe-3'
                    },
                    {
                        "data": "vreal",
                        "className": 'pe-3'
                    },
                ],
                "order": [[5, 'asc']],
                "deferRender": true,  //For speed
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
                "ajax": "../ajax/listaConsCompras.php?fechaIni=" + fechaIni+ '&fechaFin=' + fechaFin
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
            <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>LISTADO DE COMPRAS POR
                FECHA</h4></div>
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
                    <th class="width1">Id compra</th>
                    <th class="width2 text-center">NIT</th>
                    <th class="width3 text-center">Proveedor</th>
                    <th class="width4 text-center">Factura</th>
                    <th class="width5 text-center">Tipo</th>
                    <th class="width6 text-center">Fecha</th>
                    <th class="width7 text-center">Subtotal</th>
                    <th class="width8 text-center">Iva </th>
                    <th class="width9 text-center">Retefuente</th>
                    <th class="width10 text-center">Reteica</th>
                    <th class="width11 text-center">Valor </th>
                    <th class="width12 text-center">Valor Real</th>
                </tr>
                </thead>
            </table>
        </div>
        <div class="row">
            <div class="col-2 offset-10 px-0 formatoDatos5">
                <div class="container-fluid">
                    <div class="row mb-2 text-bold">
                        <div class="col-12 text-uppercase text-center">
                            Totales período
                        </div>
                    </div>
                    <div class="row text-bold text-end">
                        <div class="col-5">
                            Subtotal
                        </div>
                        <div class="col-7">
                            <?=$compras['subtotalPeriodo']?>
                        </div>
                    </div>
                    <div class="row text-bold text-end">
                        <div class="col-5">
                            IVA
                        </div>
                        <div class="col-7">
                            <?=$compras['ivaPeriodo']?>
                        </div>
                    </div>
                    <div class="row text-bold text-end">
                        <div class="col-5">
                            Retefuente
                        </div>
                        <div class="col-7">
                            <?=$compras['retefuentePeriodo']?>
                        </div>
                    </div>
                    <div class="row text-bold text-end">
                        <div class="col-5">
                            Reteica
                        </div>
                        <div class="col-7">
                            <?=$compras['reteicaPeriodo']?>
                        </div>
                    </div>
                </div>
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
    $ruta = "consultaCompras.php";
    $mensaje = "La fecha final no puede ser menor que la inicial";
    $icon = "error";
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
