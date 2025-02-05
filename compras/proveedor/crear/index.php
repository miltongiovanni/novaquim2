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
    <title>Creación de Proveedores</title>
    <meta charset="utf-8">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script>

        //var idCatProd = $('idCatProd').value;

        function nitProveedor(idCatProd) {
            let tipo = document.getElementById("tipo_0").checked === true ? 1 : 2;
            let numero = document.getElementById("numero").value;
            $.ajax({
                url: '../../../includes/controladorCompras.php',
                type: 'POST',
                data: {
                    "action": 'nitProveedor',
                    "tipo": tipo,
                    "numero": numero,
                },
                dataType: 'json',
                success: function (response) {
                    if(response.proveedorExiste){
                        alerta('Proveedor ya existe', 'warning', '../modificar/updateProvForm.php', '');
                    }else{
                        $("#nitProv").val(response.nit);
                    }
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
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>CREACIÓN DE PROVEDORES</h4></div>
    <form name="form2" method="POST" action="makeProv.php">
        <div class="mb-3 row">
            <div class="col-2">
                <label class="form-label "><strong>Tipo</strong></label>
                <div class=" form-check-inline form-control">
                    <label for="tipo_0" class="col-6 form-check-label" style="text-align: center">
                        <input type="radio" id="tipo_0" name="tipo" value="1" checked onchange="nitProveedor()">&nbsp;&nbsp;Nit
                    </label>
                    <label for="tipo_1" class="col-6 form-check-label" style="text-align: center">
                        <input type="radio" id="tipo_1" name="tipo" value="2" onchange="nitProveedor()">&nbsp;&nbsp;Cédula
                    </label>
                </div>
            </div>
            <div class="col-2">
                <label class="form-label " for="numero"><strong>Número</strong></label>
                <input type="text" class="form-control " name="numero" id="numero" onkeydown="return aceptaNum(event)"
                       onkeyup="nitProveedor()" required>
            </div>
            <div class="col-2">
                <label class="form-label " for="nitProv"><strong>NIT</strong></label>
                <input type="text" class="form-control " name="nitProv" id="nitProv"
                       onkeydown="return aceptaNum(event)" readOnly>
            </div>
            <div class="col-4">
                <label class="form-label " for="nomProv"><strong>Proveedor</strong></label>
                <input type="text" class="form-control " name="nomProv" id="nomProv" required>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-3">
                <label class="form-label " for="dirProv"><strong>Dirección</strong></label>
                <input type="text" class="form-control " name="dirProv" id="dirProv" required>
            </div>
            <div class="col-2">
                <label class="form-label " for="telProv"><strong>Teléfono</strong></label>
                <input type="text" class="form-control " name="telProv" id="telProv" maxlength="10"
                       onkeydown="return aceptaNum(event)" required>
            </div>
            <div class="col-2">
                <label class="form-label " for="contProv"><strong>Contacto</strong></label>
                <input type="text" class="form-control " name="contProv" id="contProv" required>
            </div>
            <div class="col-3">
                <label class="form-label " for="emailProv"><strong>Correo electrónico</strong></label>
                <input type="email" class="form-control " name="emailProv" id="emailProv" required>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-2">
                <label class="form-label " for="idCatProv"><strong>Tipo de Proveedor</strong></label>
                <?php
                $manager = new CategoriasProvOperaciones();
                $categorias = $manager->getCatsProv();
                $filas = count($categorias);
                echo '<select name="idCatProv" id="idCatProv" class="form-control "  required>';
                echo '<option disabled selected value="">Seleccione una opción</option>';
                for ($i = 0; $i < $filas; $i++) {
                    echo '<option value="' . $categorias[$i]["idCatProv"] . '">' . $categorias[$i]['desCatProv'] . '</option>';
                }
                echo '</select>';
                ?>
            </div>
            <div class="col-2">
                <label class="form-label " for="regProv"><strong>Régimen Proveedor</strong></label>
                <select name="regProv" id="regProv" class="form-control " required>
                    <option disabled selected value="">Seleccione una opción</option>
                    <option value="0">Simplificado</option>
                    <option value="1" selected>Común</option>
                    <option value="2" selected>Simple</option>
                </select>
            </div>

            <div class="col-1">
                <label class="form-label " for="autoretProv"><strong>Autorretenedor</strong></label>
                <select name="autoretProv" id="autoretProv" class="form-control " required>
                    <option value="0" selected>NO</option>
                    <option value="1">SI</option>
                </select>
            </div>
            <div class="col-2">
                <label class="form-label " for="idTasaIcaProv"><strong>Tasa Reteica</strong></label>
                <?php
                $manager = new TasaReteIcaOperaciones();
                $categorias = $manager->getTasasReteIca();
                $filas = count($categorias);
                echo '<select name="idTasaIcaProv" id="idTasaIcaProv" class="form-control " required >';
                echo '<option disabled selected value="">Seleccione una opción</option>';
                for ($i = 0; $i < $filas; $i++) {
                    echo '<option value="' . $categorias[$i]["idTasaRetIca"] . '">' . $categorias[$i]['reteica'] . '</option>';
                }
                echo '</select>';
                ?>
            </div>

            <div class="col-3">
                <label class="form-label " for="idRetefuente"><strong>Tasa Retefuente</strong></label>
                <?php
                $manager = new TasaRetefuenteOperaciones();
                $categorias = $manager->getTasasRetefuente();
                $filas = count($categorias);
                echo '<select name="idRetefuente" id="idRetefuente" class="form-control "  required>';
                echo '<option disabled selected value="">Seleccione una opción</option>';
                for ($i = 0; $i < $filas; $i++) {
                    echo '<option value="' . $categorias[$i]["idTasaRetefuente"] . '">' . $categorias[$i]['retefuente'] . '</option>';
                }
                echo '</select>';
                ?>
            </div>

        </div>
        <div class="mb-3 row">
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
    <div class="row">
        <div class="col-1">
            <button class="button1" id="back" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>

