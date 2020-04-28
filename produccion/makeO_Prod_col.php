<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ingreso de Compra de Materia Prima</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script  src="scripts/validar.js"></script>
    <script  src="scripts/block.js"></script>
    	<script >
	document.onkeypress = stopRKey; 
	</script>
</head>
<body> 
<div align="center"><img src="images/LogoNova1.JPG"/></div>
<?php
//ESTOS SON LOS DATOS QUE RECIBE DE LA ORDEN DE PRODUCCIÓN
include "includes/conect.php";
foreach ($_POST as $nombre_campo => $valor) 
{ 
  $asignacion = "\$".$nombre_campo."='".$valor."';"; 
  echo $nombre_campo." = ".$valor."<br>";  
  eval($asignacion); 
}  
$link=conectarServidor();   
$error=0;
/* disable autocommit */
mysqli_autocommit($link, FALSE);

//ESTA PARTE ES PARA EL CONSECUTIVO DEL LOTE
$lotinic=1;
$qrylot="select max(Lote_color) as Orden from ord_prod_col";
$resultlot=mysqli_query($link,$qrylot);
$rowlot=mysqli_fetch_array($resultlot);
if ($rowlot)
	$Orden=1+$rowlot['Orden'];		
else 
	$Orden=$lotinic;
$qrycol="select Cod_sol_col from formula_col where Id_form_col=$fcolor;";
$resultcol=mysqli_query($link,$qrycol);
$rowcol=mysqli_fetch_array($resultcol);	
$cod_prod=$rowcol['Cod_sol_col'];
/*CREACIÓN DE LA ORDEN DE PRODUCCIÓN*/
$qryOP="insert into ord_prod_col (Lote_color, Fch_prod, Id_form_color, Cod_persona, Cod_color, Cant_kg) values ($Orden,'$FchProd', $fcolor, $IdResp, $cod_prod, $can_prod)";
if($resultOP=mysqli_query($link,$qryOP))
{
	//AQUI SELECCIONA LA ORDEN QUE SE CREO ANTES
	$qry="select max(Lote_color) as Batch from ord_prod_col";
	$result=mysqli_query($link,$qry);
	$row=mysqli_fetch_array($result);
	$Lote=$row['Batch'];
	//CON BASE EN LA FORMULA SE ANALIZA EL GASTO DE MATERIA PRIMA
	$qrydet="SELECT * FROM det_formula_col where Id_formula_color=$fcolor;";
	$resultdet=mysqli_query($link,$qrydet);
	while($rowdet=mysqli_fetch_array($resultdet))
	{
		$uso=$can_prod*$rowdet['porcentaje'];
		$cod_mprima=$rowdet['Cod_mprima'];
		if ($cod_mprima==406)
		{
			$uso=$uso*1.015;
		}		
		$qryexist="SELECT inv_mprimas.codMP as Codigo, Nom_mprima as 'Materia Prima', SUM(invMP) as Existencias
				   FROM inv_mprimas, mprimas
				   WHERE inv_mprimas.codMP=mprimas.Cod_mprima AND inv_mprimas.codMP=$cod_mprima
				   group BY inv_mprimas.codMP;";
		$resultexist=mysqli_query($link,$qryexist);
		$rowexist=mysqli_fetch_array($resultexist);
		$exist=$rowexist['Existencias'];
		$materia=$rowexist['Materia Prima'];
		//echo 'materia prima '.$materia.' cantidad '.$exist. ' uso '.$uso. '<br>';

		if ($exist < $uso)
		{
			//SI NO HAY EXISTENCIAS DE MATERIA PRIMA SE CANCELA LA TRANSACCIÓN
				/* Rollback */
			mysqli_rollback($link);
			mysqli_close($link);
			mover("o_produccion_color.php","No hay inventario suficiente de ".$materia." hay ".$exist." Kg");
		}
		else
		{
			$uso1=$uso;
			$qryinv="SELECT inv_mprimas.codMP as Codigo, Nom_mprima as 'Materia Prima', loteMP as 'Lote MP', fechLote as 'Fecha Lote', invMP as Inventario
					FROM inv_mprimas, mprimas
					WHERE inv_mprimas.codMP=mprimas.Cod_mprima AND inv_mprimas.codMP=$cod_mprima order by fechLote;";
			echo $qryinv.'<br>';
			$resultinv=mysqli_query($link,$qryinv);
			while($rowinv=mysqli_fetch_array($resultinv))
			{
				$invt=$rowinv['Inventario'];
				$lot_mp=$rowinv['Lote MP'];
				$cod_mp=$rowinv['Codigo'];
				if ($invt >= $uso1)
				{
					$invt= $invt - $uso1;
					$qryupt="update inv_mprimas set invMP=$invt where loteMP='$lot_mp' and codMP=$cod_mp";
					//echo $qryupt;
					$resultupt=mysqli_query($link,$qryupt);
					$qryDOP="insert into det_ord_prod_col (Lote, Cod_mprima, Can_mprima, Lote_MP) values ($Lote, $cod_mprima, $uso1, '$lot_mp')";
					//echo $qryDOP;
					$resultDOP=mysqli_query($link,$qryDOP);
					break;
				}
				else
				{
					$uso1= $uso1 - $invt ;
					$qryupt="update inv_mprimas set invMP=0 where loteMP='$lot_mp' and codMP=$cod_mp";
					$resultupt=mysqli_query($link,$qryupt);
					if ($invt>0){
						$qryDOP="insert into det_ord_prod_col (Lote, Cod_mprima, Can_mprima, Lote_MP) values ($Lote, $cod_mprima, $invt, '$lot_mp')";}
						echo $qryDOP;
					$resultDOP=mysqli_query($link,$qryDOP);
				}
			}
		}
	}
	echo'<form action="detO_Prod_col.php" method="post" name="formulario">';
	echo '<input name="Lote" type="hidden" value="'.$Lote.'"><input type="submit" name="Submit" value="Cambiar" >';
	echo'</form>';
	$qryinsol="insert into inv_mprimas (loteMP, codMP, invMP, fechLote) values ($Orden, $cod_prod, $can_prod, '$FchProd')";
	//echo $qryDOP;
	$resultinsol=mysqli_query($link,$qryinsol);
	mysqli_commit($link);
	mysqli_autocommit($link, TRUE); 
	mysqli_close($link);
	mover_pag("detO_Prod_col.php","Orden de Producción Creada correctamente");
}
else
{
	mover_pag("o_produccion_col.php","Error al ingresar la Orden de Producción");
}

function mover_pag($ruta,$nota)
{	
	//Funcion que permite el envio del formulario 
	echo' <script >
	document.formulario.submit();
	</script>';
} 

function mover($ruta,$nota)
{
	//Funcion que permite el redireccionamiento de los usuarios a otra pagina 
	echo'<script >
	alert("'.$nota.'")
	self.location="'.$ruta.'"
	</script>';
}
?>

</body>
</html>
