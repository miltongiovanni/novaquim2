<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html>
<head>
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Actualizar datos del Cliente</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>
	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>

<body>
<div id="contenedor">
<div id="saludo1"><strong>ACTUALIZACI&Oacute;N DE DISTRIBUIDORA</strong></div>

<?php
	  $link=conectarServidor();
	  $nit=$_POST['cliente'];
	  $qry="select * from clientes where Nit_clien='$nit'";
	  $result=mysql_db_query("novaquim",$qry);
	  $row=mysql_fetch_array($result);
	  $city=$row['Ciudad_clien'];
?>

<form id="form1" name="form1" method="post" action="updateConsult.php">
<table border="0" align="center" width="49%">
	<tr><td>&nbsp;</td></tr>
    
    <tr> 
      <td width="14%" colspan="1"><strong>
        <label>C&eacute;dula </label>
      </strong></td>
      <td colspan="2"><strong>Nombre de la Distribuidora</strong></td>
      <td width="14%"><strong>
        <label>Tel&eacute;fono</label>
      </strong></td>
      <td width="14%"><strong>Fax</strong></td>
      <td width="12%" colspan="1"><strong>Celular</strong></td>
    </tr>
    <tr> 
      <td colspan="1"><input name="nit" type="text" size="12" readonly value="<?php echo $row['Nit_clien']; ?>"></td>
      <td colspan="2"><input name="nom_cliente" type="text" size="40" value="<?php echo $row['Nom_clien']; ?>"></td>
      <td><input name="tel1" type="text" maxlength="7" onKeyPress="return aceptaNum(event)" size="10" value="<?php echo $row['Tel_clien']; ?>"></td>
      <td><input name="fax" type="text" maxlength="7" size="10" onKeyPress="return aceptaNum(event)" value="<?php echo $row['Fax_clien'];?>"></td>
      <td colspan="1"><input name="celular" type="text" size="10" maxlength="10" onKeyPress="return aceptaNum(event)" value="<?php echo $row['Cel_clien']; ?>"></td>
    </tr>
    <tr> 
      
      <td colspan="3"><strong>Direcci&oacute;n</strong></td>
      <td colspan="1"><strong>Ciudad</strong></td>
      <td colspan="2"><strong>Localidad</strong></td>
    </tr>
    <tr> 
      
      <td colspan="3"><input name="direccion" type="text" size="55" value="<?php echo $row['Dir_clien']; ?>"></td>
      <td colspan="1"><?php 
	  	  $qrya="select Id_ciudad, ciudad from clientes, ciudades WHERE Ciudad_clien=Id_ciudad and Nit_clien='$nit';";
		  $resulta=mysql_db_query("novaquim",$qrya);
		  $rowa=mysql_fetch_array($resulta); 			
		  echo'<select name="Id_Ciudad">';
		  $resultp=mysql_db_query("novaquim","select Id_ciudad, ciudad from ciudades;");
		  $totalp=mysql_num_rows($resultp);
		  echo '<option selected value='.$rowa['Id_ciudad'].'>'.$rowa['ciudad'].'</option>';
          while($rowp=mysql_fetch_array($resultp))
		  {
		  	if ($rowp['ciudad']!= $rowa['ciudad'])
            echo '<option value='.$rowp['Id_ciudad'].'>'.$rowp['ciudad'].'</option>';
          }
          echo'</select>'; ?></td>
      <td colspan="2"><?php
		  $qrya="select Id_localidad, localidad from localidad, clientes WHERE Id_city=$city and Nit_clien='$nit' and Id_localidad=loc_clien ;";
		  $resulta=mysql_db_query("novaquim",$qrya);
		  $rowa=mysql_fetch_array($resulta); 			
		  echo'<select name="Id_localidad">';
		  $resultp=mysql_db_query("novaquim","select Id_localidad, localidad from localidad WHERE Id_city=$city;");
		  $totalp=mysql_num_rows($resultp);
		  echo '<option selected value='.$rowa['Id_localidad'].'>'.$rowa['localidad'].'</option>';
          while($rowp=mysql_fetch_array($resultp))
		  {
		  	if ($rowp['Id_localidad']!= $rowa['Id_localidad'])
            echo '<option value='.$rowp['Id_localidad'].'>'.$rowp['localidad'].'</option>';
          }
          echo'</select>';			
		  ?></td>
    </tr>
    <tr> 
      
      <td colspan="3"><strong>E-mail</strong></td>
      <td colspan="2"><strong>Directora de Zona</strong></td>
      <td colspan="1"><strong>Estado</strong></td>
    </tr>
    <tr> 
      
      <td colspan="3"><input name="email" type="text"  onChange="TestMail(document.form1.email.value)" size="55" value="<?php echo $row['Eml_clien']; ?>"></td>
	  <td colspan="2"><?php
		  $qrya="select Id_personal, nom_personal from personal, clientes where Id_personal=cod_vend and Nit_clien='$nit' ;";
		  $resulta=mysql_db_query("novaquim",$qrya);
		  $rowa=mysql_fetch_array($resulta); 			
		  echo'<select name="Id_vendor">';
		  $resultp=mysql_db_query("novaquim","select Id_personal, nom_personal from personal;");
		  $totalp=mysql_num_rows($resultp);
		  echo '<option selected value='.$rowa['Id_personal'].'>'.$rowa['nom_personal'].'</option>';
          while($rowp=mysql_fetch_array($resultp))
		  {
		  	if ($rowp['Id_personal']!= $rowa['Id_personal'])
            echo '<option value='.$rowp['Id_personal'].'>'.$rowp['nom_personal'].'</option>';
          }
          echo'</select>';	
		  mysql_close($link);
		  ?></td>
    
    <td colspan="1"><?php
		  echo'<select name="Estado">';
		  if ($row['Estado']=='A')
		  {
			  echo '<option selected value='.$row['Estado'].'>Activo </option>';
			  echo '<option value="N">No Activo</option>';
			  echo'</select>';			
		  }
		  if ($row['Estado']=='N')
		  {
			  echo '<option selected value='.$row['Estado'].'>No Activo </option>';
			  echo '<option value="A">Activo</option>';
			  echo'</select>';			
		  }
		  
		  ?></td>
    </tr>
    <tr> 
      <td><input type="hidden" name="Ret_fte" value="0"><input type="hidden" name="Ret_iva" value="0"><input type="hidden" name="Ret_ica" value="0"><input type="hidden"  name="Cargo" value="Distribuidora"><input type="hidden" name="Id_Cat" value="13">
        <input name="Contacto" type="hidden" value="<?php echo $row['Contacto']; ?>">
        </td><td width="4%">&nbsp;</td><td width="41%">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td width="1%">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="7"><div align="center"><input type="submit" name="Submit" value="Actualizar Datos del Cliente"></div></td>
    </tr>
  </table>
</form>
<table align="center" width="73%">
  <tr> 
      <td colspan="5"><div align="center">
	  <?php
		echo'<form action="detCliente.php" method="post" name="formulario">';
		echo '<input name="NIT" type="hidden" value="'.$nit.'"/>
		<input type="submit" name="Submit" value="Adicionar o Cambiar Sucursales" />';
		echo'</form>';        
		//mover_pag2("Proveedor Creado correctamente");
		function mover_pag2($Mensaje)
		{
			echo'<script language="Javascript">
			alert("'.$Mensaje.'");
			document.formulario.submit();
			</script>';
		}
	?>
        </div></td>
    </tr>
	<tr>
        <th width="5%" align="center">Id</th>
      	<th width="28%" align="center">Nombre Sucursal</th>
   	  <th width="12%" align="center">Tel&eacute;fono </th>
      	<th width="40%" align="center">Direccci&oacute;n Sucursal</th>
        <th width="15%" align="center">Ciudad Sucursal</th>
   </tr>
          <?php
			$link=conectarServidor();
			$bd="novaquim";
			$qry="select Id_sucursal, Nom_sucursal, Tel_sucursal, Dir_sucursal, ciudad from clientes_sucursal, ciudades where Nit_clien='$nit' and Ciudad_sucursal=Id_ciudad order by Id_sucursal;";
			$result=mysql_db_query($bd,$qry);
			while($rowp=mysql_fetch_array($result))
			{
				$sucursal=$rowp['Id_sucursal'];
				$nom_sucursal=$rowp['Nom_sucursal'];
				$tel_sucursal=$rowp['Tel_sucursal'];
				$dir_sucursal=$rowp['Dir_sucursal'];
				$ciudad_sucursal=$rowp['ciudad'];
				echo'<tr>
				  <td><div align="center" class="formatoDatos">'.$sucursal.'</div></td>
				  <td><div align="center" class="formatoDatos">'.$nom_sucursal.'</div></td>
				  <td><div align="center" class="formatoDatos">'.$tel_sucursal.'</div></td>
				  <td><div align="center" class="formatoDatos">'.$dir_sucursal.'</div></td>
				  <td><div align="center" class="formatoDatos">'.$ciudad_sucursal.'</div></td>
				</tr>';
			}
			mysql_close($link);
			?>
  </table>
<div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div>
</div>
</body>
</html>
