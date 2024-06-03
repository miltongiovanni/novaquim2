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
    <title>Creación de Código Genérico</title>
    <meta charset="utf-8">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script>

        //var idCatProd = $('idCatProd').value;

        function idProducto(codProducto) {
            //alert(idCatProd);
            $.ajax({
                url: '../../../includes/controladorBase.php',
                type: 'POST',
                data: {
                    "action": 'infoProducto',
                    "codProducto": codProducto
                },
                dataType: 'json',
                success: function (producto) {
                    $("#producto").val(producto.nomProducto);
                    $("#idCodCat").val(producto.idCatProd);
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
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>CREACIÓN DE CÓDIGO GENÉRICO</h4></div>
    <form name="form2" method="POST" action="makeCod.php">
        <div class="mb-3 row">
            <div class="col-3">
                <label class="form-label " for="idCatProd"><strong>Producto</strong></label>
                <?php
                $ProductoOperador = new ProductosOperaciones();
                $productos = $ProductoOperador->getProductos(true);
                $filas = count($productos);
                echo '<select name="codProducto" class="form-control " onchange="idProducto(this.value);" required>';
                echo '<option selected disabled value="">-----------------------------</option>';
                for ($i = 0; $i < $filas; $i++) {
                    echo '<option value="' . $productos[$i]["codProducto"] . '">' . $productos[$i]['nomProducto'] . '</option>';
                }
                echo '</select>';
                ?>
                <input name="producto" id="producto" type="hidden" readonly="readonly" value="" size="34"/>
                <input name="idCodCat" id="idCodCat" type="hidden" readonly="readonly" value="" size="34"/>
            </div>
            <div class="col-2">
                <label class="form-label " for="idCatProd"><strong>Medida</strong></label>
                <?php
                $MedidaOperador = new MedidasOperaciones();
                $medidas = $MedidaOperador->getMedidas();
                $filas = count($medidas);
                echo '<select name="medida" class="form-control " required>';
                echo '<option selected disabled value="">-----------------------------</option>';
                for ($i = 0; $i < $filas; $i++) {
                    echo '<option value="' . $medidas[$i]["idMedida"] . ',' . $medidas[$i]["desMedida"] . '">' . $medidas[$i]['desMedida'] . '</option>';
                }
                echo '</select>';
                ?>
            </div>
            <div class="col-1">
                <label class="form-label " for="fabrica"><strong>Precio fábrica</strong></label>
                <input type="text" class="form-control " name="fabrica" id="fabrica" maxlength="50"
                       onkeydown="return aceptaNum(event)" required>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-1 text-center">
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div>
            <div class="col-1 text-center">
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Continuar</span></button>
            </div>
        </div>


    </form>
</div>
</body>

</html>