<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
<meta charset="utf-8">
<title>Seleccionar Usuario a Actualizar</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>	
</head>
<body>
<div id="contenedor">

<div id="saludo"><strong>SELECCIONAR USUARIO A ACTUALIZAR</strong></div> 
<table width="100%" border="0">
  	<tr>
    	<td>
		<form id="form1" name="form1" method="post" action="updateUserForm.php">
      	<div align="center"><strong>Usuario</strong>
<?php	
				include "includes/conect.php";
				$link=conectarServidor();
				echo'<select name="IdUsuario" id="combo">';
				$result=mysqli_query($link, "select * from tblusuarios");
				echo '<option selected value="">-----------------------------</option>';
				while($row=mysqli_fetch_array($result)){
					echo '<option value='.$row['IdUsuario'].'>'.$row['Usuario'].'</option>';
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

