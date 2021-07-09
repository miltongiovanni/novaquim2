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
    <title>Creación de Presentación de Productos</title>
    <meta charset="utf-8">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>

<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2"><h4>CREACIÓN DE PRESENTACIÓN DE PRODUCTO</h4></div>
    <form name="form2" method="POST" action="makeMedida.php">
        <div class="form-group row">
            <label class="col-form-label col-1" for="codMedida"><strong>Medida</strong></label>
            <?php
            $MedidasOperador = new MedidasOperaciones();
            $medidas = $MedidasOperador->getMedidas();
            $filas = count($medidas);
            echo '<select name="codMedida" id="codMedida" class="form-control col-2" required>';
            echo '<option selected disabled value="">-----------------------------</option>';
            for ($i = 0; $i < $filas; $i++) {
                echo '<option value="' . $medidas[$i]["idMedida"] . '">' . $medidas[$i]['desMedida'] . '</option>';
            }
            echo '</select>';
            ?>
            <label class="col-form-label col-2" for="presentacion"><strong>Presentación</strong></label>
            <input name="presentacion" id="presentacion" class="form-control col-3" type="text" value="" required/>

        </div>
        <div class="form-group row">
            <label class="col-form-label col-1" for="codEnvase"><strong>Envase</strong></label>
            <?php
            $EnvasesOperador = new EnvasesOperaciones();
            $envases = $EnvasesOperador->getEnvases();
            $filas = count($envases);
            echo '<select name="codEnvase" id="codEnvase" class="form-control col-2" required>';
            echo '<option selected value="">-----------------------------</option>';
            for ($i = 0; $i < $filas; $i++) {
                echo '<option value="' . $envases[$i]["codEnvase"] . '">' . $envases[$i]['nomEnvase'] . '</option>';
            }
            echo '</select>';
            ?>
            <label class="col-form-label col-2" for="codProducto"><strong>Producto</strong></label>
            <?php
            $ProductoOperador = new ProductosOperaciones();
            $productos = $ProductoOperador->getProductos(true);
            $filas = count($productos);
            echo '<select name="codProducto" id="codProducto" class="form-control col-3" onchange="idProducto(this.value);" required>';
            echo '<option selected disabled value="">-----------------------------</option>';
            for ($i = 0; $i < $filas; $i++) {
                echo '<option value="' . $productos[$i]["codProducto"] . '">' . $productos[$i]['nomProducto'] . '</option>';
            }
            echo '</select>';


            ?>
        </div>
        <div class="form-group row">
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
            <input type="text" name="codSiigo" id="codSiigo" class="form-control col-2"
                   onkeydown="return aceptaNum(event)" value="<?= ($row['maxsiigo'] + 1) ?>" />
            <label class="col-form-label col-2" for="codigoGen"><strong>Código General</strong></label>
            <?php
            $PrecioOperador = new PreciosOperaciones();
            $precios = $PrecioOperador->getPrecios(1);
            $filas = count($precios);
            echo '<select name="codigoGen" id="codigoGen" class="form-control col-3" required>';
            echo '<option selected value="">-----------------------------</option>';
            for ($i = 0; $i < $filas; $i++) {
                echo '<option value="' . $precios[$i]["codigoGen"] . '">' . $precios[$i]['producto'] . '</option>';
            }
            echo '</select>';

            ?>

        </div>
        <div class="form-group row">
            <label class="col-form-label col-1" for="stockPresentacion"><strong>Stock Mínimo</strong></label>
            <input name="stockPresentacion" id="stockPresentacion" type="text" value="" class="form-control col-2"
                   onkeydown="return aceptaNum(event)" required/>
            <label class="col-form-label col-2" for="codTapa"><strong>Tapa</strong></label>
            <?php
            $TapasOperador = new TapasOperaciones();
            $tapas = $TapasOperador->getTapas();
            $filas = count($tapas);
            echo '<select name="codTapa" id="codTapa" class="form-control col-3" required>';
            echo '<option selected value="">-----------------------------</option>';
            for ($i = 0; $i < $filas; $i++) {
                echo '<option value="' . $tapas[$i]["codTapa"] . '">' . $tapas[$i]['tapa'] . '</option>';
            }
            echo '</select>';

            ?>

        </div>
        <div class="form-group row">
            <label class="col-form-label col-1" for="cotiza"><strong>Cotizar</strong></label>
            <select name="cotiza" id="cotiza" class="form-control col-2">
                <option value="0" selected>No</option>
                <option value="1">Si</option>
            </select>
            <label class="col-form-label col-2" for="codEtiq"><strong>Etiqueta</strong></label>
            <?php
            $EtiquetasOperador = new EtiquetasOperaciones();
            $etiquetas = $EtiquetasOperador->getEtiquetas();
            $filas = count($etiquetas);
            echo '<select name="codEtiq" id="codEtiq" class="form-control col-3" required>';
            echo '<option selected value="">-----------------------------</option>';
            for ($i = 0; $i < $filas; $i++) {
                echo '<option value="' . $etiquetas[$i]["codEtiqueta"] . '">' . $etiquetas[$i]['nomEtiqueta'] . '</option>';
            }
            echo '</select>';

            ?>

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
            <button class="button1" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>

</div>
</body>

</html>