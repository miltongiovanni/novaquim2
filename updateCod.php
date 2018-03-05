<?php
include "includes/valAcc.php";
?>
<?php
include "includes/CodObj.php";
include "includes/calcularDias.php";
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
$distribuidor= (round($fabrica*2*1.12,-2))/2;
$detal= (round($fabrica*2*1.4,-2))/2;
$mayor= (round($distribuidor*2*0.93,-2))/2;
$super= (round($fabrica*2*0.93,-2))/2;
$cod=$Cod_prod;
$mod=$cod%100;
$cod=(($cod-$mod)/100);
$codig= new codi();
if($result=$codig->updateCod($Cod_prod, $Producto, $fabrica, $distribuidor, $detal, $mayor, $super, $pres_activa, $pres_lista))
{
	$ruta="listarCod.php";
    mover_pag($ruta,"Producto actualizado correctamente");
}
else
{
	$ruta="buscarCod.php";
	mover_pag($ruta,"Error al actualizar el Producto");
}
function mover_pag($ruta,$Mensaje)
{
	echo'<script language="Javascript">
   	
   	self.location="'.$ruta.'"
	alert("'.$Mensaje.'")
   	</script>';
}
?>
