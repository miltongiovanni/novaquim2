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

<div id="saludo1"><strong>ACTUALIZACI&Oacute;N DE PERSONAL</strong></div> 

<?php
	  $link=conectarServidor();
	  $IdPersonal=$_POST['IdPersonal'];
	  $qry="select Id_personal, nom_personal, activo, Area, cel_personal, Eml_personal, cargo_personal from personal where Id_personal=$IdPersonal";
	  $result=mysqli_query($link,$qry);
	  $row=mysqli_fetch_array($result);
	  mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
?>

<form id="form1" name="form1" method="post" action="updatePerson.php">
	<table border="0" align="center" summary="cuerpo">
    <tr> 
      <td colspan="2" ><strong>Nombre</strong></td>
      <td ><strong>Celular</strong></td>
    </tr>
    <tr> 
      <td colspan="2"><?php echo'<input name="Nombre" type="text" size=36 value="'.$row['nom_personal'].'"/>';?></td>
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
          $link=conectarServidor();
		  $qryu="SELECT IdEstado, Descripcion FROM estados_pers, personal WHERE activo=IdEstado and Id_personal=$IdPersonal;";
		  $resultu=mysqli_query($link,$qryu);
		  $rowu=mysqli_fetch_array($resultu); 
		  echo'<select name="Estado">';
		  $resulte=mysqli_query($link,"SELECT IdEstado, Descripcion FROM estados_pers");
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
		  $qrya="select Id_area, areas_personal.area from areas_personal, personal WHERE personal.Area=areas_personal.Id_area and Id_personal=$IdPersonal;";
		  $resulta=mysqli_query($link,$qrya);
		  $rowa=mysqli_fetch_array($resulta); 			
		  echo'<select name="Area">';
		  $resultp=mysqli_query($link,"select Id_area, area from areas_personal;");
		  echo '<option selected value='.$rowa['Id_area'].'>'.$rowa['area'].'</option>';
          while($rowp=mysqli_fetch_array($resultp))
		  {
		  	if ($rowp['Id_area']!= $rowa['Id_area'])
            echo '<option value='.$rowp['Id_area'].'>'.$rowp['area'].'</option>';
          }
          echo'</select>';	
		  mysqli_free_result($resulta);
		  mysqli_free_result($resultp);
/* cerrar la conexión */
mysqli_close($link);
		  ?>
	</td>
    <td>
    <?php
		  $link=conectarServidor();
		  $qrya="select Id_cargo, cargo from cargos_personal, personal where cargo_personal=Id_cargo AND Id_personal=$IdPersonal";
		  $resulta=mysqli_query($link,$qrya);
		  $rowa=mysqli_fetch_array($resulta); 			
		  echo'<select name="Cargo">';
		  $resultp=mysqli_query($link,"select Id_cargo, cargo from cargos_personal;");
		  echo '<option selected value='.$rowa['Id_cargo'].'>'.$rowa['cargo'].'</option>';
          while($rowp=mysqli_fetch_array($resultp))
		  {
		  	if ($rowp['Id_cargo']!= $rowa['Id_cargo'])
            echo '<option value='.$rowp['Id_cargo'].'>'.$rowp['cargo'].'</option>';
          }
          echo'</select>';	
		  mysqli_free_result($resulta);
		  mysqli_free_result($resultp);
/* cerrar la conexión */
mysqli_close($link);	
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
          <input type="button" name="Submit" value="Actualizar" onClick="return Enviar(this.form);">
        </div></td>
    </tr>
  </table>
</form>
</div>
</body>
</html>
