<?php
include "../includes/valAcc.php";

if (isset($_POST['lote'])) {
    $lote = $_POST['lote'];
} else {
    if (isset($_SESSION['lote'])) {
        $lote = $_SESSION['lote'];
    }
}

function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$OProdOperador = new OProdOperaciones();
$ordenProd = $OProdOperador->getOProd($lote);
$EnvasadoOperador = new EnvasadoOperaciones();
$cantidadPendiente = $EnvasadoOperador->getCantidadPorEnvasar($lote);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Envasado de productos por lote</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
    <style>
        table.dataTable.compact thead th {
            padding: 4px;
        }

        table.dataTable.compact tbody td {
            padding: 2px 4px;
        }

        .width1 {
            width: 15%;
        }

        .width2 {
            width: 15%;
        }

        .width3 {
            width: 55%;
        }

        .width4 {
            width: 15%;
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
        function terminarEnvasado(lote) {
            //alert(idCatProd);
            $.ajax({
                url: '../includes/controladorProduccion.php',
                type: 'POST',
                data: {
                    "action": 'updateEstadoOProd',
                    "estado": 4,
                    "lote": lote
                },
                dataType: 'text',
                success: function (message) {
                    alerta('Envasado finalizado correctamente','../menu.php', 'success');
                },
                error: function () {
                    alert("Vous avez un GROS problème");
                }
            });
        }

        $(document).ready(function () {
            let lote = <?=$lote?>;
            let cantidadPendiente = <?=$cantidadPendiente?>;
            let ruta = "ajax/listaDetEnvasado.php?lote=" + lote;
            $('#example').DataTable({
                "columns": [
                    {
                        "data": function (row) {
                            let rep = '<form action="updateEnvasadoForm.php" method="post" name="actualiza">' +
                                '          <input name="lote" type="hidden" value="' + lote + '">' +
                                '          <input name="cantidadPendiente" type="hidden" value="' + cantidadPendiente + '">' +
                                '          <input name="codPresentacion" type="hidden" value="' + row.codPresentacion + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton"  value="Cambiar">' +
                                '      </form>'
                            return rep;
                        },
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "codPresentacion",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "presentacion",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "cantPresentacion",
                        "className": 'dt-body-center'
                    },
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
<div id="contenedor">
    <div id="saludo1"><strong>PRODUCTOS ENVASADOS POR LOTE</strong></div>
    <div class="form-group row">
        <div class="col-1 text-right"><strong>Lote</strong></div>
        <div class="col-1 bg-blue"><?= $lote; ?></div>
        <div class="col-1 text-right"><strong>Cantidad</strong></div>
        <div class="col-1 bg-blue"><?= $ordenProd['cantidadKg'] ?> Kg</div>
        <div class="col-1 text-right"><strong>Responsable</strong></div>
        <div class="col-2 bg-blue"><?= $ordenProd['nomPersonal'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-1 text-right"><strong>Producto</strong></div>
        <div class="col-2 bg-blue"><?= $ordenProd['nomProducto'] ?></div>
        <div class="col-2 text-right"><strong>Fecha de producción</strong></strong></div>
        <div class="col-2 bg-blue"><?= $ordenProd['fechProd'] ?></div>
    </div>
    <div class="form-group titulo row">
        Adicionar Envasado
    </div>
    <form method="post" action="makeEnvasado.php" name="form1">
        <input name="lote" type="hidden" value="<?= $lote; ?>">
        <input name="cantidadPendiente" type="hidden" value="<?= $cantidadPendiente; ?>">
        <div class="row">
            <div class="col-3 text-center" style="margin: 0 5px 0 0;"><strong>Presentación de Productos</strong></div>
            <div class="col-1 text-center" style="margin: 0 5px;"><strong>Unidades</strong></div>
            <div class="col-2 text-center">
            </div>
        </div>
        <div class="form-group row">
            <select name="codPresentacion" id="codPresentacion" class="form-control col-3" style="margin: 0 5px 0 0;">
                <option selected disabled value="">------------------------------</option>
                <?php
                $presentaciones = $EnvasadoOperador->getPresentacionesPorEnvasar($lote);
                for ($i = 0; $i < count($presentaciones); $i++) {
                    echo '<option value="' . $presentaciones[$i]['codPresentacion'] . '">' . $presentaciones[$i]['presentacion'] . '</option>';
                }
                ?>
            </select>
            <input type="text" style="margin: 0 5px 0 0;" class="form-control col-1" name="cantPresentacion"
                   id="cantPresentacion" onkeydown="return aceptaNum(event)">
            <div class="col-2 text-center" style="padding: 0 20px;">
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Adicionar envasado</span>
                </button>
            </div>
        </div>
    </form>
    <div class="form-group row titulo">Detalle envasado :</div>
    <div class="tabla-50">
        <table id="example" class="display compact formatoDatos">
            <thead>
            <tr>
                <th class="width1"></th>
                <th class="width2">Código</th>
                <th class="width3">Producto por presentación</th>
                <th class="width4">Cantidad</th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="tabla-50">
        <table width="100% formatoDatos">
            <tr>
                <td width="85%" class="text-right text-bold formatoDatos">Cantidad pendiente en litros</td>
                <td width="15%" class="text-center text-bold formatoDatos"><?= $cantidadPendiente ?></td>
            </tr>
        </table>
    </div>
    <div class="row form-group">
        <div class="col-2">
            <button class="button" onclick="terminarEnvasado(<?= $lote; ?>)">
                <span><STRONG>Terminar envasado</STRONG></span>
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Ir al menú</STRONG></span>
            </button>
        </div>
    </div>
</div>
</body>
</html>