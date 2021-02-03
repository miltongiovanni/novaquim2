<?php
include "../includes/valAcc.php";

if (isset($_POST['lote'])) {
    $lote = $_POST['lote'];
}else{
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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Detalle Orden de Producción</title>
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
            width: 10%;
        }

        .width3 {
            width: 40%;
        }

        .width4 {
            width: 15%;
        }

        .width5 {
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
        $(document).ready(function () {
            let lote = <?=$lote?>;
            let ruta = "ajax/listaDetOProd.php?lote=" + lote;
            $('#example').DataTable({
                "columns": [
                    {
                        "data": function (row) {
                            let rep = '<form action="updateDetOProdForm.php" method="post" name="actualiza">' +
                                '          <input name="lote" type="hidden" value="' + lote + '">' +
                                '          <input name="codMPrima" type="hidden" value="' + row.codMPrima + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton"  value="Cambiar">' +
                                '      </form>'
                            return rep;
                        },
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "codMPrima",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "aliasMPrima",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "loteMP",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "cantidadMPrima",
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
<div id="contenedor">
    <div id="saludo1"><strong>USO DE MATERIA PRIMA POR PRODUCCIÓN</strong></div>
    <div class="form-group row">
        <div class="col-1 text-right"><strong>Lote</strong></div>
        <div class="col-1 bg-blue"><?= $lote; ?></div>
        <div class="col-3 text-right"><strong>Cantidad</strong></div>
        <div class="col-1 bg-blue"><?= $ordenProd['cantidadKg'] ?> Kg</div>
        <div class="col-1 text-right"><strong>Estado</strong></div>
        <div class="col-1 bg-blue"><?= $ordenProd['descEstado'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-1 text-right"><strong>Producto</strong></div>
        <div class="col-3 bg-blue"><?= $ordenProd['nomProducto'] ?></div>
        <div class="col-2 text-right"><strong>Fecha de producción</strong></strong></div>
        <div class="col-2 bg-blue"><?= $ordenProd['fechProd'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-1 text-right"><strong>Fórmula</strong></div>
        <div class="col-3 bg-blue"><?= $ordenProd['nomFormula'] ?></div>
        <div class="col-2 text-right"><strong>Responsable</strong></div>
        <div class="col-2 bg-blue"><?= $ordenProd['nomPersonal'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-2">
            <form action="Imp_Ord_prod.php" method="post" target="_blank">
                <input name="lote" type="hidden" value="<?= $lote; ?>">
                <button class="button" type="submit">
                    <span><STRONG>Imprimir Orden</STRONG></span></button>
            </form>
        </div>
    </div>
    <div class="form-group row titulo">Detalle orden de producción :</div>
    <div class="tabla-50">
        <table id="example" class="display compact formatoDatos">
            <thead>
            <tr>
                <th class="width1"></th>
                <th class="width2">Código MP</th>
                <th class="width3">Materia Prima</th>
                <th class="width4">Lote MP</th>
                <th class="width5">MP Utilizada (Kg)</th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="row">
        <div class="col-1">
            <button class="button" onclick="window.location='../menu.php'">
                <span><STRONG>Terminar</STRONG></span>
            </button>
        </div>
    </div>
</div>
</body>
</html>