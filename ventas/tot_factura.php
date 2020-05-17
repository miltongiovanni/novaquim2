<?php
include "../includes/valAcc.php";
?>
<?php
include "includes/conect.php";
foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  
$bd="novaquim";
$link=conectarServidor();

$qryf="select Factura, Nit_cliente, Nom_clien, Ret_iva, Ret_ica, Ret_fte from factura, clientes where Factura=$factura and Nit_cliente=Nit_clien ;";
$resultf=mysql_db_query($bd,$qryf);
$rowf=mysql_fetch_array($resultf);
$reten_iva=$rowf['Ret_iva'];
$reten_ica=$rowf['Ret_ica'];
$reten_fte=$rowf['Ret_fte'];
if ($reten_iva==1)
	$reteiva=round(($iva10 + $iva16)*0.5);
else
	$reteiva=0;
if ($reten_ica==1)
	$reteica=round($subtotal*0.01104);
else
	$reteica=0;
if (($subtotal >= 642000)||($reten_fte==1))
	$retefuente=round($subtotal*0.035);
else
	$retefuente=0;
$total= $subtotal-$descuento+$iva10+$iva16;
$sql="update factura 
	SET Total=round($total),
	Subtotal=round($subtotal),
	IVA=round($iva10 + $iva16),
	Reten_iva=round($reteiva),
	Reten_ica=round($reteica),
	Reten_fte=round($retefuente)
	where Factura=$factura;";	
$result=mysql_db_query($bd,$sql);
if($result)
{  
	$ruta="menu.php";
	$sqlup="update Pedido SET Estado='F' where Id_pedido=(select Id_pedido from factura where Factura=$factura);";
	$resultup=mysql_db_query($bd,$sqlup);
	mysql_close($link);
   	mover_pag($ruta,"Factura creada correctamente");
}
else
{
    $ruta="menu.php";
	mysql_close($link);
    mover_pag($ruta,"Error al crear la Factura");
}


?>




