<?php
include "includes/valAcc.php";
include "includes/conect.php";
$bd="novaquim";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Seleccionar Vendedor y periodo a revisar comisiones</title>
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
<div id="saludo"><strong>SELECCI&Oacute;N DE VENDEDOR Y PER&Iacute;ODO PARA REVISAR COMISIONES</strong></div> 
<form method="post" action="comis_vend.php" name="form1">	
	<table align="center">
    <tr>
      	<td>&nbsp;</td>
      	<td>&nbsp;</td>
    </tr>
    <tr> 
    <td colspan="1" align="right"><div align="right"><strong>Vendedor</strong></div></td>
    <td colspan="3">
	<?php
            $link=conectarServidor();
            echo'<select name="vendedor">';
            $result=mysqli_query($link,"select Id_personal , nom_personal FROM personal where Activo=1;");
            echo '<option selected value="">------------------------------------</option>';
            while($row=mysqli_fetch_array($result)){
                echo '<option value='.$row['Id_personal'].'>'.$row['nom_personal'].'</option>';
            }
            echo'</select>';
			mysqli_free_result($result);
            mysqli_close($link);
    ?>	  </td>
  </tr>
     <tr>
      <td align="right"><strong>Fecha Inicial</strong></td>
      <td><input type="text" name="FchIni" id="sel1" readonly size=20><input type="reset" value=" ... "
		onclick="return showCalendar('sel1', '%Y-%m-%d', '12', true);"></td>
    </tr>
    <tr>
      <td align="right"><strong>Fecha Final</strong></td>
      <td><input type="text" name="FchFin" id="sel2" readonly size=20><input type="reset" value=" ... "
		onclick="return showCalendar('sel2', '%Y-%m-%d', '12', true);"></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>    <input name="Crear" type="hidden" value="3">
    <tr>
   	  <td>&nbsp;</td>
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