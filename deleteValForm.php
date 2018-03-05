<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Eliminar Tapa o V&aacute;lvula</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>	
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>

</head>


<body>
<div id="contenedor">
<div id="saludo"><strong>ELIMINACI&Oacute;N DE TAPAS O V&Aacute;LVULAS</strong></div>
<form method="post" action="deleteVal.php">
<table width="602" border="0" align="center">
<tr>
    <td colspan="2">
        <div align="center"><strong>Tapas o V&aacute;lvulas</strong>
<?php
  include "includes/conect.php";
  $link=conectarServidor();
  echo'<select name="Codigo">';
  $result=mysqli_query($link,"select * from tapas_val order by Nom_tapa");
  echo '<option selected value="">-----------------------------------------------------</option>';
  while($row=mysqli_fetch_array($result)){
	  echo '<option value='.$row['Cod_tapa'].'>'.$row['Nom_tapa'].'</option>';
  }
  echo'</select>';
  mysqli_free_result($result);
  /* cerrar la conexión */
  mysqli_close($link);
?>
          <input name="button" type="submit" value="Eliminar" onClick="return Enviar(this.form);"></div>
    </td>
</tr>
<tr>
    <td colspan="2"><div align="center">&nbsp;</div></td>
</tr>
<tr> 
    <td colspan="2">
    <div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div>
    </td>
</tr>
</table>
</form>
</div>
</body>
</html>
