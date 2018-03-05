<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
<meta charset="utf-8">
<title>Seleccionar Materia Prima a revisar Trazabilidad</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>	
</head>
<body>
<?php
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 	
}  
	include "includes/conect.php";
	$link=conectarServidor();
	$resultmp=mysqli_query($link,"select * from mprimas where Cod_mprima=$IdMP");
	$rowmp=mysqli_fetch_array($resultmp);
	$mprima=$rowmp['Nom_mprima'];
?>
<div id="contenedor">
  <div id="saludo"><strong>SELECCI&Oacute;N DE LOTE DE <?php echo strtoupper($mprima); ?> A REVISAR TRAZABILIDAD</strong></div>
<form id="form1" name="form1" method="post" action="traz_mp.php">  
<table width="700" border="0" align="center">
<tr>
      <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
 <tr>
      <td><input name="IdMP" type="hidden" value="<?php echo $IdMP; ?>">
        <div align="center"><strong>Lote</strong>
		<?php
		  echo'<select name="lote_mp">';
		  $result=mysqli_query($link,"select DISTINCT Lote from det_compras where Codigo=$IdMP and Lote<>'NULL';");
		  echo '<option selected value="">----------------------</option>';
		  while($row=mysqli_fetch_array($result)){
			  echo '<option value="'.$row['Lote'].'">'.$row['Lote'].'</option>';
		  }
		  echo'</select>';
		  mysqli_free_result($result);
		  mysqli_close($link);
		?>
          <input type="button" name="Submit" value="Continuar" onClick="return Enviar(this.form);">
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
