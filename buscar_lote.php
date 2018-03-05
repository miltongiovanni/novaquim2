<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css"><head>
<meta charset="utf-8">
<title>OP para Control de Calidad</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>	
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>BUSCAR ORDEN DE PRODUCCI&Oacute;N A PARA CONTROL DE CALIDAD</strong></div>
<table border="0" align="center">
<form id="form1" name="form1" method="post" action="cal_produccion.php">	
    <tr> 
        <td width="133"><div align="right"><strong>Orden  de Producci&oacute;n&nbsp;</strong></div></td><td>
        <?php
			include "includes/conect.php";
			$link=conectarServidor();
			echo'<select name="Lote" id="combo">';
			$result=mysqli_query($link,"SELECT Lote from ord_prod where Estado='P';;");
			echo '<option selected value="">----------</option>';
			while($row=mysqli_fetch_array($result))
			{
				echo '<option value='.$row['Lote'].'>'.$row['Lote'].'</option>';
			}
			echo'</select>';
			mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
		?></td>
        <input type="hidden" name="Crear" value="5">
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td align="right"><input type="reset" value="Restablecer"></td>
        <td align="left"><input type="button" value="    Continuar    " onclick="return Enviar(this.form);"></td>

    </tr>
</form>    
  	<tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="2"><div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div></td></tr>
</table>
</div>
</body>
</html>
