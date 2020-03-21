<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
    <meta charset="utf-8">
    <title>Seleccionar Servicio a eliminar</title>
    <script type="text/javascript" src="scripts/validar.js"></script>
    <script type="text/javascript" src="scripts/block.js"></script>	
    <script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>SERVICIO A BORRAR</strong></div>
<form id="form1" name="form1" method="post" action="deleteServ.php">
<table width="100%" border="0">
  	<tr>
    	<td>
        <div align="center"><strong>Servicio</strong>
          <?php
            include "includes/conect.php";
            $link=conectarServidor();
            echo'<select name="IdServ">';
            $result=mysqli_query($link,"select IdServicio, DesServicio from servicios order by DesServicio");
            echo '<option value="" selected>---------------------------------------------------</option>';
            while($row=mysqli_fetch_array($result)){
                echo '<option value='.$row['IdServicio'].'>'.$row['DesServicio'].'</option>';
            }
            echo'</select>';
			mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
        ?>
        &nbsp;
        <input type="button" value="Eliminar" onClick="return Enviar(this.form);">
      	</div>
        </td>
  	</tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="2"><div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div></td>
    </tr>
</table>
</form>
</div>
</body>
</html>
