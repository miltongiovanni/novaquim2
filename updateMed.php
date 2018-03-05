<?php
include "includes/valAcc.php";
?>
<?php
include "includes/MedObj.php";
include "includes/calcularDias.php";

foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
$link=conectarServidor();
$qryb="SELECT fabrica, distribuidor, detal, super, mayor from precios where codigo_ant=$IdCodAnt;";	
$resultb=mysqli_query($link,$qryb);
$rowb=mysqli_fetch_array($resultb);
$fabrica=$rowb['fabrica'];
$distribuidor=$rowb['distribuidor'];
$detal=$rowb['detal'];
$super=$rowb['super'];
$mayor=$rowb['mayor'];
mysqli_free_result($resultb);
mysqli_close($link);//Cerrar la conexion
$prodpres=new ProdPre();
if($result=$prodpres->updateMed($Cod_Present,$Present, $IdProducto, $IdMedida, $IdEnvase, $IdTapa, $IdCodAnt, $IdEtiq, $stock, $fabrica, $distribuidor, $detal, $mayor, $super, $IdIva, $Cotiza))
{
	$ruta="listarmed.php";
    mover_pag($ruta,"Presentación Actualizada correctamente");
}
else
{
	$ruta="buscarMed.php";
	mover_pag($ruta,"Error al Actualizar la Presentación del Producto");
}
function mover_pag($ruta,$Mensaje)
{
	echo'<script language="Javascript">
   	alert("'.$Mensaje.'")
   	self.location="'.$ruta.'"
   	</script>';
}
?>
