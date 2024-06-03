<?php
include "../../../includes/valAcc.php";
if (isset($_POST['loteColor'])) {
    $loteColor = $_POST['loteColor'];
}else{
    if (isset($_SESSION['loteColor'])) {
        $loteColor = $_SESSION['loteColor'];
    }
}


function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$OProdColorOperador = new OProdColorOperaciones();
$ordenProd = $OProdColorOperador->getOProdColor($loteColor);
$DetOProdColorOperador = new DetOProdColorOperaciones();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Detalle Orden de Producción de Color</title>
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
            let loteColor = <?=$loteColor?>;
            let ruta = "../ajax/listaDetOProdColor.php?loteColor=" + loteColor;
            $('#example').DataTable({
                "columns": [
                    {
                        "data": function (row) {
                            let rep = '<form action="updateDetOProdColorForm.php" method="post" name="actualiza">' +
                                '          <input name="loteColor" type="hidden" value="' + loteColor + '">' +
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
                        "data": "loteMPrima",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "cantMPrima",
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
        <img src="../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>USO DE MATERIA PRIMA POR PRODUCCIÓN DE COLOR</h4></div>
    <div class="mb-3 row">
        <div class="col-1"><strong>Lote</strong></div>
        <div class="col-1 bg-blue"><?= $loteColor; ?></div>
        <div class="col-1"><strong>Cantidad</strong></div>
        <div class="col-1 bg-blue"><?= $ordenProd['cantKg'] ?> Kg</div>
        <div class="col-2"><strong>Fecha de producción</strong></strong></div>
        <div class="col-1 bg-blue"><?= $ordenProd['fechProd'] ?></div>
    </div>
    <div class="mb-3 row">
        <div class="col-1"><strong>Producto</strong></div>
        <div class="col-2 bg-blue"><?= $ordenProd['nomMPrima'] ?></div>
        <div class="col-2"><strong>Responsable</strong></div>
        <div class="col-2 bg-blue"><?= $ordenProd['nomPersonal'] ?></div>
    </div>
    <div class="mb-3 row titulo">Detalle orden de producción :</div>
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