<?php
include "includes/valAcc.php";
?>
<?php
include "includes/ValObj.php";
include "includes/calcularDias.php";             
$cod_val=$_POST['Codigo'];
$nom_val=$_POST['nombre'];
$min_stock=$_POST['stock'];
$valvu= new valv();
if($result=$valvu->updateVal($cod_val,$nom_val, $min_stock))
{
	$ruta="listarVal.php";
    mover_pag($ruta,"Tapa o Válvula actualizada correctamente");
}
else
{
	$ruta="buscarVal.php";
	mover_pag($ruta,"Error al actualizar la Tapa o Válvula");
}
function mover_pag($ruta,$Mensaje)
{
	echo'<script language="Javascript">
   	alert("'.$Mensaje.'")
   	self.location="'.$ruta.'"
   	</script>';
}
?>
