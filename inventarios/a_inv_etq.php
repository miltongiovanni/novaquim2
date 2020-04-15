<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
<meta charset="utf-8">
<title>Ajuste de Inventario de Etiquetas</title>
<script  src="scripts/validar.js"></script>
<script  src="scripts/block.js"></script>
</head>
<body>
<div id="contenedor">
  <div id="saludo"><strong>SELECCI&Oacute;N DE ETIQUETA A AJUSTAR INVENTARIO</strong></div>
<form id="form1" name="form1" method="post" action="a_inv_etq2.php">  
<table width="700" border="0" align="center">
 <tr>
      <td>
        <div align="center"><strong>Etiqueta</strong>
          <?php
		  include "includes/conect.php";
		  $link=conectarServidor();
		  echo'<select name="IdEtq">';
		  $result=mysqli_query($link,"select Cod_etiq, Nom_etiq from etiquetas order by Nom_etiq ;;");
		  echo '<option selected value="">--------------------------------------------------</option>';
		  while($row=mysqli_fetch_array($result))
		  {
			  echo '<option value='.$row['Cod_etiq'].'>'.$row['Nom_etiq'].'</option>';
		  }
		  echo'</select>';
		  mysqli_close($link);
		?>
          <input type="submit" name="Submit" value="Continuar" onClick="return Enviar0(this.form);">
        </div>
      </td>
    </tr>
    <tr>
      <td colspan="2"><div align="center"></div></td>
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
