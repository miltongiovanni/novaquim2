<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{

    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Consulta de uso de Materia Prima por mes</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../../css/datatables.css">
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>
    <script>
        $(document).ready(function () {
            var table = $('#example').DataTable({
                "columns": [
                    {
                        "data": "codMPrima",
                        "className": 'dt-body-center',
                        width: '5%'
                    },
                    {
                        "data": "nomMPrima",
                        "className": '',
                        width: '35%'
                    },
                    <?php
                    $date = date_create($fechRef);
                    date_add($date, date_interval_create_from_date_string('-12 month'));
                    for($k = 12; $k >= 1; $k--):
                    date_add($date, date_interval_create_from_date_string('1 month'));
                    $date_month = date_format($date, 'Y-m');
                    ?>
                    {
                        "data": "<?=$date_month ?>",
                        "className": 'dt-body-right pe-4',
                        width: '5%'
                    },
                    <?php
                    endfor;
                    ?>
                ],
                /*"order": [[0, 'asc']],*/
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
                "ajax": "../ajax/listaMPrimaAcumulada.php?fechRef=<?=$fechRef?>",
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
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>CONSULTA DE KG ACUMULADOS DE MATERIA PRIMA POR 12 MESES HASTA <?= $fechRef ?></h4></div>
    <div class="row justify-content-end">
        <div class="col-1">
            <button class="button" onclick="window.location='../../../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-100">
        <table id="example" class="formatoDatos5 table table-sm table-striped">
            <thead>
            <tr>
                <th class="width1 text-center">Código</th>
                <th class="width2 text-center">Materia Prima</th>
                <?php
                $date = date_create($fechRef);
                $j = 3;
                date_add($date, date_interval_create_from_date_string('-12 month'));
                for ($i = 12; $i >= 1; $i--):
                    date_add($date, date_interval_create_from_date_string('1 month'));
                    $date_month = date_format($date, 'Y-m');
                    ?>
                    <th class="width-date"><?= $date_month ?></th>
                <?php
                endfor;
                ?>
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