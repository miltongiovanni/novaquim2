<?php
include "../../../includes/valAcc.php";
if (isset($_POST['loteColor'])) {
    $loteColor = $_POST['loteColor'];
} else {
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
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../../css/datatables.css">

    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>
    <script src="../../../js/jszip.js"></script>
    <script src="../../../js/pdfmake.js"></script>
    <script src="../../../js/vfs_fonts.js"></script>
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
                        "className": 'dt-body-center',
                        width: '15%'
                    },
                    {
                        "data": "codMPrima",
                        "className": 'dt-body-center',
                        width: '10%'
                    },
                    {
                        "data": "aliasMPrima",
                        "className": 'dt-body-center',
                        width: '40%'
                    },
                    {
                        "data": "loteMPrima",
                        "className": 'dt-body-center',
                        width: '15%'
                    },
                    {
                        "data": "cantMPrima",
                        "className": 'dt-body-center',
                        width: '20%'
                    }
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
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>USO DE MATERIA PRIMA POR PRODUCCIÓN DE COLOR</h4></div>
    <div class="mb-3 row formatoDatos5">
        <div class="col-1">
            <strong>Lote</strong>
            <div class="bg-blue"><?= $loteColor; ?></div>
        </div>
        <div class="col-2">
            <strong>Producto</strong>
            <div class="bg-blue"><?= $ordenProd['nomMPrima'] ?></div>
        </div>
        <div class="col-1">
            <strong>Cantidad</strong>
            <div class="bg-blue"><?= $ordenProd['cantKg'] ?> Kg</div>
        </div>
        <div class="col-2">
            <strong>Fecha de producción</strong>
            <div class="bg-blue"><?= $ordenProd['fechProd'] ?></div>
        </div>
        <div class="col-2">
            <strong>Responsable</strong>
            <div class="bg-blue"><?= $ordenProd['nomPersonal'] ?></div>
        </div>
    </div>
    <div class="mb-3 row">
    </div>
    <div class="mb-3 row titulo">Detalle orden de producción :</div>
    <div class="tabla-50">
        <table id="example" class="formatoDatos5 table table-sm table-striped">
            <thead>
            <tr>
                <th></th>
                <th class="text-center">Código MP</th>
                <th class="text-center">Materia Prima</th>
                <th class="text-center">Lote MP</th>
                <th class="text-center">MP Utilizada (Kg)</th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="row">
        <div class="col-1">
            <button class="button" onclick="window.location='../../../menu.php'">
                <span><STRONG>Terminar</STRONG></span>
            </button>
        </div>
    </div>
</div>
</body>
</html>