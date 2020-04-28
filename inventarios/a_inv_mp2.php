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
<script  src="scripts/validar.js"></script>
<script  src="scripts/block.js"></script>
	<script >
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">

<?php
	  $link=conectarServidor();
	  foreach ($_POST as $nombre_campo => $valor) 
	  { 
		  $asignacion = "\$".$nombre_campo."='".$valor."';"; 
		  //echo $nombre_campo." = ".$valor."<br>";  
		  eval($asignacion); 
	  }  
	  $qry="select * from mprimas where Cod_mprima=$IdMP";
	  $result=mysqli_query($link,$qry);
	  $row=mysqli_fetch_array($result);
	  mysqli_close($link);
?>
<div id="saludo"><strong>AJUSTE DE INVENTARIO DE <?php echo strtoupper($row['Nom_mprima']); ?></strong></div>
<table border="0" align="center" width="34%">
	<tr> 
  		<td width="24%"><div align="center"><strong>Item</strong></div></td>
		<td width="33%"><div align="center"><strong>Lote</strong></div></td>
		<td width="43%"><div align="center"><strong>Inventario </strong></div></td>
	</tr>
    <?php 
		$link=conectarServidor();
		$qry="select loteMP, inv_mp from inv_mprimas where Cod_mprima=$IdMP;";
		$i=0;
		$a=1;
		if ($result=mysqli_query($link,$qry))
		{
			while($row=mysqli_fetch_array($result))
			{
				$lote=$row['Lote_mp'];
				$inv=$row['inv_mp'];
				$i=$i+1;
				echo '<tr><form action="updateInvMP.php" method="post" name="actualiza'.$i.'">';
				echo '<td';
				if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
				echo '><div align="center">'.$i.'</div></td>
				<td';
				if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
				echo '><div align="center">'.$row['Lote_mp'].'</div></td>';
				echo '<td';
				if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
				echo '><div align="center"><input name="inv" type="text" size="5" value="'.$row['inv_mp'].'"/></div></td>';
				echo '<td align="center" valign="middle">';
				echo '<input type="submit" class="formatoBoton" name="Submit" value="Cambiar" >
					  <input name="lote" type="hidden" value="'.$lote.'">
					  <input name="mprima" type="hidden" value="'.$IdMP.'">
					  <input name="inv_ant" type="hidden" value="'.$inv.'">';
				echo '</td></form></tr>';
			}
			mysqli_close($link);
		}
	?>
    <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><div align="left"> </div></td>
    </tr>
  </table>
</div>
</body>
</html>
