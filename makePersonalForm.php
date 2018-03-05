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
		<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>CREACI&Oacute;N DE PERSONAL</strong></div> 
  <form name="form2" method="POST" action="makePerson.php">
      <table border="0" align="center" summary="">
          <tr> 
              <td width="56"><div align="right"><b>Nombre</b></div></td>
              <td  colspan="2"><input type="text" name="nombre" size=30 onKeyPress="return aceptaLetra(event)" maxlength="30"></td>
          </tr>
          <tr> 
              <td><div align="right"><strong>Celular</strong></div></td>
              <td colspan="2" ><input type="text" name="celular" size=30 onKeyPress="return aceptaNum(event)" maxlength="10"></td>
          </tr>
          <tr>
              <td><div align="right"><strong>E-mail</strong></div></td>
              <td colspan="2" ><input type="text" name="email" onChange="TestMail(document.form2.Email.value)" size=30 maxlength="35"></td>													
          </tr>
          <tr> 
              <td><div align="right"><strong>Estado</strong></div></td>
              <td colspan="2" >
              <select name="estado">
                  <?php
                      include "includes/conect.php";
                      $link=conectarServidor();
                      $qry="select IdEstado, Descripcion from estados_pers;";	
                      $result=mysqli_query($link,$qry);
                      echo '<option value="1" selected>Activo</option>';
                      while($row=mysqli_fetch_array($result))
                      {
                          if ($row['IdEstado']!=1)
                              echo '<option value="'.$row['IdEstado'].'">'.$row['Descripcion'].'</option>';
                      }
                      mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
                  ?>
              </select> 
          </tr>
          <tr> 
              <td><div align="right"><strong>&Aacute;rea</strong></div></td>
              <td colspan="2" >
              <select name="area">
                  <?php
                      $link=conectarServidor();
                      $qry="select Id_area, area from areas_personal;";	
                      $result=mysqli_query($link, $qry);
                      echo '<option value="" selected>----------------------------</option>';
                      while($row=mysqli_fetch_array($result))
                      {
                              echo '<option value="'.$row['Id_area'].'">'.$row['area'].'</option>';
                      }
                      mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
                  ?>
              </select> 
          </tr>
          <tr> 
              <td><div align="right"><strong>Cargo</strong></div></td>
              <td colspan="2" >
              <select name="cargo">
                  <?php
                      $link=conectarServidor();
                      $qry="select Id_cargo, cargo from cargos_personal;";	
                      $result=mysqli_query($link, $qry);
                      echo '<option value="" selected>------------------------------------</option>';
                      while($row=mysqli_fetch_array($result))
                      {
                              echo '<option value="'.$row['Id_cargo'].'">'.$row['cargo'].'</option>';
                      }
                      mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
                  ?>
              </select> 
          </tr>
          <tr> 
              <td>   </td>
              <td width="106"><input type="button" value="    Enviar    " onClick="return Enviar(this.form);"></td>
              <td width="106"><input type="reset" value="Restablecer"></td>
          </tr>
          <tr>
              <td colspan="3"><div align="center">&nbsp;</div></td>
          </tr>
          <tr>
              <td colspan="3"><div align="center">&nbsp;</div></td>
          </tr>
          <tr> 
              <td colspan="3">
              <div align="center"><input type="button" class="resaltado" onClick="history.back()" value="VOLVER"></div>
              </td>
          </tr>
      </table>
  </form>
</div>
</body>
</html>

