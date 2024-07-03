<?php
include "../../../includes/valAcc.php";
include "../includes/num_letra.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
if (isset($_POST['idNotaC'])) {
    $idNotaC = $_POST['idNotaC'];
} elseif (isset($_SESSION['idNotaC'])) {
    $idNotaC = $_SESSION['idNotaC'];
}
$notaCrOperador = new NotasCreditoOperaciones();
$detNotaCrOperador = new DetNotaCrOperaciones();

$detNotaCrOperador = new DetNotaCrOperaciones();
$hasDetalle = $detNotaCrOperador->hasDetalleNC($idNotaC);
$notaC = $notaCrOperador->getNotaC($idNotaC);
if ($notaC['motivo'] == 1 && $detNotaCrOperador->hasDescNotaCr($idNotaC)) {
    $detNotaC = $detNotaCrOperador->getTableDetNotaCrDes($idNotaC);
}
$totalesNotaC = $notaCrOperador->getTotalesNotaC($idNotaC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Detalle Nota de Crédito</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
    <style>
        table {
            table-layout: fixed;
        }

        .width1 {
            width: 9%;
        }

        .width2 {
            width: 11%;
        }

        .width3 {
            width: 40%;
        }

        .width4 {
            width: 8%;
        }

        .width5 {
            width: 5%;
        }

        .width6 {
            width: 9%;
        }

        .width7 {
            width: 9%;
        }

        .width8 {
            width: 9%;
        }

        .width9 {
            width: 80%;
        }

        .width10 {
            width: 20%;
        }
        table.dataTable.compact thead th,
        table.dataTable.compact thead td {
            padding: 4px 4px 4px 4px;
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
            window.location.href = "../../../menu.php";
        }

        function eliminarSession() {
            let variable = 'idNotaC';
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

        function cantDetNotaC(facturaOrigen, codProducto) {
            $.ajax({
                url: '../includes/controladorVentas.php',
                type: 'POST',
                data: {
                    "action": 'cantDetNotaC',
                    "facturaOrigen": facturaOrigen,
                    "codProducto": codProducto,
                },
                dataType: 'html',
                success: function (cantidad) {
                    $("#cantProducto").html(cantidad);
                },
                error: function () {
                    alert("Vous avez un GROS problème");
                }
            });
        }

        $(document).ready(function () {
            let idNotaC = <?=$idNotaC?>;
            let ruta = "../ajax/listaDetNotaC.php?idNotaC=" + idNotaC;
            $('#example').DataTable({
                "columns": [
                    {
                        "data": function (row) {
                            let rep = '';
                            rep = '<form action="updateDetNotaC.php" method="post" name="actualiza">' +
                                '          <input name="idNotaC" type="hidden" value="' + idNotaC + '">' +
                                '          <input name="codProducto" type="hidden" value="' + row.codigo + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton"  value="Cambiar">' +
                                '      </form>'
                            return rep;
                        },
                        "className": 'text-center'
                    },
                    {
                        "data": "codProducto",
                        "className": 'text-center'
                    },
                    {
                        "data": "producto",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "cantidad",
                        "className": 'text-center'
                    },
                    {
                        "data": "iva",
                        "className": 'text-center'
                    },
                    {
                        "data": "precioProducto",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": "subtotal",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": function (row) {
                            let rep = '';
                            rep = '<form action="delDetNotaC.php" method="post" name="elimina">' +
                                '          <input name="idNotaC" type="hidden" value="' + idNotaC + '">' +
                                '          <input name="codProducto" type="hidden" value="' + row.codigo + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton"  value="Eliminar">' +
                                '      </form>';
                            return rep;
                        },
                        "className": 'text-center'
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
        <img src="../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>DETALLE DE LA NOTA CRÉDITO</h4></div>
    <div class="mb-3 row">
        <div class="col-1"><strong>Nota crédito</strong></div>
        <div class="col-1 bg-blue"><?= $idNotaC; ?></div>
        <div class="col-1"><strong>Fecha nota</strong></div>
        <div class="col-1 bg-blue"><?= $notaC['fechaNotaC'] ?></div>
        <div class="col-2"><strong>Factura origen</strong></div>
        <div class="col-1 bg-blue"><?= $notaC['facturaOrigen'] ?></div>
        <div class="col-2"><strong>Factura destino</strong></div>
        <div class="col-1 bg-blue"><?= $notaC['facturaDestino'] ?></div>

    </div>
    <div class="mb-3 row">
        <div class="col-1"><strong>Cliente</strong></strong></div>
        <div class="col-5 bg-blue"><?= $notaC['nomCliente'] ?></div>
        <div class="col-1"><strong>Motivo</strong></div>
        <div class="col-2 bg-blue"><?= $notaC['descMotivo'] ?></div>
    </div>

    <form action="makeDetNotaC.php" method="post" name="formulario">
        <input name="idNotaC" type="hidden" value="<?= $idNotaC; ?>">
        <input name="motivo" type="hidden" value="<?= $notaC['motivo']; ?>">
        <?php
        if ($notaC['motivo'] == 0) : // DEVOLUCIÓN DE PRODUCTOS

            ?>
            <div class="mb-3 titulo row text-center">
                <strong>Productos para devolución</strong>
            </div>
            <div class="row">
                <label for="codProducto" class="form-label col-4 text-start"><strong>Producto</strong></label>
                <label for="cantProducto" class="form-label col-1 text-center"><strong>Cantidad</strong></label>
                <div class="col-2 text-center"></div>
            </div>
            <div class="mb-3 row">
                <select name="codProducto" id="codProducto" class="form-select col-4"
                        onchange="cantDetNotaC(<?= $notaC['facturaOrigen']; ?>, this.value)">
                    <option selected disabled value="">Escoja un producto</option>
                    <?php
                    $prodDev = $notaCrOperador->getProductosNotaC($idNotaC, $notaC['facturaOrigen']);
                    for ($i = 0; $i < count($prodDev); $i++) {
                        echo '<option value="' . $prodDev[$i]["codProducto"] . '">' . $prodDev[$i]['producto'] . '</option>';
                    }
                    ?>
                </select>
                <select name="cantProducto" id="cantProducto" class="form-select col-1 ms-2" required>
                </select>
                <div class="col-2 text-center" style="padding: 0 20px;">
                    <button class="button" type="button" onclick="return Enviar(this.form)">
                        <span>Adicionar detalle</span>
                    </button>
                </div>
            </div>
        <?php

        elseif ($notaC['motivo'] == 1)://  DESCUENTO NO REALIZADO

            ?>
            <div class="mb-3 titulo row text-center">
                <strong>Descuento no realizado</strong>
            </div>
            <div class="row">
                <div class="col-1 text-center" style="margin: 0 5px;"><strong>Descuento</strong></div>
                <div class="col-2 text-center"></div>
            </div>
            <div class="mb-3 row">
                <input type="text" style="margin: 0 5px 0 0;" class="form-control col-1" name="cantProducto"
                       id="cantProducto" onkeydown="return aceptaNum(event)">%
                <div class="col-2 text-center" style="padding: 0 20px;">
                    <button class="button" type="button" onclick="return Enviar(this.form)"><span>Continuar</span>
                    </button>
                </div>
            </div>
        <?php
        endif;
        ?>
    </form>

    <?php
    if(!$hasDetalle):
        ?>
        <form action="makeDetNotaC.php" method="post" name="formulario2">

            <input name="idNotaC" type="hidden" value="<?= $idNotaC; ?>">
            <input name="motivo" type="hidden" value="<?= $notaC['motivo']; ?>">
            <input name="allFactura" type="hidden" value="1">
            <div class="mb-3 row">
                <div class="col-2 text-center">
                    <button class="button" type="button" onclick="return Enviar(this.form)"><span>Devolver toda la factura</span>
                    </button>
                </div>
            </div>

        </form>
    <?php
    endif;
    ?>
    <div class="mb-3 titulo row text-center">
        <strong>Detalle nota crédito</strong>
    </div>
    <?php
    if ($notaC['motivo'] == 0) :
        ?>
        <div class="tabla-70">
            <table id="example" class="formatoDatos table table-sm table-striped">
                <thead>
                <tr>
                    <th class="width1"></th>
                    <th class="width2">Código</th>
                    <th class="width3">Producto</th>
                    <th class="width4">Cantidad</th>
                    <th class="width5">Iva</th>
                    <th class="width6">Precio</th>
                    <th class="width7">Subtotal</th>
                    <th class="width8"></th>
                </tr>
                </thead>
            </table>
        </div>
    <?php
    else:
    if ( $detNotaCrOperador->hasDescNotaCr($idNotaC)) {
        ?>
        <div class="tabla-70">
            <table class="formatoDatos table table-sm table-striped">
                <tr>
                    <th class="width9"><strong>Descripción</strong></th>
                    <th class="width10"><strong>Valor</strong></th>
                </tr>
                <tr>
                    <td class="text-center">Descuento <?= $detNotaC['cantidad'] ?> % Comercial no concedido en la
                        Factura No.<?= $notaC['facturaOrigen'] ?></td>
                    <td class="text-center"><?= $notaC['subtotalNotaC'] ?></td>
                </tr>
            </table>
        </div>
    <?php
    }
    endif;
    ?>
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
                    <strong><?= $notaC['subtotalNotaC'] ?></strong>
                </div>
            </div>
        </div>
        <div class="row formatoDatos mb-3">
            <div class="col-9"><?= numletra($notaC['totalNotaC']) ?></div>
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
                <div class=" text-start">
                    <strong>IVA 5%</strong>
                </div>
                <div class=" text-start">
                    <strong><?= $notaC['fechaNotaC'] < FECHA_C ? 'IVA 16%' : 'IVA 19%' ?></strong>
                </div>
                <div class=" text-start">
                    <strong>TOTAL</strong>
                </div>
            </div>
            <div class="col-1 ms-3 px-0" style=" flex: 0 0 10%; max-width: 10%;">
                <div class="text-end">
                    <strong><?= $notaC['descuentoNotaC'] ?></strong>
                </div>
                <div class="text-end">
                    <strong><?= $notaC['retFteNotaCrFormated']  ?></strong>
                </div>
                <div class="text-end">
                    <strong><?= $notaC['retIcaNotaCrFormated'] ?></strong>
                </div>
                <div class="text-end">
                    <strong><?= $notaC['motivo'] == 0 ? isset($totalesNotaC['iva10nota_c'])? $totalesNotaC['iva10nota_c']:'$0' : '$0' ?></strong>
                </div>
                <div class="text-end">
                    <strong><?= $notaC['motivo'] == 0 ? isset($totalesNotaC['iva19nota_c'])? $totalesNotaC['iva19nota_c']:'$0' : $notaC['ivaNotaC'] ?></strong>
                </div>
                <div class="text-end">
                    <strong><?= $notaC['totalNotaCrFormated'] ?></strong>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-2">
            <form action="Imp_NotaC.php" method="post" target="_blank">
                <input name="idNotaC" type="hidden" value="<?php echo $idNotaC; ?>">
                <button name="Submit" type="submit" class="button"><span>Imprimir Nota Crédito</span></button>
            </form>
        </div>
        <div class="col-2">
            <form action="updateNotaCrForm.php" method="post">
                <input name="idNotaC" type="hidden" value="<?php echo $idNotaC; ?>">
                <button name="Submit" type="button" onclick="return Enviar(this.form)" class="button"><span>Modificar</span></button>
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
