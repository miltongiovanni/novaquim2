<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
<meta charset="utf-8">
<title>Seleccionar Personal a Actualizar</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>	
</head>
<body>
<div id="contenedor">

<div id="saludo"><strong>SELECCIONAR PERSONAL A ACTUALIZAR</strong></div> 
<table width="100%" border="0">
  	<tr>
    	<td>
		<form id="form1" name="form1" method="post" action="updatePersonForm.php">
      	<div align="center"><strong>Personal:</strong>
      	  <?php	
				include "includes/conect.php";
				$link=conectarServidor();
				echo'<select name="IdPersonal" id="combo">';
				$result=mysqli_query($link,"select Id_personal, nom_personal from personal;");
				echo '<option selected value="">-----------------------------------------</option>';
				while($row=mysqli_fetch_array($result)){
					echo '<option value='.$row['Id_personal'].'>'.$row['nom_personal'].'</option>';
				}
				echo'</select>';
				mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
			?>
          <input type="submit" name="Submit" value="Continuar" onClick="return Enviar2(this.form);">
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
        <td colspan="2">
        <div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div>
        </td>
    </tr>
</table>
</div>
</body>
</html>

