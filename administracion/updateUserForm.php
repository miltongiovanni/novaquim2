<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idUsuario = $_POST['idUsuario'];
$manager = new UsuariosOperaciones();
$user = $manager->getUser($idUsuario);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Actualizar datos del Usuario</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>

<body>
<div id="contenedor" class="container-fluid">

    <div id="saludo1">
        <img src="../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>ACTUALIZACIÓN DE USUARIOS</h4></div>

    <form id="form1" name="form1" method="post" action="updateUser.php">
        <input type="hidden" class="form-control col-2" name="idUsuario" id="idUsuario" required
               value="<?= $user['idUsuario'] ?>">
        <div class="form-group row">
            <label class="col-form-label col-1 text-end" for="nombre"><strong>Nombre</strong></label>
            <input type="text" class="form-control col-2" name="nombre" id="nombre" size=30
                   value="<?= $user['nombre'] ?>" required
                   onkeydown="return aceptaLetra(event)" maxlength="30">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1 text-end" for="apellido"><strong>Apellidos</strong></label>
            <input type="text" class="form-control col-2" name="apellido" id="apellido" size=30 required
                   value="<?= $user['apellido'] ?>" onkeydown="return aceptaLetra(event)" maxlength="30">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1" for="usuario"><b>Usuario</b></label>
            <input type="text" class="form-control col-2" id="usuario" maxlength="10" name="usuario" required
                   value="<?= $user['usuario'] ?>" size=30>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1" for="idPerfil"><strong>Perfil</strong></label>
            <select class="form-select col-2" name="idPerfil" id="idPerfil" required>
                <?php
                //include "../includes/conect.php";
                $managerPerfiles = new PerfilesOperaciones();
                $perfiles = $managerPerfiles->getPerfiles();
                echo '<option value="' . $user['idPerfil'] . '" selected>' . $user['perfil'] . '</option>';
                for ($i = 0; $i < count($perfiles); $i++) {

                    if ($user['idPerfil'] != $perfiles[$i]['idPerfil']) {
                        echo '<option value="' . $perfiles[$i]['idPerfil'] . '">' . $perfiles[$i]['perfil'] . '</option>';
                    }

                }
                ?>
            </select>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1" for="estadoUsuario"><strong>Estado</strong></label>
            <select class="form-select col-2" name="estadoUsuario" id="estadoUsuario" required>
                <option value="<?= $user['estadoUsuario'] ?>" selected><?=$user['estado'] ?></option>
                <?php
                //include "../includes/conect.php";
                $managerEstados = new EstadosUsuariosOperaciones();
                $estados = $managerEstados->getEstados();
                for ($i = 0; $i < count($estados); $i++) {
                    if ($user['estadoUsuario'] != $estados[$i]['idEstado']) {
                        echo '<option value="' . $estados[$i]['idEstado'] . '">' . $estados[$i]['estado'] . '</option>';
                    }

                }
                ?>
            </select>
        </div>
        <div class="form-group row">
            <div class="col-1 text-center">
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div>
            <div class="col-1 text-center">
                <button class="button" type="button"
                        onclick="return Enviar(this.form)"><span>Actualizar</span></button>
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