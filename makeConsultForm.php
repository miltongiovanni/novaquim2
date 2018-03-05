<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
	<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<title>Creaci&oacute;n de Clientes</title>
	<meta charset="utf-8">
	<script type="text/javascript" src="scripts/validar.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>	
		<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>CREACI&Oacute;N DE DISTRIBUIDORAS</strong></div>
<form name="form2" method="POST" action="makeConsult.php">
    <table border="0" align="center" >
        <tr>
            <td colspan="2"><div align="center">&nbsp;</div></td>
        </tr>
        <tr> 
            <td><div align="right"><b>No:</b></div></td>
          <td><input type="hidden" name="tipo" value="0" ><input type="text" name="NIT" size=20  onKeyPress="return aceptaNum(event)" id="NIT" maxlength="10"></td>
        </tr>
        <tr>
        <td><div align="right"><b>Ciudad</b></div></td>
        <td> <?php
				include "includes/conect.php";
				$link=conectarServidor();
				echo'<select name="ciudad_cli">';
				$result=mysql_db_query("novaquim","select Id_ciudad, ciudad from ciudades;");
				$total=mysql_num_rows($result);
				echo '<option selected value="">------------------------------------</option>';
				while($row=mysql_fetch_array($result)){
					echo '<option value='.$row['Id_ciudad'].'>'.$row['ciudad'].'</option>';
				}
				echo'</select>';
				mysql_close($link);
	   ?>	  </td>
        </tr>
        <tr> 
            <td height="30">   </td>
            <td><input type="reset" value="Restablecer">
                    <input type="button" value=" Continuar " onClick="return Enviar(this.form);" >
                    </td>
        </tr>
        <tr> 
            <td colspan="2">
            <div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="VOLVER"></div>                    </td>
        </tr>
    </table>
</form>
</div>
</body>
</html>

