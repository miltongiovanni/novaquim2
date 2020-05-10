<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
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
  //echo $nombre_campo." = ".$valor."<br>";  
  eval($asignacion); 
}  
$link=conectarServidor();   
$error=0;
//COMIENZA LA TRANSACCIÓN
mysqli_autocommit($link, FALSE);
//ESTA PARTE ES PARA EL CONSECUTIVO DEL LOTE
$lotinic=1;
$qrylot="select max(Lote_mp) as Orden from ord_prod_mp";
$resultlot=mysqli_query($link,$qrylot);
$rowlot=mysqli_fetch_array($resultlot);
if ($rowlot)
	$Orden=1+$rowlot['Orden'];		
else 
	$Orden=$lotinic;
$qrymp="select Cod_mp from formula_mp where Id_form_mp=$fmprima;";
$resultmp=mysqli_query($link,$qrymp);
$rowmp=mysqli_fetch_array($resultmp);	
$cod_matp=$rowmp['Cod_mp'];
/*CREACIÓN DE LA ORDEN DE PRODUCCIÓN*/
$qryOP="insert into ord_prod_mp (Lote_mp, Fch_prod, Id_form_mp, Cod_persona, Cod_mprima, Cant_kg) values ($Orden,'$FchProd', $fmprima, $IdResp, $cod_matp, $can_prod)";
//echo $qryOP;
if($resultOP=mysqli_query($link,$qryOP))
{
	//AQUI SELECCIONA LA ORDEN QUE SE CREO ANTES
	$qry="select max(Lote_mp) as Batch from ord_prod_mp";
	$result=mysqli_query($link,$qry);
	$row=mysqli_fetch_array($result);
	$Lote=$row['Batch'];
	//CON BASE EN LA FORMULA SE ANALIZA EL GASTO DE MATERIA PRIMA
	$qrydet="SELECT * FROM det_formula_mp where Id_formula_mp=$fmprima;";
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
			mysqli_rollback($link);
			mysqli_close($link);
			mover("o_produccion_MP.php","No hay inventario suficiente de ".$materia." solo hay ".$exist." Kg");
		}
		else
		{
			$uso1=$uso;
			$qryinv="SELECT inv_mprimas.codMP as Codigo, Nom_mprima as 'Materia Prima', loteMP as 'Lote MP', fechLote as 'Fecha Lote', invMP as Inventario
					FROM inv_mprimas, mprimas
					WHERE inv_mprimas.codMP=mprimas.Cod_mprima AND inv_mprimas.codMP=$cod_mprima order by fechLote;";
			//echo $qryinv.'<br>';
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
					
					$qryDOP="insert into det_ord_prod_mp (Lote_mprima, Id_mprima, Can_mprima, Lote_MP) values ($Lote, $cod_mprima, $uso1, '$lot_mp')";
					//echo $qryDOP;
					$resultDOP=mysqli_query($link,$qryDOP);
					break;
				}
				else
				{
					$uso1= $uso1 - $invt ;
					$qryupt="update inv_mprimas set invMP=0 where loteMP='$lot_mp' and codMP=$cod_mp";
					$resultupt=mysqli_query($link,$qryupt);
					if ($invt>0)
					{
						$qryDOP="insert into det_ord_prod_mp (Lote_mprima, Id_mprima, Can_mprima, Lote_MP) values ($Lote, $cod_mprima, $invt, '$lot_mp')";
						$resultDOP=mysqli_query($link,$qryDOP);
					}
						
					
				}
			}
		}
	}
	echo'<form action="detO_Prod_MP.php" method="post" name="formulario">';
	echo '<input name="Lote" type="hidden" value="'.$Lote.'"><input type="submit" name="Submit" value="Cambiar" >';
	echo'</form>';
	$qryinsol="insert into inv_mprimas (loteMP, codMP, invMP, fechLote) values ($Orden, $cod_matp, $can_prod, '$FchProd')";
	echo "<br><br><br><br><br><br><br><br><br>";
	$resultinsol=mysqli_query($link,$qryinsol);
	mysqli_commit($link);
	mysqli_autocommit($link, TRUE);
	mysqli_close($link);
	mover_pag("detO_Prod_MP.php","Orden de Producción Creada correctamente");
}
else
{
	mover_pag("o_prod_MP.php","Error al ingresar la Orden de Producción");
}

function mover_pag($ruta,$mensaje)
{	
	//Funcion que permite el envio del formulario 
	echo' <script >
	document.formulario.submit();
	</script>';
} 

function mover($ruta,$mensaje)
{
	//Funcion que permite el redireccionamiento de los usuarios a otra pagina 
	echo'<script >
	alert("'.$mensaje.'")
	self.location="'.$ruta.'"
	</script>';
}
?>

</body>
</html>
