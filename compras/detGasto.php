<?php
include "../../../includes/valAcc.php";

if (isset($_SESSION['idGasto'])) {//Si la factura existe
    $idGasto = $_SESSION['idGasto'];
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
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$GastoOperador = new GastosOperaciones();
$DetGastoOperador = new DetGastosOperaciones();
$gasto = $GastoOperador->getGasto($idGasto);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Ingreso del Detalle de los Gastos de Industrias Novaquim</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
    <style>
        table.dataTable.compact thead th, table.dataTable.compact thead td {
            padding: 4px 4px 4px 4px;
        }
        table {
            table-layout: fixed;
        }

        .width1 {
            width: 10%;
        }

        .width2 {
            width: 45%;
        }

        .width3 {
            width: 5%;
        }
        .width4 {
            width: 10%;
        }

        .width5 {
            width: 20%;
        }
        .width6 {
            width: 10%;
        }

    </style>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>
    <script src="../js/jszip.js"></script>
    <!--<script src="../js/pdfmake.js"></script>-->  <!--Para exportar PDF-->
    <!--<script src="../js/vfs_fonts.js"></script>--> <!--Para exportar PDF-->
    <script>
        function redireccion() {
            window.location.href = "../menu.php";
        }

        function eliminarSession() {
            let variable = 'idGasto';
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

        function updateEstadoGasto(idGasto) {
            let estadoActualGasto = <?=$gasto['estadoGasto']?>;
            if (estadoActualGasto != 2) {
                eliminarSession();
            } else {
                $.ajax({
                    url: '../includes/controladorCompras.php',
                    type: 'POST',
                    data: {
                        "action": 'updateEstadoGasto',
                        "idGasto": idGasto,
                        "estadoGasto": 3,
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
            let idGasto = <?=$idGasto?>;
            let ruta = "ajax/listaDetGasto.php?idGasto=" + idGasto;
            $('#example').DataTable({
                "columns": [
                    {
                        "data": function (row) {
                            let rep = '<form action="updateDetGastoForm.php" method="post" name="elimina">' +
                                '          <input name="idGasto" type="hidden" value="' + idGasto + '">' +
                                '          <input name="producto" type="hidden" value="' + row.producto + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton"  value="Cambiar">' +
                                '      </form>'
                            return rep;
                        },
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "producto",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "iva",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "cantGasto",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "precGasto",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": function (row) {
                            let rep = '<form action="delDetGasto.php" method="post" name="elimina">' +
                                '          <input name="idGasto" type="hidden" value="' + idGasto + '">' +
                                '          <input name="producto" type="hidden" value="' + row.producto + '">' +
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
        <img src="../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>INGRESO DE DETALLE DE LOS GASTOS</h4></div>
    <div class="form-group row">
        <div class="col-1 text-end"><strong>No. de Gasto</strong></div>
        <div class="col-1 bg-blue"><?= $idGasto; ?></div>
        <div class="col-1 text-end"><strong>Proveedor</strong></strong></div>
        <div class="col-3" style="background-color: #dfe2fd;"><?= $gasto['nomProv'] ?></div>
        <div class="col-1 text-end"><strong>NIT</strong></div>
        <div class="col-1 bg-blue"><?= $gasto['nitProv'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-1 text-end"><strong>No. de Factura</strong></div>
        <div class="col-1 bg-blue"><?= $gasto['numFact'] ?></div>
        <div class="col-2 text-end"><strong>Fecha de compra</strong></div>
        <div class="col-1 bg-blue"><?= $gasto['fechGasto']; ?></div>
        <div class="col-2 text-end"><strong>Fecha Vencimiento </strong></strong></div>
        <div class="col-1 bg-blue"><?= $gasto['fechVenc'] ?></div>
        <div class="col-1 text-end"><strong>Estado</strong></div>
        <div class="col-1 bg-blue"><?= $gasto['descEstado'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-1 text-end"><strong>Valor Factura</strong></div>
        <div class="col-1 bg-blue"><?= $gasto['totalGasto'] ?></div>
        <div class="col-1 text-end"><strong>Rete Ica</strong></strong></div>
        <div class="col-1 bg-blue"><?= $gasto['reteicaGasto'] ?></div>
        <div class="col-1 text-end"><strong>Retención</strong></div>
        <div class="col-1 bg-blue"><?= $gasto['retefuenteGasto'] ?></div>
        <div class="col-1 text-end"><strong>Valor a Pagar</strong></div>
        <div class="col-1 bg-blue"><?= $gasto['vreal'] ?></div>
    </div>

    <?php
    if ($gasto['estadoGasto'] != 7) {
        ?>
        <div class="form-group titulo row text-center">
            <strong>Adicionar Detalle</strong>
        </div>
        <form method="post" action="makeDetGasto.php" name="form1">
            <input name="idGasto" type="hidden" value="<?= $idGasto; ?>">
            <div class="row">
                <div class="col-3 text-center" style="margin: 0 5px 0 0;"><strong>Descripción</strong></div>
                <div class="col-1 text-center" style="margin: 0 5px;"><strong>Cantidad</strong></div>
                <div class="col-1 text-center" style="margin: 0 5px;"><strong>Precio Unitario (Sin IVA)</strong></div>
                <div class="col-1 text-center" style="margin: 0 5px;"><strong>Tasa Iva</strong></div>
                <div class="col-2 text-center">
                </div>
            </div>
            <div class="form-group row">
                <input type="text" style="margin: 0 5px 0 0;" class="form-control col-3" name="producto"
                       id="producto">
                <input type="text" style="margin: 0 5px 0 0;" class="form-control col-1" name="cantGasto"
                       id="cantGasto" onkeydown="return aceptaNum(event)">
                <input type="text" style="margin: 0 5px;" class="form-control col-1" name="precGasto" id="precGasto"
                       onkeydown="return aceptaNum(event)">
                <?php
                $manager = new TasaIvaOperaciones();
                $tasas = $manager->getTasasIva();
                $filas = count($tasas);
                echo '<select name="codIva" id="codIva" class="form-control col-1" required>';
                echo '<option selected disabled value="">-------------</option>';
                for ($i = 0; $i < $filas; $i++) {
                    echo '<option value="' . $tasas[$i]["idTasaIva"] . '">' . $tasas[$i]['iva'] . '</option>';
                }
                echo '</select>';
                ?>
                <div class="col-2 text-center" style="padding: 0 20px;">
                    <button class="button" type="button" onclick="return Enviar(this.form)">
                        <span>Adicionar detalle</span>
                    </button>
                </div>
            </div>
        </form>
        <?php
    } ?>
    <div class="form-group titulo row text-center">
        <strong>Detalle del gasto</strong>
    </div>
    <table id="example" class="display compact formatoDatos" style="width:80%; margin-bottom: 20px;">
        <thead>
        <tr>
            <th class="width1 text-center"></th>
            <th class="width2 text-center">Descripción</th>
            <th class="width3 text-center">Iva</th>
            <th class="width4 text-center">Cantidad</th>
            <th class="width5 text-center">Precio unitario(Sin Iva)</th>
            <th class="width6 text-center"></th>
        </tr>
        </thead>
    </table>
    <div class="row">
        <div class="col-1">
            <button class="button" type="button" id="back" onClick="updateEstadoGasto(<?= $idGasto ?>)">
                <span>Terminar</span>
            </button>
        </div>
    </div>
</div>
</body>
</html>
