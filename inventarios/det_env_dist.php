<?php
include "includes/valAcc.php";
?>
<?php
	include "includes/conect.php";
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  
	//Envasado
	$link=conectarServidor();   
/* disable autocommit */
mysqli_autocommit($link, FALSE);
	//ESTA PARTE ES PARA EL CONSECUTIVO DE LA TABLA
	$Id=1;
	$qrylot="select max(Id_env_dist) as Id from det_env_dist";
	$resultlot=mysqli_query($link,$qrylot);
	$rowlot=mysqli_fetch_array($resultlot);
	if ($rowlot)
		$Orden=1+$rowlot['Id'];		
	else 
		$Orden=$Id;
	//SE INSERTA LA CANTIDAD DE PRODUCTO DE DISTRIBUCION ENVASADO
	$qryins="insert into det_env_dist (Id_env_dist, Fch_env_dist, Cod_dist, Cantidad) values ($Orden, '$Fecha', $IdDist, $Cantidad)";
	$resultins=mysqli_query($link,$qryins);
	//SE CARGA EN EL INVENTARIO
	$qry_dist="select Id_distribucion, inv_dist from inv_distribucion where Id_distribucion=$IdDist;";
	$result_dist=mysqli_query($link,$qry_dist);
	$row_dist=mysqli_fetch_array($result_dist);
	if ($row_dist['inv_dist'])
	{
		$inv_dist=$row_dist['inv_dist']+$Cantidad;
		$qry_up_dist="update inv_distribucion set inv_dist=$inv_dist where Id_distribucion=$IdDist";
		$result_up_env=mysqli_query($link,$qry_up_dist);
	}
	else
	{	
		$qryins_dist="insert into inv_distribucion (Id_distribucion, inv_dist) values ($IdDist, $Cantidad)";
		$resultins_prod=mysqli_query($link,$qryins_dist);
	}
	//SE DESCUENTA EL ENVASE
	$qry_env="select * from inv_envase where Cod_envase = (select Cod_envase from rel_dist_mp where Cod_dist=$IdDist)";
	$result_env=mysqli_query($link,$qry_env);
	$row_env=mysqli_fetch_array($result_env);
	$inv_env=$row_env['inv_envase'];
	$cod_env=$row_env['Cod_envase'];
	if ($inv_env >= $Cantidad)
	{
		$inv_env=$inv_env - $Cantidad;
		$qry_up_env="update inv_envase set inv_envase=$inv_env where Cod_envase=$cod_env";
		$result_up_env=mysqli_query($link,$qry_up_env);
	}
	else
	{
		mysqli_rollback($link);
		mysqli_close($link);
		echo' <script >
			alert("No hay envase suficiente solo hay '.$inv_env.' unidades");
			self.location="env_dist.php";
		</script>';
	}
	//SE DESCUENTA LA TAPA
	$qry_val="select * from inv_tapas_val where Cod_tapa = (select Cod_tapa from rel_dist_mp where Cod_dist=$IdDist)";
	$result_val=mysqli_query($link,$qry_val);
	$row_val=mysqli_fetch_array($result_val);
	$inv_val=$row_val['inv_tapa'];
	$cod_val=$row_val['Cod_tapa'];
	if ($inv_val >= $Cantidad)
	{
		$inv_val=$inv_val - $Cantidad;
		$qry_up_val="update inv_tapas_val set inv_tapa=$inv_val where Cod_tapa=$cod_val";
		$result_up_val=mysqli_query($link,$qry_up_val);
	}
	else
	{
		mysqli_rollback($link);
		mysqli_close($link); 
		echo' <script >
			alert("No hay tapas o válvulas suficientes, sólo hay '.$inv_val.' unidades");
			self.location="env_dist.php";
		</script>';
	}
	//SE DESCUENTA EL INVENTARIO DE MATERIA PRIMA
	$qry_mp="select Cod_dist, cant_medida, Cod_envase, Cod_tapa, Densidad, Codigo_mp 
	from rel_dist_mp, env_dist, medida where Cod_MP=Id_env_dist and Cod_dist=$IdDist AND Cod_umedid=Id_medida;";
	$result_mp=mysqli_query($link,$qry_mp);
	$row_mp=mysqli_fetch_array($result_mp);
	$uso=$row_mp['cant_medida']*$Cantidad*$row_mp['Densidad']/1000;
	$Codigo_mp=$row_mp['Codigo_mp'];
	$qry_inv="select Cod_mprima, Lote_mp, sum(inv_mp) as Inventario from inv_mprimas WHERE Cod_mprima=$Codigo_mp group by Cod_mprima;";
	$result_inv=mysqli_query($link,$qry_inv);
	$row_inv=mysqli_fetch_array($result_inv);
	$inv_mp=$row_inv['Inventario'];
	if ($inv_mp >= $uso)
	{
		$qry_inv2="select Cod_mprima, Lote_mp, inv_mp from inv_mprimas WHERE Cod_mprima=$Codigo_mp;";
		$result_inv2=mysqli_query($link,$qry_inv2);
		$uso1=$uso;
		while($rowinv2=mysqli_fetch_array($result_inv2))
		{
			$invt=$rowinv2['inv_mp'];
			$lot_mp=$rowinv2['Lote_mp'];
			$cod_mp=$rowinv2['Cod_mprima'];
			if ($invt >= $uso1)
			{
				$invt= $invt - $uso1;
				$qryupt="update inv_mprimas set inv_mp=$invt where Lote_mp='$lot_mp' and Cod_mprima=$cod_mp";
				$resultupt=mysqli_query($link,$qryupt);
				break;
			}
			else
			{
				$uso1= $uso1 - $invt ;
				$qryupt="update inv_mprimas set inv_mp=0 where Lote_mp='$lot_mp' and Cod_mprima=$cod_mp";
				$resultupt=mysqli_query($link,$qryupt);
			}
		}
	}
	else
	{
		mysqli_rollback($link);
		mysqli_close($link);
		echo' <script >
			alert("No hay Materia Prima suficiente, sólo hay '.$inv_mp.' Kilogramos");
			self.location="env_dist.php";
		</script>';
	}
	//SE REALIZA EL COMMIT 
	mysqli_commit($link);
	mysqli_autocommit($link, TRUE);
	mysqli_close($link);
	echo'<script >
		alert("Productos Cargados correctamente");
		self.location="menu.php";
		</script>';		
?>

