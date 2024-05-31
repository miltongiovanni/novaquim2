<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Lista de Precios</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>

<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo" class="form-group"><strong>DETALLE LISTA DE PRECIOS</strong></div>
    <?php
    $Presentaciones = $_POST['Presentaciones'];
    if ($_POST['seleccion1']) {
        $opciones_prod = implode(",", $_POST['seleccion1']);
        $i = 0;
        $qry = "select codigoGen, producto, ";
        //SE DETERMINA A QUE PRECIO SE VA A COTIZAR
        $c = count($_POST['seleccion1']);
        $precios1 = array();
        for ($k = 0; $k < $c; $k++) {
            if ($_POST['seleccion1'][$k] == 1) {
                $precios1[] = " Fábrica";
                $precios[] = " fabrica";
            }
            if ($_POST['seleccion1'][$k] == 2) {
                $precios1[] = " Distrib";
                $precios[] = " distribuidor";
            }
            if ($_POST['seleccion1'][$k] == 3) {
                $precios1[] = " Detal";
                $precios[] = " detal";
            }
            if ($_POST['seleccion1'][$k] == 4) {
                $precios1[] = " Mayor";
                $precios[] = " mayor";
            }
            if ($_POST['seleccion1'][$k] == 5) {
                $precios1[] = " Super";
                $precios[] = " super";
            }
        }
        $opciones_prec1 = implode(",", $precios1);
        $opciones_prec = implode(",", $precios);
        $qry = $qry . $opciones_prec;
        $qry = $qry . " from precios, (SELECT DISTINCTROW precios.codigoGen codigo, cantMedida FROM prodpre, precios, medida 
    WHERE precios.codigoGen=prodpre.codigoGen and medida.idMedida=prodpre.codMedida and prodpre.presentacionActiva=0) as tabla  where presActiva=0 and codigoGen=codigo";

        //SELECCIONA EL TIPO DE PRESENTACIONES 1 PARA TODAS, 2 PARA PEQUE�AS Y 3 PARA GRANDES
        if ($Presentaciones == 1) {
            $wh = " and cantMedida<=20000";
            $presen = "Todas";
        }
        if ($Presentaciones == 2) {
            $wh = " and cantMedida<=4000";
            $presen = "Pequeñas";
        }
        if ($Presentaciones == 3) {
            $wh = " and cantMedida>=3500";
            $presen = "Grandes";
        }
        $qry = $qry . $wh . " order by codigoGen";
        //echo $qry."<br>";
    } else {
        //echo "no escogió productos de novaquim <br>";
        echo ' <script >
	alert("Debe escoger algún tipo de precio");
	history.back();
	</script>';
    }
    ?>
    <div class="row form-group">
        <div class="col-1">
            <strong>Presentación</strong>
        </div>
        <div class="col-2">
            <?= $presen; ?>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-1">
            <strong>Precio</strong>
        </div>
        <div class="col-2">
            <?= $opciones_prec1; ?>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-2">
            <form action="ImpPrecios.php" method="post" target="_blank">
                <input type="hidden" name="precioSinIva" value="<?= $_POST['precioSinIva'];?>">
                <input name="query" type="hidden" value="<?php echo $qry; ?>">
                <input name="opciones_prec1" type="hidden" value="<?php echo $opciones_prec1; ?>">

                <button class="button" type="submit" onclick="return Enviar(this.form)">
                    <span>Imprimir Lista</span></button>

            </form>
        </div>

    </div>
    <div class="row form-group">
        <div class="col-1">
            <button class="button" type="button"
                    onclick="window.location='../../../menu.php'">
                <span><STRONG>Ir al Menú</STRONG></span></button>
        </div>
    </div>
</div>
</body>

</html>