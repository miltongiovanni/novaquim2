<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
<meta charset="utf-8">
<title>Ajuste de Inventario de Envase</title>
<script  src="../js/validar.js"></script>
<script  src="scripts/block.js"></script>
</head>
<body>
<div id="contenedor">
  <div id="saludo"><strong>SELECCIÓN DE ENVASE A AJUSTAR INVENTARIO</strong></div>
<form id="form1" name="form1" method="post" action="a_inv_env2.php">  
<table width="700" border="0" align="center">
 <tr>
      <td>
        <div align="center"><strong>Envase</strong>
		<?php
		  include "includes/conect.php";
		  $link=conectarServidor();
		  echo'<select name="IdEnv">';
		  $result=mysqli_query($link,"SELECT Cod_envase, Nom_envase FROM envase order by Nom_envase;");
		  echo '<option selected value="">---------------------------------------------------------------------------------</option>';
		  while($row=mysqli_fetch_array($result))
		  {
			  echo '<option value='.$row['Cod_envase'].'>'.$row['Nom_envase'].'</option>';
		  }
		  echo'</select>';
		  mysqli_close($link);
		?>
        <input type="submit" name="Submit" value="Continuar" onClick="return Enviar0(this.form);">
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
