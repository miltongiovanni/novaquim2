<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
<meta charset="utf-8">
<title>Seleccionar Presentaci&oacute;n de Producto a Desactivar</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>	
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>SELECCI&Oacute;N DE PRESENTACI&Oacute;N DE PRODUCTO A DESACTIVAR</strong></div>
<form id="form1" name="form1" method="post" action="desactiv_prese.php">
<table width="100%" border="0">
  <tr>
      <td>
      <div align="center"><strong>Presentaci&oacute;n de Producto</strong>&nbsp;  
          <?php
              include "includes/conect.php";
              $link=conectarServidor();
              echo'<select name="IdProdPre">';
              $result=mysqli_query($link,"select Cod_prese, Nombre  from prodpre WHERE pres_activo=0  order by Nombre");
              echo '<option value="" selected>----------------------------------------------------------------------------------------------</option>';
              while($row=mysqli_fetch_array($result))
              {
                  echo '<option value='.$row['Cod_prese'].'>'.$row['Nombre'].'</option>';
              }
              echo'</select>';
              mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
          ?>
          <input type="submit" name="Submit" value="Continuar" onClick="return Enviar(this.form);">
      </div>
      </td>
  </tr>
  <tr>
      <td colspan="2"><div align="center">&nbsp;</div></td>
  </tr>
  <tr> 
      <td colspan="2"><div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div></td>
  </tr>
</table>
</form>
</div>
</body>
</html>
