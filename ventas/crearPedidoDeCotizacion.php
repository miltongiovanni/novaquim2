<?php
include "../../../includes/valAcc.php";
$idCotPersonalizada = $_POST['idCotPersonalizada'];
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
    <title>Crear pedido a partir de cotización personalizada</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script>

        //var idCatProd = $('idCatProd').value;

        function nitClientes() {
            let tipo = document.getElementById("tipo_0").checked === true ? 1 : 2;
            let numero = document.getElementById("numero").value;
            $.ajax({
                url: '../includes/controladorVentas.php',
                type: 'POST',
                data: {
                    "action": 'nitCliente',
                    "tipo": tipo,
                    "numero": numero,
                },
                dataType: 'text',
                success: function (nitValid) {
                    $("#nitCliente").val(nitValid);
                },
                error: function () {
                    alert("Vous avez un GROS problème");
                }
            });
        }

        function agregarCliente() {
            let form = document.getElementById('creaction_cliente_form');
            let form_valido = Validar(form);
            if (form_valido) {
                const formData = new FormData(form);
                formData.append('action', 'crearCliente');
                $.ajax({
                    url: '../includes/controladorVentas.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.success === true) {
                            document.getElementById('idCliente').value = response.lastIdCliente;
                            document.getElementById('idSucursal').value = response.lastIdSucursal;
                            $("#creacion_cliente").hide();
                            $("#creacion_pedido").show();
                        }else{
                            alerta(response.mensaje, response.icon, '', '');
                            document.getElementById('numero').value = '';
                            document.getElementById('nitCliente').value = '';
                        }
                    },
                    error: function () {
                        alert("Vous avez un GROS problème");
                    }
                });
            }
        }
    </script>
</head>
<body>
<?php

$operadorClienteCotizacion = new ClientesCotizacionOperaciones();
$operadorCotizacionPersonalizada = new CotizacionesPersonalizadasOperaciones();
$cotizacion = $operadorCotizacionPersonalizada->getCotizacionP($idCotPersonalizada);
if (!$cotizacion) {
    $ruta = "pedidoDeCotizacion.php";
    $mensaje = "No existe una cotización personalizada con ese número.  Intente de nuevo.";
    $icon = "warning";
    mover_pag($ruta, $mensaje, $icon);
    exit;
}
if($cotizacion['idPedido'] != 0){
    $ruta = "pedidoDeCotizacion.php";
    $mensaje = "Ya existe un pedido basado en ésta cotización";
    $icon = "error";
    mover_pag($ruta, $mensaje, $icon);
    exit;
}
$cliente_cotizacion_personalizada = $operadorClienteCotizacion->getClienteFromCotizacionPersonalizada($idCotPersonalizada);

$operadorCliente = new ClientesOperaciones();
$cliente = $operadorCliente->getClienteByName($cliente_cotizacion_personalizada['nomCliente']);
if ($cliente) {
    $cliente_id = $cliente['idCliente'];
    $sucursal_id = 1;
}
?>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25">
        <h4>CREACIÓN DE PEDIDO A PARTIR DE COTIZACIÓN PERSONALIZADA</h4>
    </div>
    <?php
    if (!$cliente):
        ?>
        <div id="creacion_cliente">
            <form id="creaction_cliente_form" method="POST">
                <div class=" row ">
                    <h5 class="text-center text-bold mb-4">Agregar cliente que no existe</h5>
                    <label class="form-label col-2 text-start mx-2"><strong>Tipo</strong></label>
                    <label class="form-label col-2 text-start mx-2"
                           for="numero"><strong>Número</strong></label>
                    <label class="form-label col-2 text-start mx-2" for="nitCliente"><strong>NIT</strong></label>
                    <label class="form-label col-3 text-start mx-2" for="nomCliente"><strong>Cliente</strong></label>
                </div>
                <div class="mb-3 row">
                    <div class="col-2 form-check-inline form-control mx-2" style="display: flex">
                        <label for="tipo_0" class="col-6 form-check-label" style="text-align: center">
                            <input type="radio" id="tipo_0" name="tipo" value="1" checked onchange="nitClientes()">&nbsp;&nbsp;Nit
                        </label>
                        <label for="tipo_1" class="col-6 form-check-label" style="text-align: center">
                            <input type="radio" id="tipo_1" name="tipo" value="2" onchange="nitClientes()">&nbsp;&nbsp;Cédula
                        </label>
                    </div>
                    <input type="text" class="form-control col-2 mx-2" name="numero" id="numero"
                           onkeydown="return aceptaNum(event)"
                           onkeyup="nitClientes()">
                    <input type="text" class="form-control col-2 mx-2" name="nitCliente" id="nitCliente"
                           value="" onkeydown="return aceptaNum(event)" readOnly required>
                    <input type="text" class="form-control col-3 mx-2" name="nomCliente" id="nomCliente"
                           value="<?= $cliente_cotizacion_personalizada['nomCliente'] ?>" required>
                </div>
                <div class="row">
                    <label class="form-label col-2 text-start mx-2" for="telCliente"><strong>Teléfono</strong></label>
                    <label class="form-label col-2 text-start mx-2" for="emailCliente"><strong>Correo electrónico</strong></label>
                    <label class="form-label col-2 text-start mx-2" for="ciudadCliente"><strong>Ciudad</strong></label>
                    <label class="form-label col-3 text-start mx-2" for="dirCliente"><strong>Dirección</strong></label>
                </div>
                <div class="mb-3 row">
                    <input type="text" class="form-control col-2 mx-2" name="telCliente" id="telCliente" maxlength="10"
                           onkeydown="return aceptaNum(event)" value="<?= $cliente_cotizacion_personalizada['telCliente'] ?>">
                    <input type="email" class="form-control col-2 mx-2" name="emailCliente" id="emailCliente"
                           value="<?= $cliente_cotizacion_personalizada['emailCliente'] ?>">
                    <select name="ciudadCliente" id="ciudadCliente" class="form-control col-2 mx-2" required>
                        <option selected value="<?= $cliente_cotizacion_personalizada['idCiudad'] ?>"><?= $cliente_cotizacion_personalizada['ciudad'] ?></option>
                        <?php
                        $manager = new CiudadesOperaciones();
                        $ciudades = $manager->getCiudades();
                        $filas = count($ciudades);
                        for ($i = 0; $i < $filas; $i++) {
                            if ($ciudades[$i]["idCiudad"] != $cliente_cotizacion_personalizada['idCiudad']) {
                                echo '<option value="' . $ciudades[$i]["idCiudad"] . '">' . $ciudades[$i]['ciudad'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <input type="text" class="form-control col-3 mx-2" name="dirCliente" id="dirCliente"
                           value="<?= $cliente_cotizacion_personalizada['dirCliente'] ?>" required>
                </div>
                <div class="row">
                    <label class="form-label col-2 text-start mx-2" for="contactoCliente"><strong>Nombre
                            Contacto</strong></label>
                    <label class="form-label col-2 text-start mx-2" for="cargoCliente"><strong>Cargo
                            Contacto</strong></label>
                    <label class="form-label col-2 text-start mx-2" for="celCliente"><strong>Celular
                            Contacto</strong></label>
                    <label class="form-label col-3 text-start mx-2" for="idCatCliente"><strong>Actividad</strong></label>
                </div>
                <div class="mb-3 row">
                    <input type="text" class="form-control col-2 mx-2" name="contactoCliente" id="contactoCliente"
                           value="<?= $cliente_cotizacion_personalizada['contactoCliente'] ?>" required>
                    <input type="text" class="form-control col-2 mx-2" name="cargoCliente" id="cargoCliente"
                           value="<?= $cliente_cotizacion_personalizada['cargoContacto'] ?>" required>
                    <input type="text" class="form-control col-2 mx-2" name="celCliente" id="celCliente"
                           onkeydown="return aceptaNum(event)" maxlength="10" value="<?= $cliente_cotizacion_personalizada['celCliente'] ?>" required>
                    <select name="idCatCliente" id="idCatCliente" class="form-control col-3 mx-2" required>
                        <option selected
                                value="<?= $cliente_cotizacion_personalizada['idCatCliente'] ?>"><?= $cliente_cotizacion_personalizada['desCatClien'] ?></option>
                        <?php
                        $manager = new CategoriasCliOperaciones();
                        $categorias = $manager->getCatsCli();
                        $filas = count($categorias);
                        for ($i = 0; $i < $filas; $i++) {
                            if ($categorias[$i]["idCatClien"] != $cliente_cotizacion_personalizada['idCatCliente']) {
                                echo '<option value="' . $categorias[$i]["idCatClien"] . '">' . $categorias[$i]['desCatClien'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="row">
                    <label class="form-label col-1 text-start mx-2" for="retIva"><strong>Autoret Iva</strong></label>
                    <label class="form-label col-1 text-start mx-2" for="retFte"><strong>Retefuente</strong></label>
                    <label class="form-label col-1 text-start mx-2" for="retIca"><strong>Autoret Ica</strong></label>
                    <label class="form-label col-1 text-start mx-2" for="exenIva"><strong>Exen Iva</strong></label>
                    <label class="form-label col-1 text-start mx-2" for="estadoCliente"><strong>Estado</strong></label>
                    <label class="form-label col-2 text-start mx-2" for="codVendedor"><strong>Vendedor</strong></label>

                </div>
                <div class="mb-3 row">

                    <select name="retIva" id="retIva" class="form-control col-1 mx-2">
                        <?php
                        if ($cliente['retIva'] == 1):
                            ?>
                            <option value="0">No</option>
                            <option value="1" selected>Si</option>
                        <?php
                        else:
                            ?>
                            <option value="0" selected>No</option>
                            <option value="1">Si</option>
                        <?php
                        endif;
                        ?>
                    </select>
                    <select name="retFte" id="retFte" class="form-control col-1 mx-2">
                        <?php
                        if ($cliente['retFte'] == 1):
                            ?>
                            <option value="0">No</option>
                            <option value="1" selected>Si</option>
                        <?php
                        else:
                            ?>
                            <option value="0" selected>No</option>
                            <option value="1">Si</option>
                        <?php
                        endif;
                        ?>
                    </select>
                    <select name="retIca" id="retIca" class="form-control col-1 mx-2">
                        <?php
                        if ($cliente['retIca'] == 1):
                            ?>
                            <option value="0">No</option>
                            <option value="1" selected>Si</option>
                        <?php
                        else:
                            ?>
                            <option value="0" selected>No</option>
                            <option value="1">Si</option>
                        <?php
                        endif;
                        ?>
                    </select>
                    <select name="exenIva" id="exenIva" class="form-control col-1 mx-2">
                        <?php
                        if ($cliente['exenIva'] == 1):
                            ?>
                            <option value="0">No</option>
                            <option value="1" selected>Si</option>
                        <?php
                        else:
                            ?>
                            <option value="0" selected>No</option>
                            <option value="1">Si</option>
                        <?php
                        endif;
                        ?>
                    </select>
                    <select name="estadoCliente" id="estadoCliente" class="form-control col-1 mx-2">
                        <?php
                        if ($cliente['estadoCliente'] == 1):
                            ?>
                            <option value="0">Inactivo</option>
                            <option value="1" selected>Activo</option>
                        <?php
                        else:
                            ?>
                            <option value="0" selected>Inactivo</option>
                            <option value="1">Activo</option>
                        <?php
                        endif;
                        ?>
                    </select>
                    <select name="codVendedor" id="codVendedor" class="form-control col-2 mx-2" required>
                        <option selected value="<?= $cliente_cotizacion_personalizada['codVendedor'] ?>"><?= $cliente_cotizacion_personalizada['nomPersonal'] ?></option>
                        <?php
                        $PersonalOperador = new PersonalOperaciones();
                        $personal = $PersonalOperador->getPersonal(true);
                        for ($i = 0; $i < count($personal); $i++) {
                            if ($personal[$i]["idPersonal"] != $cliente_cotizacion_personalizada['codVendedor']) {
                                echo '<option value="' . $personal[$i]["idPersonal"] . '">' . $personal[$i]['nomPersonal'] . '</option>';
                            }
                        }
                        echo '';
                        ?>
                    </select>
                </div>
                <div class="mb-3 row my-5">
                    <div class="col-2 text-center">
                        <button class="button" type="button" onclick="agregarCliente();"><span>Agregar cliente</span></button>
                    </div>
                </div>
            </form>
        </div>
    <?php
    endif;
    ?>
    <div id="creacion_pedido"
        <?php
        if (!$cliente):
            ?>
            style="display: none"
        <?php
        endif;
        ?>
    >
        <form method="post" action="makePedidoDeCotizacion.php" name="form1">
            <input type="hidden" name="idCliente" id="idCliente" value="<?=$cliente_id ?? ''?>">
            <input type="hidden" name="idSucursal" id="idSucursal" value="<?=$sucursal_id ?? ''?>">
            <input type="hidden" name="idCotPersonalizada" id="idCotPersonalizada" value="<?=$idCotPersonalizada?>">
            <div class="mb-3 row">
                <label class="form-label col-2 text-end" for="nom_cliente"><strong>Cliente: </strong></label>
                <input type="text" class="form-control col-5" name="nom_cliente" id="nom_cliente" value="<?= $cliente_cotizacion_personalizada['nomCliente'] ?? '' ?>" readonly>
            </div>
            <div class="mb-3 row">
                <label class="form-label col-2 text-end" for="nomSucursal"><strong>Sucursal: </strong></label>
                <input type="text" class="form-control col-5" name="nomSucursal" id="nomSucursal" value="<?= $cliente_cotizacion_personalizada['nomCliente'] ?? '' ?>" readonly>
            </div>
            <div class="mb-3 row">
                <label class="form-label col-2 text-end" for="fechaPedido"><strong>Fecha de Pedido: </strong></label>
                <input type="date" class="form-control col-5" name="fechaPedido" id="fechaPedido" required>
            </div>
            <div class="mb-3 row">
                <label class="form-label col-2 text-end" for="fechaEntrega"><strong>Fecha de entrega: </strong></label>
                <input type="date" class="form-control col-5" name="fechaEntrega" id="fechaEntrega" required>
            </div>
            <div class="mb-3 row">
                <label class="form-label col-2 text-end"><strong>Precio: </strong></label>
                <div class="form-label col-5 ">
                    <input name="tipoPrecio" type="radio" id="precio_0" value="1" <?= $cotizacion['tipoPrecio'] == 1 ? 'checked': '' ?>>
                    <label for="precio_0">Fábrica</label>
                    <input type="radio" name="tipoPrecio" value="2" id="precio_1" <?= $cotizacion['tipoPrecio'] == 2 ? 'checked': '' ?> >
                    <label for="precio_1">Distribuidor</label>
                    <input type="radio" name="tipoPrecio" value="3" id="precio_2" <?= $cotizacion['tipoPrecio'] == 3 ? 'checked': '' ?>>
                    <label for="precio_2">Detal</label>
                    <input type="radio" name="tipoPrecio" value="4" id="precio_3" <?= $cotizacion['tipoPrecio'] == 4 ? 'checked': '' ?>>
                    <label for="precio_3">Mayorista</label>
                    <input type="radio" name="tipoPrecio" value="5" id="precio_4" <?= $cotizacion['tipoPrecio'] == 5 ? 'checked': '' ?>>
                    <label for="precio_4">Superetes</label>
                </div>
            </div>
            <div class="row mb-3 my-4">
                <div class="col-1">
                    <button class="button" type="button" onclick="return Enviar(this.form)">
                        <span>Continuar</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="row">
        <div class="col-1">
            <button class="button1" id="back" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>
