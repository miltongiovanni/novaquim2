<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
	<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<title>Creaci&oacute;n de Proveedores</title>
	<meta charset="utf-8">
	<script  src="scripts/validar.js"></script>
	<script  src="scripts/block.js"></script>
   	<script >
	document.onkeypress = stopRKey; 
	</script>
</head>	
<?php
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
?>
	<!-- Copiar dentro del tag HEAD --></head>
<body>
<div id="contenedor"> 
<div id="saludo1"><strong>CREACI&Oacute;N DE PROVEDORES</strong></div>
<form name="form2" method="POST" action="makeProv2.php">   
<table align="center">
  <tr> 
      <td width="126"><div align="right"><b>NIT</b></div></td>
    <td width="242"><input type="text" name="NIT" size=34 id="NIT" maxlength="50"  value="<?php echo $nit ?>" readonly></td>
</tr>
  <tr> 
      <td><div align="right"><strong>Proveedor</strong></div></td>
    <td><input type="text" name="Proveedor" maxlength="50" size=34 id="Proveedor"></td>
  </tr>
  <tr> 
      <td><div align="right"><b>Direcci&oacute;n</b></div></td>
      <td><input type="text"  maxlength="50" name="Direccion" size=34 id="Direccion" ></td>
  </tr>
  <tr> 
      <td><div align="right"><b>Nombre Contacto</b></div></td>
      <td><input type="text"  maxlength="30" name="Contacto" size=34 id="Contacto" ></td>
  </tr>
  <tr> 
      <td><div align="right"><strong>Tel&eacute;fono</strong></div></td>
      <td><input type="text" name="Tel1" size=34 onKeyPress="return aceptaNum(event)" id="Tel1"></td>
  </tr>
  <tr> 
      <td><div align="right"><strong>Fax</strong></div></td>
      <td><input type="text" name="Fax" size=34 onKeyPress="return aceptaNum(event)" id="Fax"></td>
  </tr>
  <tr>
      <td><div align="right"><strong>Correo electr&oacute;nico</strong></div></td>
      <td><input type="text" name="Email" maxlength="50" onChange="TestMail(document.form2.Email.value)" size=34></td>													
  </tr>
  <tr> 
      <td><div align="right"><strong>Tipo de Proveedor</strong></div></td>
      <td>
      <select name="IdCat" id="IdCat">
          <?php
              include "includes/conect.php";
              $link=conectarServidor();
              $qry="select * from cat_prov";	
              $result=mysqli_query($link,$qry);
              echo '<option value="1" selected>Materia Prima</option>';
              while($row=mysqli_fetch_array($result))
              {
                  if ($row['Id_cat_prov']!=1)
                      echo '<option value="'.$row['Id_cat_prov'].'">'.$row['Des_cat_prov'].'</option>';
              }
              mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
          ?>
  		</select>            </tr>
   <tr>  
      <td><div align="right"><strong>Autorretenedor</strong></div></td>
      <td><select name="autoret"> <option value="0" selected>NO</option><option value="1">SI</option></select></td>           
  </tr>
  <tr>  
      <td><div align="right"><strong>R&eacute;gimen Proveedor</strong></div></td>
      <td><select name="regimen">
        <option value="0">Simplificado</option>
        <option value="1" selected>Com&uacute;n</option>
      </select></td>           
  </tr>
  <tr>  
      <td><div align="right"><strong>Tasa Reteica</strong></div></td>
      <td><?php
		  $link=conectarServidor();
		  echo'<select name="Tasa_reteica">';
		  $resultca=mysqli_query($link,"select idTasaRetIca,tasaRetIca from tasa_reteica;");
          while($rowca=mysqli_fetch_array($resultca))
		  {
            echo '<option value='.$rowca['Id_tasa_retica'].'>'.$rowca['tasa_retica'].'</option>';
          }
          echo'</select>';	
		  mysqli_free_result($resultca);	
		  mysqli_close($link);
		  ?></td>           
  </tr>
  <tr>  
      <td></td> 
      <td align="center"><input type="submit" value="      Crear     "><input type="reset" value="Restablecer"></td> 
  </tr> 
  <tr> 
      <td colspan="2"><div align="center">&nbsp;</div></td> 
  </tr> 
  <tr>  
      <td colspan="2"><div align="center"> <input type="button" class="resaltado" onClick="window.location='menu.php'" value="VOLVER"></div></td> 
  </tr> 
</table> 
</form>
</div> 
</body>
</html>

