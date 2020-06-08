<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
<meta charset="utf-8">
<title>Seleccionar Materia Prima a revisar Trazabilidad</title>
<script  src="../js/validar.js"></script>
<script  src="scripts/block.js"></script>
</head>
<body>
<?php
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 	
}  
	include "includes/conect.php";
	$link=conectarServidor();
	$resultmp=mysqli_query($link,"select Nombre from prodpre where Cod_prese=$Id_Prod");
	$rowmp=mysqli_fetch_array($resultmp);
	$producto=$rowmp['Nombre'];
	mysqli_free_result($resultmp);
?>
<div id="contenedor">
  <div id="saludo"><strong>SELECCIÓN DE LOTE DE <?php echo mb_strtoupper($producto); ?> A REVISAR TRAZABILIDAD</strong></div>
<form id="form1" name="form1" method="post" action="traz_prod.php">  
<table width="700" border="0" align="center">
<tr>
      <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
 <tr>
      <td><input name="Id_Prod" type="hidden" value="<?php echo $Id_Prod; ?>">
        <div align="center"><strong>Lote</strong>
<?php
				echo'<select name="lote_prod">';
				$result=mysqli_query($link,"select Lote, codPresentacion from envasado where codPresentacion=$Id_Prod order by Lote DESC;");
				echo '<option selected value="">-------</option>';
				while($row=mysqli_fetch_array($result)){
					echo '<option value='.$row['Lote'].'>'.$row['Lote'].'</option>';
				}
				echo'</select>';
				mysqli_free_result($result);
				mysqli_close($link);
			?>
          <input type="submit" name="Submit" value="Continuar" onClick="return Enviar(this.form);">
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
      <td colspan="2"><div align="center">
        <input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  ">
      </div></td>
    </tr>
</table>
</form
></div>
</body>
</html>
