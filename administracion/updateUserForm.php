<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idUsuario = $_POST['idUsuario'];
$manager = new UsuariosOperaciones();
$row = $manager->getUser($idUsuario);
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
  <meta charset="utf-8">
  <title>Actualizar datos del Usuario</title>
  <script  src="../js/validar.js"></script>
</head>

<body>
  <div id="contenedor">

    <div id="saludo1"><strong>ACTUALIZACIÓN DE USUARIOS</strong></div>

    <form id="form1" name="form1" method="post" action="updateUser.php">
      <input type="hidden" class="form-control col-2" name="idUsuario" id="idUsuario" value="<?=$row['idUsuario']?>">
      <div class="form-group row">
        <label class="col-form-label col-1 text-right"  for="nombre"><strong>Nombre</strong></label>
        <input type="text" class="form-control col-2" name="nombre" id="nombre" size=30 value="<?=$row['nombre']?>"
          onKeyPress="return aceptaLetra(event)" maxlength="30">
      </div>
      <div class="form-group row">
        <label class="col-form-label col-1 text-right"  for="apellido"><strong>Apellidos</strong></label>
        <input type="text" class="form-control col-2" name="apellido" id="apellido" size=30
          value="<?=$row['apellido']?>" onKeyPress="return aceptaLetra(event)" maxlength="30">
      </div>
      <div class="form-group row">
        <label class="col-form-label col-1" for="usuario"><b>Usuario</b></label>
        <input type="text" class="form-control col-2" id="usuario" maxlength="10" name="usuario"
          value="<?=$row['usuario']?>" size=30>
      </div>
      <div class="form-group row">
        <label class="col-form-label col-1" for="idPerfil"><strong>Perfil</strong></label>
        <select class="form-control col-2" name="idPerfil" id="idPerfil">
          <?php
          //include "../includes/conect.php";
          $managerPerfiles = new PerfilesOperaciones();
          $perfiles = $managerPerfiles->getPerfiles();
          echo '<option value="' . $row['idPerfil'] . '" selected>' . $row['perfil'] . '</option>';
          for ($i = 0; $i < count($perfiles); $i++) {

              if ($row['idPerfil'] != $perfiles[$i]['idPerfil']) {
                  echo '<option value="' .$perfiles[$i]['idPerfil'] . '">' . $perfiles[$i]['perfil'] . '</option>';
              }

          }
          $con = null;
          $result = null;
          ?>
        </select>
      </div>
      <div class="form-group row">
        <label class="col-form-label col-1" for="estadoUsuario"><strong>Estado</strong></label>
        <select class="form-control col-2" name="estadoUsuario" id="estadoUsuario">
          <?php
          //include "../includes/conect.php";
          $managerEstados = new EstadosUsuariosOperaciones();
          $estados = $managerEstados->getEstados();
          echo '<option value="' . $row['estadoUsuario'] . '" selected>' . $row['estado'] . '</option>';
          for ($i = 0; $i < count($estados); $i++) {

              if ($row['idEstado'] != $estados[$i]['idEstado']) {
                  echo '<option value="' .$estados[$i]['idEstado'] . '">' . $estados[$i]['estado'] . '</option>';
              }

          }

          $con = null;
          $result = null;
          ?>
        </select>
      </div>
      <div class="form-group row">
        <div class="col-1 text-center" >
          <button class="button" 
            onclick="return Enviar2(this.form)"><span>Actualizar</span></button>
        </div>
        <div class="col-1 text-center" >
          <button class="button"   type="reset"><span>Reiniciar</span></button>
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