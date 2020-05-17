<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Ingreso de Fórmulas de Color</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script  src="../js/validar.js"></script>
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
<div id="saludo"><strong>INGRESO DE FÓRMULAS DE COLOR</strong></div> 
<form method="post" action="detFormula_Col.php" name="form1">	
<table align="center" summary="cuerpo">
    <tr>
      <td align="right"><strong>Solución de Color:</strong></td>
      <td><?php
			include "includes/conect.php";
			$link=conectarServidor();
			echo'<select name="cod_sol">';
			$result=mysqli_query($link,"select Cod_mprima, Nom_mprima from mprimas LEFT join formula_col on Cod_mprima=Cod_sol_col WHERE Cod_sol_col is NULL AND Nom_mprima like 'Solucion%'");
			echo '<option value="">----------------------------------------------</option>';
            while($row=mysqli_fetch_array($result))
			{
				echo '<option value='.$row['Cod_mprima'].'>'.$row['Nom_mprima'].'</option>';
            }
            echo'</select>';
			mysqli_free_result($result);
/* cerrar la conexión */
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