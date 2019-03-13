<?php
include "includes/valAcc.php";
?>
<?php
include "includes/MPObj.php";
include "includes/calcularDias.php";
$cod_cat_mp=$_POST['IdCatMP'];                 
$cod_mp=$_POST['Cod_mp'];
$mprima=$_POST['mprimas'];
$min_stock=$_POST['stock'];
$tasa_iva= $_POST['tasa_iva'];

$mpri= new mprim();
if($result=$mpri->updateMP($cod_mp,$mprima, $cod_cat_mp, $min_stock, $tasa_iva))
{
	$qryinv="update inv_mprimas set Nom_mprima='$mprima' where Cod_mprima=$cod_mp";
    $link=conectarServidor();
    $result=mysqli_query($link,$qryinv);
	$ruta="listarMP.php";
    mover_pag($ruta,"Materia Prima actualizada correctamente");
}
else
{
	$ruta="buscarMP.php";
	mover_pag($ruta,"Error al actualizar la Materia Prima");
}
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
function mover_pag($ruta,$Mensaje)
{
	echo'<script language="Javascript">
   	alert("'.$Mensaje.'")
   	self.location="'.$ruta.'"
   	</script>';
}
?>
