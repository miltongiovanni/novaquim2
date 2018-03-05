<?php
include "includes/valAcc.php";
include "includes/conect.php";
//echo $_SESSION['Perfil'];
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Actualizar datos de Producto</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>
	<script type="text/javascript">
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
$link=conectarServidor();
$qry="select * from mprimas where Cod_mprima=$IdMP";
$result=mysql_db_query("novaquim",$qry);
$row=mysql_fetch_array($result);
$nom_mprima=$row['Nom_mprima'];
$qrye="select apariencia_mp, olor_mp, color_mp, pH_mp, densidad_mp from mprimas where Cod_mprima=$IdMP";
$resulte=mysql_db_query("novaquim",$qrye);
$rowe=mysql_fetch_array($resulte);
mysql_close($link);
?>
<div id="contenedor">
<div id="saludo1"><strong>CONTROL DE CALIDAD DE <?php echo strtoupper($nom_mprima)." CON LOTE No. ".$Lote_MP; ?></strong></div>
<table width="50%" align="center" summary="especificacion">
<tr>
	<td colspan="2" class="titulo">&nbsp;</td>
</tr>
<tr>
	<td colspan="2" align="left" class="titulo">Especificaci&oacute;n</td>
</tr>
<tr>
	<td width="50%" align="right"><strong>Apariencia:</strong></td>
	<td width="50%"><?php echo strtoupper($rowe['apariencia_mp']); ?></td>
</tr>
<tr>
	<td width="47%" align="right"><strong>Olor:</strong></td>
	<td width="53%"><?php echo strtoupper($rowe['olor_mp']); ?></td>
</tr>
<tr>
	<td width="47%" align="right"><strong>Color:</strong></td>
	<td width="53%"><?php echo strtoupper($rowe['color_mp']); ?></td>
</tr>
<tr>
	<td width="47%" align="right"><strong>pH:</strong></td>
	<td width="53%"><?php echo strtoupper($rowe['pH_mp']); ?></td>
</tr>
<tr>
	<td width="47%" align="right"><strong>Gravedad Espec&iacute;fica:</strong></td>
	<td width="53%"><?php echo strtoupper($rowe['densidad_mp']); ?>&nbsp;&plusmn;&nbsp;0.05</td>
</tr>
<tr>
	<td colspan="2" class="titulo">&nbsp;</td>
</tr>

</table>
<form id="form1" name="form1" method="post" action="controlMP.php">
	<table border="0" align="center" width="50%">
    <tr>
	<td align="left" class="titulo">Resultados An&aacute;lisis</td>
	<td align="left" class="titulo">Cumple / Valor</td>
</tr>
<tr>
	<td width="50%" align="right"><strong>Apariencia:</strong></td>
	<td width="50%"><input name="apar_mp" type="radio" id="apar_mp_0" value="1" checked> Si  <input type="radio" name="apar_mp" value="2" id="apar_mp_1"> No</td>
</tr>
<tr>
	<td width="48%" align="right"><strong>Olor:</strong></td>
	<td width="38%"><input name="olor_mp" type="radio" id="olor_mp_0" value="1" checked> Si  <input type="radio" name="olor_mp" value="2" id="olor_mp_1"> No</td>
</tr>
<tr>
	<td width="48%" align="right"><strong>Color:</strong></td>
	<td width="38%"><input name="color_mp" type="radio" id="color_mp_0" value="1" checked> Si  <input type="radio" name="color_mp" value="2"  id="color_mp_1"> No</td>
</tr>
<tr>
	<td width="48%" align="right"><strong>pH:</strong></td>
	<td width="38%">
    <?php if($rowe['pH_mp']<>'N.A.')
	   	echo '<input name="pH_comp" type="text" size=20 onKeyPress="return aceptaNum(event)"  value="">';
	   else
	   	echo '<input name="pH_comp" type="text" size=20 onKeyPress="return aceptaNum(event)" readonly value="'.$rowe['pH_mp'].'">';
	?>
     </td>
</tr>
<tr>
	<td width="48%" align="right"><strong>Gravedad Espec&iacute;fica:</strong></td>
	<td width="38%">
    <?php if($rowe['densidad_mp']<>'N.A.')
	   	echo '<input name="dens_mp" type="text" size=20 onKeyPress="return aceptaNum(event)"  value="">';
	   else
	   	echo '<input name="dens_mp" type="text" size=20 onKeyPress="return aceptaNum(event)" readonly value="'.$rowe['densidad_mp'].'">';
	?>
    </td>
</tr>

    <tr> 
      <td>&nbsp;</td>
      <td width="14%"><div align="left"><input name="IdMP" type="hidden" value="<?php echo $IdMP; ?>"><input name="Lote_MP" type="hidden" value="<?php echo $Lote_MP; ?>">
          <input type="submit" name="Submit" value="Grabar Datos"  onClick="return Enviar(this.form);">
        </div></td>
    </tr>
  </table>
</form>
</div>
</body>
</html>
