<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Ajuste de Inventario de Producto Terminado</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script>

        function getLotesPresentacion(codPresentacion) {
            $.ajax({
                url: '../includes/controladorInventarios.php',
                type: 'POST',
                data: {
                    "action": 'findLotesPresentacion',
                    "codPresentacion": codPresentacion
                },
                dataType: 'json',
                success: function (lotes) {
                    let rep = '<option selected disabled value="">------------</option>';
                    for (i = 0; i < lotes.length; i++) {
                        rep += '<option value="' + lotes[i].loteProd + '">' + lotes[i].loteProd + '</option>';
                    }
                    $("#loteProd").html(rep);
                },
                error: function () {
                    alert("Vous avez un GROS problème");
                }
            });
        }

        function getInvPresentacionXLote(codPresentacion, loteProd) {
            $.ajax({
                url: '../includes/controladorInventarios.php',
                type: 'POST',
                data: {
                    "action": 'findInvProdTerminadoXLote',
                    "codPresentacion": codPresentacion,
                    "loteProd": loteProd,
                },
                dataType: 'json',
                success: function (response) {
                    $("#invProd").val(response);
                    $("#inv_ant").val(response);
                },
                error: function () {
                    alert("Vous avez un GROS problème");
                }
            });
        }
    </script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>SELECCIÓN DE PRODUCTO A AJUSTAR INVENTARIO</h4></div>
    <form id="form1" name="form1" method="post" action="../producto-distribucion/updateInvProd.php">
        <input type="hidden" name="tipo_inv" value="prod">
        <input type="hidden" name="idResponsable" value="<?= $_SESSION['userId']?>">
        <input type="hidden" name="inv_ant" id="inv_ant" value="">
        <div class="mb-3 row">
            <label class="form-label col-2" for="codPresentacion"><strong>Producto</strong></label>
            <select name="codPresentacion" id="codPresentacion" class="form-select col-3 formatoDatos"
                    onchange="getLotesPresentacion(this.value)" required>
                <option selected disabled value="">Seleccione una opción</option>
                <?php
                $PresentacionOperador = new PresentacionesOperaciones();
                $presentaciones = $PresentacionOperador->getPresentaciones(true);
                $filas = count($presentaciones);
                for ($i = 0; $i < $filas; $i++) {
                    echo '<option value="' . $presentaciones[$i]["codPresentacion"] . '">' . $presentaciones[$i]['presentacion'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="mb-3 row">
            <label class="form-label col-2" for="loteProd"><strong>Lote</strong></label>
            <select name="loteProd" id="loteProd" class="form-select col-3 formatoDatos"
                    onchange="getInvPresentacionXLote(document.getElementById('codPresentacion').value, this.value)"
                    required>
            </select>
        </div>
        <div class="mb-3 row">
            <label class="form-label col-2 text-end"
                   for=invProd><strong>Inventario</strong></label>
            <input type="text" class="form-control col-3 formatoDatos" name="invProd" id="invProd"
                   onkeydown="return aceptaNum(event)">

        </div>
        <div class="mb-3 row">
            <label class="form-label col-2 text-end"
                   for=motivo_ajuste><strong>Motivo ajuste</strong></label>
            <textarea class="form-control col-3" name="motivo_ajuste" id="motivo_ajuste" required></textarea>
        </div>
        <div class="mb-3 row">
            <div class="col-1 text-center">
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div>
            <div class="col-1 text-center">
                <button class="button" type="button"
                        onclick="return Enviar(this.form)"><span>Continuar</span></button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-1">
            <button class="button1" id="back" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>
