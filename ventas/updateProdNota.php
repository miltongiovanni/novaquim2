<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Acualizaci&oacute;n</title>
</head>
<body>
<?php
foreach ($_POST as $nombre_campo => $valor) 
{ 
  $asignacion = "\$".$nombre_campo."='".$valor."';"; 
  echo $nombre_campo." = ".$valor."<br>";  
  eval($asignacion); 
}  
$link=conectarServidor();
//ESTO ES PARA MIRAR LA CANTIDAD DE PRODUCTO QUE TEN�A LA NOTA
$qrycanot="select Can_producto as CantNota from det_nota_c where Id_Nota=$nota and Cod_producto=$codigo;";
$resultcanot=mysqli_query($link,$qrycanot);
$row_canot=mysqli_fetch_array($resultcanot);
$CantNota=$row_canot['CantNota'];  
$cambio=$cantidad-$CantNota;
if($codigo <100000)
{	
 //SI ES PRODUCTO DE L�NEA
  $qrylot="SELECT Lote_producto as Lote from remision, det_remision, factura, nota_c 
  WHERE remision.Id_remision=det_remision.Id_remision AND factura.Id_remision=remision.Id_remision and Factura=Fac_orig and Cod_producto=$codigo and Nota=$nota;";
  $resultlot=mysqli_query($link,$qrylot);
  $row_lot=mysqli_fetch_array($resultlot);
  $lote=$row_lot['Lote'];  
  if ($lote==NULL)
	$lote=0;
  $qryinv="select Cod_prese, lote_prod, inv_prod from inv_prod where Cod_prese=$codigo and lote_prod=$lote";
  $resultinv=mysqli_query($link,$qryinv);
  $rowinv=mysqli_fetch_array($resultinv);
  $invt=$rowinv['inv_prod'];
  if ($invt==NULL)
  {
	$qryupt="insert into inv_prod (Cod_prese, lote_prod, inv_prod) values ($codigo, $lote, $cambio)";
  }
  else
  {
	$invt= $invt + $cambio;
	//SE ACTUALIZA EL INVENTARIO
	$qryupt="update inv_prod set inv_prod=$invt where lote_prod=$lote and Cod_prese=$codigo";
  }
  $resultupt=mysqli_query($link,$qryupt);
  //ACTUALIZACI�N DEL DETALLE DE LA NOTA DE CREDITOS
  $qryr="update det_nota_c set Can_producto=$cantidad where Id_Nota=$nota and Cod_producto=$codigo";
  $resultr=mysqli_query($link,$qryr);
  echo' <script language="Javascript">
		  alert("Actualizando producto fab en nota de credito");
		  </script>'; 
  echo'<form action="makeNota.php" method="post" name="formulario">';
  echo '<input name="nota" type="hidden" value="'.$nota.'"><input name="crear" type="hidden" value="5"><input type="submit" name="Submit" class="formatoBoton1" value="Cambiar" >';
  echo'</form>'; 
  echo' <script language="Javascript" type="text/javascript"> document.formulario.submit(); </script>';  
}
else
{
  	$qryinv="select Id_distribucion, inv_dist from inv_distribucion WHERE Id_distribucion=$codigo";
	$resultinv=mysqli_query($link,$qryinv);
	$rowinv=mysqli_fetch_array($resultinv);
	$invt=$rowinv['inv_dist'];
	if ($invt==NULL)
	{
	  $qryupt="insert into inv_distribucion (Id_distribucion, inv_dist) values ($codigo, $cantidad)";
	}
	else
	{
	  $invt= $invt + $cambio;
	  //SE ACTUALIZA EL INVENTARIO
	  $qryupt="update inv_distribucion set inv_dist=$invt where Id_distribucion=$codigo";
	}
	$resultupt=mysqli_query($link,$qryupt);
	//INSERCION DEL DETALLE DE LA NOTA DE CREDITOS
	$qryr="update det_nota_c set Can_producto=$cantidad where Id_Nota=$nota and Cod_producto=$codigo";
	$resultr=mysqli_query($link,$qryr);
	echo'<form action="makeNota.php" method="post" name="formulario">';
	echo '<input name="nota" type="hidden" value="'.$nota.'"><input name="crear" type="hidden" value="5"><input type="submit" name="Submit" value="Cambiar" >';
	echo'</form>'; 
	echo' <script language="Javascript" type="text/javascript"> document.formulario.submit(); </script>';
}
mysqli_close($link);
?>
</body>
</html>