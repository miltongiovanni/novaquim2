<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Actualizar datos del Usuario</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>

<body>
<div id="contenedor">

<div id="saludo1"><strong>ACTUALIZACI&Oacute;N DE USUARIOS</strong></div> 

<?php
	  $link=conectarServidor();
	  $IdUsuario=$_POST['IdUsuario'];
	  $qry="select *from tblusuarios where IdUsuario=$IdUsuario";
	  $result=mysqli_query($link,$qry);
	  $row=mysqli_fetch_array($result);
	  mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
?>

<form id="form1" name="form1" method="post" action="updateUser.php">
	<table width="41%" border="0" align="center">
    <tr> 
      <td width="30%" ><strong>
        <label>Nombre </label>
      </strong></td>
      <td width="30%" ><strong>Apellido</strong></td>
      <td width="20%" ><strong>
      </strong></td>
    </tr>
    <tr> 
      <td><?php echo'<input name="Nombre" type="text" value="'.$row['Nombre'].'"/>';?></td>
      <td><?php echo'<input name="Apellido" type="text" value="'.$row['Apellido'].'"/>';?></td>
      <td></td>
    </tr>
    <tr> 
      <td><strong>Usuario</strong></td>
      <td><strong>Fecha Creaci&oacute;n</strong></td>
      <td><strong>Fecha De Cambio</strong></td>
    </tr>
    <tr> 
      <td><?php echo'<input name="Usuario" type="text" value="'.$row['Usuario'].'"/>';?></td>
      <td><?php echo'<input name="FecCrea" type="text" readonly value="'.$row['FecCrea'].'"/>';?></td>
      <td><script>fecha();</script></td>
    </tr>
    <tr> 
      <td><strong>Estado</strong></td>
      <td><strong>Perfil</strong></td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td>
		<?php
          $link=conectarServidor();
		  $qryu="select *from tblusuarios, tblestados where tblusuarios.IdUsuario=$IdUsuario and tblusuarios.EstadoUsuario=tblestados.IdEstado";
		  $resultu=mysqli_query($link,$qryu);
		  $rowu=mysqli_fetch_array($resultu); 
		  echo'<select name="IdEstado">';
		  $resulte=mysqli_query($link,"select * from tblestados");
		  echo '<option selected value='.$rowu['IdEstado'].'>'.$rowu['Descripcion'].'</option>';
          while ($rowe=mysqli_fetch_array($resulte))
		  {
			if ($rowe['Descripcion']!= $rowu['Descripcion'])
	        	echo '<option value='.$rowe['IdEstado'].'>'.$rowe['Descripcion'].'</option>';
          }
          echo'</select>';
		  mysqli_free_result($resultu);
		  mysqli_free_result($resulte);
/* cerrar la conexión */
mysqli_close($link);
		?>
	  </td>
	  <td><?php
		  $link=conectarServidor();
		  $qrya="select *from tblusuarios, tblperfiles where tblusuarios.IdUsuario=$IdUsuario and tblusuarios.IdPerfil=tblperfiles.IdPerfil";
		  $resulta=mysqli_query($link,$qrya);
		  $rowa=mysqli_fetch_array($resulta); 			
		  echo'<select name="IdEstado2">';
		  $resultp=mysqli_query($link,"select * from tblperfiles");
		  echo '<option selected value='.$rowa['IdPerfil'].'>'.$rowa['Descripcion'].'</option>';
          while($rowp=mysqli_fetch_array($resultp))
		  {
		  	if ($rowp['Descripcion']!= $rowa['Descripcion'])
            echo '<option value='.$rowp['IdPerfil'].'>'.$rowp['Descripcion'].'</option>';
          }
          echo'</select>';	
		  mysqli_free_result($resulta);
		  mysqli_free_result($resultp);
/* cerrar la conexión */
mysqli_close($link);		
		  ?>
	  </td>
    <td>&nbsp;</td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><div align="center">
          <input type="submit" name="Submit" value="Actualizar">
        </div></td>
    </tr>
  </table>
</form>
</div>
</body>
</html>
