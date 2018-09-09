<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
	<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<title>Creaci&oacute;n de usuarios</title>
	<meta charset="utf-8">
	<script type="text/javascript" src="scripts/validar.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>	
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>CREACI&Oacute;N DE USUARIOS</strong></div> 
  <form name="form2" method="POST" action="makeUser.php">
      <table width="273" border="0" align="center">
          <tr> 
              <td width="78"><div align="right"><label for="nombre"><b>Nombre</b></label></div></td>
              <td  colspan="2"><input type="text" name="nombre" id="nombre" size=30 onKeyPress="return aceptaLetra(event)" maxlength="30"></td>
          </tr>
          <tr> 
              <td><div align="right"><label for="apellido"><strong>Apellidos</strong></label></div></td>
              <td colspan="2" ><input type="text" name="apellido" id="apellido" size=30 onKeyPress="return aceptaLetra(event)" maxlength="30"></td>
          </tr>
          <tr> 
              <td><div align="right"><label for="usuario"><b>Usuario</b></label></div></td>
              <td colspan="2" ><input type="text" id="usuario"  maxlength="10" name="usuario" size=30 ></td>
          </tr>
          <tr> 
              <td><div align="right"><label for="idPerfil"><strong>Perfil</strong></label></div></td>
              <td colspan="2" >
              <select name="idPerfil" id="idPerfil">
                <?php
                    include "includes/conect.php";
                    $mysqli=conectarServidor();
                    $qry="select * from tblperfiles";	
                    $result = $mysqli->query($qry);
                    echo '<option value="6" selected>USUARIO</option>';
                    while($row = $result->fetch_assoc())
                    {
                        if ($row['IdPerfil']!=6)
                            echo '<option value="'.$row['IdPerfil'].'">'.$row['Descripcion'].'</option>';
                    }
                    $result->free();
  			  /* cerrar la conexión  */
          $mysqli->close();
                ?>
              </select> 
          </tr>
          <tr> 
              <td>   </td>
              <td width="90"><button class="button" style="vertical-align:middle" onclick="return Enviar(this.form)"><span>Continuar</span></button></td>
              <td width="90"><button class="button" style="vertical-align:middle" type="reset"><span>Borrar</span></button></td>
          </tr>
          <tr>
              <td colspan="3"><div align="center">&nbsp;</div></td>
          </tr>
          <tr>
              <td colspan="3"><div align="center">&nbsp;</div></td>
          </tr>
          <tr> 
              <td colspan="3"><div align="center"><button class="button1" id="back" style="vertical-align:middle" onClick="history.back()"> <span>VOLVER</span></button></div>
              </td>
          </tr>
      </table>
  </form>
</div>
</body>
</html>

