<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Preparación de Solución de Color</title>
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
<?php
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  

?>
<div id="contenedor">
<div id="saludo"><strong>PREPARACIÓN DE SOLUCIÓN DE COLOR</strong></div>
<form method="post" action="makeO_Prod_col.php" name="form1">	
  	<table align="center" summary="cuerpo">
    <tr>
      	<td width="199" align="right"><strong>Solución de Color</strong></td>
      	<td width="194">
		<?php
			include "includes/conect.php";
			$link=conectarServidor();
			echo'<select name="fcolor">';
			$result=mysqli_query($link,"select Id_form_col, Nom_mprima from formula_col, mprimas where Cod_sol_col=Cod_mprima;");
			echo '<option value="">-------------------------------------------</option>';
            while($row=mysqli_fetch_array($result))
			{
				echo '<option value='.$row['Id_form_col'].'>'.$row['Nom_mprima'].'</option>';
            }
            echo'</select>';
			mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
		?>
        </td>
    </tr>
    
     <tr>
      <td align="right"><strong>Fecha de Preparación</strong></td>
      <td><input type="text" name="FchProd" id="sel2" readonly size=20><input type="reset" value=" ... "
		onclick="return showCalendar('sel2', '%Y-%m-%d', '12', true);"></td>
    </tr>
    <tr>
      <td align="right"><strong>Responsable</strong></td>
      <td>
      <?php
				//include "conect.php";
				$link=conectarServidor();
				echo'<select name="IdResp">';
				$result=mysqli_query($link,"select * from personal where Area=2 and activo=1");
				echo '<option selected value="">-------------------------------------------</option>';
				while($row=mysqli_fetch_array($result)){
					echo '<option value='.$row['Id_personal'].'>'.$row['nom_personal'].'</option>';
				}
				echo'</select>';
				mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
	   ?>
	  </td>
    </tr>
    <tr>
      <td align="right"><strong>Cantidad a Producir (Kg)</strong></td>
      <td><input type="text" name="can_prod" size=25></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
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