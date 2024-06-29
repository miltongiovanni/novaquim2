<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');






?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Rutero diario</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
    <style>
        table {
            table-layout: fixed;
        }

        .width1 {
            width: 7%;
        }

        .width2 {
            width: 10%;
        }
        .width3 {
            width: 7%;
        }
        .width4 {
            width: 7%;
        }

        .width5 {
            width: 23%;
        }

        .width6 {
            width: 23%;
        }

        .width7 {
            width: 23%;
        }
    </style>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>

</head>
<body>
<?php
$ruteroOperador = new RuteroOperaciones();
$pedidoOperador = new PedidosOperaciones();

if (isset($_POST['idRutero'])) {
    $idRutero = $_POST['idRutero'];
} elseif (isset($_SESSION['idRutero'])) {
    $idRutero = $_SESSION['idRutero'];
}else{
    if (isset($_POST['seleccion1'])) {
        $selPedidos = $_POST['seleccion1'];
    } else {
        $ruta = "selPedEntrega.php";
        $mensaje = "Debe escoger algún pedido";
        $icon = "warning";
        mover_pag($ruta, $mensaje, $icon);
    }
    $fechaRutero = $_POST['fechaRutero'];
    $idRutero = $ruteroOperador->makeRutero($fechaRutero, implode(',', $selPedidos) );
    foreach ($selPedidos as $pedido){
        $pedidoOperador->updateEstadoPedido(7, $pedido);
    }
    $_SESSION['idRutero'] = $idRutero;
}

if (!isset($fechaRutero)){
    $rutero = $ruteroOperador->getRutero($idRutero);
    $fechaRutero = $rutero['fechaRutero'];
}
?>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>RUTERO No. <?=$idRutero ?> DEL <?=$fechaRutero ?> </h4></div>
    <div class="row justify-content-end mb-3">
        <div class="col-2">
            <form action="Imp_Rutero.php" method="post" target="_blank">
                <input type="hidden" name="idRutero" value="<?=$idRutero?>">
                <button class="button" type="submit">
                    <span><STRONG>Imprimir rutero</STRONG></span></button>
            </form>
        </div>
        <div class="col-1">
            <button class="button" type="button" onClick="eliminarSession()">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>

    <div class="tabla-100">
        <table id="example" class="formatoDatos table table-sm table-striped">
            <thead>
            <tr>
                <th class="width1 text-center">Pedido</th>
                <th class="width2 text-center">Fecha pedido</th>
                <th class="width3 text-center">Factura</th>
                <th class="width4 text-center">Remisión</th>
                <th class="width5 text-center">Cliente</th>
                <th class="width6 text-center">Lugar de entrega</th>
                <th class="width7 text-center">Dirección de entrega</th>
            </tr>
            </thead>
        </table>
    </div>

    <div class="row">
        <div class="col-1">
            <button class="button" type="button" onClick="eliminarSession()">
                <span><STRONG>Ir al Menú</STRONG></span>
            </button>
        </div>
    </div>
</div>
<script src="../js/jquery-3.3.1.min.js"></script>
<script src="../js/datatables.js"></script>
<script src="../js/dataTables.buttons.js"></script>
<script src="../js/jszip.js"></script> <!--Para exportar Excel-->
<!--<script src="../js/pdfmake.js"></script>-->  <!--Para exportar PDF-->
<!--<script src="../js/vfs_fonts.js"></script>--> <!--Para exportar PDF-->
<script src="../js/buttons.html5.js"></script>
<script>
    function redireccion() {
        window.location.href = "../menu.php";
    }

    function eliminarSession() {
        let variable = 'idRutero';
        $.ajax({
            url: '../includes/controladorVentas.php',
            type: 'POST',
            data: {
                "action": 'eliminarSession',
                "variable": variable,
            },
            dataType: 'text',
            success: function (res) {
                redireccion();
            },
            error: function () {
                alert("Vous avez un GROS problème");
            }
        });
    }

    $(document).ready(function () {
        let idRutero = <?=$idRutero?>;
        let ruta = "../ajax/listaRutero.php?idRutero=" + idRutero;
        $('#example').DataTable({
            "columns": [
                {
                    "data": "idPedido",
                    "className": 'dt-body-center'
                },
                {
                    "data": "fechaPedido",
                    "className": 'dt-body-center'
                },
                {
                    "data": "idFactura",
                    "className": 'dt-body-center'
                },
                {
                    "data": "idRemision",
                    "className": 'dt-body-center'
                },
                {
                    "data": "nomCliente",
                    "className": 'dt-body-left'
                },
                {
                    "data": "nomSucursal",
                    "className": 'dt-body-left'
                },
                {
                    "data": "dirSucursal",
                    "className": 'dt-body-left'
                }
            ],
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": 1
            }],
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
            "paging": false,
            "ordering": false,
            "info": false,
            "searching": false,
            "lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
            "language": {
                "lengthMenu": "Mostrando _MENU_ datos por página",
                "zeroRecords": "No hacen falta productos",
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
            "ajax": ruta
        });
    });
</script>
</body>
</html>
	   