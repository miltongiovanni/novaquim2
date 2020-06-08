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
// $Cod_kit,  $Cantidad, $Fecha
//Envasado
$link=conectarServidor();   
//COMIENZA LA TRANSACCIÓN


/* disable autocommit */
mysqli_autocommit($link, FALSE);

$qry1="select Id_kit, Codigo, Cod_env from kit where Id_kit=$Cod_kit;";
$result1=mysqli_query($link,$qry1);
$row_1=mysqli_fetch_array($result1);
$Cod_env=$row_1['Cod_env'];
$Codigo=$row_1['Codigo'];
//SE DESCUENTA EL ENVASE
$qry_env="select invEnvase.Cod_envase, Nom_envase, invEnvase from inv_envase, envase WHERE inv_envase.codEnvase=envase.Cod_envase and inv_envase.codEnvase=$Cod_env";
$result_env=mysqli_query($link,$qry_env);
$row_env=mysqli_fetch_array($result_env);
$inv_env=$row_env['inv_envase'];
$cod_env=$row_env['Cod_envase'];
$envase=$row_env['Nom_envase'];
if ($inv_env >= $Cantidad)
{
	$inv_env=$inv_env - $Cantidad;
	$qry_up_env="update inv_envase set invEnvase=$inv_env where codEnvase=$cod_env";
	$result_up_env=mysqli_query($link,$qry_up_env);
}
else
{
	mysqli_rollback($link);
	mysqli_close($link);
	echo'<script >
	alert("No hay inventario suficiente de '.$envase.', solo hay '.$inv_env.' unidades")
	self.location="arm_kits.php"
	</script>';
}

//REVISA UNO POR UNO CADA UNO DE LOS COMPONENTES
$qry2="select Id_kit, Cod_producto from det_kit where Id_kit=$Cod_kit;";
$result2=mysqli_query($link,$qry2);
while($row2=mysqli_fetch_array($result2))
{
	$cod_producto=$row2['Cod_producto'];
	/*DESCARGA DEL INVENTARIO*/
	$unidades=$Cantidad;
	$i=1;
	if($cod_producto <100000)
	{	
		$qryinvt="select inv_prod.codPresentacion, Nombre, sum(invProd) as Inv from inv_prod, prodpre where inv_prod.codPresentacion=$cod_producto and invProd >0 and inv_prod.codPresentacion=prodpre.Cod_prese GROUP by codPresentacion;";
		$resultinvt=mysqli_query($link,$qryinvt);
		$rowinv1=mysqli_fetch_array($resultinvt);
		$inventario=$rowinv1['Inv'];
		$prod_nova=$rowinv1['Nombre'];
		if ($inventario >= $unidades)
		{
		  $qryinv="select codPresentacion, loteProd, invProd from inv_prod where codPresentacion=$cod_producto and invProd >0 order by loteProd;";
		  $resultinv=mysqli_query($link,$qryinv);
		  while($rowinv=mysqli_fetch_array($resultinv))
		  {
			  $invt=$rowinv['inv_prod'];
			  $i=$i+1;
			  $lot_prod=$rowinv['lote_prod'];
			  $cod_prod=$rowinv['Cod_prese'];
			  if (($invt >= $unidades))
			  {
				  $invt= $invt - $unidades;
				  /*SE ACTUALIZA EL INVENTARIO*/
				  $qryupt="update inv_prod set invProd=$invt where loteProd=$lot_prod and codPresentacion=$cod_prod";
				  $resultupt=mysqli_query($link,$qryupt);
			  }
			  else
			  {
				  $unidades= $unidades - $invt ;
				  $resultins_p=mysqli_query($link,$qryins_p);
				  /*SE ACTUALIZA EL INVENTARIO*/
				  $qryupt="update inv_prod set invProd=0 where loteProd=$lot_prod and codPresentacion=$cod_prod";
				  $resultupt=mysqli_query($link,$qryupt);	
			  }
		  }
		}
		else
		{
			mysqli_rollback($link);
			mysqli_close($link);
			echo'<script >
			alert("No hay suficiente inventario de '.$prod_nova.' sólo hay '.$inventario.' unidades")
			self.location="arm_kits.php"
			</script>';
		}
	}
	else
	{
		$qryinv="select inv_distribucion.codDistribucion, Producto, invDistribucion from inv_distribucion, distribucion 
		WHERE inv_distribucion.codDistribucion=distribucion.Id_distribucion and inv_distribucion.codDistribucion=$cod_producto;";
		$resultinv=mysqli_query($link,$qryinv);
		$unidades=$Cantidad;
		$rowinv=mysqli_fetch_array($resultinv);	
		$invt=$rowinv['inv_dist'];
		$cod_prod=$rowinv['Id_distribucion'];
		$prod_dist=$rowinv['Producto'];
		if ($invt >= $unidades)
		{
			$invt= $invt - $unidades;
			$qryupt="update inv_distribucion set invDistribucion=$invt where codDistribucion=$cod_prod";
			$resultupt=mysqli_query($link,$qryupt);
		}
		else
		{
			mysqli_rollback($link);
			mysqli_close($link);
			echo'<script >
			alert("No hay suficiente inventario de '.$prod_dist.' sólo hay '.$invt.' unidades")
			self.location="arm_kits.php"
			</script>';
		}
	}
}  //TODO BIEN HASTA AHORA
	//SE INSERTA LA CANTIDAD DE KITS
	if($Codigo <100000)
	{
		//PRODUCTOS DE LA EMPRESA
		$qry_prod="select codPresentacion, loteProd, invProd FROM inv_prod where codPresentacion=$Codigo";
		$result_prod=mysqli_query($link,$qry_prod);
		$row_prod=mysqli_fetch_array($result_prod);
		if ($row_prod)
		{
		  $cod_prod=$row_prod['Cod_prese'];
		  $lote_prod=$row_prod['lote_prod'];
		  $inv_prod=$row_prod['inv_prod'];
		  $inv_prod=$inv_prod+$Cantidad;
		  $qry_up_prod="update inv_prod set invProd=$inv_prod where codPresentacion=$Codigo and loteProd=$lote_prod";
		  $result_up_prod=mysqli_query($link,$qry_up_prod);
		}
		else
		{
			$qryins="insert into inv_prod (codPresentacion, loteProd, invProd) values ($Codigo, 0, $Cantidad)";
			$resultins=mysqli_query($link,$qryins);
		}
	}
	else
	{
		//PRODUCTOS DE DISTRIBUCION
		$qry_dist="select codDistribucion, invDistribucion from inv_distribucion where codDistribucion=$Codigo";
		$result_dist=mysqli_query($link,$qry_dist);
		$row_dist=mysqli_fetch_array($result_dist);
		if ($row_dist)
		{
		  $cod_dist=$row_dist['Id_distribucion'];
		  $inv_dist=$row_dist['inv_dist'];
		  $inv_dist=$inv_dist+$Cantidad;
		  $qry_up_dist="update inv_distribucion set invDistribucion=$inv_dist where codDistribucion=$Codigo";
		  $result_up_dist=mysqli_query($link,$qry_up_dist);
		}
		else
		{
			$qryins="insert into inv_distribucion (codDistribucion, invDistribucion) values ($Codigo, $Cantidad)";
			$resultins=mysqli_query($link,$qryins);
		}
	}
	//SE CARGA A LA TABLA
	$qryins_kit="insert into arm_kit (Cod_kit, Cantidad, Fecha_arm) values ($Cod_kit, $Cantidad, '$Fecha')";
	$resultins_prod=mysqli_query($link,$qryins_kit);
	//SE REALIZA EL COMMIT 
	mysqli_commit($link);
	mysqli_autocommit($link, TRUE);
	mysqli_close($link);
	echo'<script >
	alert("Kit Creados y Cargados con Éxito")
	self.location="listar_arm_kits.php"
	</script>';
?>