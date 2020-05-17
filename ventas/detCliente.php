<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Sucursales por Cliente</title>
<meta charset="utf-8">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="../js/validar.js"></script>
	<script  src="scripts/block.js"></script>
        <link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue2.css" title="blue">
    <script  src="scripts/calendar.js"></script>
    <script  src="scripts/calendar-sp.js"></script>
    <script  src="scripts/calendario.js"></script>
    	<script >
	document.onkeypress = stopRKey; 
	</script>
</head>
<body> 
<div id="contenedor">
<div id="saludo1"><strong>SUCURSALES POR CLIENTE</strong></div>
<?php
include "includes/conect.php";
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
if($Crear==0)
{
		/*echo '<form method="post" action="detProveedor.php" name="form3">';
		echo '<input name="NIT" type="hidden" value="'.$NIT.'"/>
		<input name="IdCat" type="hidden" value="'.$IdCat.'"/>
		<input name="Crear" type="hidden" value="1"/>
		<input type="submit" name="Submit" value="Cambiar" />';
		echo'<script >
			document.form3.submit();
			</script>';	*/
} 

if($Crear==1)
{
	$link=conectarServidor();   
	$qrybus="select MAX(Id_sucursal) AS Id from clientes_sucursal where Nit_clien='$NIT';";
	$resultbus=mysqli_query($link,$qrybus);
	$rowbus=mysqli_fetch_array($resultbus);
	$id=$rowbus['Id']+1;
	$qryins="insert into clientes_sucursal (Nit_clien, Nom_sucursal, Tel_sucursal, Dir_sucursal, Ciudad_sucursal, Id_sucursal) values ('$NIT', '$nom_sucursal', '$tel_sucursal','$dir_sucursal', '$ciudad_sucursal',$id)";
	$resultqryins=mysqli_query($link,$qryins);
	mysqli_close($link);
}
?>

  <table align="center" width="52%" summary="Encabezado">
    <?php
	  	$link=conectarServidor();
		$qry="select Nit_clien, Nom_clien from clientes where Nit_clien='$NIT';";
		$result=mysqli_query($link,$qry);
		$row=mysqli_fetch_array($result);
		mysqli_close($link);
	 ?>
     <tr><td width="13%">&nbsp;</td></tr>
    <tr>
      <td align="left"><strong>Cliente: </strong></td>
      <td width="59%" align="left"><?php echo  $row['Nom_clien']?></td>
      <td width="9%"><strong>NIT:</strong></td>
      <td width="19%"><?php echo  $row['Nit_clien']?></td>
    </tr>
    </table>
<form method="post" action="detCliente.php" name="form1">
<table align="center" summary="Detalle" width="52%">
    <tr>
      <td colspan="5"><div align="center"><strong>ADICIONAR SUCURSAL</strong></div></td>
    </tr>
    <tr>
      <td width="10%"><div align="right"><strong>Nombre</strong></div></td>
      <td colspan="3"><input type="text" name="nom_sucursal" size=60 id="Cliente" maxlength="60"></td>    
    </tr>
    <tr>
    	<td><div align="right"><b>Dirección</b></div></td>
        <td colspan="3"><input type="text"  maxlength="50" name="dir_sucursal" size=60 id="Direccion" ></td>
    </tr>
    <tr>
    <td><div align="right"><strong>Teléfono</strong></div></td>
        <td width="17%"><input type="text" name="tel_sucursal" maxlength="7" size=15 onKeyPress="return aceptaNum(event)" id="Tel1" ></td>
        <td width="11%"><div align="right"><b>Ciudad</b></div></td>
        <td width="43%"> 
			<?php
				$link=conectarServidor();
				echo'<select name="ciudad_sucursal">';
				$result=mysqli_query($link,"select Id_ciudad, ciudad from ciudades;");
				echo '<option selected value="">----------------------------</option>';
				while($row=mysqli_fetch_array($result)){
					echo '<option value='.$row['Id_ciudad'].'>'.$row['ciudad'].'</option>';
				}
				echo'</select>';
				mysqli_close($link);
	   		?>	  
       </td>
       <td width="19%" align="left"><input name="submit" type="submit" onClick="return Enviar(this.form)"  value="Continuar"><?php echo '<input name="NIT" type="hidden" value="'.$NIT.'"><input name="Crear" type="hidden" value="1">'; ?> </td>
    </tr>    
</table>
</form>
<p>&nbsp;

</p>
<table width="69%" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>	
  		<th width="6%" align="center"></th>
        <th width="6%" align="center">Id</th>
      	<th width="27%" align="center">Nombre Sucursal</th>
   	  	<th width="10%" align="center">Teléfono </th>
      	<th width="34%" align="center">Direccción Sucursal</th>
        <th width="12%" align="center">Ciudad</th>
        <th width="11%" align="center">&nbsp;</th>
   </tr>
          <?php
			$link=conectarServidor();
			$qry="select Id_sucursal, Nom_sucursal, Tel_sucursal, Dir_sucursal, ciudad from clientes_sucursal, ciudades where Nit_clien='$NIT' and Ciudad_sucursal=Id_ciudad order by Id_sucursal;";
			$result=mysqli_query($link,$qry);
			$a=1;
			while($row=mysqli_fetch_array($result))
			{
				$sucursal=$row['Id_sucursal'];
				$nom_sucursal=$row['Nom_sucursal'];
				$tel_sucursal=$row['Tel_sucursal'];
				$dir_sucursal=$row['Dir_sucursal'];
				$ciudad_sucursal=$row['ciudad'];
				echo'<tr>
				<td align="center" valign="middle">
				<form action="form_up_SucClien.php" method="post" name="actualiza">
					<input name="NIT" type="hidden" value="'.$NIT.'">
					<input name="Crear" type="hidden" value="0">
					<input name="Id_sucursal" type="hidden" value="'.$sucursal.'">
				 	<input type="submit" name="Submit" class="formatoBoton"  value="Modificar">
				</form>
				</td>
				<td';
				if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
				echo '><div align="center" class="formatoDatos">'.$sucursal.'</div></td>
				<td';
				if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
				echo '><div align="center" class="formatoDatos">'.$nom_sucursal.'</div></td>
				<td';
				if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
				echo '><div align="center" class="formatoDatos">'.$tel_sucursal.'</div></td>
				<td';
				if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
				echo '><div align="center" class="formatoDatos">'.$dir_sucursal.'</div></td>
				<td';
				if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
				echo '><div align="left" class="formatoDatos">'.$ciudad_sucursal.'</div></td>
				<td align="center" valign="middle">
				<form action="delSucClien.php" method="post" name="elimina">
					<input name="NIT" type="hidden" value="'.$NIT.'">
					<input name="Id_sucursal" type="hidden" value="'.$sucursal.'">
				 	<input type="submit" name="Submit" class="formatoBoton"  value="Eliminar">
				</form>
				</td>
				</tr>';
			}
			mysqli_close($link);
			?>
</table>
<table width="27%" border="0" align="center">
<tr> 
        <td><div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Terminar"></div></td>
    </tr>
</table> 
</div>
</body>
</html>