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

<div id="saludo1"><strong>ACTUALIZACI&Oacute;N DE PERSONAL</strong></div> 

<?php
	  $mysqli=conectarServidor();
	  $IdPersonal=$_POST['IdPersonal'];
	  $qry="select Id_personal, nom_personal, activo, Area, cel_personal, Eml_personal, cargo_personal from personal where Id_personal=$IdPersonal";
	  $result=$mysqli->query($qry);
	  $row=$result->fetch_assoc();
	  $result->free();
/* cerrar la conexión */
$mysqli->close();
?>

<form id="form1" name="form1" method="post" action="updatePerson.php">
	<table border="0" align="center" summary="cuerpo">
    <tr> 
      <td colspan="2" ><strong>Nombre</strong></td>
      <td ><strong>Celular</strong></td>
    </tr>
    <tr> 
      <td colspan="2"><?php echo'<input name="Nombre" type="text" size=36 value="'.utf8_encode($row['nom_personal']).'"/>';?></td>
      <td><?php echo'<input name="Celular" type="text" value="'.$row['cel_personal'].'"/>';?></td>
    </tr>
    <tr> 
      <td><strong>Estado</strong></td>
      <td><strong>&Aacute;rea</strong></td>
      <td><strong>Cargo</strong></td>
    </tr>
    <tr> 
      <td>
		<?php
      $mysqli=conectarServidor();
		  $qryu="SELECT IdEstado, Descripcion FROM estados_pers, personal WHERE activo=IdEstado and Id_personal=$IdPersonal;";
		  $resultu=$mysqli->query($qryu);
		  $rowu=$resultu->fetch_assoc();
		  echo'<select name="Estado">';
		  $resulte=$mysqli->query("SELECT IdEstado, Descripcion FROM estados_pers");
		  echo '<option selected value='.$rowu['IdEstado'].'>'.utf8_encode($rowu['Descripcion']).'</option>';
          while ($rowe=$resulte->fetch_assoc())
		  {
			if ($rowe['Descripcion']!= $rowu['Descripcion'])
	        	echo '<option value='.$rowe['IdEstado'].'>'.utf8_encode($rowe['Descripcion']).'</option>';
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
		  $qrya="select Id_area, areas_personal.area from areas_personal, personal WHERE personal.Area=areas_personal.Id_area and Id_personal=$IdPersonal;";
		  $resulta=$mysqli->query($qrya);
		  $rowa=$resulta->fetch_assoc(); 			
		  echo'<select name="Area">';
		  $resultp=$mysqli->query("select Id_area, area from areas_personal;");
		  echo '<option selected value='.$rowa['Id_area'].'>'.utf8_encode($rowa['area']).'</option>';
          while($rowp=$resultp->fetch_assoc())
		  {
		  	if ($rowp['Id_area']!= $rowa['Id_area'])
            echo '<option value='.$rowp['Id_area'].'>'.utf8_encode($rowp['area']).'</option>';
          }
          echo'</select>';	
		  $resulta->free();
      $resultp->free();
/* cerrar la conexión */
$mysqli->close();
		  ?>
	</td>
    <td>
    <?php
		  $mysqli=conectarServidor();
		  $qrya="select Id_cargo, cargo from cargos_personal, personal where cargo_personal=Id_cargo AND Id_personal=$IdPersonal";
		  $resulta=$mysqli->query($qrya);
		  $rowa=$resulta->fetch_assoc(); 			
		  echo'<select name="Cargo">';
		  $resultp=$mysqli->query("select Id_cargo, cargo from cargos_personal;");
		  echo '<option selected value='.$rowa['Id_cargo'].'>'.utf8_encode($rowa['cargo']).'</option>';
          while($rowp=$resultp->fetch_assoc())
		  {
		  	if ($rowp['Id_cargo']!= $rowa['Id_cargo'])
            echo '<option value='.$rowp['Id_cargo'].'>'.utf8_encode($rowp['cargo']).'</option>';
          }
          echo'</select>';	
		  $resulta->free();
      $resultp->free();
/* cerrar la conexión */
$mysqli->close();
		  ?>
    </td>
    </tr>
    <tr> 
      <td><strong>E-mail</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="3"> <?php echo'<input name="Email" type="text" value="'.$row['Eml_personal'].'" onChange="TestMail(document.form1.Email.value)" size="36">';?></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td><input type="hidden" name="IdPersonal" value="<?php echo $IdPersonal ?>"></td>
      <td><div align="center">
        <button class="button" style="vertical-align:middle" onclick="return Enviar(this.form)"><span>Actualizar</span></button>
        </div></td>
    </tr>
  </table>
</form>
</div>
</body>
</html>
