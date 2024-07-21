<?php
include "../../../includes/valAcc.php";
include "../../../includes/ventas.php";
include "../../../includes/num_letra.php";

if (isset($_POST['idRemision'])) {
    $idRemision = $_POST['idRemision'];
} elseif (isset($_SESSION['idRemision'])) {
    $idRemision = $_SESSION['idRemision'];
}
$remisionOperador = new RemisionesOperaciones();
$remision = $remisionOperador->getRemision($idRemision);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Detalle de Remisión</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../../css/datatables.css">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>
    
    <script>
        function redireccion() {
            window.location.href = "../../../menu.php";
        }

        function eliminarSession() {
            let variable = 'idRemision';
            $.ajax({
                url: '../../../includes/controladorVentas.php',
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
            let idRemision = <?=$idRemision?>;
            let ruta = "../ajax/listaDetRemision.php?idRemision=" + idRemision;
            $('#example').DataTable({
                "columns": [
                    {
                        "data": "codigo",
                        "className": 'text-center',
                        width: '20%'
                    },
                    {
                        "data": "producto",
                        "className": 'dt-body-left',
                        width: '60%'
                    },
                    {
                        "data": "cantProductoT",
                        "className": 'text-center',
                        width: '20%'
                    },
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
                "ajax": ruta
            });
        });
    </script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>DETALLE DE SALIDA POR REMISIÓN</h4></div>
    <div class="mb-3 row formatoDatos5">
        <div class="col-1">
            <strong>Remisión</strong>
            <div class="bg-blue"><?= $idRemision; ?></div>
        </div>
        <div class="col-1">
            <strong>Fecha Remisión</strong>
            <div class="bg-blue"><?= $remision['fechaRemision'] ?></div>
        </div>
        <div class="col-1">
            <strong>No. de Pedido</strong>
            <div class="bg-blue"><?= $remision['idPedido']; ?></div>
        </div>
        <div class="col-1">
            <strong>Nit</strong>
            <div class="bg-blue"><?= $remision['nitCliente'] ?></div>
        </div>
        <div class="col-4">
            <strong>Cliente</strong>
            <div class="bg-blue"><?= $remision['nomCliente'] ?></div>
        </div>
    </div>
    <div class="mb-3 row formatoDatos5">
        <div class="col-3">
            <strong>Lugar de entrega</strong>
            <div class="bg-blue"><?= $remision['nomSucursal'] ?></div>
        </div>
        <div class="col-3">
            <strong>Dirección entrega </strong>
            <div class="bg-blue"><?= $remision['dirSucursal'] ?></div>
        </div>
        <div class="col-1">
            <strong>Teléfono</strong>
            <div class="bg-blue"><?= $remision['telCliente'] ?></div>
        </div>
        <div class="col-1">
            <strong>Ciudad</strong>
            <div class="bg-blue"><?= $remision['ciudad'] ?></div>
        </div>
    </div>
    <div class="mb-3 titulo row text-center">
        <strong>Detalle</strong>
    </div>
    <div class="tabla-50">
        <table id="example" class="formatoDatos5 table table-sm table-striped">
            <thead>
            <tr>
                <th class="text-center">Código</th>
                <th class="text-center">Producto</th>
                <th class="text-center">Cantidad</th>
            </tr>
            </thead>
        </table>

    </div>
    <div class="mb-3 row">
        <div class="col-2">
            <form action="Imp_Remision.php" method="post" target="_blank">
                <input name="idRemision" type="hidden" value="<?php echo $idRemision ?>">
                <button name="Submit" type="submit" class="button"><span>Imprimir Remisión</span></button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-1">
            <button class="button" id="back" onClick="eliminarSession()"><span>Terminar</span>
            </button>
        </div>
    </div>
</div>
</body>
</html>