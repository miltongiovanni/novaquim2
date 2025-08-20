<?php
include "../../../includes/valAcc.php";
include "../../../includes/ventas.php";
include "../../../includes/num_letra.php";

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
            let variable = 'idFactura';
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
            let idFactura = <?=$idFactura?>;
            let ruta = "../ajax/listaDetFactura.php?idFactura=" + idFactura;
            $('#example').DataTable({
                "columns": [
                    {
                        "data": "codigo",
                        "className": 'dt-body-center',
                        width: '15%'
                    },
                    {
                        "data": "producto",
                        "className": 'dt-body-left',
                        width: '55%'
                    },
                    {
                        "data": "cantProducto",
                        "className": 'dt-body-center',
                        width: '10%'
                    },
                    {
                        "data": "iva",
                        "className": 'dt-body-center',
                        width: '10%'
                    },
                    {
                        "data": "precioProducto",
                        "className": 'dt-body-center',
                        width: '10%'
                    },
                    {
                        "data": "subtotal",
                        "className": 'dt-body-center',
                        width: '10%'
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
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>DETALLE DE FACTURA DE VENTA</h4></div>
    <div class="mb-3 row formatoDatos5">
        <div class="col-1">
            <strong>No. de Factura</strong>
            <div class="bg-blue"><?= $idFactura; ?></div>
        </div>
        <div class="col-2">
            <strong>Pedido(s)</strong>
            <div class="bg-blue"><?= $factura['idPedido']; ?></div>
        </div>
        <div class="col-2">
            <strong>Remision(es)</strong>
            <div class="bg-blue"><?= $factura['idRemision'] ?></div>
        </div>
        <div class="col-1">
            <strong>Fecha Factura</strong>
            <div class="bg-blue"><?= $factura['fechaFactura'] ?></div>
        </div>
        <div class="col-1">
            <strong>Vencimiento</strong>
            <div class="bg-blue"><?= $factura['fechaVenc'] ?></div>
        </div>
        <div class="col-1">
            <strong>Estado</strong>
            <div class="bg-blue"><?= $factura['estadoFactura'] ?></div>
        </div>
    </div>
    <div class="mb-3 row formatoDatos5">
        <div class="col-1">
            <strong>Nit</strong>
            <div class="bg-blue"><?= $factura['nitCliente'] ?></div>
        </div>
        <div class="col-3">
            <strong>Cliente</strong>
            <div class="bg-blue"><?= $factura['nomCliente'] ?></div>
        </div>
        <div class="col-4">
            <strong>Dirección </strong>
            <div class="bg-blue"><?= $factura['dirCliente'] ?></div>
        </div>
    </div>
    <div class="mb-3 row formatoDatos5">
        <div class="col-1">
            <strong>Ciudad</strong>
            <div class="bg-blue"><?= $factura['Ciudad'] ?></div>
        </div>
        <div class="col-1">
            <strong>Teléfono</strong>
            <div class="bg-blue"><?= $factura['telCliente'] ?></div>
        </div>
        <div class="col-1">
            <strong>Orden compra</strong>
            <div class="bg-blue"><?= $factura['ordenCompra'] != 0 ? $factura['ordenCompra'] : '' ?></div>
        </div>
        <div class="col-1">
            <strong>Forma de pago</strong>
            <div class="bg-blue"><?= $factura['fechaFactura'] == $factura['fechaVenc'] ? 'Contado' : 'Crédito' ?></div>
        </div>
        <div class="col-2">
            <strong>Vendedor</strong>
            <div class="bg-blue"><?= $factura['vendedor'] ?></div>
        </div>
    </div>
    <div class="mb-3 titulo row text-center">
        <strong>Detalle</strong>
    </div>
    <div class="tabla-70">
        <table id="example" class="formatoDatos5 table table-sm table-striped">
            <thead>
            <tr>
                <th class="text-center">Código</th>
                <th class="text-center">Producto</th>
                <th class="text-center">Cantidad</th>
                <th class="text-center">Iva</th>
                <th class="text-center">Vlr Unitario</th>
                <th class="text-center">Vlr Total</th>
            </tr>
            </thead>
        </table>

    </div>
    <div class="tabla-70">
        <div class="row formatoDatos5">
            <div class="col-10"><strong>SON:</strong></div>
            <div class="col-1 px-0">
                <div class="text-start">
                    <strong>SUBTOTAL</strong>
                </div>
            </div>
            <div class="col-1">
                <div class="text-end">
                    <strong>$<?= number_format($factura['subtotal'], 2, '.', ',') ?></strong>
                </div>
            </div>
        </div>
        <?php
        $totalMostrar = $factura['subtotal'] - $factura['descuento'] + $factura['iva'] - $factura['retencionFte'] - $factura['retencionIca'];
        ?>
        <div class="row formatoDatos5">
            <div class="col-10"><?= numletra(round($totalMostrar)) ?></div>
            <div class="col-1 px-0">
                <div class="text-start">
                    <strong>DESCUENTO</strong>
                </div>
                <div class="text-start">
                    <strong>RETEFUENTE</strong>
                </div>
                <div class="text-start">
                    <strong>RETEICA</strong>
                </div>
            </div>
            <div class="col-1">
                <div class="text-end">
                    <strong>$<?= number_format($factura['descuento'], 2, '.', ',') ?></strong>
                </div>
                <div class="text-end">
                    <strong>$<?= number_format($factura['retencionFte'], 2, '.', ',') ?></strong>
                </div>
                <div class="text-end">
                    <strong>$<?= number_format($factura['retencionIca'], 2, '.', ',') ?></strong>
                </div>
            </div>
        </div>
        <div class="row formatoDatos5">
            <div class="col-10"><strong>OBSERVACIONES:</strong></div>
            <div class="col-1 px-0">
                <div class="text-start">
                    <strong>IVA 5%</strong>
                </div>
            </div>
            <div class="col-1">
                <div class="text-end">
                    <strong>$<?= number_format($totales['iva10Real'], 2, '.', ',') ?></strong>
                </div>
            </div>
        </div>
        <div class="row formatoDatos5">
            <div class="col-10"><?= $factura['observaciones'] ?></div>
            <div class="col-1 px-0">
                <div class="text-start">
                    <strong><?= $factura['fechaFactura'] < FECHA_C ? 'IVA 16%' : 'IVA 19%' ?></strong>
                </div>
                <div class="text-start">
                    <strong>TOTAL</strong>
                </div>
            </div>
            <div class="col-1">
                <div class="text-end">
                    <strong>$<?= number_format($totales['iva16Real'], 2, '.', ',') ?></strong>
                </div>
                <div class="text-end">
                    <strong>$<?= number_format($totalMostrar, 2, '.', ',') ?></strong>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-2">
            <form action="Imp_Factura.php" method="post" target="_blank">
                <input name="idFactura" type="hidden" value="<?php echo $idFactura; ?>">
                <button name="Submit" type="submit" class="button"><span>Imprimir Factura</span></button>
            </form>
        </div>
        <?php
        if ($factura['Estado'] == 'E' || $factura['Estado'] == 'P'):
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