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
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Creación de Productos de Distribución</title>
    <meta charset="utf-8">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script>

        //var idCatProd = $('idCatProd').value;

        function idProducto(idCatDis) {
            //alert(idCatProd);
            $.ajax({
                url: '../includes/controladorBase.php',
                type: 'POST',
                data: {
                    "action": 'ultimoProdDisxCat',
                    "idCatDis": idCatDis
                },
                dataType: 'text',
                success: function (lastCodDis) {
                    $("#idDistribucion").val(lastCodDis);
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
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2"><h4>CREACIÓN DE PRODUCTOS DE DISTRIBUCIÓN</h4></div>
    <form name="form2" method="POST" action="makeDis.php">
        <div class="form-group row">

            <label class="col-form-label col-1" for="idCatDis"><strong>Categoría</strong></label>
            <?php
            $manager = new CategoriasDisOperaciones();
            $categorias = $manager->getCatsDis();
            $filas = count($categorias);
            echo '<select name="idCatDis" id="idCatDis" class="form-control col-2" onchange="idProducto(this.value);" required>';
            echo '<option disabled selected value="">-----------------------------</option>';
            for ($i = 0; $i < $filas; $i++) {
                echo '<option value="' . $categorias[$i]["idCatDis"] . '">' . $categorias[$i]['catDis'] . '</option>';
            }
            echo '</select>';
            ?>
            <?php
            $link = Conectar::conexion();

            $qry = "SELECT MAX(siigo) maxsiigo FROM (SELECT MAX(codSiigo) siigo FROM distribucion  WHERE CodIva=3
                    union
                    SELECT MAX(codSiigo) siigo FROM prodpre  WHERE CodIva=3
                    union
                    SELECT MAX(codSiigo) siigo FROM servicios  WHERE CodIva=3
                    ) AS a";
            $stmt = $link->prepare($qry);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <label class="col-form-label col-1" for="codSiigo"><strong>Código Siigo</strong></label>
            <input type="text" name="codSiigo" id="codSiigo" class="form-control col-3"
                   onkeydown="return aceptaNum(event)" value="<?= ($row['maxsiigo'] + 1) ?>"/>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1" for="idDistribucion"><strong>Código</strong></label>
            <input type="text" class="form-control col-2" name="idDistribucion" id="idDistribucion"
                   onkeydown="return aceptaNum(event)" readOnly>
            <label class="col-form-label col-1"
                   for="producto"><strong>Producto</strong></label>
            <input type="text" class="form-control col-3" name="producto" id="producto"
                   onkeydown="return aceptaLetra(event)" maxlength="50" required>
        </div>
        <div class="form-group row">

            <label class="col-form-label col-1" for="precioVta"><strong>Precio
                    Venta</strong></label>
            <input type="text" class="form-control col-2" name="precioVta" id="precioVta"
                   onkeydown="return aceptaNum(event)" required>
            <label class="col-form-label col-1" for="codIva"><strong>Iva</strong></label>
            <?php
            $manager = new TasaIvaOperaciones();
            $tasas = $manager->getTasasIva();
            $filas = count($tasas);
            echo '<select name="codIva" id="codIva" class="form-control col-3" required>';
            echo '<option selected disabled value="">-----------------------------</option>';
            for ($i = 0; $i < $filas; $i++) {
                echo '<option value="' . $tasas[$i]["idTasaIva"] . '">' . $tasas[$i]['iva'] . '</option>';
            }
            echo '</select>';
            ?>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1" for="stockDis"><strong>Stock
                    Min</strong></label>
            <input type="text" class="form-control col-2" min="0" name="stockDis" id="stockDis" pattern="[0-9]"
                   onkeydown="return aceptaNum(event)" required>
            <label class="col-form-label col-1" for="cotiza"><strong>Cotizar</strong></label>
            <select name="cotiza" id="cotiza" class="form-control col-3">
                <option value="1">Si</option>
                <option value="0" selected>No</option>
            </select>
        </div>
        <div class="form-group row">
            <div class="col-1 text-center">
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div>
            <div class="col-1 text-center">
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Continuar</span></button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-1">
            <button class="button1" type="button" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>

