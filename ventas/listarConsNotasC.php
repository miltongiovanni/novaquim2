<?php
include "../../../includes/valAcc.php";
include "../includes/calcularDias.php";
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
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <link rel="stylesheet" href="../css/datatables.css">
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
            width: 20%;
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
            width: 5%;
        }

        .width8 {
            width: 5%;
        }

        .width9 {
            width: 5%;
        }

        .width10 {
            width: 7%;
        }

        .width11 {
            width: 5%;
        }

        .width12 {
            width: 5%;
        }

        .width13 {
            width: 15%;
        }
    </style>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>
    

    <script>



        $(document).ready(function () {
            var fechaIni = '<?= $fechaIni ?>';
            var fechaFin = '<?= $fechaFin ?>';
            var table = $('#example').DataTable({
                "columns": [
                    {
                        "data": "idNotaC",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nitCliente",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nomCliente",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "fechaNotaC",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "subtotalNotaC",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "ivaNotaC",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "retFteNotaC",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "retIcaNotaC",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "retIvaNotaC",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "totalNotaC",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "facturaOrigen",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "facturaDestino",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "razon",
                        "className": 'dt-body-center'
                    },
                ],
                "order": [[0, 'desc']],
                "deferRender": true,  //For speed
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
            <img src="../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>LISTADO DE NOTAS CRÉDITO POR
                FECHA (<?= $fechaIni.' - '.$fechaFin.')' ?></h4></div>
        <div class="row flex-end">
            <div class="col-1">
                <button class="button" type="button" onclick="window.location='../menu.php'">
                    <span><STRONG>Ir al Menú</STRONG></span></button>
            </div>
        </div>
        <div class="tabla-100">
            <table id="example" class="display compact formatoDatos">
                <thead>
                <tr>
                    <th class="width1">Id</th>
                    <th class="width2 text-center">NIT</th>
                    <th class="width3 text-center">Cliente</th>
                    <th class="width4 text-center">Fecha Nota C</th>
                    <th class="width5 text-center">Subtotal</th>
                    <th class="width6 text-center">Iva</th>
                    <th class="width7 text-center">Retefuente</th>
                    <th class="width8 text-center">Reteica</th>
                    <th class="width9 text-center">Reteiva</th>
                    <th class="width10 text-center">Total</th>
                    <th class="width11 text-center">Fac Origen</th>
                    <th class="width12 text-center">Fac Destino</th>
                    <th class="width13 text-center">Motivo</th>
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
    <?php
} else {
    $ruta = "consultaNotasC.php";
    $mensaje = "La fecha final no puede ser menor que la inicial";
    $icon = "error";
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
