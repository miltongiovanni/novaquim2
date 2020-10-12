<?php include "../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');


//echo '<pre>'; print_r($_POST); die;
foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
//echo '<pre>';var_dump($seleccionProd);
//echo '<pre>';var_dump($seleccionDis);
die;
if (!isset($_POST['seleccionProd'])) {
    $ruta = "cotizacion.php";
    $mensaje = "Debe escoger alguna familia de los productos Novaquim";
    mover_pag($ruta, $mensaje);
} else {
    $opciones_prod = implode(",", $_POST['seleccion1']);
    $i = 0;
    //SE DETERMINA A QUE PRECIO SE VA A COTIZAR
    if ($precio == 1)
        $qry = "select DISTINCT codigo_ant, Producto, prodpre.fabrica as precio from prodpre, productos, precios WHERE Cod_ant=codigo_ant and prodpre.Cod_produc=productos.Cod_produc and Cotiza=0 ";
    if ($precio == 2)
        $qry = "select DISTINCT codigo_ant, Producto, prodpre.distribuidor as precio from prodpre, productos, precios WHERE Cod_ant=codigo_ant and prodpre.Cod_produc=productos.Cod_produc and Cotiza=0 ";
    if ($precio == 3)
        $qry = "select DISTINCT codigo_ant, Producto, prodpre.detal as precio from prodpre, productos, precios WHERE Cod_ant=codigo_ant and prodpre.Cod_produc=productos.Cod_produc and Cotiza=0 ";
    if ($precio == 4)
        $qry = "select DISTINCT codigo_ant, Producto, prodpre.mayor as precio from prodpre, productos, precios WHERE Cod_ant=codigo_ant and prodpre.Cod_produc=productos.Cod_produc and Cotiza=0 ";
    if ($precio == 5)
        $qry = "select DISTINCT codigo_ant, Producto, prodpre.super as precio from prodpre, productos, precios WHERE Cod_ant=codigo_ant and prodpre.Cod_produc=productos.Cod_produc and Cotiza=0 ";
    //SELECCIONA EL TIPO DE PRESENTACIONES 1 PARA TODAS, 2 PARA PEQUEÑAS Y 3 PARA GRANDES
    if ($Presentaciones == 1)
        $wh = "";
    if ($Presentaciones == 2)
        $wh = " and Cod_umedid<=11 and Cotiza=0";
    if ($Presentaciones == 3)
        $wh = " and Cod_umedid>=10 and Cotiza=0";
    $qry = $qry . $wh . "";
    $b = count($_POST['seleccion1']);
    $qryp = " and (";
    for ($k = 0; $k < $b; $k++) {
        $qryp = $qryp . " Id_cat_prod=" . ($_POST['seleccion1'][$k]);
        if ($k <= ($b - 2))
            $qryp = $qryp . " or ";
    }
    $qryp = $qryp . ")";
    $qry = $qry . $qryp;
    echo $qry . "<br>";
    $qryd = "select Id_distribucion, Producto, precio_vta from distribucion where Cotiza=0";
    if ($_POST['seleccion']) {
        $qryd = $qryd . " and (";
        $opciones_dist = implode(",", $_POST['seleccion']);
        //echo $separado_por_comas."<br>";
        //print_r(explode(',', $separado_por_comas));
        //echo "<br>";

        $a = count($_POST['seleccion']);
        for ($j = 0; $j < $a; $j++) {
            $qryd = $qryd . "(Id_distribucion >= " . ($_POST['seleccion'][$j] * 100000 + 1) . " and Id_distribucion <= " . (($_POST['seleccion'][$j] + 1) * 100000 - 1) . ")";

            if ($j <= ($a - 2))
                $qryd = $qryd . " or ";
        }
        $qryd = $qryd . ")";
        $ba = 1;
        //echo $qryd."<br>";
        //echo "<br>";
    } else {
        //echo "no escogió productos de distribución <br>";
        $No_dist = 1;
    }
    $link = conectarServidor();
    /*validacion del valor a pagar"*/
    if ($ba == 1) {
        $qryIns = "insert into cotizaciones (idCliente, fechaCotizacion, precioCotizacion, presentaciones, distribucion, productos)
	  values  ($cliente, '$FchCot', $precio, $Presentaciones, '$opciones_dist', '$opciones_prod')";
        if ($resultIns = mysqli_query($link, $qryIns)) {
            $qrys = "select max(idCotizacion) as num_cotiza from cotizaciones";
            $results = mysqli_query($link, $qrys);
            $rows = mysqli_fetch_array($results);
            $num_cotiza = $rows['num_cotiza'];
            $No_dist = 0;
            mysqli_close($link);
            echo '<form method="post" action="det_cotiza.php" name="form5" target="_blank">';
            echo '<input name="Crear" type="hidden" value="5">';
            echo '<input name="Destino" type="hidden" value="' . $Destino . '">';
            echo '<input name="num_cotiza" type="hidden" value="' . $num_cotiza . '">';
            echo '<input type="submit" name="Submit" value="Analizar" >';
            echo '</form>';
            echo '<script >
			  document.form5.submit();
			  </script>';
        } else {
            mysqli_close($link);
            mover_pag("cotizacion.php", "Error al ingresar la Cotización");
        }
    }
}

/*
$clienteCotizacionOperador = new ClientesCotizacionOperaciones();
if ($cliExis == 1) {
    $clienteOperador = new ClientesOperaciones();
    $cliente = $clienteOperador->getCliente($idCliente);
    $datos = array($cliente['nomCliente'], $cliente['contactoCliente'], $cliente['cargoCliente'], $cliente['telCliente'], $cliente['celCliente'], $cliente['dirCliente'], $cliente['emailCliente'], $cliente['idCatCliente'], $cliente['ciudadCliente'], $cliente['codVendedor']);
} else {
    $datos = array($nomCliente, $contactoCliente, $cargoContacto, $telCliente, $celCliente, $dirCliente, $emailCliente, $idCatCliente, $idCiudad, $codVendedor);
}
try {
    $lastIdCliente = $clienteCotizacionOperador->makeCliente($datos);
    $ruta = "listarClientCot.php";
    $mensaje = "Cliente creado con éxito";
} catch (Exception $e) {
    $ruta = "makeClienCotForm.php";
    $mensaje = "Error al crear el Cliente";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}*/

