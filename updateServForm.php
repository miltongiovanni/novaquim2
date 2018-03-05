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
<title>Actualizar Servicio</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>ACTUALIZACI&Oacute;N DE SERVICIO</strong></div>
<?php
	  $link=conectarServidor();
	  $IdServ=$_POST['IdServ'];
	  $qry="select IdServicio, DesServicio, Cod_iva, tasa, Activo from servicios, tasa_iva where Id_tasa=Cod_iva and IdServicio=$IdServ";
	  $result=mysqli_query($link,$qry);
	  $row=mysqli_fetch_array($result);
	  mysqli_free_result($result);
			/* cerrar la conexión */
			mysqli_close($link);
?>

<form id="form1" name="form1" method="post" action="updateServ.php">
	<table border="0" align="center" width="50%" >
    <tr> 
      <td width="10%"><div align="center"><strong>C&oacute;digo </strong></div></td>
      <td colspan="2"><div align="center"><strong>Descripci&oacute;n</strong></div></td>
      <td width="16%"><div align="center"><strong>Tasa de IVA</strong></div></td>
       <td width="23%"><div align="center"><strong>Producto Activo</strong></div></td>
      
      
    </tr> 
    <tr> 
      <td><div align="center"><?php echo'<input name="Id_serv" type="text" readonly size="6" value="'.$row['IdServicio'].'"/>';?></div></td>
      <td colspan="2"><div align="center"><?php echo'<input name="servicio" type="text" size="40" value="'.$row['DesServicio'].'"/>';?></div></td>
      
      
     
      <td><div align="center">
        <?php
		  $link=conectarServidor();
		  echo'<select name="cod_iva">';
		  $result2=mysqli_query($link,"select * from tasa_iva");
		  echo '<option selected value='.$row['Cod_iva'].'>'.$row['tasa'].'</option>';
          while ($row2=mysqli_fetch_array($result2))
		  {
			if ($row2['tasa']!= $row['tasa'])
	        	echo '<option value='.$row2['Id_tasa'].'>'.$row2['tasa'].'</option>';
          }
          echo'</select>';
		  mysqli_free_result($result2);
/* cerrar la conexión */
mysqli_close($link);
		?>
      </div></td>
      <td><div align="center">
	  <?php 
        $Activo=$row['Activo'];
        if ($Activo==1)
        {
        echo '<select name="Activo" >
            <option value="1" selected>No</option>
            <option value="0">Si</option>
            </select>';
        }
        else
		{
		echo '<select name="Activo" >
            <option value="0" selected>Si</option>
            <option value="1">No</option>
            </select>';	
		}    
        ?></div></td>
      
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td> 
      <td width="26%">&nbsp;</td> <td width="25%" >&nbsp;</td><td>&nbsp;</td> 
      <td><div align="center">
          <input name="Submit" type="submit" class="formatoBoton1" value="Enviar">
        </div></td>
    </tr>
  </table>
</form>
</div>
</body>
</html>
