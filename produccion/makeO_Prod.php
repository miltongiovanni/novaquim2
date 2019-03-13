<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ingreso de Compra de Materia Prima</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="scripts/validar.js"></script>
    <script type="text/javascript" src="scripts/block.js"></script>
    	<script type="text/javascript">
	document.onkeypress = stopRKey; 
	</script>
</head>
<body> 
<div align="center"><img src="images/LogoNova1.JPG"/></div>
<p></p>
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


/* disable autocommit */
mysqli_autocommit($link, FALSE);


//ESTA PARTE ES PARA EL CONSECUTIVO DEL LOTE
$lotinic=1;
$qrylot="select max(Lote) as Orden from ord_prod";
$resultlot=mysqli_query($link,$qrylot);
$rowlot=mysqli_fetch_array($resultlot);
if ($rowlot)
	$Orden=1+$rowlot['Orden'];		
else 
	$Orden=$lotinic;
	
	
/*CREACIÓN DE LA ORDEN DE PRODUCCIÓN*/
$qryOP="insert into ord_prod (Lote, Fch_prod, Id_form, Cod_persona, Cod_prod, Cant_kg) values ($Orden,'$FchProd', $IdForm, $IdResp, $cod_prod, $can_prod)";
if($resultOP=mysqli_query($link,$qryOP))
{
	
	//AQUI SELECCIONA LA ORDEN QUE SE CREO ANTES
	$qry="select max(Lote) as Batch from ord_prod";
	$result=mysqli_query($link,$qry);
	$row=mysqli_fetch_array($result);
	$Lote=$row['Batch'];
	//CON BASE EN LA FORMULA SE ANALIZA EL GASTO DE MATERIA PRIMA
	$qrydet="SELECT * FROM det_formula where Id_formula=$IdForm;";
	$resultdet=mysqli_query($link,$qrydet);
	while($rowdet=mysqli_fetch_array($resultdet))
	{
		$uso=$can_prod*$rowdet['porcentaje'];
		$cod_mprima=$rowdet['Cod_mprima'];
		$orden=$rowdet['Orden'];
		if ($cod_mprima==406)
		{
			$uso=$uso*1.015;
		}		
		$qryexist="SELECT inv_mprimas.Cod_mprima as Codigo, Nom_mprima as 'Materia Prima', SUM(inv_mp) as Existencias
				   FROM inv_mprimas, mprimas
				   WHERE inv_mprimas.Cod_mprima=mprimas.Cod_mprima AND inv_mprimas.Cod_mprima=$cod_mprima
				   group BY inv_mprimas.Cod_mprima;";
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
			mover("o_produccion.php","No hay inventario suficiente de ".$materia." hay ".$exist." Kg");
		}
		else
		{
			$uso1=$uso;
			$qryinv="SELECT inv_mprimas.Cod_mprima as Codigo, Nom_mprima as 'Materia Prima', Lote_mp as 'Lote MP', Fecha_lote as 'Fecha Lote', inv_mp as Inventario
					FROM inv_mprimas, mprimas
					WHERE inv_mprimas.Cod_mprima=mprimas.Cod_mprima AND inv_mprimas.Cod_mprima=$cod_mprima order by Fecha_lote;";
			$resultinv=mysqli_query($link,$qryinv);
			while($rowinv=mysqli_fetch_array($resultinv))
			{
				$invt=$rowinv['Inventario'];
				$lot_mp=$rowinv['Lote MP'];
				$cod_mp=$rowinv['Codigo'];
				if ($invt >= $uso1)
				{
					$invt= $invt - $uso1;
					$qryupt="update inv_mprimas set inv_mp=$invt where Lote_mp='$lot_mp' and Cod_mprima=$cod_mp";
					//echo $qryupt;
					$resultupt=mysqli_query($link,$qryupt);
					$qryDOP="insert into det_ord_prod (Lote, Cod_mprima, Can_mprima, Lote_MP, Orden) values ($Lote, $cod_mprima, $uso1, '$lot_mp', $orden)";
					//echo $qryDOP;
					$resultDOP=mysqli_query($link,$qryDOP);
					break;
				}
				else
				{
					$uso1= $uso1 - $invt ;
					$qryupt="update inv_mprimas set inv_mp=0 where Lote_mp='$lot_mp' and Cod_mprima=$cod_mp";
					$resultupt=mysqli_query($link,$qryupt);
					if ($invt>0)
					{
						$qryDOP="insert into det_ord_prod (Lote, Cod_mprima, Can_mprima, Lote_MP, Orden) values ($Lote, $cod_mprima, $invt, '$lot_mp', $orden)";
						$resultDOP=mysqli_query($link,$qryDOP);
					}
					
	
				}
			}
		}
	}
	echo'<form action="detO_Prod.php" method="post" name="formulario">';
	echo '<input name="Lote" type="hidden" value="'.$Lote.'"/><input type="submit" name="Submit" value="Cambiar" />';
	echo'</form>';
	mysqli_commit($link);
	mysqli_autocommit($link, TRUE);
	mysqli_close($link);
	mover_pag("detO_Prod.php","Orden de Producción Creada correctamente");
}
else
{
	mover_pag("o_produccion.php","Error al ingresar la Orden de Producción");
}

function mover_pag($ruta,$nota)
{	
	//Funcion que permite el envio del formulario 
	echo' <script language="Javascript">
	document.formulario.submit();
	</script>';
} 

function mover($ruta,$nota)
{
	//Funcion que permite el redireccionamiento de los usuarios a otra pagina 
	echo'<script language="Javascript">
	alert("'.$nota.'")
	self.location="'.$ruta.'"
	</script>';
}
?>

</body>
</html>
