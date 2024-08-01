<?php
include "../../../includes/valAcc.php";

if (isset($_POST['lote'])) {
    $lote = $_POST['lote'];
} else {
    if (isset($_SESSION['lote'])) {
        $lote = $_SESSION['lote'];
    }
}


function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
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
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../../css/datatables.css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/datatables.js"></script>

    <script>
        $(document).ready(function () {
            let lote = <?=$lote?>;
            let ruta = "../ajax/listaDetOProd.php?lote=" + lote;
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
                        "data": "loteMP",
                        "className": 'dt-body-center',
                        width: '15%'
                    },
                    {
                        "data": "cantidadMPrima",
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
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>USO DE MATERIA PRIMA POR PRODUCCIÓN</h4></div>
    <div class="mb-3 row">
        <div class="col-1">
            <strong>Lote</strong>
            <div class="bg-blue"><?= $lote; ?></div>
        </div>
        <div class="col-1">
            <strong>Cantidad</strong>
            <div class="bg-blue"><?= $ordenProd['cantidadKg'] ?> Kg</div>
        </div>
        <div class="col-2">
            <strong>Fecha de producción</strong>
            <div class="bg-blue"><?= $ordenProd['fechProd'] ?></div>
        </div>
        <div class="col-2">
            <strong>Responsable</strong>
            <div class="bg-blue"><?= $ordenProd['nomPersonal'] ?></div>
        </div>
        <div class="col-2">
            <strong>Estado</strong>
            <div class="bg-blue"><?= $ordenProd['descEstado'] ?></div>
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-4">
            <strong>Producto</strong>
            <div class="bg-blue"><?= $ordenProd['nomProducto'] ?></div>
        </div>
        <div class="col-4">
            <strong>Fórmula</strong>
            <div class="bg-blue"><?= $ordenProd['nomFormula'] ?></div>
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-2">
            <form action="Imp_Ord_prod.php" method="post" target="_blank">
                <input name="lote" type="hidden" value="<?= $lote; ?>">
                <button class="button" type="submit">
                    <span><STRONG>Imprimir Orden</STRONG></span></button>
            </form>
        </div>
    </div>
    <div class="mb-3 row titulo">Detalle orden de producción :</div>
    <div class="tabla-50">
        <table id="example" class="formatoDatos5 table table-sm table-striped">
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
            <button class="button" onclick="window.location='../../../menu.php'">
                <span><STRONG>Terminar</STRONG></span>
            </button>
        </div>
    </div>
</div>
</body>
</html>