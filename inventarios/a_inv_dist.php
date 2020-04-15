<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
<meta charset="utf-8">
<title>Ajuste de Inventario de Producto de Distribuci&oacute;n</title>
<script  src="scripts/validar.js"></script>
<script  src="scripts/block.js"></script>
</head>
<body>
<div id="contenedor">
  <div id="saludo"><strong>SELECCI&Oacute;N DE PRODUCTO DE DISTRIBUCI&Oacute;N A AJUSTAR INVENTARIO</strong></div>
<form id="form1" name="form1" method="post" action="a_inv_dist2.php">  
<table width="700" border="0" align="center">
 <tr>
      <td>
        <div align="center"><strong>Producto de Distribuci&oacute;n</strong>
          <?php
		  include "includes/conect.php";
		  $link=conectarServidor();
		  echo'<select name="IdDist">';
		  $result=mysqli_query($link,"select Id_distribucion, Producto from distribucion where Activo=0 order by Producto;");
		  echo '<option selected value="">---------------------------------------------------------------------------------</option>';
		  while($row=mysqli_fetch_array($result))
		  {
			  echo '<option value='.$row['Id_distribucion'].'>'.$row['Producto'].'</option>';
		  }
		  echo'</select>';
		  mysqli_close($link);
		?>
          <input type="button" name="Submit" value="Continuar" onClick="return Enviar0(this.form);">
        </div>
      </td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  ">
      </div></td>
    </tr>
</table>
</form>
</div>
</body>
</html>
