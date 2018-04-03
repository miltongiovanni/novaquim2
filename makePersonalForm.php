<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
	<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<title>Creaci&oacute;n de Personal</title>
	<meta charset="utf-8">
	<script type="text/javascript" src="scripts/validar.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>	
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>CREACI&Oacute;N DE PERSONAL</strong></div> 
  <form name="form2" method="POST" action="makePerson.php">
      <table border="0" align="center" summary="">
          <tr> 
              <td width="56"><div align="right"><label for="nombre"><b>Nombre</b></label></div></td>
              <td  colspan="2"><input type="text" name="nombre" id="nombre" size=30 onKeyPress="return aceptaLetra(event)" maxlength="30"></td>
          </tr>
          <tr> 
              <td><div align="right"><label for="celular"><strong>Celular</strong></label></div></td>
              <td colspan="2" ><input type="text" name="celular" id="celular" size=30 onKeyPress="return aceptaNum(event)" maxlength="10"></td>
          </tr>
          <tr>
              <td><div align="right"><label for="email"><strong>E-mail</strong></label></div></td>
              <td colspan="2" ><input type="text" name="email" id="email" onChange="TestMail(document.form2.Email.value)" size=30 maxlength="35" required placeholder="Ingrese un e-mail correcto"></td>													
          </tr>
          <tr> 
              <td><div align="right"><label for="estado"><strong>Estado</strong></label></div></td>
              <td colspan="2" >
              <select name="estado">
                  <?php
                      include "includes/conect.php";
                      $mysqli=conectarServidor();
                      $qry="select IdEstado, Descripcion from estados_pers;";	
                      $result = $mysqli->query($qry);
                      echo '<option value="1" selected>Activo</option>';
                      while($row = $result->fetch_assoc())
                      {
                          if ($row['IdEstado']!=1)
                              echo '<option value="'.$row['IdEstado'].'">'.$row['Descripcion'].'</option>';
                      }
                      $result->free();
/* cerrar la conexión */
$mysqli->close();
                  ?>
              </select> 
          </tr>
          <tr> 
              <td><div align="right"><label for="area"><strong>&Aacute;rea</strong></label></div></td>
              <td colspan="2" >
              <select name="area">
                  <?php
                      $mysqli=conectarServidor();
                      $qry="select Id_area, area from areas_personal;";	
                      $result = $mysqli->query($qry);
                      echo '<option value="" selected>----------------------------</option>';
                      while($row = $result->fetch_assoc())
                      {
                              echo '<option value="'.$row['Id_area'].'">'.utf8_encode($row['area']).'</option>';
                      }
                      $result->free();
/* cerrar la conexión */
$mysqli->close();
                  ?>
              </select> 
          </tr>
          <tr> 
              <td><div align="right"><label for="cargo"><strong>Cargo</strong></label></div></td>
              <td colspan="2" >
              <select name="cargo">
                  <?php
                      $mysqli=conectarServidor();
                      $qry="select Id_cargo, cargo from cargos_personal;";	
                      $result=$mysqli->query($qry);
                      echo '<option value="" selected>------------------------------------</option>';
                      while($row=$result->fetch_assoc())
                      {
                              echo '<option value="'.$row['Id_cargo'].'">'.utf8_encode($row['cargo']).'</option>';
                      }
                      $result->free();
/* cerrar la conexión */
$mysqli->close();
                  ?>
              </select> 
          </tr>
          <tr> 
              <td>   </td>
              <td width="106"><button class="button" style="vertical-align:middle" onclick="return Enviar(this.form)"><span>Continuar</span></button></td>
              <td width="106"><button class="button" style="vertical-align:middle" type="reset"><span>Borrar</span></button></td>
          </tr>
          <tr>
              <td colspan="3"><div align="center">&nbsp;</div></td>
          </tr>
          <tr>
              <td colspan="3"><div align="center">&nbsp;</div></td>
          </tr>
          <tr> 
              <td colspan="3">
              <div align="center"><button class="button1" id="back" style="vertical-align:middle" onClick="history.back()"> <span>VOLVER</span></button></div>
              </td>
          </tr>
      </table>
  </form>
</div>
</body>
</html>

