<?php
include "../includes/valAcc.php";
if (isset($_SESSION['idFormula'])) {
    $idFormula = $_SESSION['idFormula'];
}
if (isset($_POST['idFormula'])) {
    $idFormula = $_POST['idFormula'];
}

function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$formulaOperador = new FormulasOperaciones();
$nomFormula = $formulaOperador->getNomFormula($idFormula);
$DetFormulaOperador = new DetFormulaOperaciones();
$porcentajeTotal = $DetFormulaOperador->getPorcentajeTotal($idFormula);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Porcentaje de Materias Primas en la Fórmula</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/datatables.css">
    <style>
        table.dataTable.compact thead th, table.dataTable.compact thead td {
            padding: 4px 4px 4px 4px;
        }
    </style>
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/datatables.js"></script>
    <script src="../js/jszip.js"></script>
    <script src="../js/pdfmake.js"></script>
    <script src="../js/vfs_fonts.js"></script>
    <script>
        $(document).ready(function () {
            let idFormula = <?=$idFormula?>;
            let ruta = "ajax/listaDetFormulas.php?idFormula=" + idFormula;
            $('#example').DataTable({
                "columns": [
                    {
                        "data": function (row) {
                            let rep = '<form action="updateDetFormulaForm.php" method="post" name="cambiar">' +
                                '          <input name="idFormula" type="hidden" value="' + idFormula + '">' +
                                '          <input name="codMPrima" type="hidden" value="' + row.codMPrima + '">' +
                                '          <input type="button" name="Submit" onclick="return Enviar(this.form)" class="formatoBoton"  value="Cambiar">' +
                                '      </form>'
                            return rep;
                        },
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "orden",
                        "className": 'dt-body-center'
                    },
                    {
                        "data": "nomMPrima",
                        "className": 'dt-body-left'
                    },
                    {
                        "data": "porcentaje",
                        "className": 'dt-body-right'
                    },
                    {
                        "data": function (row) {
                            let rep = '<form action="delDetFormula.php" method="post" name="elimina">' +
                                '          <input name="idFormula" type="hidden" value="' + idFormula + '">' +
                                '          <input name="codMPrima" type="hidden" value="' + row.codMPrima + '">' +
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

<div id="contenedor">
    <div id="saludo1"><strong>DETALLE DE FÓRMULA DE <?= strtoupper($nomFormula); ?>
        </strong></div>
    <form method="post" action="makeDetFormula.php" name="form1">
            <input name="idFormula" type="hidden" value="<?= $idFormula; ?>">
            <div class="row">
                <label class="col-form-label col-3 text-center" for="codMPrima" style="margin: 0 5px 0 0;"><strong>Materia Prima</strong></label>
                <label class="col-form-label col-1 text-center" for="porcentaje" style="margin: 0 5px;"><strong>% en fórmula</strong></label>
                <label class="col-form-label col-1 text-center" for="orden" style="margin: 0 5px;"><strong>Orden</strong></label>
                <div class="col-2 text-center">
                </div>
            </div>
            <div class="form-group row">
                <select name="codMPrima" id="codMPrima" class="form-control col-3" style="margin: 0 5px 0 0;">
                    <option disabled selected value="">-----------------------------</option>
                <?php
                $mprimas = $DetFormulaOperador->getMPrimasFormula($idFormula);
                for ($i = 0; $i < count($mprimas); $i++) {
                    echo '<option value="' . $mprimas[$i]["codMPrima"] . '">' . $mprimas[$i]['nomMPrima'] . '</option>';
                }
                echo '</select>';
                ?>
                <input type="text" style="margin: 0 5px;" class="form-control col-1" name="porcentaje"
                       id="porcentaje" onKeyPress="return aceptaNum(event)">
                <input type="text" style="margin: 0 5px;" class="form-control col-1" name="orden" id="orden"
                       onKeyPress="return aceptaNum(event)">
                <div class="col-2 text-center" style="padding: 0 20px;">
                    <button class="button" onclick="return Enviar(this.form)"><span>Adicionar detalle</span>
                    </button>
                </div>
            </div>
    </form>
    <div class="form-group titulo row">
        <strong>Detalle de la fórmula</strong>
    </div>
    <div class="tabla-50">
        <table id="example" class="display compact">
            <thead>
            <tr>
                <th width="15%"></th>
                <th width="15%">Orden</th>
                <th width="40%">Materia Prima</th>
                <th width="15%">Porcentaje</th>
                <th width="15%"></th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="tabla-50">
        <table width="100%">
            <tr>
                <td width="70%" class="text-right text-bold">Total</td>
                <td width="15%" class="text-right text-bold"><?=$porcentajeTotal ?></td>
                <td width="15%"></td>
            </tr>
        </table>
    </div>

    <div class="row">
        <div class="col-1">
            <button class="button" id="back" onclick="window.location='../menu.php'"><span>Terminar</span>
            </button>
        </div>
    </div>

</div>
</body>
</html>