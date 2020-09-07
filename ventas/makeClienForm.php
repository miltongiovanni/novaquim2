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
    <title>Creación de Clientes</title>
    <meta charset="utf-8">
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
    </script>
</head>
<body>
<div id="contenedor">
    <div id="saludo"><strong>CREACIÓN DE CLIENTES</strong></div>
    <form name="form2" method="POST" action="makeClien.php">
        <div class="form-group row">

            <label class="col-form-label col-2"><strong>Tipo</strong></label>
            <div class="col-2 form-check-inline form-control" style="display: flex">
                <label for="tipo_0" class="col-6 form-check-label" style="text-align: center">
                    <input type="radio" id="tipo_0" name="tipo" value="1" checked onchange="nitClientes()">&nbsp;&nbsp;Nit
                </label>
                <label for="tipo_1" class="col-6 form-check-label" style="text-align: center">
                    <input type="radio" id="tipo_1" name="tipo" value="2" onchange="nitClientes()">&nbsp;&nbsp;Cédula
                </label>
            </div>

            <label class="col-form-label col-2 text-right"
                   for="codProducto"><strong>Número</strong></label>
            <input type="text" class="form-control col-2" name="numero" id="numero" onKeyPress="return aceptaNum(event)"
                   onkeyup="nitClientes()" required>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-right" for="nitCliente"><strong>NIT</strong></label>
            <input type="text" class="form-control col-2" name="nitCliente" id="nitCliente"
                   onKeyPress="return aceptaNum(event)" readOnly required>
            <label class="col-form-label col-2 text-right" for="nomCliente"><strong>Cliente</strong></label>
            <input type="text" class="form-control col-2" name="nomCliente" id="nomCliente" required>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-right" for="dirCliente"><strong>Dirección</strong></label>
            <input type="text" class="form-control col-2" name="dirCliente" id="dirCliente" required>
            <label class="col-form-label col-2" for="idCatCliente"><strong>Ciudad</strong></label>
            <?php
            $manager = new CiudadesOperaciones();
            $ciudades = $manager->getCiudades();
            $filas = count($ciudades);
            echo '<select name="idCatCliente" id="idCatCliente" class="form-control col-2"  required>';
            for ($i = 0; $i < $filas; $i++) {
                echo '<option value="' . $ciudades[$i]["idCiudad"] . '">' . $ciudades[$i]['ciudad'] . '</option>';
            }
            echo '</select>';
            ?>
        </div>
        <div class="form-group row">

            <label class="col-form-label col-2 text-right" for="contactoCliente"><strong>Nombre Contacto</strong></label>
            <input type="text" class="form-control col-2" name="contactoCliente" id="contactoCliente" required>
            <label class="col-form-label col-2 text-right" for="telCliente"><strong>Teléfono</strong></label>
            <input type="text" class="form-control col-2" name="telCliente" id="telProv"
                   onKeyPress="return aceptaNum(event)">

        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-right" for="cargoCliente"><strong>Cargo Contacto</strong></label>
            <input type="text" class="form-control col-2" name="cargoCliente" id="cargoCliente" required>
            <label class="col-form-label col-2 text-right" for="emailCliente"><strong>Correo electrónico</strong></label>
            <input type="email" class="form-control col-2" name="emailCliente" id="emailProv">
                    </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-right" for="celCliente"><strong>Celular Contacto</strong></label>
            <input type="text" class="form-control col-2" name="celCliente" id="celCliente"  onKeyPress="return aceptaNum(event)">

            <label class="col-form-label col-2" for="idCatCliente"><strong>Actividad</strong></label>
            <?php
            $manager = new CategoriasCliOperaciones();
            $categorias = $manager->getCatsCli();
            $filas = count($categorias);
            echo '<select name="idCatCliente" id="idCatCliente" class="form-control col-2" required>';
            echo '<option disabled selected value="">-----------------------------</option>';
            for ($i = 0; $i < $filas; $i++) {
                echo '<option value="' . $categorias[$i]["idCatClien"] . '">' . $categorias[$i]['desCatClien'] . '</option>';
            }
            echo '</select>';
            ?>

        </div>
        <div class="form-group row">
            <label class="col-form-label col-2" for="retIva"><strong>Autorretenedor Iva</strong></label>
            <select name="retIva" id="retIva" class="form-control col-2">
                <option value="0" selected>No</option>
                <option value="1">Si</option>
            </select>
            <label class="col-form-label col-2" for="retFte"><strong>Aplica Retefuente</strong></label>
            <select name="retFte" id="retFte" class="form-control col-2">
                <option value="0">No</option>
                <option value="1" selected>Si</option>
            </select>

        </div>
        <div class="form-group row">
            <label class="col-form-label col-2" for="idTasaIcaProv"><strong>Autorretenedor Ica</strong></label>
            <select name="retIva" id="retIva" class="form-control col-2">
                <option value="0" selected>No</option>
                <option value="1">Si</option>
            </select>
            <label class="col-form-label col-2" for="codResponsable"><strong>Vendedor</strong></label>
            <?php
            $PersonalOperador = new PersonalOperaciones();
            $personal = $PersonalOperador->getPersonal(true);
            echo '<select name="codResponsable" id="codResponsable" class="form-control col-2" required >';
            echo '<option selected disabled value="">-----------------------------</option>';
            for ($i = 0; $i < count($personal); $i++) {
                echo '<option value="' . $personal[$i]["idPersonal"] . '">' . $personal[$i]['nomPersonal'] . '</option>';
            }
            echo '</select>';
            ?>
        </div>
        <div class="form-group row">
            <div class="col-1 text-center">
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div>
            <div class="col-1 text-center">
                <button class="button" onclick="return Enviar(this.form)"><span>Continuar</span></button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-1">
            <button class="button1" id="back" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
    <!--<table border="0" align="center" >
        <tr>
            <td colspan="2"><div align="center">&nbsp;</div></td>
        </tr>
        <tr>
            <td width="67"><div align="right"><strong>Tipo:</strong></div></td>
           <td width="194" colspan="2">
            <input name="tipo" type="radio" id="tipo_0" value="1" checked> 
            Nit
            <input type="radio" name="tipo" value="2" id="tipo_1"> 
            Cédula                    		</td>
        </tr>
        <tr> 
            <td><div align="right"><b>No:</b></div></td>
          <td><input type="text" name="NIT" size=20  onKeyPress="return aceptaNum(event)" id="NIT" maxlength="10"></td>
        </tr>
        <tr>
        <td><div align="right"><b>Ciudad</b></div></td>
        <td> <?php
    /*				include "includes/conect.php";
                    $link=conectarServidor();
                    echo'<select name="ciudad_cli">';
                    $result=mysqli_query($link,"select Id_ciudad, ciudad from ciudades;");
                    echo '<option selected value="">------------------------------------</option>';
                    while($row=mysqli_fetch_array($result)){
                        echo '<option value='.$row['Id_ciudad'].'>'.$row['ciudad'].'</option>';
                    }
                    echo'</select>';
                    mysqli_free_result($result);
                    mysqli_close($link);
           */ ?>	  </td>
        </tr>
        <tr> 
            <td height="30">   </td>
            <td>
                    <input type="button" value=" Continuar " onClick="return Enviar(this.form);" >
                    <input type="reset" value="Restablecer"></td>
        </tr>
        <tr> 
            <td colspan="2">
            <div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="VOLVER"></div>                    </td>
        </tr>
    </table>
</form>-->
</div>
</body>
</html>

