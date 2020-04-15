<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
<meta charset="utf-8">
<title>Seleccionar F&oacute;rmula a Actualizar</title>
<script  src="scripts/validar.js"></script>
<script  src="scripts/block.js"></script>	
	<script >
	document.onkeypress = stopRKey; 
	</script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>SELECCI&Oacute;N DE F&Oacute;RMULA A ACTUALIZAR</strong></div> 
<table width="100%" border="0">
  	<tr>
    	<td>
		<form id="form1" name="form1" method="post" action="detFormula.php">
      	<div align="center"><strong>F&oacute;rmula</strong>
<?php
				include "includes/conect.php";
				$link=conectarServidor();
				echo'<select name="Formula" id="combo">';
				$result=mysqli_query($link,"select * from formula order by Nom_form");
				echo '<option selected value="">--------------------------------------------------------------------------</option>';
				while($row=mysqli_fetch_array($result)){
					echo '<option value='.$row['Id_form'].'>'.$row['Nom_form'].'</option>';
				}
				echo'</select>';
				mysqli_free_result($result);
				/* cerrar la conexión */
				mysqli_close($link);
			?>
            <input type="submit" name="Submit" value="Continuar" onClick="return Enviar(this.form);">
            <input name="CrearFormula" type="hidden" value="2"> 
      	</div>
    	</form>    
        </td>
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
