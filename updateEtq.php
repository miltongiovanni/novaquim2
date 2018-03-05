<?php
include "includes/valAcc.php";
?>
<?php
include "includes/EtqObj.php";
include "includes/calcularDias.php";             
$cod_etq=$_POST['Codigo'];
$nom_etq=$_POST['nombre'];
$min_stock=$_POST['stock'];
$etiqu= new etiq();
if($result=$etiqu->updateEtq($cod_etq, $nom_etq, $min_stock))
{
	$qryinv="update inv_etiquetas set Nom_etiq='$nom_etq' where Cod_etiq=$cod_etq";
    $link=conectarServidor();
    $result=mysqli_query($link,$qryinv);
//mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
	$ruta="listarEtq.php";
    mover_pag($ruta,"Etiqueta actualizada correctamente");
}
else
{
	$ruta="buscarEtq.php";
	mover_pag($ruta,"Error al actualizar la Etiqueta");
}
function mover_pag($ruta,$Mensaje)
{
	echo'<script language="Javascript">
   	alert("'.$Mensaje.'")
   	self.location="'.$ruta.'"
   	</script>';
}
?>
