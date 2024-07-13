<?php
include "../../../includes/valAcc.php";
// Función para cargar las clases
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if (is_array($valor)) {
        //echo $nombre_campo.print_r($valor).'<br>';
    } else {
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
if ($idTapOEnv < 100) {
    $EnvasesOperador = new EnvasesOperaciones();
    $envase = $EnvasesOperador->getEnvase($idTapOEnv);
    $producto = $envase['nomEnvase'];
} else {
    $TapasOperador = new TapasOperaciones();
    $tapa = $TapasOperador->getTapa($idTapOEnv);
    $producto = $tapa['tapa'];
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lista de Compra por Envase o Tapa</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <link rel="stylesheet" href="../../../css/datatables.css">
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>
    

    <script>
        $(document).ready(function () {
            var idTapOEnv = <?= $idTapOEnv ?>;
            $('#example').DataTable({
                "columns": [
                    {
                        /*"className": 'dt-control',*/
                        /*"orderable": false,*/
                        "data": "fechComp",
                        /*"defaultContent": ''*/
                    },
                    {
                        "data": "nomProv",
                    },
                    {
                        "data": "precioSinIva",
                    },
                    {
                        "data": "precioConIva",
                    },
                    {
                        "data": "cantidad",
                    },
                ],
                "columnDefs":
                    [{
                        "targets": [0, 1, 2, 3, 4],
                        "className": 'dt-body-center'
                    }
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
                "ajax": "../ajax/listaCompraxEnvaseTapa.php?idTapOEnv=" + idTapOEnv
            });
        });
    </script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>LISTADO DE COMPRAS DE <?= $producto ?></h4></div>
    <div class="row justify-content-end">
        <div class="col-1">
            <button class="button" type="button" onclick="window.location='../../../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
    <div class="tabla-60">
        <table id="example" class="formatoDatos5 table table-sm table-striped">
            <thead>
            <tr>
                <th class="text-center">Fecha Compra</th>
                <th class="text-center">Proveedor</th>
                <th class="text-center">Precio Compra sin IVA</th>
                <th class="text-center">Precio Compra con IVA</th>
                <th class="text-center">Cantidad</th>
            </tr>
            </thead>
        </table>
    </div>

    <div class="row">
        <div class="col-1">
            <button class="button" type="button"
                    onclick="window.location='../../../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>


</div>
</body>
</html>