<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
	<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<title>Armado de Kits</title>
	<meta charset="utf-8">
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
	<!-- Copiar dentro del tag HEAD -->
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>ARMADO  DE KITS DE PRODUCTOS</strong></div>
<table  border="0" align="center" class="table2" width="24%" cellspacing="0">
  <form name="form2" method="POST" action="armado_kits.php">
    <tr>
    	<td width="16%"><div align="right"><strong>Kit</strong></div></td>
      <td width="84%">
      	<div align="left"> <?php
				include "includes/conect.php";
				$link=conectarServidor();
				echo'<select name="Cod_kit">';
				$result=mysqli_query($link,"SELECT Id_kit as Id, Codigo as C�digo, Nombre as Producto, Nom_envase as Envase from kit, prodpre, envase where Codigo=Cod_prese AND Cod_env=envase.Cod_envase
		union
		SELECT Id_kit as Id, Codigo as C�digo, Producto, Nom_envase as Envase from kit, distribucion, envase where Codigo=Id_distribucion AND Cod_env=envase.Cod_envase;");
				echo '<option selected value="">-----------------------------------------------------</option>';
				while($row=mysqli_fetch_array($result)){
					echo '<option value='.$row['Id'].'>'.$row['Producto'].'</option>';
				}
				echo'</select>';
				mysqli_close($link);
			?>
      	</div>
        </td>
  	</tr>
    <tr> 
        <td><div align="right"><strong>Cantidad</strong></div></td>
		<td><input type="text" name="Cantidad" onKeyPress="return aceptaNum(event)" size=20 ></td>
    </tr>
    <tr>
      <td><div align="right"><strong>Fecha</strong></div></td>
      <td><input type="text" name="Fecha" id="sel1" readonly size=20><input type="reset" value=" ... "
		onclick="return showCalendar('sel1', '%Y-%m-%d', '12', true);"></td>
    </tr>
    <tr><td></td>
        <td>
            <div align="center">
              <input type="button" value="Continuar" onClick="return Enviar(this.form);">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="reset" value="Reiniciar">    	
          </div></td>
    </tr>
    </form>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr> 
        <td colspan="2">
        <div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div>        </td>
    </tr>
</table>
</div>
</body>
</html>

