<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Seleccionar Categor&iacute;a de Materia Prima</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>	
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>SELECCIONAR CATEGOR&Iacute;A DE MATERIA PRIMA</strong></div>
<form id="form1" name="form1" method="post" action="updateCatForm_MP.php"> 
<table width="309" border="0" align="center">
  	<tr>
    	<td width="60"><strong>Categor&iacute;a</strong></td>
        <td width="160"> 
      	<div align="center">
			<?php
				include "includes/conect.php";
				$link=conectarServidor();
				echo'<select name="IdCat" id="combo">';
				$result=mysqli_query($link,"select * from cat_mp");
				echo '<option selected value="">---------------------------------------</option>';
				while($row=mysqli_fetch_array($result)){
					echo '<option value='.$row['Id_cat_mp'].'>'.$row['Des_cat_mp'].'</option>';
				}
				echo'</select>';
				mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
			?>
         </div>
        <td width="75"><input type="button" value="Continuar" onClick="return Enviar(this.form);"/></td>
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
