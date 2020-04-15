<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
	<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<title>Creaci&oacute;n de Kits de Productos de Distribuci&oacute;n</title>
	<meta charset="utf-8">
	<script  src="scripts/validar.js"></script>
	<script  src="scripts/block.js"></script>
		<script >
	document.onkeypress = stopRKey; 
	</script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>CREACI&Oacute;N DE KITS DE PRODUCTOS</strong></div>
<form name="form2" method="POST" action="make_kits.php">
<table  border="0" align="center" class="table2" width="34%" cellspacing="0">
    <tr> 
    <?php
	include "includes/conect.php";
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  

    $link=conectarServidor(); 
	if ($Codigo==1)
	{
	  echo '<tr><td><div align="right"><strong>Producto Novaquim</strong></div></td><td><div align="left">';
	  echo'<select name="Codigo">';
	  $result=mysql_db_query("novaquim","SELECT Cod_prese, Nombre FROM prodpre where Cod_produc>900 order by Nombre;");
	  while($row=mysqli_fetch_array($result))
	  {
		  echo '<option value='.$row['Cod_prese'].'>'.$row['Nombre'].'</option>';
	  }
	  echo'</select>';
	  echo '</div></td></tr>';
	}
	else
	{
		echo '<tr><td><div align="right"><strong>Producto de Distribuci&oacute;n</strong></div></td><td><div align="left">';
		echo'<select name="Codigo">';
		$result=mysqli_query($link,"select Id_distribucion, Producto from distribucion where Activo=0 order by Producto;");
		while($row=mysqli_fetch_array($result))
		{
			echo '<option value='.$row['Id_distribucion'].'>'.$row['Producto'].'</option>';
		}
		echo '</select>';
		echo '</div></td></tr>';
	}
	mysqli_close($link);
	?>
    </tr>
    <tr>
    	<td><div align="right"><strong>Empaque</strong></div></td>
      <td width="61%">
      	<div align="left"> <?php
				
				$link=conectarServidor();
				echo'<select name="Cod_env">';
				$result=mysqli_query($link,"select * from envase");
				echo '<option selected value="">-----------------------------------------------------</option>';
				while($row=mysqli_fetch_array($result)){
					echo '<option value='.$row['Cod_envase'].'>'.$row['Nom_envase'].'</option>';
				}
				echo'</select>';
			?>
      	</div>
        </td>
  	</tr>
    <tr>
        <td colspan="2"><div align="center">&nbsp;</div></td>
    </tr>
    <tr><td></td> 
        <td >
            <div align="center">
              <input type="button" value="Continuar" onClick="return Enviar(this.form);">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="reset" value="Reiniciar">    	
          </div></td>
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

