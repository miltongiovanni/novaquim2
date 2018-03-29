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
      	<div align="center"><label for="combo"><strong>Usuario</strong></label>
<?php	
				include "includes/conect.php";
        $mysqli=conectarServidor();
				echo'<select name="IdUsuario" id="combo">';
        $qry="select * from tblusuarios"; 
        $result = $mysqli->query($qry);
				echo '<option selected value="">-----------------------------</option>';
				while($row = $result->fetch_assoc()){
					echo '<option value='.$row['IdUsuario'].'>'.$row['Usuario'].'</option>';
				}
				echo'</select>';
        $result->free();
/* cerrar la conexión */
$mysqli->close();
			?>
        <button class="button" style="vertical-align:middle" onclick="return Enviar2(this.form)"><span>Continuar</span></button>
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
        <div align="center"><button class="button1" id="back" style="vertical-align:middle" onClick="history.back()"> <span>VOLVER</span></button></div>
        </td>
    </tr>
</table>
</div>
</body>
</html>

