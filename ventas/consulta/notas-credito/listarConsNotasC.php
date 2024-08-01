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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Listado de Notas crédito por fecha</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../../css/datatables.css">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>
    <script>
        $(document).ready(function () {
            var fechaIni = '<?= $fechaIni ?>';
            var fechaFin = '<?= $fechaFin ?>';
            var table = $('#example').DataTable({
                "columns": [
                    {
                        "data": "idNotaC",
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
                        width: '20%'
                    },
                    {
                        "data": "fechaNotaC",
                        "className": 'dt-body-center',
                        width: '7%'
                    },
                    {
                        "data": "subtotalNotaC",
                        "className": 'dt-body-right pe-4',
                        width: '7%'
                    },
                    {
                        "data": "ivaNotaC",
                        "className": 'dt-body-right pe-4',
                        width: '7%'
                    },
                    {
                        "data": "retFteNotaC",
                        "className": 'dt-body-right pe-4',
                        width: '5%'
                    },
                    {
                        "data": "retIcaNotaC",
                        "className": 'dt-body-right pe-4',
                        width: '5%'
                    },
                    {
                        "data": "retIvaNotaC",
                        "className": 'dt-body-right pe-4',
                        width: '5%'
                    },
                    {
                        "data": "totalNotaC",
                        "className": 'dt-body-right pe-4',
                        width: '7%'
                    },
                    {
                        "data": "facturaOrigen",
                        "className": 'dt-body-center',
                        width: '5%'
                    },
                    {
                        "data": "facturaDestino",
                        "className": 'dt-body-center',
                        width: '5%'
                    },
                    {
                        "data": "razon",
                        "className": '',
                        width: '13%'
                    },
                ],
                "order": [[0, 'desc']],
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
                "ajax": "../ajax/listaConsNotasC.php?fechaIni=" + fechaIni+ '&fechaFin=' + fechaFin
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
            <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>LISTADO DE NOTAS CRÉDITO POR
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
                    <th class="text-center">Id</th>
                    <th class="text-center">NIT</th>
                    <th class="text-center">Cliente</th>
                    <th class="text-center">Fecha Nota C</th>
                    <th class="text-center">Subtotal</th>
                    <th class="text-center">Iva</th>
                    <th class="text-center">Retefuente</th>
                    <th class="text-center">Reteica</th>
                    <th class="text-center">Reteiva</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Fac Origen</th>
                    <th class="text-center">Fac Destino</th>
                    <th class="text-center">Motivo</th>
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
    <?php
} else {
    $ruta = "../notas-credito/";
    $mensaje = "La fecha final no puede ser menor que la inicial";
    $icon = "error";
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
