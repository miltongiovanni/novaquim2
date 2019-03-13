<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de Envases como producto de Distribuci&oacute;n</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>LISTADO DE ENVASES COMO PRODUCTO DE DISTRIBUCI&Oacute;N</strong></div>
<table width="100%" border="0">
  <tr> 
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
      </div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0">
<tr>
    <th width="29" class="formatoEncabezados">Item</th>
    <th width="253" class="formatoEncabezados">Producto Distribuci&oacute;n</th>
    <th width="187" class="formatoEncabezados">Envase</th>
    <th width="156" class="formatoEncabezados">Tapa o V&aacute;lvula</th>
</tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();
//sentencia SQL    tblusuarios.IdUsuario,
$sql="	select Id_env_dis, Producto, Nom_envase, Nom_tapa from rel_env_dis, distribucion, envase, tapas_val
WHERE Dist=Id_distribucion and Env=Cod_envase and Tapa=Cod_tapa;";
$result=mysqli_query($link,$sql);
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
echo'<tr';
	  if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
<td class="formatoDatos"><div align="center">'.$row['Id_env_dis'].'</div></td>
<td class="formatoDatos"><div align="center">'.$row['Producto'].'</div></td>
<td class="formatoDatos"><div align="center">'.$row['Nom_envase'].'</div></td>
<td class="formatoDatos"><div align="center">'.$row['Nom_tapa'].'</div></td>';
echo'</tr>';
}
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
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
      <td><div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
      </div></td>
    </tr>
</table>
</div>
</body>
</html>