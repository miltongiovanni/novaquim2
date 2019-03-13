<?php
include "includes/valAcc.php";
?>
<?php
include "includes/DisObj.php";
include "includes/calcularDias.php";
foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	} 




$bd="novaquim";

if ($cod_iva==1)
	$cuenta=41353803;
if ($cod_iva==2)
	$cuenta=41353802;
if ($cod_iva==3)
	$cuenta=41353801;
if ($cod_iva==5)
	$cuenta=41353802;
         
$prodd= new distri();
if($result=$prodd->updateDis($Id_prod, $producto, $cod_iva, $cat_dist, $cuenta, $cotiza, $precio_vta, $Activo, $stock_dis))
{
	$qryinv="update inv_distribucion set Producto='$producto' where Id_distribucion=$Id_prod";
    $link=conectarServidor();
    $result=mysqli_query($link,$qryinv);
    mysqli_close($link);//Cerrar la conexion
	$ruta="listarDis.php";
    mover_pag($ruta,"Producto de Distribución actualizado correctamente");
}
else
{
	$ruta="buscarDis.php";
	mover_pag($ruta,"Error al actualizar el Producto de Distribución");
}
function mover_pag($ruta,$Mensaje)
{
	echo'<script language="Javascript">
   	alert("'.$Mensaje.'")
   	self.location="'.$ruta.'"
   	</script>';
}
?>
