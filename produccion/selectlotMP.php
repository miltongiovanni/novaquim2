<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
<meta charset="utf-8">
<title>Seleccionar Materia Prima a Actualizar</title>
<script  src="scripts/validar.js"></script>
<script  src="scripts/block.js"></script>
</head>
<body>
<?php 
include "includes/conect.php";
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
    $link=conectarServidor();  
	$bd="novaquim";   
	$qrybus="select mprimas.Cod_mprima, Nom_mprima from mprimas, inv_mprimas where mprimas.Cod_mprima=inv_mprimas.Cod_mprima and Estado_MP='C' and mprimas.Cod_mprima=$IdMP";
	$resultbus=mysql_db_query($bd,$qrybus);
	$rowbus=mysql_fetch_array($resultbus);
?>
<div id="contenedor">
  <div id="saludo"><strong>SELECCI&Oacute;N DE LOTE DE <?php echo strtoupper($rowbus['Nom_mprima']); ?> A REALIZAR CONTROL DE CALIDAD</strong></div>
<form id="form1" name="form1" method="post" action="calidadMPForm.php">  
<table width="700" border="0" align="center">
 <tr>
      <td>
        <div align="center"><strong>Lote:&nbsp;</strong>
		<?php
			$link=conectarServidor();
			echo'<select name="Lote_MP">';
			$result=mysql_db_query("novaquim","select inv_mprimas.Lote_mp from mprimas, inv_mprimas where mprimas.Cod_mprima=inv_mprimas.Cod_mprima and Estado_MP='C' and mprimas.Cod_mprima=$IdMP");
			$total=mysql_num_rows($result);
			echo '<option selected value="">----------------</option>';
			while($row=mysql_fetch_array($result))
			{
				echo '<option value='.$row['Lote_mp'].'>'.$row['Lote_mp'].'</option>';
			}
			echo'</select>';
			mysql_close($link);
		?>
          <input name="IdMP" type="hidden" value="<?php echo $IdMP; ?>"><input type="submit" name="Submit" value="Continuar" onClick="return Enviar(this.form);">
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
