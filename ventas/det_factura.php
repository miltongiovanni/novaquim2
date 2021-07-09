<?php
include "../includes/valAcc.php";
include "../includes/ventas.php";
include "../includes/num_letra.php";

if (isset($_POST['idFactura'])) {
    $idFactura = $_POST['idFactura'];
} elseif (isset($_SESSION['idFactura'])) {
    $idFactura = $_SESSION['idFactura'];
}
$facturaOperador = new FacturasOperaciones();
$factura = $facturaOperador->getFactura($idFactura);
$totales = calcularTotalesFactura($idFactura, $factura['descuento']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Detalle de Factura de Venta</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
    <style>
        table {
            table-layout: fixed;
        }

        .width1 {
            width: 15%;
        }

        .width2 {
            width: 55%;
        }

        .width3 {
            width: 10%;
        }

        .width4 {
            width: 10%;
        }

        .width5 {
            width: 10%;
        }

        .width6 {
            width: 10%;
        }

    </style>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
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
            let variable = 'idFactura';
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
            let idFactura = <?=$idFactura?>;
            let ruta = "ajax/listaDetFactura.php?idFactura=" + idFactura;
            $('#example').DataTable({
                "columns": [
                    {
                        "data": "codigo",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "producto",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "cantProducto",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "iva",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "precioProducto",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "subtotal",
                        "className": 'dt-body-center'
                    },
                ],
                "columnDefs": [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 1
                }],
                "dom": 'Blfrtip',
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
        <img src="../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>DETALLE DE FACTURA DE VENTA</h4></div>
    <div class="form-group row">
        <div class="col-1 text-end"><strong>No. de Factura</strong></div>
        <div class="col-1 bg-blue"><?= $idFactura; ?></div>
        <div class="col-1 text-end"><strong>Pedido(s)</strong></div>
        <div class="col-2 bg-blue"><?= $factura['idPedido']; ?></div>
        <div class="col-1 text-end"><strong>Remision(es)</strong></div>
        <div class="col-2 bg-blue"><?= $factura['idRemision'] ?></div>
        <div class="col-1 text-end"><strong>Estado</strong></div>
        <div class="col-1 bg-blue"><?= $factura['estadoFactura'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-1 text-end"><strong>Nit</strong></div>
        <div class="col-1 bg-blue"><?= $factura['nitCliente'] ?></div>
        <div class="col-1 text-end"><strong>Cliente</strong></strong></div>
        <div class="col-4 bg-blue"><?= $factura['nomCliente'] ?></div>
        <div class="col-1 text-end"><strong>Teléfono</strong></div>
        <div class="col-1 bg-blue"><?= $factura['telCliente'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-1 text-end"><strong>Fecha Factura</strong></div>
        <div class="col-1 bg-blue"><?= $factura['fechaFactura'] ?></div>
        <div class="col-1 text-end"><strong>Dirección </strong></div>
        <div class="col-4 bg-blue"><?= $factura['dirCliente'] ?></div>
        <div class="col-1 text-end"><strong>Ciudad</strong></div>
        <div class="col-1 bg-blue"><?= $factura['Ciudad'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-1 text-end"><strong>Vencimiento</strong></div>
        <div class="col-1 bg-blue"><?= $factura['fechaVenc'] ?></div>
        <div class="col-1 text-end"><strong>Orden compra</strong></div>
        <div class="col-1 bg-blue"><?= $factura['ordenCompra'] != 0 ? $factura['ordenCompra'] : '' ?></div>
        <div class="col-1 text-end"><strong>Forma de pago</strong></div>
        <div class="col-1 bg-blue"><?= $factura['fechaFactura'] == $factura['fechaVenc'] ? 'Contado' : 'Crédito' ?></div>
        <div class="col-1 text-end"><strong>Vendedor</strong></div>
        <div class="col-2 bg-blue"><?= $factura['vendedor'] ?></div>
    </div>
    <div class="form-group titulo row text-center">
        <strong>Detalle</strong>
    </div>
    <div class="tabla-70">
        <table id="example" class="display compact formatoDatos">
            <thead>
            <tr>
                <th class="width1">Código</th>
                <th class="width2">Producto</th>
                <th class="width3">Cantidad</th>
                <th class="width4">Iva</th>
                <th class="width5">Vlr Unitario</th>
                <th class="width6">Vlr Total</th>
            </tr>
            </thead>
        </table>

    </div>
    <div class="tabla-70">
        <div class="row formatoDatos">
            <div class="col-9"><strong>SON:</strong></div>
            <div class="col-1 me-3 px-0">
                <div class=" text-start">
                    <strong>SUBTOTAL</strong>
                </div>
            </div>
            <div class="col-1 ms-3 px-0" style=" flex: 0 0 10%; max-width: 10%;">
                <div class="text-end">
                    <strong>$<?= number_format($factura['subtotal'], 2, '.', ',') ?></strong>
                </div>
            </div>
        </div>
        <div class="row formatoDatos">
            <div class="col-9"><?= numletra(round($factura['total'])) ?></div>
            <div class="col-1 me-3 px-0">
                <div class=" text-start">
                    <strong>DESCUENTO</strong>
                </div>
                <div class=" text-start">
                    <strong>RETEFUENTE</strong>
                </div>
                <div class=" text-start">
                    <strong>RETEICA</strong>
                </div>
            </div>
            <div class="col-1 ms-3 px-0" style=" flex: 0 0 10%; max-width: 10%;">
                <div class="text-end">
                    <strong>$<?= number_format($totales['descuento'], 2, '.', ',') ?></strong>
                </div>
                <div class="text-end">
                    <strong>$<?= number_format($factura['retencionFte'], 2, '.', ',') ?></strong>
                </div>
                <div class="text-end">
                    <strong>$<?= number_format($factura['retencionIca'], 2, '.', ',') ?></strong>
                </div>
            </div>
        </div>
        <div class="row formatoDatos">
            <div class="col-9"><strong>OBSERVACIONES:</strong></div>
            <div class="col-1 me-3 px-0">
                <strong>IVA 5%</strong>
            </div>
            <div class="col-1  ms-3 px-0" style=" flex: 0 0 10%; max-width: 10%;">
                <div class="text-end">
                    <strong>$<?= number_format($totales['iva10Real'], 2, '.', ',') ?></strong>
                </div>
            </div>
        </div>
        <div class="row formatoDatos">
            <div class="col-9"><?= $factura['observaciones'] ?></div>
            <div class="col-1 me-3 px-0">
                <div class=" text-start">
                    <strong><?= $factura['fechaFactura'] < FECHA_C ? 'IVA 16%' : 'IVA 19%' ?></strong>
                </div>
                <div class=" text-start">
                    <strong>TOTAL</strong>
                </div>
            </div>
            <div class="col-1  ms-3 px-0" style=" flex: 0 0 10%; max-width: 10%;">
                <div class="text-end">
                    <strong>$<?= number_format($totales['iva16Real'], 2, '.', ',') ?></strong>
                </div>
                <div class="text-end">
                    <strong>$<?= number_format($factura['total'], 2, '.', ',') ?></strong>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-2">
            <form action="Imp_Factura.php" method="post" target="_blank">
                <input name="idFactura" type="hidden" value="<?php echo $idFactura; ?>">
                <button name="Submit" type="submit" class="button"><span>Imprimir Factura</span></button>
            </form>
        </div>
        <?php
        if ($factura['Estado'] == 'E'):
            ?>
            <div class="col-2">
                <form action="updateFacturaForm.php" method="post">
                    <input name="idFactura" type="hidden" value="<?php echo $idFactura; ?>">
                    <button name="Submit" type="button" onclick="return Enviar(this.form)" class="button"><span>Modificar</span></button>
                </form>
            </div>
        <?php
        endif;
        ?>
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