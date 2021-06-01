<?php
include "../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$idCotizacion = $_SESSION['idCotizacion'];
$cotizacionOperador = new CotizacionesOperaciones();
$cotizacion = $cotizacionOperador->getCotizacion($idCotizacion);
$seleccionProd = explode(",", $cotizacion['productos']);
$seleccionDis = explode(",", $cotizacion['distribucion']);
$cotizacion['productos'] = str_replace("1", " Limpieza Equipos", $cotizacion['productos']);
$cotizacion['productos'] = str_replace("2", " Limpieza General", $cotizacion['productos']);
$cotizacion['productos'] = str_replace("3", " Mantenimiento de pisos", $cotizacion['productos']);
$cotizacion['productos'] = str_replace("4", " Productos para Lavandería", $cotizacion['productos']);
$cotizacion['productos'] = str_replace("5", " Aseo Doméstico y Oficina", $cotizacion['productos']);
$cotizacion['productos'] = str_replace("6", " Higiene Cocina", $cotizacion['productos']);
$cotizacion['productos'] = str_replace("7", " Línea Automotriz", $cotizacion['productos']);
$cotizacion['distribucion'] = str_replace("1", " Implementos de Aseo", $cotizacion['distribucion']);
$cotizacion['distribucion'] = str_replace("2", " Desechables", $cotizacion['distribucion']);
$cotizacion['distribucion'] = str_replace("3", " Cafetería", $cotizacion['distribucion']);
$cotizacion['distribucion'] = str_replace("4", " Abarrotes", $cotizacion['distribucion']);
$cotizacion['distribucion'] = str_replace("5", " Distribución Aseo", $cotizacion['distribucion']);
$cotizacion['distribucion'] = str_replace("6", " Aseo Personal", $cotizacion['distribucion']);
$cotizacion['distribucion'] = str_replace("7", " Hogar", $cotizacion['distribucion']);
$cotizacion['distribucion'] = str_replace("8", " Papelería", $cotizacion['distribucion']);
$cotizacion['distribucion'] = str_replace("9", " Otros", $cotizacion['distribucion']);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Detalle de la Cotización</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1"><h4>DETALLE DE LA COTIZACIÓN</h4></div>
    <?php
    if ($cotizacion['destino'] == 1)
        $dest = "Impresión";
    if ($cotizacion['destino'] == 2)
        $dest = "Correo Electrónico";
    if ($cotizacion['presentaciones'] == 1)
        $presen = "Todas";
    if ($cotizacion['presentaciones'] == 2)
        $presen = "Pequeñas";
    if ($cotizacion['presentaciones'] == 3)
        $presen = "Grandes";
    if ($cotizacion['precioCotizacion'] == 1)
        $precio_c = "Fábrica";
    if ($cotizacion['precioCotizacion'] == 2)
        $precio_c = "Distribuidor";
    if ($cotizacion['precioCotizacion'] == 3)
        $precio_c = "Detal";
    if ($cotizacion['precioCotizacion'] == 4)
        $precio_c = "Mayorista";
    if ($cotizacion['precioCotizacion'] == 5)
        $precio_c = "Superetes";
    $opciones_prod = $cotizacion['productos'];

    if ($cotizacion['distribucion']) {
        $opciones_dist = $cotizacion['distribucion'];
    } else {
        $opciones_dist = 'No eligió Productos de Distribución';
    }
    ?>
    <div class="form-group row">
        <label class="col-form-label col-2 text-end"><strong>No. Cotización:</strong></label>
        <div class="form-control col-8"><?php echo $idCotizacion; ?></div>
    </div>
    <div class="form-group row">
        <label class="col-form-label col-2 text-end"><strong>Cliente:</strong></label>
        <div class="form-control col-8"><?php echo $cotizacion['nomCliente']; ?></div>
    </div>
    <div class="form-group row">
        <label class="col-form-label col-2 text-end"><strong>Fecha de Cotización:</strong></label>
        <div class="form-control col-8"><?php echo $cotizacion['fechaCotizacion']; ?></div>
    </div>
    <div class="form-group row">
        <label class="col-form-label col-2 text-end"><strong>Destino:</strong></label>
        <div class="form-control col-8"><?php echo $dest; ?></div>
    </div>
    <div class="form-group row">
        <label class="col-form-label col-2 text-end"><strong>Presentación:</strong></label>
        <div class="form-control col-8"><?php echo $presen; ?></div>
    </div>
    <div class="form-group row">
        <label class="col-form-label col-2 text-end"><strong>Precio:</strong></label>
        <div class="form-control col-8"><?php echo $precio_c; ?></div>
    </div>
    <div class="form-group row">
        <label class="col-form-label col-2 text-end"><strong>Productos Novaquim:</strong></label>
        <div class="form-control col-8"><?php echo $opciones_prod; ?></div>
    </div>
    <div class="form-group row">
        <label class="col-form-label col-2 text-end"><strong>Productos de Distribución:</strong></label>
        <div class="form-control col-8"><?php echo $opciones_dist; ?></div>
    </div>
    <div class="form-group row">
        <div class="col-2">
            <form id="form1" name="form1" method="post" action="UpdateCotform.php">
                <input name="idCotizacion" type="hidden" value="<?php echo $idCotizacion; ?>">
                <button class="button" type="button" onClick="return Enviar(this.form);">
                    <span>Modificar cotización</span>
                </button>
            </form>
        </div>
        <div class="col-2">
            <form method="post" action="Imp_Cotizacion.php" name="form3" target="_blank">
                <input name="idCotizacion" type="hidden" value="<?php echo $idCotizacion; ?>">
                <button class="button" type="submit"><span>Imprimir cotización</span></button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-1">
            <button class="button" type="button" onclick="window.location='../menu.php'">
                <span>Ir a Menú</span>
            </button>
        </div>
    </div>

</div>
</body>
</html>
	   