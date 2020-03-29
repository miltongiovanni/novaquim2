<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
  require '../clases/'.$classname.'.php';
}

spl_autoload_register('cargarClases');
?>
<!DOCTYPE html>
<html>

<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Creación de Usuarios</title>
    <meta charset="utf-8">
    <script src="../js/validar.js"></script>
</head>

<body>
    <div id="contenedor">
        <div id="saludo"><strong>CREACIÓN DE USUARIOS</strong></div>
        <form name="makeUserForm" id="makeUserForm" method="POST" action="makeUser.php">
            <div class="form-group row">
                <label class="col-form-label col-1" style="text-align: right;" for="nombre"><strong>Nombre</strong></label>
                <input type="text" class="form-control col-2" name="nombre" id="nombre" size=30 onKeyPress="return aceptaLetra(event)"
                    maxlength="30">
            </div>
            <div class="form-group row">
                <label class="col-form-label col-1" style="text-align: right;" for="apellido"><strong>Apellidos</strong></label>
                <input type="text" class="form-control col-2" name="apellido" id="apellido" size=30 onKeyPress="return aceptaLetra(event)"
                    maxlength="30">
            </div>
            <div class="form-group row">
                <label class="col-form-label col-1" for="usuario"><b>Usuario</b></label>
                <input type="text" class="form-control col-2" id="usuario" maxlength="10" name="usuario" size=30>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-1" for="idPerfil"><strong>Perfil</strong></label>
                <select class="form-control col-2" name="idPerfil" id="idPerfil">
                    <?php
                    $perfilOperador = new PerfilesOperaciones();
                    $perfiles = $perfilOperador->getPerfiles();
                    echo '<option value="6" selected>USUARIO</option>';
                    for ($i = 0; $i < count($perfiles); $i++) {
                        if ($perfiles[$i]['idPerfil']!=6)
                            echo '<option value="'.$perfiles[$i]['idPerfil'].'">'.$perfiles[$i]['descripcion'].'</option>';
                    }
                ?>
                </select>
            </div>
            <div class="form-group row">
                <div class="col-1" style="text-align: center;">
                    <button class="button"  onclick="return Enviar(this.form)"><span>Continuar</span></button>
                </div>
                <div class="col-1" style="text-align: center;">
                    <button class="button"  type="reset"><span>Reiniciar</span></button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-1"><button class="button1" id="back"  onClick="history.back()">
                    <span>VOLVER</span></button></div>
        </div>
    </div>
</body>

</html>