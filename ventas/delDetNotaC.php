<?php
include "../includes/valAcc.php";
include "includes/conect.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Acualización</title>
</head>
<body>
<?php
foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
} 
$link=conectarServidor(); 

if($codigo <100000)
{	
 //SI ES PRODUCTO DE LÍNEA
  $qrylot= "SELECT loteProducto as Lote from remision, det_remision, factura, nota_c 
  WHERE remision.idRemision=det_remision.idRemision AND factura.idRemision=remision.idRemision and idFactura=facturaOrigen and codProducto=$codigo and idNotaC=$mensaje;";
  $resultlot=mysqli_query($link,$qrylot);
  $row_lot=mysqli_fetch_array($resultlot);
  $lote=$row_lot['Lote'];  
  if ($lote==NULL)
	$lote=0;
  $qryinv="select codPresentacion, lote_prod, inv_prod from inv_prod where codPresentacion=$codigo and lote_prod=$lote";
  $resultinv=mysqli_query($link,$qryinv);
  $rowinv=mysqli_fetch_array($resultinv);
  $invt=$rowinv['inv_prod'];
  if ($invt==NULL)
  {
	$qryupt="insert into inv_prod (codPresentacion, lote_prod, inv_prod) values ($codigo, $lote, $cantidad)";
  }
  else
  {
	$invt= $invt - $cantidad;
	//SE ACTUALIZA EL INVENTARIO
	$qryupt="update inv_prod set invProd=$invt where loteProd=$lote and Cod_prese=$codigo";
  }
  $resultupt=mysqli_query($link,$qryupt);
}
else
{
  	$qryinv="select Id_distribucion, invDistribucion from inv_distribucion WHERE Id_distribucion=$codigo";
	$resultinv=mysqli_query($link,$qryinv);
	$rowinv=mysqli_fetch_array($resultinv);
	$invt=$rowinv['inv_dist'];
	if ($invt==NULL)
	{
	  $qryupt="insert into inv_distribucion (Id_distribucion, invDistribucion) values ($codigo, $cantidad)";
	}
	else
	{
	  $invt= $invt + $cantidad;
	  //SE ACTUALIZA EL INVENTARIO
	  $qryupt="update inv_distribucion set invDistribucion=$invt where Id_distribucion=$codigo";
	}
	$resultupt=mysqli_query($link,$qryupt);
}
//ACTUALIZACIÓN DEL DETALLE DE LA NOTA DE CREDITOS
  $qryr="delete from det_nota_c where idNotaC=$mensaje and codProducto=$codigo;";
  $resultr=mysqli_query($link,$qryr);
  echo' <script >
		  alert("Borrado producto de la nota de credito");
		  </script>'; 
  echo'<form action="makeNota.php" method="post" name="formulario">';
  echo '<input name="nota" type="hidden" value="'.$mensaje.'"><input name="crear" type="hidden" value="5"><input type="submit" name="Submit" class="formatoBoton1" value="Cambiar" >';
  echo'</form>'; 
  echo' <script  > document.formulario.submit(); </script>';
	
	
	
	
	
mysqli_close($link);
?>
</body>
</html>