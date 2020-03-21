<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Relación de Pacas de Productos de Distribución</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>
    <link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue2.css" title="blue" />
    <script type="text/javascript" src="scripts/calendar.js"></script>
    <script type="text/javascript" src="scripts/calendar-sp.js"></script>
    <script type="text/javascript" src="scripts/calendario.js"></script>
    	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>

</head>
<body> 
<div id="contenedor">
<div id="saludo"><strong>RELACIÓN DE PACAS CON PRODUCTOS DE DISTRIBUCIÓN</strong></div>
<?php
	include "includes/conect.php";
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  
	 
	
	if($Crear==1)
	{
		$link=conectarServidor(); 
		//REVISA QUE NO ESTE INCLUIDO CON ANTERIORIDAD LA RELACIÓN
		$qrybus="SELECT Cod_paca from rel_dist_emp where Cod_paca=$cod_paca;";
		$resultqrybus=mysqli_query($link,$qrybus);
		$row_bus=mysqli_fetch_array($resultqrybus);
		if ($row_bus['Cod_paca']==$cod_paca)
		{
			echo' <script language="Javascript">
				alert("Relación incluida anteriormente");
				self.location="crearDes.php"
			</script>'; 
		}
		//INSERTANDO LA RELACIÓN
		$qryins="insert rel_dist_emp (Cod_paca, Cod_unidad, Cantidad) values ($cod_paca, $cod_unidad, $Unidades)";
		$resultins=mysqli_query($link,$qryins);
		echo '<form method="post" action="crearDes2.php" name="form3">';
		echo'<input name="Crear" type="hidden" value="5">'; 
		echo'<input name="cod_paca" type="hidden" value="'.$cod_paca.'">'; 
		echo'<input name="cod_unidad" type="hidden" value="'.$cod_unidad.'">'; 
		echo '</form>';
		echo'<script language="Javascript">
			document.form3.submit();
			</script>';	
			mysqli_free_result($resultqrybus);
/* cerrar la conexión */
mysqli_close($link);
	}

 ?>
<table  align="center" border="0">
    <?php
    	$link=conectarServidor();
		if($Crear==0)
		{		
			$qry1="select Id_distribucion, Producto from distribucion where Id_distribucion=$cod_paca;";
			
			$result1=mysqli_query($link,$qry1);
			$row1=mysqli_fetch_array($result1);
			echo '<form method="post" action="crearDes2.php" name="form1">
			<tr> 
				<td align="left" ><strong>Producto Empacado:</strong></td>
				<td align="left"><input name="Producto" type="text" value="'.$row1['Producto'].'" readOnly size="54"></td>
    		</tr>
			<tr>
			<td ><div align="left"><strong>Producto por Unidad:</strong></div></td>
			<td ><div align="left">';
			echo'<select name="cod_unidad">';
			$result=mysqli_query($link,"select Id_distribucion, Producto from distribucion order by Producto;");
			while($row=mysqli_fetch_array($result))
			{
				echo '<option value='.$row['Id_distribucion'].'>'.$row['Producto'].'</option>';
			}
			echo '</select>';
			echo '</div></td></tr>
			<tr>
				<td><div align="left"><strong>Unidades por Empaque:</strong></div></td>
				<td><input name="Unidades" type="text" size="54" onKeyPress="return aceptaNum(event)"></td>
			</tr>
			<tr>';
			echo '<td colspan="2" align="center"><input type="button" onclick="return Enviar(this.form)" value="Continuar"></td>';
			echo '<input name="Crear" type="hidden" value="1">'; 
			echo '<input name="cod_paca" type="hidden" value="'.$cod_paca.'"></tr></form>';
				mysqli_free_result($result1);
				mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
		}
	?>
    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
</table>
<table width="45%" border="0" align="center">
          <?php
			
			if($Crear==5)
			{		
			$link=conectarServidor();
			echo '<tr><td colspan="2" class="titulo3" >Paca : </td> </tr> 
 			<tr> <td colspan="4" ><hr /></td> </tr> 
          	<tr>
            <th width="17%"><strong>C&oacute;digo</strong></th>
            <th width="52%"><strong>Producto </strong></th>
            <th width="18%"><strong> </strong></th>
            <th width="13%"></th>
  			</tr>
  			<tr> <td  colspan="4" class="font2" ><hr /></td> </tr>';
			$qry3="select Cod_paca, Producto from rel_dist_emp, distribucion where Cod_paca=Id_distribucion and Cod_paca=$cod_paca;";
			$result3=mysqli_query($link,$qry3);
			$row3=mysqli_fetch_array($result3);
			echo'<tr>';
			echo '<td ><div align="center">'.$row3['Cod_paca'].'</div></td>
			  	  <td ><div align="center">'.$row3['Producto'].'</div></td>
				  <td ><div align="center"></div></td>
			      <td align="center" valign="middle" class="font2">';
			echo '</td></tr>';
			$qry4="select Cod_unidad, Cantidad, Producto from rel_dist_emp, distribucion where Cod_unidad=Id_distribucion and Cod_unidad=$cod_unidad and Cod_paca=$cod_paca;";
			$result4=mysqli_query($link,$qry4);
			$row4=mysqli_fetch_array($result4);
			echo '<tr>
    			<td colspan="2" class="titulo3" >Unidades por Paca : </td>    
  			</tr> 
  			<tr> <td  colspan="4" ><hr /></td> </tr>
			<tr>
            <th width="15%" ><strong>C&oacute;digo</strong></th>
            <th width="77%" ><strong>Producto </strong></th>
            <th width="77%" ><strong>Cantidad </strong></th>
            <th width="8%" ></th>
  			</tr>';
			
			echo'<tr>';
			echo '</td>
				  <td ><div align="center">'.$row4['Cod_unidad'].'</div></td>
				  <td ><div align="center">'.$row4['Producto'].'</div></td>
				  <td ><div align="center">'.$row4['Cantidad'].'</div></td>
				  <td align="center" valign="middle" >';
			/*echo '<form action="crearDes2.php" method="post" name="elimina">
			<input type="submit" class="formatoBoton" name="Submit" value="Eliminar" />
			<input name="cod_paca" type="hidden" value="'.$cod_paca.'"/>
			<input name="cod_unidad" type="hidden" value="'.$cod_unidad.'"/>
			<input name="Crear" type="hidden" value="0"/>
			</form>'; PENDIENTE REVISAR LA OPCION DE ELIMINAR*/
			echo '</td></tr>';
			mysqli_free_result($result3);
			mysqli_free_result($result4);
/* cerrar la conexión */
mysqli_close($link);
			}
			?>           
<tr><td ></td> </tr>
</table>
<table width="27%" border="0" align="center">
    <tr> 
        <td><div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú;">
        </div></td>
    </tr>
</table> 
</div>
</body>
</html>
	   