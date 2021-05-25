<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Ajuste de Inventario de Producto de Distribución</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script>
        function getInvProdDistribucion(codDistribucion) {
            $.ajax({
                url: '../includes/controladorInventarios.php',
                type: 'POST',
                data: {
                    "action": 'findInvProdDistribucion',
                    "codDistribucion": codDistribucion,
                },
                dataType: 'json',
                success: function (response) {
                    $("#invDistribucion").val(response);
                },
                error: function () {
                    alert("Vous avez un GROS problème");
                }
            });
        }
    </script>
</head>
<body>
<div id="contenedor">
    <div id="saludo"><h4>SELECCIÓN DE PRODUCTO DE DISTRIBUCIÓN A AJUSTAR INVENTARIO</h4></div>
    <form id="form1" name="form1" method="post" action="updateInvDist.php">
        <div class="form-group row">
            <label class="col-form-label col-2" for="codDistribucion"><strong>Producto</strong></label>
            <select name="codDistribucion" id="codDistribucion" class="form-control col-3 formatoDatos"
                    onchange="getInvProdDistribucion(this.value)" required>
                <option selected disabled value="">-----------------------------</option>
                <?php
                $prodDistribucionOperador = new ProductosDistribucionOperaciones();
                $productos = $prodDistribucionOperador->getProductosDistribucion(true);
                $filas = count($productos);
                for ($i = 0; $i < $filas; $i++) {
                    echo '<option value="' . $productos[$i]["idDistribucion"] . '">' . $productos[$i]['producto'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-right"
                   for=invDistribucion><strong>Inventario</strong></label>
            <input type="text" class="form-control col-3 formatoDatos" name="invDistribucion" id="invDistribucion"
                   onkeydown="return aceptaNum(event)">

        </div>
        <div class="form-group row">
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
