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
</head>

<body>
<div id="contenedor">

<div id="saludo1"><strong>ACTUALIZACI&Oacute;N DE USUARIOS</strong></div> 

<?php
    $mysqli=conectarServidor();
	  $IdUsuario=$_POST['IdUsuario'];
	  $qry="select *from tblusuarios where IdUsuario=$IdUsuario";
    $result = $mysqli->query($qry);
    $row = $result->fetch_assoc();
    $result->free();
/* cerrar la conexión */
$mysqli->close();
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
          $mysqli=conectarServidor();
		  $qryu="select *from tblusuarios, tblestados where tblusuarios.IdUsuario=$IdUsuario and tblusuarios.EstadoUsuario=tblestados.IdEstado";
		  $resultu=$mysqli->query($qryu);
		  $rowu=$resultu->fetch_assoc();
		  echo'<select name="IdEstado">';
		  $resulte=$mysqli->query("select * from tblestados");
		  echo '<option selected value='.$rowu['IdEstado'].'>'.$rowu['Descripcion'].'</option>';
          while ($rowe=$resulte->fetch_assoc())
		  {
			if ($rowe['Descripcion']!= $rowu['Descripcion'])
	        	echo '<option value='.$rowe['IdEstado'].'>'.$rowe['Descripcion'].'</option>';
          }
          echo'</select>';
		  $resultu->free();
		  $resulte->free();
/* cerrar la conexión */
$mysqli->close();
		?>
	  </td>
	  <td><?php
		  $mysqli=conectarServidor();
		  $qrya="select *from tblusuarios, tblperfiles where tblusuarios.IdUsuario=$IdUsuario and tblusuarios.IdPerfil=tblperfiles.IdPerfil";
		  $resulta=$mysqli->query($qrya);
		  $rowa=$resulta->fetch_assoc();			
		  echo'<select name="IdEstado2">';
		  $resultp=$mysqli->query("select * from tblperfiles");
		  echo '<option selected value='.$rowa['IdPerfil'].'>'.$rowa['Descripcion'].'</option>';
          while($rowp=$resultp->fetch_assoc())
		  {
		  	if ($rowp['Descripcion']!= $rowa['Descripcion'])
            echo '<option value='.$rowp['IdPerfil'].'>'.$rowp['Descripcion'].'</option>';
          }
          echo'</select>';	
		  $resulta->free();
      $resultp->free();
/* cerrar la conexión */
$mysqli->close();	
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
        <button class="button" style="vertical-align:middle" onclick="return Enviar2(this.form)"><span>Actualizar</span></button>
        </div></td>
    </tr>
  </table>
</form>
</div>
</body>
</html>
