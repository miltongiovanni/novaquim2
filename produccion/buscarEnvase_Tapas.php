<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
<meta charset="utf-8">
<title>Seleccionar Envase o Tapa a Consultar Compra</title>
<script  src="scripts/validar.js"></script>
<script  src="scripts/block.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>SELECCIONAR ENVASE O TAPA A CONSULTAR COMPRA</strong></div>
<table width="100%" border="0">
  	<tr>
    	<td>
		<form id="form1" name="form1" method="post" action="listacompraxEnv.php">
      	<div align="center"><strong>Envase o Tapa</strong>
<?php

$link=conectarServidor();
echo'<select name="IdEnvTap">';
$result=mysqli_query($link,"select Cod_envase as codigo, Nom_envase as producto from envase union select Cod_tapa as codigo, Nom_tapa as producto from tapas_val order by producto;");
echo '<option selected value="">-----------------------------------------------------</option>';
while($row=mysqli_fetch_array($result))
{
	echo '<option value='.$row['codigo'].'>'.$row['producto'].'</option>';
}
echo'</select>';
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
?>
          <input type="button" value="Continuar" onClick="return Enviar(this.form);">
      	</div>
    	</form>    
        </td>
  	</tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="2"><div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div></td>
    </tr>
</table>
</div>
</body>
</html>
