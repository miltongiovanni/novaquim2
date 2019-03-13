<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
<meta charset="utf-8">
<title>Seleccionar F&oacute;rmula a Actualizar</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>	
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>SELECCI&Oacute;N DE F&Oacute;RMULA DE MATERIA PRIMA A ACTUALIZAR</strong></div> 
<table width="100%" border="0">
  	<tr>
    	<td>
		<form id="form1" name="form1" method="post" action="detFormula_MP.php">
      	<div align="center"><strong>F&oacute;rmula de Materia Prima</strong>
<?php
				include "includes/conect.php";
				$link=conectarServidor();
				echo'<select name="Formula" id="combo">';
				$result=mysqli_query($link,"select Id_form_mp, Nom_mprima from formula_mp, mprimas where Cod_mp=Cod_mprima order by Nom_mprima;");
				echo '<option selected value="">--------------------------------------------------------------------------</option>';
				while($row=mysqli_fetch_array($result)){
					echo '<option value='.$row['Id_form_mp'].'>'.$row['Nom_mprima'].'</option>';
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
