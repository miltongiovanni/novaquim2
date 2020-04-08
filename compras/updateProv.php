<?php
include "includes/valAcc.php";
?>
<?php
include "includes/provObj.php";
include "includes/calcularDias.php";

foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
$bd="novaquim";
$prov1=new Prover();
if($result=$prov1->updateProv($nit, $proveedor, $direccion, $contacto, $tel1, $fax, $email, $Id_Cat, $Auto_ret, $Tasa_reteica, $regimen))
{
	$ruta="listarProv.php";
    mover_pag($ruta,"Proveedor Actualizado correctamente");
}
else
{
	$ruta="buscarProv.php";
	mover_pag($ruta,"Error al Actualizar el Proveedor");
}
function mover_pag($ruta,$Mensaje)
{
	echo'<script >
   	alert("'.$Mensaje.'")
   	self.location="'.$ruta.'"
   	</script>';
}
?>
