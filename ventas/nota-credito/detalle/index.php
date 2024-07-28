<?php
include "../../../includes/valAcc.php";
include "../../../includes/num_letra.php";
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
            let variable = 'idNotaC';
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

        function cantDetNotaC(facturaOrigen, codProducto) {
            $.ajax({
                url: '../../../includes/controladorVentas.php',
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
                        "className": 'text-center',
                        width: '9%'
                    },
                    {
                        "data": "codProducto",
                        "className": 'text-center',
                        width: '11%'
                    },
                    {
                        "data": "producto",
                        "className": 'dt-body-left',
                        width: '40%'
                    },
                    {
                        "data": "cantidad",
                        "className": 'text-center',
                        width: '8%'
                    },
                    {
                        "data": "iva",
                        "className": 'text-center',
                        width: '5%'
                    },
                    {
                        "data": "precioProducto",
                        "className": 'dt-body-right pe-4',
                        width: '9%'
                    },
                    {
                        "data": "subtotal",
                        "className": 'dt-body-right pe-4',
                        width: '9%'
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
                        "className": 'text-center',
                        width: '9%'
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
                "ajax": ruta,
                initComplete: function (settings, json) {
                    $('#example thead th').removeClass('pe-4');
                },
            });
        });
    </script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>DETALLE DE LA NOTA CRÉDITO</h4></div>
    <div class="mb-3 row formatoDatos5">
        <div class="col-1">
            <strong>Nota crédito</strong>
            <div class="bg-blue"><?= $idNotaC; ?></div>
        </div>
        <div class="col-1">
            <strong>Fecha nota</strong>
            <div class="bg-blue"><?= $notaC['fechaNotaC'] ?></div>
        </div>
        <div class="col-2">
            <strong>Factura origen</strong>
            <div class="bg-blue"><?= $notaC['facturaOrigen'] ?></div>
        </div>
        <div class="col-2">
            <strong>Factura destino</strong>
            <div class="bg-blue"><?= $notaC['facturaDestino'] ?></div>
        </div>
    </div>
    <div class="mb-3 row formatoDatos5">
        <div class="col-4">
            <strong>Cliente</strong>
            <div class="bg-blue"><?= $notaC['nomCliente'] ?></div>
        </div>
        <div class="col-2">
            <strong>Motivo</strong>
            <div class="bg-blue"><?= $notaC['descMotivo'] ?></div>
        </div>
    </div>
    <form action="makeDetNotaC.php" class="formatoDatos5" method="post" name="formulario">
        <input name="idNotaC" type="hidden" value="<?= $idNotaC; ?>">
        <input name="motivo" type="hidden" value="<?= $notaC['motivo']; ?>">
        <?php
        if ($notaC['motivo'] == 0) : // DEVOLUCIÓN DE PRODUCTOS

            ?>
            <div class="mb-3 titulo row text-center">
                <strong>Productos para devolución</strong>
            </div>
            <div class="mb-3 row">
                <div class="col-3">
                    <label for="codProducto" class="form-label"><strong>Producto</strong></label>
                    <select name="codProducto" id="codProducto" class="form-select"
                            onchange="cantDetNotaC(<?= $notaC['facturaOrigen']; ?>, this.value)">
                        <option selected disabled value="">Escoja un producto</option>
                        <?php
                        $prodDev = $notaCrOperador->getProductosNotaC($idNotaC, $notaC['facturaOrigen']);
                        for ($i = 0; $i < count($prodDev); $i++) {
                            echo '<option value="' . $prodDev[$i]["codProducto"] . '">' . $prodDev[$i]['producto'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-1">
                    <label for="cantProducto" class="form-label col-1 text-center"><strong>Cantidad</strong></label>
                    <select name="cantProducto" id="cantProducto" class="form-select col-1 ms-2" required>
                    </select>
                </div>
                <div class="col-2 pt-2">
                    <button class="button mt-3" type="button" onclick="return Enviar(this.form)">
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
            <div class="mb-3 row">
                <div class="col-1">
                    <label for="cantProducto" class="form-label"><strong>Descuento</strong></label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="cantProducto" aria-describedby="basic-addon2" id="cantProducto" onkeydown="return aceptaNum(event)">
                        <span class="input-group-text" id="basic-addon2">%</span>
                    </div>
                </div>
                <div class="col-2 pt-3">
                    <button class="button mt-3" type="button" onclick="return Enviar(this.form)"><span>Continuar</span>
                    </button>
                </div>
            </div>
        <?php
        endif;
        ?>
    </form>

    <?php
    if(!$hasDetalle && $notaC['motivo'] == 0 ):
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
            <table id="example" class="formatoDatos5 table table-sm table-striped">
                <thead>
                <tr>
                    <th class=""></th>
                    <th class="text-center">Código</th>
                    <th class="text-center">Producto</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-center">Iva</th>
                    <th class="text-center">Precio</th>
                    <th class="text-center">Subtotal</th>
                    <th class="text-center"></th>
                </tr>
                </thead>
            </table>
        </div>
    <?php
    else:
    if ( $detNotaCrOperador->hasDescNotaCr($idNotaC)) {
        ?>
        <div class="tabla-70">
            <table id="example2" class="formatoDatos5 table table-sm table-striped">
                <thead>
                <tr>
                    <th class="text-center"><strong>Descripción</strong></th>
                    <th class="text-center"><strong>Valor</strong></th>
                </tr>
                </thead>
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
        <div class="row formatoDatos5">
            <div class="col-10"><strong>SON:</strong></div>
            <div class="col-1">
                <div class=" text-start">
                    <strong>SUBTOTAL</strong>
                </div>
            </div>
            <div class="col-1">
                <div class="text-end">
                    <strong><?= $notaC['subtotalNotaC'] ?></strong>
                </div>
            </div>
        </div>
        <div class="row formatoDatos5 mb-3">
            <div class="col-10"><?= numletra($notaC['totalNotaC']) ?></div>
            <div class="col-1">
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
            <div class="col-1">
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
            <form action="../modificar/updateNotaCrForm.php" method="post">
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
