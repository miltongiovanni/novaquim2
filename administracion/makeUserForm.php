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
    <title>Creación de Usuarios</title>
    <meta charset="utf-8">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>

<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>CREACIÓN DE USUARIOS</h4></div>
    <form name="makeUserForm" id="makeUserForm" method="POST" action="makeUser.php">
        <div class="form-group row">
            <label class="col-form-label col-1 text-end" for="nombre"><strong>Nombre: </strong></label>
            <input type="text" class="form-control col-2" name="nombre" id="nombre" size=30
                   onkeydown="return aceptaLetra(event)"
                   maxlength="30" required>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1 text-end" for="apellido"><strong>Apellidos: </strong></label>
            <input type="text" class="form-control col-2" name="apellido" id="apellido" size=30
                   onkeydown="return aceptaLetra(event)"
                   maxlength="30" required>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1 text-end" for="usuario"><b>Usuario: </b></label>
            <input type="text" class="form-control col-2" id="usuario" maxlength="10" name="usuario" size=30 required>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1 text-end" for="idPerfil"><strong>Perfil: </strong></label>
            <select class="form-select col-2" name="idPerfil" id="idPerfil" required>
                <?php
                $perfilOperador = new PerfilesOperaciones();
                $perfiles = $perfilOperador->getPerfiles();
                echo '<option value="6" selected>USUARIO</option>';
                for ($i = 0; $i < count($perfiles); $i++) {
                    if ($perfiles[$i]['idPerfil'] != 6)
                        echo '<option value="' . $perfiles[$i]['idPerfil'] . '">' . $perfiles[$i]['perfil'] . '</option>';
                }
                ?>
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
            <button class="button1" id="back" onClick="history.back()">
                <span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>

</html>