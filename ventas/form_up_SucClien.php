<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Modificar Sucursal </title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>
        <link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue2.css" title="blue">
    <script type="text/javascript" src="scripts/calendar.js"></script>
    <script type="text/javascript" src="scripts/calendar-sp.js"></script>
    <script type="text/javascript" src="scripts/calendario.js"></script>
    	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body> 
<div id="contenedor">
<div id="saludo1"><strong>ACTUALIZACI&Oacute;N DE SUCURSAL POR CLIENTE</strong></div>
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
		$qrys="select Nom_sucursal, Tel_sucursal, Dir_sucursal, Ciudad_sucursal, ciudad from clientes_sucursal, ciudades where Nit_clien='$NIT' and Id_sucursal=$Id_sucursal and Ciudad_sucursal=Id_ciudad;";
		$results=mysqli_query($link,$qrys);
		$rows=mysqli_fetch_array($results);
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
<form method="post" action="update_sucursal.php" name="form1">
<table align="center" summary="Detalle" width="52%">
 	<tr>
        <td align="center" colspan="4">&nbsp; </td>
    </tr>
    <tr>
      <td colspan="5"><div align="center"><strong>MODIFICAR SUCURSAL</strong></div></td>
    </tr>
     <tr>
        <td align="center" colspan="4">&nbsp; </td>
    </tr>
    <tr>
      <td width="10%"><div align="right"><strong>Nombre</strong></div></td>
      <td colspan="3"><input type="text" name="nom_sucursal" size=60 id="Cliente" maxlength="60" value="<?php echo  $rows['Nom_sucursal']?>"></td>    
    </tr>
    <tr>
    	<td><div align="right"><b>Direcci&oacute;n</b></div></td>
        <td colspan="3"><input type="text"  maxlength="50" name="dir_sucursal" size=60 id="Direccion" value="<?php echo  $rows['Dir_sucursal']?>"></td>
    </tr>
    <tr>
    <td><div align="right"><strong>Tel&eacute;fono</strong></div></td>
        <td width="17%"><input type="text" name="tel_sucursal" maxlength="10" size=15 onKeyPress="return aceptaNum(event)" id="Tel1" value="<?php echo  $rows['Tel_sucursal']?>"></td>
        <td width="11%"><div align="right"><b>Ciudad</b></div></td>
        <td width="43%"> 
			<?php
				$link=conectarServidor();
				echo'<select name="ciudad_sucursal">';
				$result=mysqli_query($link,"select Id_ciudad, ciudad from ciudades;");
				echo '<option selected value="'.$rows['Ciudad_sucursal'].'">'.$rows['ciudad'].'</option>';
				while($row=mysqli_fetch_array($result))
				{
					if ($row['Id_ciudad']<>$rows['Ciudad_sucursal'])
					echo '<option value='.$row['Id_ciudad'].'>'.$row['ciudad'].'</option>';
				}
				echo'</select>';
				mysqli_close($link);
	   		?>	  
       </td>
    </tr>
    <tr>
        <td align="center" colspan="4">&nbsp; </td>
    </tr>
    <tr>
    	<td align="center" colspan="4"><input name="submit" type="submit" onClick="return Enviar(this.form)"  value="Actualizar"><?php echo '<input name="NIT" type="hidden" value="'.$NIT.'">'; echo '<input name="Id_Sucursal" type="hidden" value="'.$Id_sucursal.'">'; ?> </td>
    </tr>
</table>
</form>
</div>
</body>
</html>