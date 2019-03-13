<?php
include "includes/valAcc.php";
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

/* disable autocommit */
mysqli_autocommit($link, FALSE);
$qry1="select Id_kit, Codigo, Cod_env from kit where Id_kit=$Cod_kit;";
$result1=mysqli_query($link,$qry1);
$row_1=mysqli_fetch_array($result1);
$Cod_env=$row_1['Cod_env'];
$Codigo=$row_1['Codigo'];

/*REVISAR SI HAY INVENTARIO SUFICIENTE PARA DESCARGAR*/
if ($Codigo >100000)
{
	$qry_bus="select inv_distribucion.Id_distribucion as Codigo, Producto, inv_dist as Inv from inv_distribucion, distribucion WHERE inv_distribucion.Id_distribucion=distribucion.Id_distribucion and inv_distribucion.Id_distribucion=$Codigo;";
}
else
{
	$qry_bus="select inv_prod.Cod_prese as Codigo, Nombre as Producto, sum(inv_prod) as Inv from inv_prod, prodpre where inv_prod.Cod_prese=$Codigo and inv_prod.Cod_prese=prodpre.Cod_prese GROUP by Codigo;";
}
$result_bus=mysqli_query($link,$qry_bus);
$row_bus=mysqli_fetch_array($result_bus);
$inv_bus=$row_bus['Inv'];
$cod_bus=$row_bus['Codigo'];
$prod_bus=$row_bus['Producto'];
if ($inv_bus < $Cantidad)
{
	mysqli_rollback($link);
	mysqli_close($link);
	echo'<script language="Javascript">
	alert("No hay suficiente inventario de '.$prod_bus.' sólo hay '.$inv_bus.' unidades")
	self.location="desarm_kits.php"
	</script>';
}
else
{
	  //SE INSERTA LA CANTIDAD DE KITS
	  if($Codigo <100000)
	  {
		  //PRODUCTOS DE LA EMPRESA
		  $qry_prod="select Cod_prese, max(lote_prod) as lote, inv_prod FROM inv_prod where Cod_prese=$Codigo";
		  $result_prod=mysqli_query($link,$qry_prod);
		  $row_prod=mysqli_fetch_array($result_prod);
		  if ($row_prod)
		  {
			$cod_prod=$row_prod['Cod_prese'];
			$lote_prod=$row_prod['lote'];
			$inv_prod=$row_prod['inv_prod'];
			$inv_prod=$inv_prod-$Cantidad;
			$qry_up_prod="update inv_prod set inv_prod=$inv_prod where Cod_prese=$Codigo and lote_prod=$lote_prod";
			$result_up_prod=mysqli_query($link,$qry_up_prod);
		  }
	  }
	  else
	  {
		  //PRODUCTOS DE DISTRIBUCION
		  $qry_dist="select Id_distribucion, inv_dist from inv_distribucion where Id_distribucion=$Codigo";
		  $result_dist=mysqli_query($link,$qry_dist);
		  $row_dist=mysqli_fetch_array($result_dist);
		  if ($row_dist)
		  {
			$cod_dist=$row_dist['Id_distribucion'];
			$inv_dist=$row_dist['inv_dist'];
			$inv_dist=$inv_dist-$Cantidad;
			$qry_up_dist="update inv_distribucion set inv_dist=$inv_dist where Id_distribucion=$Codigo";
			$result_up_dist=mysqli_query($link,$qry_up_dist);
		  }
	  }
}
//SE CARGA EL ENVASE
$qry_env="select inv_envase.Cod_envase, Nom_envase, inv_envase from inv_envase, envase WHERE inv_envase.Cod_envase=envase.Cod_envase and inv_envase.Cod_envase=$Cod_env";
$result_env=mysqli_query($link,$qry_env);
$row_env=mysqli_fetch_array($result_env);
$inv_env=$row_env['inv_envase'];
$cod_env=$row_env['Cod_envase'];
$envase=$row_env['Nom_envase'];
$inv_env=$inv_env + $Cantidad;
$qry_up_env="update inv_envase set inv_envase=$inv_env where Cod_envase=$cod_env";
$result_up_env=mysqli_query($link,$qry_up_env);

if ($Codigo >100000)
{
  //REVISA UNO POR UNO CADA UNO DE LOS COMPONENTES
  $qry2="select Id_kit, Cod_producto from det_kit where Id_kit=$Cod_kit;";
  $result2=mysqli_query($link,$qry2);
  while($row2=mysqli_fetch_array($result2))
  {
	$cod_producto=$row2['Cod_producto'];
	/*CARGA DEL INVENTARIO*/
	$qryinv="select inv_distribucion.Id_distribucion, Producto, inv_dist from inv_distribucion, distribucion WHERE inv_distribucion.Id_distribucion=distribucion.Id_distribucion and inv_distribucion.Id_distribucion=$cod_producto;";
	$resultinv=mysqli_query($link,$qryinv);
	$rowinv=mysqli_fetch_array($resultinv);	
	$invt=$rowinv['inv_dist'];
	$cod_prod=$rowinv['Id_distribucion'];
	$prod_dist=$rowinv['Producto'];
	$invt= $invt + $Cantidad;
	$qryupt="update inv_distribucion set inv_dist=$invt where Id_distribucion=$cod_prod";
	$resultupt=mysqli_query($link,$qryupt);
  }
}
else
{
	//REVISA UNO POR UNO CADA UNO DE LOS COMPONENTES
	$qry2="select Id_kit, Cod_producto from det_kit where Id_kit=$Cod_kit;";
	$result2=mysqli_query($link,$qry2);
	while($row2=mysqli_fetch_array($result2))
	{
		$cod_producto=$row2['Cod_producto'];
	  	if($cod_producto <100000)
	  	{	
		  $qrylot="select max(lote_prod) as lote from inv_prod where Cod_prese=$cod_producto";
		  $resultlot=mysqli_query($link,$qrylot);
		  $rowlot=mysqli_fetch_array($resultlot);
		  $lote=$rowlot['lote'];
		  $qryinvt="select inv_prod.Cod_prese, Nombre, inv_prod as Inv, lote_prod as lote from inv_prod, prodpre where inv_prod.Cod_prese=$cod_producto and inv_prod >0 and inv_prod.Cod_prese=prodpre.Cod_prese and lote_prod=$lote";
		  $resultinvt=mysqli_query($link,$qryinvt);
		  $rowinv1=mysqli_fetch_array($resultinvt);
		  $inventario=$rowinv1['Inv'];
		  $prod_nova=$rowinv1['Nombre'];
		  $invt= $inventario + $Cantidad;
		  /*SE ACTUALIZA EL INVENTARIO*/
		  $qryupt="update inv_prod set inv_prod=$invt where lote_prod=$lote and Cod_prese=$cod_producto";
		  $resultupt=mysqli_query($link,$qryupt);
		}
	    else
	    {
		  $qryinv="select inv_distribucion.Id_distribucion, Producto, inv_dist from inv_distribucion, distribucion WHERE inv_distribucion.Id_distribucion=distribucion.Id_distribucion and inv_distribucion.Id_distribucion=$cod_producto;";
		  $resultinv=mysqli_query($link,$qryinv);
		  $rowinv=mysqli_fetch_array($resultinv);	
		  $invt=$rowinv['inv_dist'];
		  $cod_prod=$rowinv['Id_distribucion'];
		  $prod_dist=$rowinv['Producto'];
		  $invt= $invt + $Cantidad;
		  $qryupt="update inv_distribucion set inv_dist=$invt where Id_distribucion=$cod_prod";
		  $resultupt=mysqli_query($link,$qryupt);
		}
	}
}  
	//SE CARGA A LA TABLA
	$qryins_kit="insert into desarm_kit (Cod_kit, Cantidad, Fecha_desarm) values ($Cod_kit, $Cantidad, '$Fecha')";
	$resultins_prod=mysqli_query($link,$qryins_kit);
	//SE REALIZA EL COMMIT 
	mysqli_commit($link);
	mysqli_autocommit($link, TRUE);
	mysqli_close($link);
	echo'<script language="Javascript">
	alert("Kit desarmados con éxito")
	self.location="listar_desarm_kits.php"
	</script>';
?>