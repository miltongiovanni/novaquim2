<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Porcentaje de Materias Primas en la F&oacute;rmula</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<script  src="scripts/validar.js"></script>
<script  src="scripts/block.js"></script>
	<script >
	document.onkeypress = stopRKey; 
	</script>

</head>
<body> 


<?php
include "includes/conect.php";
foreach ($_POST as $nombre_campo => $valor) 
{ 
$asignacion = "\$".$nombre_campo."='".$valor."';"; 
//echo $nombre_campo." = ".$valor."<br>";  
eval($asignacion); 
}  
if($CrearFormula==0)
{
   $link=conectarServidor();   
   $bd="novaquim";   
   /*CREACION DE LA FORMULACION*/
   $qryForm="insert into formula_col (Cod_sol_col) values ($cod_sol)";
   if($resultfact=mysqli_query($link,$qryForm))
   {
		$qry="select max(Id_form_col) as Form from formula_col";
		$result=mysqli_query($link,$qry);
		$row=mysqli_fetch_array($result);
		$Formula=$row['Form'];
		echo '<form method="post" action="detFormula_Col.php" name="form3">';
		echo'<input name="CrearFormula" type="hidden" value="5">'; 
		echo'<input name="Formula" type="hidden" value="'.$Formula.'">'; 
		echo '</form>';
		echo'<script >
		document.form3.submit();
		</script>';	
		mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
	}
	else
	{
		mover_pag("formula_col.php","Error al ingresar la Formulación");
		mysqli_close($link);
	}
} 
function mover_pag($ruta,$nota)
{	
	//Funcion que permite el redireccionamiento de los usuarios a otra pagina 
	echo' <script >
	alert("'.$nota.'")
	self.location="'.$ruta.'"
	</script>';
}
if($CrearFormula==1)
{
 	//AGREGANDO LOS COMPONENTES DE LA FORMULACIÓN
	$percent=$percent/100;
	$link=conectarServidor();   
	$qryFact="insert into det_formula_col (Id_formula_color, Cod_mprima, porcentaje) values ($Formula, $cod_mprima, $percent)";
	$resultfact=mysqli_query($link,$qryFact);
	$qry="select sum(porcentaje) as Total from det_formula_col where Id_formula_color=$Formula;";
	$result=mysqli_query($link,$qry);
	$row=mysql_fetch_array($result);
	$Total=$row['Total'];
	mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
} 
if($CrearFormula==2)
{
 	//AGREGANDO LOS COMPONENTES DE LA FORMULACIÓN
	$link=conectarServidor();   
	$qry="select sum(porcentaje) as Total from det_formula_col where Id_formula_color=$Formula;";
	$result=mysqli_query($link,$qry);
	$row=mysql_fetch_array($result);
	$Total=$row['Total'];
	mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
} 
?>
 <?php
	  	$link=conectarServidor();
	  	$qry="SELECT Cod_sol_col, Nom_mprima as solucion from formula_col, mprimas WHERE Cod_sol_col=Cod_mprima AND Id_form_col=$Formula";
		$result=mysqli_query($link,$qry);
		$row=mysqli_fetch_array($result);
		mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
	 ?>  
<div id="contenedor">
<div id="saludo1"><strong>INGRESO DEL DETALLE DE F&Oacute;RMULA DE
<?php echo  strtoupper ($row['solucion']);?>
</strong></div>
<form method="post" action="detFormula_Col.php" name="form1">
<table  align="center" border="0" summary="encabezado"> 
    <tr>
      <td width="90">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td class="formatoDatos"><div align="center"><strong>Materia Prima</strong></div></td>
      <td width="94" class="formatoDatos"><div align="center"><strong>% en F&oacute;rmula</strong></div></td>
    </tr>
    <tr>
      <td><div align="center">
        <?php

			$link=conectarServidor();
			echo'<select name="cod_mprima">';
			$result=mysqli_query($link,"select Tabla.Cod_mprima, Nom_mprima from (select Cod_mprima, Nom_mprima from mprimas WHERE Nom_mprima like 'Color %' or Cod_mprima=406) as Tabla LEFT join det_formula_col on Tabla.Cod_mprima=det_formula_col.Cod_mprima and Id_formula_color=$Formula 
WHERE det_formula_col.Cod_mprima is NULL;");
            while($row=mysqli_fetch_array($result))
			{
				echo '<option value='.$row['Cod_mprima'].'>'.$row['Nom_mprima'].'</option>';
            }
            echo'</select>';
			mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
		?>      
      </div></td>
      <td><div align="center"><input name="percent" type="text" size=8 onKeyPress="return aceptaNum(event)"></div></td>
      <td width="105" align="right"><input name="submit" onClick="return Enviar(this.form)" type="submit"  value="Continuar">
          <input name="CrearFormula" type="hidden" value="1">
          <?php echo'<input name="Formula" type="hidden" value="'.$Formula.'">'; ?> </td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
</table>
</form>
<table border="0" align="center" cellspacing="0" summary="detalle">
  <tr>
        <th width="61" class="formatoDatos">&nbsp;</th>
        <th width="253" align="center" class="formatoDatos">Materia Prima</th>
        <th width="71" align="center" class="formatoDatos">Porcentaje</th>
        <th width="6" class="formatoDatos">&nbsp;</th>
    </tr>
<?php
$link=conectarServidor();
$qry="select det_formula_col.Cod_mprima as codigo, Nom_mprima, porcentaje from mprimas, det_formula_col 
where Id_formula_color=$Formula and det_formula_col.Cod_mprima=mprimas.Cod_mprima";
$result=mysqli_query($link,$qry);
$n=0;
while($row=mysqli_fetch_array($result))
{
	$n++;
	$codmp=$row['codigo'];
	$mprima=$row['Nom_mprima'];
	$percent=$row['porcentaje'];
	echo'<tr>
			
				<td align="center" ><form action="updateFormula_col.php" method="post" name="actualiza"><input type="submit" name="Submit" value="Cambiar" class="formatoBoton">
				<input name="IdForm" type="hidden" value="'.$Formula.'">
				<input name="mprima" type="hidden" value="'.$codmp.'">
				<input name="percent" type="hidden" value="'.$percent.'">
			</form></td>
		<td class="formatoDatos"><div align="center">'.$row['Nom_mprima'].'</div></td>
		<td class="formatoDatos"><div align="center">'.$row['porcentaje']*(100).' %</div></td>
		
		<td align="center"><form action="delmapForm_col.php" method="post" name="elimina"><input type="submit" name="Submit" value="Eliminar" class="formatoBoton">
				<input name="IdForm" type="hidden" value="'.$Formula.'">
				<input name="mprima" type="hidden" value="'.$codmp.'">
				<input name="percent" type="hidden" value="'.$percent.'">
			</form></td>
	</tr>';
}
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
?>
    <tr>
      	<td colspan="3" class="formatoDatos"><div align="right"><strong>Total</strong></div></td>
        <td align="center" class="formatoDatos"><?php echo  $Total*(100).' %'; ?></td><td>&nbsp;</td>
    </tr>
</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Terminar"></div>
</div>
</body>
</html>