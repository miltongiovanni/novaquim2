<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html>

<head>
  <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
  <meta charset="utf-8">
  <title>Actualizar datos del Usuario</title>
  <script type="text/javascript" src="../js/validar.js"></script>
</head>

<body>
  <div id="contenedor">

    <div id="saludo1">
      <h4>ACTUALIZACIÓN DE USUARIOS</h4>
    </div>

    <?php  
    function cargarClases($classname)
    {
      require '../clases/'.$classname.'.php';
    }

    spl_autoload_register('cargarClases');
    $idUsuario=$_POST['idUsuario'];
    $manager = new UsersManager();
    $row=$manager->getUser($idUsuario);
        
    ?>

    <form id="form1" name="form1" method="post" action="updateUser.php">
      <div class="form-group row">
        <label class="col-form-label col-1" style="text-align: right;" for="idUsuario">Id</label>
        <input type="text" class="form-control col-2" name="idUsuario" id="idUsuario" value="<?=$row['idUsuario']?>" readOnly>
      </div>
      <div class="form-group row">
        <label class="col-form-label col-1" style="text-align: right;" for="nombre">Nombre</label>
        <input type="text" class="form-control col-2" name="nombre" id="nombre" size=30 value="<?=$row['nombre']?>" onKeyPress="return aceptaLetra(event)" maxlength="30">
      </div>
      <div class="form-group row">
        <label class="col-form-label col-1" style="text-align: right;" for="apellido"><strong>Apellidos</strong></label>
        <input type="text" class="form-control col-2" name="apellido" id="apellido" size=30 value="<?=$row['apellido']?>" onKeyPress="return aceptaLetra(event)" maxlength="30">
      </div>
      <div class="form-group row">
        <label class="col-form-label col-1" for="usuario"><b>Usuario</b></label>
        <input type="text" class="form-control col-2" id="usuario" maxlength="10" name="usuario" value="<?=$row['usuario']?>" size=30>
      </div>
      <div class="form-group row">
        <label class="col-form-label col-1" for="idPerfil"><strong>Perfil</strong></label>
        <select class="form-control col-2" name="idPerfil" id="idPerfil">
          <?php
                    //include "../includes/conect.php";
                    $con=Conectar::conexion();
                    $qry="select * from tblperfiles";
                    $result = $con->query($qry);	
                    echo '<option value="6" selected>USUARIO</option>';
                    while($row = $result->fetch(PDO::FETCH_ASSOC))
                    {
                        if ($row['IdPerfil']!=6)
                            echo '<option value="'.$row['IdPerfil'].'">'.$row['Descripcion'].'</option>';
                    }
                    $con=null;
                    $result=null;
                ?>
        </select>
      </div>
      <div class="form-group row">
        <div class="col-1" style="text-align: center;">
          <button class="button" style="vertical-align:middle" onclick="return Enviar(this.form)"><span>Continuar</span></button>
        </div>
        <div class="col-1" style="text-align: center;">
          <button class="button" style="vertical-align:middle" type="reset"><span>Borrar</span></button>
        </div>
      </div>
      <div class="row">
        <div class="col-1"><button class="button1" id="back" style="vertical-align:middle" onClick="history.back()">
            <span>VOLVER</span></button></div>
      </div>
      <div class="form-group row">
        <label class="col-form-label col-1" style="text-align: right;" for="nombre">Nombre</label>
        <label class="col-form-label col-1" style="text-align: right;" for="apellido">Apellido</label>
      </div>
      <div class="form-group row">
        <input type="text" class="form-control col-2" name="nombre" id="nombre" size=30 onKeyPress="return aceptaLetra(event)"
          maxlength="30">
        <input type="text" class="form-control col-2" name="nombre" id="nombre" size=30 onKeyPress="return aceptaLetra(event)"
          maxlength="30">
      </div>



      <table width="41%" border="0" align="center">
        <tr>
          <td width="30%"><strong>
              <label>Nombre </label>
            </strong></td>
          <td width="30%"><strong>Apellido</strong></td>
          <td width="20%"><strong>
            </strong></td>
        </tr>
        <tr>
          <td>
            <?php echo'<input name="Nombre" type="text" value="'.$row['nombre'].'"/>';?>
          </td>
          <td>
            <?php echo'<input name="Apellido" type="text" value="'.$row['apellido'].'"/>';?>
          </td>
          <td></td>
        </tr>
        <tr>
          <td><strong>Usuario</strong></td>
          <td><strong>Fecha Creación</strong></td>
          <td><strong>Fecha De Cambio</strong></td>
        </tr>
        <tr>
          <td>
            <?php echo'<input name="Usuario" type="text" value="'.$row['usuario'].'"/>';?>
          </td>
          <td>
            <?php echo'<input name="FecCrea" type="text" readonly value="'.$row['fecCrea'].'"/>';?>
          </td>
          <td>
            <script>
              fecha();
            </script>
          </td>
        </tr>
        <tr>
          <td><strong>Estado</strong></td>
          <td><strong>Perfil</strong></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>
            <?php
            $con=Conectar::conexion();
            $qryu="select * from tblusuarios, tblestados where tblusuarios.idUsuario=$idUsuario and tblusuarios.estadoUsuario=tblestados.idEstado";
            $resultu = $con->query($qryu);
            $rowu = $resultu->fetch(PDO::FETCH_ASSOC);
            echo'<select name="idEstado">';
            $resulte=$con->query("select * from tblestados");
            echo '<option selected value='.$rowu['idEstado'].'>'.$rowu['descripcion'].'</option>';
                while ($rowe=$resulte->fetch(PDO::FETCH_ASSOC))
            {
            if ($rowe['descripcion']!= $rowu['descripcion'])
                  echo '<option value='.$rowe['idEstado'].'>'.$rowe['descripcion'].'</option>';
                }
                echo'</select>';
            $resultu=null;
            $resulte=null;
            ?>
          </td>
          <td>
            <?php
            $qrya="select *from tblusuarios, tblperfiles where tblusuarios.idUsuario=$idUsuario and tblusuarios.idPerfil=tblperfiles.idPerfil";
            $resulta=$con->query($qrya);
            $rowa=$resulta->fetch(PDO::FETCH_ASSOC);			
            echo'<select name="idEstado2">';
            $resultp=$con->query("select * from tblperfiles");
            echo '<option selected value='.$rowa['idPerfil'].'>'.$rowa['descripcion'].'</option>';
                while($rowp=$resultp->fetch(PDO::FETCH_ASSOC))
            {
              if ($rowp['descripcion']!= $rowa['descripcion'])
                  echo '<option value='.$rowp['idPerfil'].'>'.$rowp['descripcion'].'</option>';
                }
                echo'</select>';	
            $resulta=null;
            $resultp=null;
            /* cerrar la conexi�n */
            $con=null;	
            ?>
          </td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>
            <div align="center">
              <button class="button" style="vertical-align:middle" onclick="return Enviar2(this.form)"><span>Actualizar</span></button>
            </div>
          </td>
        </tr>
      </table>
    </form>
  </div>
</body>

</html>