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
<div id="saludo"><strong>CREACI&Oacute;N DE CLIENTES</strong></div>
<form name="form2" method="POST" action="makeClien.php">
    <table border="0" align="center" >
        <tr>
            <td colspan="2"><div align="center">&nbsp;</div></td>
        </tr>
        <tr>
            <td width="67"><div align="right"><strong>Tipo:</strong></div></td>
           <td width="194" colspan="2">
            <input name="tipo" type="radio" id="tipo_0" value="1" checked> 
            Nit
            <input type="radio" name="tipo" value="2" id="tipo_1"> 
            C&eacute;dula                    		</td>
        </tr>
        <tr> 
            <td><div align="right"><b>No:</b></div></td>
          <td><input type="text" name="NIT" size=20  onKeyPress="return aceptaNum(event)" id="NIT" maxlength="10"></td>
        </tr>
        <tr>
        <td><div align="right"><b>Ciudad</b></div></td>
        <td> <?php
				include "includes/conect.php";
				$link=conectarServidor();
				echo'<select name="ciudad_cli">';
				$result=mysqli_query($link,"select Id_ciudad, ciudad from ciudades;");
				echo '<option selected value="">------------------------------------</option>';
				while($row=mysqli_fetch_array($result)){
					echo '<option value='.$row['Id_ciudad'].'>'.$row['ciudad'].'</option>';
				}
				echo'</select>';
				mysqli_free_result($result);
				mysqli_close($link);
	   ?>	  </td>
        </tr>
        <tr> 
            <td height="30">   </td>
            <td>
                    <input type="button" value=" Continuar " onClick="return Enviar(this.form);" >
                    <input type="reset" value="Restablecer"></td>
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

