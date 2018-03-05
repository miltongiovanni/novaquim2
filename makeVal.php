<?php
include "includes/valAcc.php";
?>
<?php
	include "includes/ValObj.php";
	include "includes/calcularDias.php";
	$min_stock = $_POST['min_stock'];
	$nom_val = $_POST['tapa'];
	$link=conectarServidor();
	$sql="SELECT MAX(Cod_tapa) as Codigo FROM tapas_val";	
	$result=mysqli_query($link,$sql);
	$row= mysqli_fetch_row($result);
	$cod_val=$row[0]+1;
	$valvu=new valv();
	if($result=$valvu->crearVal($cod_val,$nom_val, $min_stock))
	{  
		$link=conectarServidor();
		$qryInv="insert into inv_tapas_val (Cod_tapa, inv_tapa) values ($cod_val, 0)";
		
		$resultInv=mysqli_query($link, $qryInv);
		//$perfil1=$_SESSION['Perfil'];
		$ruta="listarVal.php";
		/******LOG DE CREACION *********/
		//$IdUser=$_SESSION['IdUsuario'];
		//$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
		//$Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
		//$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','CREACION DE CATEGORIA')";
		//$ResutLog=mysql_db_query("users",$qryAcces);
		/*********FIN DEL LOG CREACION*****/
		//mysqli_free_result($resultInv);
/* cerrar la conexión */

		mover_pag($ruta,"Válvula o Tapa creada correctamente");
	}
	else
	{
		$ruta="crearVal.php";
		mysql_close($link);
		mover_pag($ruta,"Error al crear la Válvula o Tapa");
	}
	mysqli_free_result($result);
mysqli_close($link);
function mover_pag($ruta,$Mensaje){
echo'<script language="Javascript">
   alert("'.$Mensaje.'")
   self.location="'.$ruta.'"
   </script>';
}
?>