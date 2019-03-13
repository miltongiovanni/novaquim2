<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Borrar Producto de Distribuci&oacute;n</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>	
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>ELIMINACI&Oacute;N DE PRODUCTO DE DISTRIBUCI&Oacute;N</strong></div>
<form method="post" action="deleteDis.php">
<table width="100%" border="0" align="center">
	<tr>
		<td colspan="2">
			<div align="center"><strong>Producto</strong>
<?php
	  include "includes/conect.php";
	  $link=conectarServidor();
	  echo'<select name="IdDis">';
	  $result=mysqli_query($link,"select * from distribucion order by Producto");
	  echo '<option value="" selected>------------------------------------------------------------------------------------------------------------</option>';
	  while($row=mysqli_fetch_array($result)){
		echo '<option value='.$row['Id_distribucion'].'>'.$row['Producto'].'</option>';
	  }
	  echo'</select>';
	  mysqli_free_result($result);
	  /* cerrar la conexión */
	  mysqli_close($link);
?> 
	      &nbsp;<input name="button" type="submit" value="Borrar" onClick="return Enviar(this.form);"></div>
			    
		</td>
	</tr>
	<tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
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
