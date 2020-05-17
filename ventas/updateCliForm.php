<?php
include "../includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<title>Actualizar datos del Cliente</title>
<script  src="../js/validar.js"></script>

</head>

<body>
<div id="contenedor">
<div id="saludo1"><strong>ACTUALIZACIÓN DE CLIENTE</strong></div>

<?php
	  $link=conectarServidor();
	  $nit=$_POST['cliente'];
	  $qry="select * from clientes where Nit_clien='$nit'";
	  $result=mysqli_query($link,$qry);
	  $row=mysqli_fetch_array($result);
	  $city=$row['Ciudad_clien'];
?>

<form id="form1" name="form1" method="post" action="updateClien.php">
<table border="0" align="center">
<tr> 
  <td colspan="2"><strong>NIT</strong></td>
  <td colspan="3"><strong>Cliente</strong></td>
  <td><strong>Teléfono</strong></td>
  <td colspan="2"><strong>Fax</strong></td>
</tr>
<tr> 
  <td colspan="2"><?php echo'<input name="nit" type="text" readonly value="'.$row['Nit_clien'].'">';?></td>
  <td colspan="3"><?php echo'<input name="nom_cliente" type="text" size="40" value="'.$row['Nom_clien'].'">';?></td>
  <td><?php echo'<input name="tel1" type="text" maxlength="7" onKeyPress="return aceptaNum(event)" size="10" value="'.$row['Tel_clien'].'">';?></td>
  <td colspan="2"><?php echo'<input name="fax" type="text" maxlength="7" size="10" onKeyPress="return aceptaNum(event)" value="'.$row['Fax_clien'].'">';?></td>
</tr>
<tr> 
  <td colspan="2"><strong>Contacto</strong></td>
  <td colspan="3"><strong>Dirección</strong></td>
  <td colspan="1"><strong>Ciudad</strong></td>
  <td colspan="2"><strong>Celular</strong></td>
</tr>
<tr> 
  <td colspan="2"><?php echo'<input name="Contacto" type="text" value="'.$row['Contacto'].'">';?></td>
  <td colspan="3"><?php echo'<input name="direccion" type="text" size="40" value="'.$row['Dir_clien'].'">';?></td>
  <td colspan="1"><?php 
      $qrya="select Id_ciudad, ciudad from clientes, ciudades WHERE Ciudad_clien=Id_ciudad and Nit_clien='$nit';";
      $resulta=mysqli_query($link,$qrya);
      $rowa=mysqli_fetch_array($resulta); 			
      echo'<select name="Id_Ciudad">';
      $resultp=mysqli_query($link,"select Id_ciudad, ciudad from ciudades;");
      echo '<option selected value='.$rowa['Id_ciudad'].'>'.$rowa['ciudad'].'</option>';
      while($rowp=mysqli_fetch_array($resultp))
      {
        if ($rowp['ciudad']!= $rowa['ciudad'])
        echo '<option value='.$rowp['Id_ciudad'].'>'.$rowp['ciudad'].'</option>';
      }
      echo'</select>'; ?></td>
  <td colspan="2"><?php echo'<input name="celular" type="text" size="10" maxlength="10" onKeyPress="return aceptaNum(event)" value="'.$row['Cel_clien'].'">';?></td>
</tr>
<tr> 
  <td colspan="2"><strong>Cargo  Contacto</strong></td>
  <td colspan="3"><strong>E-mail</strong></td>
  <td colspan="2"><strong>Actividad</strong></td>
  <td colspan="1"><strong>Estado</strong></td>
</tr>
<tr> 
  <td colspan="2"><?php echo'<input name="Cargo" type="text" value="'.$row['Cargo'].'">';?></td>
  <td colspan="3"><?php echo'<input name="email" type="text" value="'.$row['Eml_clien'].'" onChange="TestMail(document.form1.email.value)" size="40">';?></td>
  <td colspan="2"><?php
      $qrya="select Id_cat_clien, desCatClien from clientes, cat_clien WHERE Id_cat_clien=idCatClien and Nit_clien='$nit';";
      $resulta=mysqli_query($link,$qrya);
      $rowa=mysqli_fetch_array($resulta); 			
      echo'<select name="Id_Cat">';
      $resultp=mysqli_query($link,"select idCatClien, desCatClien from cat_clien");
      echo '<option selected value='.$rowa['Id_cat_clien'].'>'.$rowa['Des_cat_cli'].'</option>';
      while($rowp=mysqli_fetch_array($resultp))
      {
        if ($rowp['Des_cat_cli']!= $rowa['Des_cat_cli'])
        echo '<option value='.$rowp['Id_cat_cli'].'>'.$rowp['Des_cat_cli'].'</option>';
      }
      echo'</select>';			
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
  <td colspan="2"><div align="center"><strong>Autoretenedor Iva</strong></div></td>
  <td colspan="2"><div align="center"><strong>Autoretenedor Ica</strong></div></td>
  <td colspan="1"><div align="center"><strong>Rete Fte</strong></div></td>
  <td colspan="3"><div align="center"><strong>Vendedor</strong></div></td>
  
</tr>
<tr> 
  <td align="center" colspan="2"><?php
      echo'<select name="Ret_iva">';
      if ($row['Ret_iva']==0)
      {
          echo '<option selected value='.$row['Ret_iva'].'>No</option>';
          echo '<option value="1">Si</option>';
          echo'</select>';			
      }
      if ($row['Ret_iva']==1)
      {
          echo '<option selected value='.$row['Ret_iva'].'>Si</option>';
          echo '<option value="0">No</option>';
          echo'</select>';			
      }
      ?></td>
  <td align="center" colspan="2"><?php
      echo'<select name="Ret_ica">';
      if ($row['Ret_ica']==0)
      {
          echo '<option selected value='.$row['Ret_ica'].'>No</option>';
          echo '<option value=1>Si</option>';
          echo'</select>';			
      }
      if ($row['Ret_ica']==1)
      {
          echo '<option selected value='.$row['Ret_ica'].'>Si</option>';
          echo '<option value=0>No</option>';
          echo'</select>';			
      }
      ?></td>
  <td align="center" colspan="1"><?php
      echo'<select name="Ret_fte">';
      if ($row['Ret_fte']==0)
      {
          echo '<option selected value='.$row['Ret_fte'].'>No</option>';
          echo '<option value=1>Si</option>';
          echo'</select>';			
      }
      if ($row['Ret_fte']==1)
      {
          echo '<option selected value='.$row['Ret_fte'].'>Si</option>';
          echo '<option value=0>No</option>';
          echo'</select>';			
      }
      ?></td>
  <td colspan="3"><div align="center">
    <?php
      $qrya="select Id_personal, nom_personal from personal, clientes where Id_personal=cod_vend and Nit_clien='$nit' ;";
      $resulta=mysqli_query($link,$qrya);
      $rowa=mysqli_fetch_array($resulta); 			
      echo'<select name="Id_vendor">';
      $resultp=mysqli_query($link,"select Id_personal, nom_personal from personal where activo=1;");
      echo '<option selected value='.$rowa['Id_personal'].'>'.$rowa['nom_personal'].'</option>';
      while($rowp=mysqli_fetch_array($resultp))
      {
        if ($rowp['Id_personal']!= $rowa['Id_personal'])
        echo '<option value='.$rowp['Id_personal'].'>'.$rowp['nom_personal'].'</option>';
      }
      echo'</select>';	
      mysqli_close($link);
      ?>
  </div></td>
  
</tr>
<tr> 
  <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
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
		echo '<input name="NIT" type="hidden" value="'.$nit.'"/><input name="Crear" type="hidden" value="0"/>
		<input type="submit" name="Submit" value="Adicionar o Cambiar Sucursales" />';
		echo'</form>';        
		//mover_pag2("Proveedor Creado correctamente");
		function mover_pag2($mensaje)
		{
			echo'<script >
			alert("'.$mensaje.'");
			document.formulario.submit();
			</script>';
		}
	?>
        </div></td>
    </tr>
	<tr>
        <th width="5%" align="center">Id</th>
      	<th width="28%" align="center">Nombre Sucursal</th>
   	  <th width="12%" align="center">Teléfono </th>
      	<th width="40%" align="center">Direccción Sucursal</th>
        <th width="15%" align="center">Ciudad Sucursal</th>
   </tr>
          <?php
			$link=conectarServidor();
			$qry="select Id_sucursal, Nom_sucursal, Tel_sucursal, Dir_sucursal, ciudad from clientes_sucursal, ciudades where Nit_clien='$nit' and Ciudad_sucursal=Id_ciudad order by Id_sucursal;";
			$result=mysqli_query($link,$qry);
			while($rowp=mysqli_fetch_array($result))
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
			mysqli_close($link);
			?>
  </table>
<div align="center"><input type="button" class="resaltado" onClick="history.back()" value="  VOLVER  "></div>
</div>
</body>
</html>
