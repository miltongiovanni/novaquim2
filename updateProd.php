<?php
include "includes/valAcc.php";
?>
<?php
include "includes/ProdObj.php";
include "includes/calcularDias.php";
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  



$prod= new produ();
if($result=$prod->updateProd($Cod_prod, $Producto, $IdCat, $cuenta, $prod_act, $den_min, $den_max, $ph_min, $ph_max, $fragancia, $color, $Apariencia ))
{
	$ruta="listarProd.php";
    mover_pag($ruta,"Producto actualizado correctamente");
}
else
{
	$ruta="buscarProd.php";
	mover_pag($ruta,"Error al actualizar el Producto");
}
function mover_pag($ruta,$Mensaje)
{
	echo'<script language="Javascript">
   	alert("'.$Mensaje.'")
   	self.location="'.$ruta.'"
   	</script>';
}
?>
