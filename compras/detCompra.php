<?php
include "../includes/valAcc.php";

if (isset($_SESSION['idCompra'])) {//Si la factura existe
    $idCompra = $_SESSION['idCompra'];
    $tipoCompra = $_SESSION['tipoCompra'];
}
foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if (is_array($valor)) {
        //echo $nombre_campo.print_r($valor).'<br>';
    } else {
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}

function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');


switch ($tipoCompra) {
    case 1:
        $titulo = ' materias primas';
        $rutaError = 'compramp.php';
        break;
    case 2:
        $titulo = ' envases y/o tapas';
        $rutaError = 'compraenv.php';
        break;
    case 3:
        $titulo = ' etiquetas';
        $rutaError = 'compraetq.php';
        break;
    case 5:
        $titulo = ' productos de distribución';
        $rutaError = 'compradist.php';
        break;
}
$CompraOperador = new ComprasOperaciones();
$DetComprasOperador = new DetComprasOperaciones();
$compra = $CompraOperador->getCompra($idCompra, $tipoCompra);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Detalle compra de<?= $titulo ?></title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
    <style>
        table.dataTable.compact thead th, table.dataTable.compact thead td {
            padding: 4px 4px 4px 4px;
        }

        .width1 {
            width: 8%;
        }

        .width2 {
            width: 8%;
        }

        .width3 {
            width: 36%;
        }

        .width4 {
            width: 5%;
        }

        .width5 {
            width: 10%;
        }

        .width6 {
            width: 10%;
        }

        .width7 {
            width: 15%;
        }

        .width8 {
            width: 8%;
        }

        .width34 {
            width: 41%;
        }
        .width56 {
            width: 20%;
        }
    </style>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>
    <script src="../js/jszip.js"></script>
    <script src="../js/pdfmake.js"></script>
    <script src="../js/vfs_fonts.js"></script>
    <script>
        function redireccion() {
            window.location.href = "../menu.php";
        }

        function eliminarSession() {
            let variable = 'idCompra';
            $.ajax({
                url: '../includes/controladorCompras.php',
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

        function updateEstadoCompra(idCompra) {
            let estadoActualCompra = <?=$compra['estadoCompra']?>;
            if (estadoActualCompra != 2) {
                eliminarSession();
            } else {
                $.ajax({
                    url: '../includes/controladorCompras.php',
                    type: 'POST',
                    data: {
                        "action": 'updateEstadoCompra',
                        "idCompra": idCompra,
                        "estadoCompra": 3,
                    },
                    dataType: 'json',
                    success: function (respuesta) {
                        if (respuesta.msg == 'OK') {
                            eliminarSession();
                        }
                    },
                    error: function () {
                        alert("Vous avez un GROS problème");
                    }
                });
            }
        }

        $(document).ready(function () {
            let tipoCompra = <?=$tipoCompra?>;
            let idCompra = <?=$idCompra?>;
            let ruta = "ajax/listaDetCompra.php?idCompra=" + idCompra + "&tipoCompra=" + tipoCompra;
            $('#example').DataTable({
                "columns": [
                    {
                        "data": function (row) {
                            let rep = '<form action="updateDetCompraForm.php" method="post" name="elimina">' +
                                '          <input name="tipoCompra" type="hidden" value="' + tipoCompra + '">' +
                                '          <input name="idCompra" type="hidden" value="' + idCompra + '">' +
                                '          <input name="codigo" type="hidden" value="' + row.codigo + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton"  value="Cambiar">' +
                                '       </form>'
                            return rep;
                        },
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "codigo",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "Producto",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "iva",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "cantidad",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "precio",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "lote",
                        "className": 'dt-body-center',
                        "visible": tipoCompra == 1 ? true : false
                    },
                    {
                        "data": function (row) {
                            let rep = '<form action="delDetCompra.php" method="post" name="elimina">' +
                                '          <input name="tipoCompra" type="hidden" value="' + tipoCompra + '">' +
                                '          <input name="idCompra" type="hidden" value="' + idCompra + '">' +
                                '          <input name="codigo" type="hidden" value="' + row.codigo + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton"  value="Eliminar">' +
                                '      </form>'
                            return rep;
                        },
                        "className": 'dt-body-center'
                    }
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
        <img src="../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>DETALLE DE COMPRA DE<?= $titulo ?></h4></div>
    <div class="form-group row">
        <div class="col-1 text-end"><strong>No. de Compra</strong></div>
        <div class="col-1 bg-blue"><?= $idCompra; ?></div>
        <div class="col-1 text-end"><strong>Proveedor</strong></strong></div>
        <div class="col-3 bg-blue"><?= $compra['nomProv'] ?></div>
        <div class="col-1 text-end"><strong>NIT</strong></div>
        <div class="col-1 bg-blue"><?= $compra['nitProv'] ?></div>
        <div class="col-1 text-end"><strong>No. de Factura</strong></div>
        <div class="col-1 bg-blue"><?= $compra['numFact'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-2 text-end"><strong>Fecha de compra</strong></div>
        <div class="col-1 bg-blue"><?= $compra['fechComp']; ?></div>
        <div class="col-2 text-end"><strong>Fecha Vencimiento </strong></strong></div>
        <div class="col-1 bg-blue"><?= $compra['fechVenc'] ?></div>
        <div class="col-1 text-end"><strong>Estado</strong></div>
        <div class="col-1 bg-blue"><?= $compra['descEstado'] ?></div>
        <div class="col-1 text-end"><strong>Subtotal</strong></div>
        <div class="col-1 bg-blue"><?= $compra['subtotalCompra'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-1 text-end"><strong>Iva </strong></div>
        <div class="col-1 bg-blue"><?= $compra['ivaCompra'] ?></div>
        <div class="col-1 text-end"><strong>Reteiva </strong></div>
        <div class="col-1 bg-blue"><?= $compra['reteivaCompra'] ?></div>
        <div class="col-1 text-end"><strong>Rete Ica</strong></strong></div>
        <div class="col-1 bg-blue"><?= $compra['reteicaCompra'] ?></div>
        <div class="col-1 text-end"><strong>Retención</strong></div>
        <div class="col-1 bg-blue"><?= $compra['retefuenteCompra'] ?></div>
        <div class="col-1 text-end"><strong>Valor a Pagar</strong></div>
        <div class="col-1 bg-blue"><?= $compra['vreal'] ?></div>
    </div>


    <?php
    if ($compra['estadoCompra'] != 7) {
        ?>
        <div class="titulo row text-center">
            <strong>Adicionar Productos</strong>
        </div>
        <?php
        if ($tipoCompra == 1) {
            ?>
            <form method="post" action="makeDetCompra.php" name="form1">
                <input name="tipoCompra" type="hidden" value="<?= $tipoCompra; ?>">
                <input name="idCompra" type="hidden" value="<?= $idCompra; ?>">
                <div class="row">
                    <div class="col-2 text-center" style="margin: 0 5px 0 0;"><strong>Materia Prima</strong></div>
                    <div class="col-1 text-center" style="margin: 0 5px;"><strong>Cantidad en Kg</strong></div>
                    <div class="col-1 text-center" style="margin: 0 5px;"><strong>Precio por Kg (Sin IVA)</strong></div>
                    <div class="col-1 text-center" style="margin: 0 5px;"><strong>Lote Materia Prima</strong></div>
                    <div class="text-center" style="margin: 0 0 0 5px; flex: 0 0 10%; max-width: 10%;"><strong>Fecha
                            Lote</strong></div>
                    <div class="col-2 text-center">
                    </div>
                </div>
                <div class="form-group row">
                    <?php
                    $productos = $DetComprasOperador->getProdPorProveedorCompra($compra['idProv'], $tipoCompra, $idCompra);
                    $filas = count($productos);
                    echo '<select name="codigo" id="codigo" class="form-control col-2" style="margin: 0 5px;" required>';
                    echo '<option disabled selected value="">-----------------------------</option>';
                    for ($i = 0; $i < $filas; $i++) {
                        echo '<option value="' . $productos[$i]["Codigo"] . '">' . $productos[$i]['Producto'] . '</option>';
                    }
                    echo '</select>';
                    ?>
                    <input type="text" style="margin: 0 5px 0 0;" class="form-control col-1" name="cantidad"
                           id="cantidad"
                           onkeydown="return aceptaNum(event)">
                    <input type="text" style="margin: 0 5px;" class="form-control col-1" name="precio" id="precio"
                           onkeydown="return aceptaNum(event)">
                    <input type="text" style="margin: 0 5px;" class="form-control col-1" maxlength="15" name="lote" id="lote">
                    <input type="date" style="margin: 0 0 0 5px; flex: 0 0 10%; max-width: 10%;" class="form-control"
                           name="fechLote" id="fechLote">
                    <div class="col-2 text-center" style="padding: 0 20px;">
                        <button class="button" type="button" onclick="return Enviar(this.form)"><span>Adicionar producto</span>
                        </button>
                    </div>
                </div>
            </form>
            <?php
        }
        if ($tipoCompra == 2) {
            ?>
            <form method="post" action="makeDetCompra.php" name="form1">
                <input name="tipoCompra" type="hidden" value="<?= $tipoCompra; ?>">
                <input name="idCompra" type="hidden" value="<?= $idCompra; ?>">
                <div class="row">
                    <div class="col-2 text-center" style="margin: 0 5px 0 0;"><strong>Envase o tapa
                        </strong></div>
                    <div class="col-1 text-center" style="margin: 0 5px;"><strong>Cantidad</strong></div>
                    <div class="col-1 text-center" style="margin: 0 5px;"><strong>Precio por Un (Sin IVA)</strong></div>
                    <div class="col-2 text-center"></div>
                </div>
                <div class="form-group row">
                    <?php
                    $manager = new DetProveedoresOperaciones();
                    $productos = $DetComprasOperador->getProdPorProveedorCompra($compra['idProv'], $tipoCompra, $idCompra);
                    $filas = count($productos);
                    echo '<select name="codigo" id="codigo" class="form-control col-2" style="margin: 0 5px;" required>';
                    echo '<option disabled selected value="">-----------------------------</option>';
                    for ($i = 0; $i < $filas; $i++) {
                        echo '<option value="' . $productos[$i]["Codigo"] . '">' . $productos[$i]['Producto'] . '</option>';
                    }
                    echo '</select>';
                    ?>
                    <input type="text" style="margin: 0 5px 0 0;" class="form-control col-1" name="cantidad"
                           id="cantidad"
                           onkeydown="return aceptaNum(event)">
                    <input type="text" style="margin: 0 5px;" class="form-control col-1" name="precio" id="precio"
                           onkeydown="return aceptaNum(event)">
                    <div class="col-2 text-center" style="padding: 0 20px;">
                        <button class="button" type="button" onclick="return Enviar(this.form)"><span>Adicionar producto</span>
                        </button>
                    </div>
                </div>
            </form>
            <?php
        }
        if ($tipoCompra == 3) {
            ?>
            <form method="post" action="makeDetCompra.php" name="form1">
                <input name="tipoCompra" type="hidden" value="<?= $tipoCompra; ?>">
                <input name="idCompra" type="hidden" value="<?= $idCompra; ?>">
                <div class="row">
                    <div class="col-2 text-center" style="margin: 0 5px 0 0;"><strong>Etiqueta</strong></div>
                    <div class="col-1 text-center" style="margin: 0 5px;"><strong>Cantidad</strong></div>
                    <div class="col-1 text-center" style="margin: 0 5px;"><strong>Precio por Un (Sin IVA)</strong></div>
                    <div class="col-2 text-center">
                    </div>
                </div>
                <div class="form-group row">
                    <?php
                    $manager = new DetProveedoresOperaciones();
                    $productos = $DetComprasOperador->getProdPorProveedorCompra($compra['idProv'], $tipoCompra, $idCompra);
                    $filas = count($productos);
                    echo '<select name="codigo" id="codigo" class="form-control col-2" style="margin: 0 5px;" required>';
                    echo '<option disabled selected value="">-----------------------------</option>';
                    for ($i = 0; $i < $filas; $i++) {
                        echo '<option value="' . $productos[$i]["Codigo"] . '">' . $productos[$i]['Producto'] . '</option>';
                    }
                    echo '</select>';
                    ?>
                    <input type="text" style="margin: 0 5px 0 0;" class="form-control col-1" name="cantidad"
                           id="cantidad"
                           onkeydown="return aceptaNum(event)">
                    <input type="text" style="margin: 0 5px;" class="form-control col-1" name="precio" id="precio"
                           onkeydown="return aceptaNum(event)">
                    <div class="col-2 text-center" style="padding: 0 20px;">
                        <button class="button" type="button" onclick="return Enviar(this.form)"><span>Adicionar producto</span>
                        </button>
                    </div>
                </div>
            </form>
            <?php
        }
        if ($tipoCompra == 5) {
            ?>
            <form method="post" action="makeDetCompra.php" name="form1">
                <input name="tipoCompra" type="hidden" value="<?= $tipoCompra; ?>">
                <input name="idCompra" type="hidden" value="<?= $idCompra; ?>">
                <div class="row">
                    <div class="col-2 text-center" style="margin: 0 5px 0 0;"><strong>Producto de distribución</strong>
                    </div>
                    <div class="col-1 text-center" style="margin: 0 5px;"><strong>Cantidad</strong></div>
                    <div class="col-1 text-center" style="margin: 0 5px;"><strong>Precio por Un (Sin IVA)</strong></div>
                    <div class="col-2 text-center">
                    </div>
                </div>
                <div class="form-group row">
                    <?php
                    $manager = new DetProveedoresOperaciones();
                    $productos = $DetComprasOperador->getProdPorProveedorCompra($compra['idProv'], $tipoCompra, $idCompra);
                    $filas = count($productos);
                    echo '<select name="codigo" id="codigo" class="form-control col-2" style="margin: 0 5px;" required>';
                    echo '<option disabled selected value="">-----------------------------</option>';
                    for ($i = 0; $i < $filas; $i++) {
                        echo '<option value="' . $productos[$i]["Codigo"] . '">' . $productos[$i]['Producto'] . '</option>';
                    }
                    echo '</select>';
                    ?>
                    <input type="text" style="margin: 0 5px 0 0;" class="form-control col-1" name="cantidad"
                           id="cantidad"
                           onkeydown="return aceptaNum(event)">
                    <input type="text" style="margin: 0 5px;" class="form-control col-1" name="precio" id="precio"
                           onkeydown="return aceptaNum(event)">
                    <div class="col-2 text-center" style="padding: 0 20px;">
                        <button class="button" type="button" onclick="return Enviar(this.form)"><span>Adicionar producto</span>
                        </button>
                    </div>
                </div>
            </form>
            <?php
        }
        ?>
        <?php
    }
    ?>
    <div class="titulo row text-center">
        <strong>Detalle de la compra</strong>
    </div>
    <table id="example" class="display compact formatoDatos" style="width:80%; margin-bottom: 20px;">
        <thead>
        <tr>
            <th class="width1"></th>
            <th class="text-center width2">Código</th>
            <?php
            if ($tipoCompra == 1) {
                ?>
                <th class="text-center width3">Materia Prima</th>
                <th class="text-center width4">Iva</th>
                <th class="text-center width5">Cantidad(Kg)</th>
                <th class="text-center width6">Precio/Kg</th>
                <th class="text-center width7">Lote M. Prima</th>
                <?php
            }
            ?>
            <?php
            if ($tipoCompra == 2) {
                ?>
                <th class="text-center width34">Envase o tapa</th>
                <th class="text-center width4">Iva</th>
                <th class="text-center width5">Cantidad</th>
                <th class="text-center width56">Precio unitario(Sin Iva)</th>
                <th style="display: none">Lote</th>
                <?php
            }
            ?>
            <?php
            if ($tipoCompra == 3) {
                ?>
                <th class="text-center width34">Etiqueta</th>
                <th class="text-center width4">Iva</th>
                <th class="text-center width5">Cantidad</th>
                <th class="text-center width56">Precio unitario(Sin Iva)</th>
                <th style="display: none">Lote</th>
                <?php
            }
            ?>
            <?php
            if ($tipoCompra == 5) {
                ?>
                <th class="text-center width34">Producto</th>
                <th class="text-center width4"">Iva</th>
                <th class="text-center width5">Cantidad</th>
                <th class="text-center width56">Precio unitario(Sin Iva)</th>
                <th style="display: none">Lote</th>
                <?php
            }
            ?>
            <th class="width8"></th>
        </tr>
        </thead>
    </table>
    <div class="row">
        <div class="col-1">
            <button class="button" id="back" onClick="updateEstadoCompra(<?= $idCompra ?>)"><span>Terminar</span>
            </button>
        </div>
    </div>
</div>
</body>
</html>