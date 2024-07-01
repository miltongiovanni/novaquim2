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
    <meta charset="utf-8">
    <title>Ajuste de Inventario de Etiquetas</title>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script>
        function getInvTapa(codEtiqueta) {
            $.ajax({
                url: '../../../../includes/controladorInventarios.php',
                type: 'POST',
                data: {
                    "action": 'findInvEtiqueta',
                    "codEtiqueta": codEtiqueta,
                },
                dataType: 'json',
                success: function (response) {
                    $("#invEtiq").val(response);
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
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>SELECCIÓN DE ETIQUETA A AJUSTAR INVENTARIO</h4></div>
    <form id="form1" name="form1" method="post" class="formatoDatos5" action="updateInvEtq.php">
        <input type="hidden" name="tipo_inv" value="etq">
        <input type="hidden" name="idResponsable" value="<?= $_SESSION['userId']?>">
        <input type="hidden" name="inv_ant" id="inv_ant" value="">
        <div class="mb-3 row">
            <div class="col-3">
                <label class="form-label" for="codEtiqueta"><strong>Etiqueta</strong></label>
                <select name="codEtiqueta" id="codEtiqueta" class="form-select" onchange="getInvTapa(this.value)" required>
                    <option selected disabled value="">Seleccione una opción</option>
                    <?php
                    $etiquetaOperador = new EtiquetasOperaciones();
                    $etiquetas = $etiquetaOperador->getEtiquetas();
                    $filas = count($etiquetas);
                    for ($i = 0; $i < $filas; $i++) {
                        echo '<option value="' . $etiquetas[$i]["codEtiqueta"] . '">' . $etiquetas[$i]['nomEtiqueta'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-1">
                <label class="form-label" for=invEtiq><strong>Inventario</strong></label>
                <input type="text" class="form-control" name="invEtiq" id="invEtiq" onkeydown="return aceptaNum(event)">
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-4">
                <label class="form-label" for=motivo_ajuste><strong>Motivo ajuste</strong></label>
                <textarea class="form-control" name="motivo_ajuste" id="motivo_ajuste" required></textarea>
            </div>
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
