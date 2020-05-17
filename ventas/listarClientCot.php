<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Lista de Clientes de Cotización</title>
<meta charset="utf-8">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<script  src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>LISTA DE CLIENTES DE COTIZACIÓN</strong></div>
<table  align="center" width="700"border="0">
  <tr> 
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú">
      </div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0" cellpadding="0">
	<tr>
	<th width="10" class="formatoEncabezados"></th>
    <th width="100" align="center" class="formatoEncabezados">Id</th>
    <th width="348" align="center" class="formatoEncabezados">Cliente</th>
    <th width="300" align="center" class="formatoEncabezados">Dirección</th>
	<th width="156" align="center" class="formatoEncabezados">Contacto</th>
    <th width="141" align="center" class="formatoEncabezados">Cargo Contacto</th>
	<th width="61" align="center" class="formatoEncabezados">Teléfono</th>
	<th width="155" align="center" class="formatoEncabezados">Actividad</th>
  </tr>   
<?php
include "includes/conect.php" ;
$link=conectarServidor();
$sql="	SELECT Id_cliente, Nom_clien, Contacto, Cargo, Tel_clien, Cel_clien, Fax_clien, Dir_clien, Eml_clien, desCatClien from clientes_cotiz, cat_clien where Id_cat_clien=idCatClien order by Nom_clien;";
$result=mysqli_query($link,$sql);
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	echo'<tr';
	  if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
	<td class="formatoDatos"><div align="center"><a aiotitle="click to expand" href="javascript:togglecomments('."'".'UniqueName'.$a."'".')">+/-</a></div></td>
	<td class="formatoDatos"><div align="center">'.$row['Id_cliente'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Nom_clien'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Dir_clien'].'</div></td>	
	<td class="formatoDatos"><div align="left">'.$row['Contacto'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Cargo'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Tel_clien'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Des_cat_cli'].'</div></td>
	';
	
	echo'</tr>';
	echo '<tr><td colspan="4"><div class="commenthidden" id="UniqueName'.$a.'"><table width="300" border="0" align="center" cellspacing="0" bordercolor="#CCCCCC">
	<tr>
	  <th width="60" class="formatoEncabezados">Fax</th>
	  <th width="100" class="formatoEncabezados">Celular</th>
      <th width="200" class="formatoEncabezados">Correo Electrónico</th>
  	</tr>';
	echo '<tr>
	<td class="formatoDatos"><div align="left">'.$row['Fax_clien'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Cel_clien'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Eml_clien'].'</div></td>
	</tr>';
	echo '</table></div></td></tr>';
	$a=$a+1;
}
mysqli_free_result($result);
mysqli_close($link);//Cerrar la conexion
?>

</table>
<table width="27%" border="0" align="center">
<tr>
        <td class="formatoDatos">&nbsp;</td>
  </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr> 
      <td><div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú">
      </div></td>
    </tr>
</table>
</div>
</body>
</html>