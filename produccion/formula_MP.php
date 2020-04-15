<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ingreso de F&oacute;rmulas de Materia Prima</title>
    <meta charset="utf-8">
    <link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script  src="scripts/validar.js"></script>
	<script  src="scripts/block.js"></script>
    <link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue2.css" title="blue">
    <script  src="scripts/calendar.js"></script>
    <script  src="scripts/calendar-sp.js"></script>
    <script  src="scripts/calendario.js"></script>
    	<script >
	document.onkeypress = stopRKey; 
	</script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>INGRESO DE F&Oacute;RMULAS DE MATERIA PRIMA</strong></div> 
<form method="post" action="detFormula_MP.php" name="form1">	
<table align="center" summary="cuerpo" width="50%">
<tr>
      <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
      <td width="50%" align="right"><strong>Materia Prima:</strong></td>
      <td width="50%"><?php
			include "includes/conect.php";
			$link=conectarServidor();
			echo'<select name="mprima1">';
			$result=mysqli_query($link,"select Cod_mprima, Nom_mprima from mprimas order by Nom_mprima");
			echo '<option value="">----------------------------------------------</option>';
            while($row=mysqli_fetch_array($result))
			{
				echo '<option value='.$row['Cod_mprima'].'>'.$row['Nom_mprima'].'</option>';
            }
            echo'</select>';
			mysqli_free_result($result);
/* cerrar la conexi�n */
mysqli_close($link);
		?></td>
    </tr>
    <tr>
   	  <td><input name="CrearFormula" type="hidden" value="0"></td>
    	<td><div align="right"><input name="button" type="button" onClick="return Enviar(this.form);" value="Continuar"></div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="2">
        <div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div>        </td>
    </tr>
  </table>
</form> 
</div>
</body>
</html>