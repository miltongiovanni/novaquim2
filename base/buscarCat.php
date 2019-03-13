<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Seleccionar Categor&iacute;a</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
	
</head>
<body>
<div id="contenedor">

<div id="saludo"><strong>SELECCI&Oacute;N  DE CATEGOR&Iacute;A&nbsp;</strong></div> 
<form id="form1" name="form1" method="post" action="updateCatForm.php">
<table border="0" align="center">
  	<tr>
    	<td><strong>Categor&iacute;a</strong></td>
		<td>
      	<div align="center">
			<?php
				include "includes/conect.php";
				$link=conectarServidor();
				echo'<select name="IdCat" id="combo">';
				$result=mysqli_query($link,"select * from cat_prod");
				echo '<option selected value="">---------------------------------------</option>';
				while($row=mysqli_fetch_array($result)){
					echo '<option value='.$row['Id_cat_prod'].'>'.$row['Des_cat_prod'].'</option>';
				}
				echo'</select>';
				mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
			?>
        </div></td>
        <td><input type="button" value="Continuar" onClick="return Enviar(this.form);"/></td>
	</tr>
    <tr>
    	<td colspan="3"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="3"><div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div></td>
    </tr>
</table> 	
</form>  
</div>
</body>
</html>
