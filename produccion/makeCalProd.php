<?php
include "includes/valAcc.php";
include "includes/conect.php";
?>
<?php
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
$link=conectarServidor();
$qry="insert into cal_producto (Lote, den_prod, ph_prod, ol_prod,col_prod, ap_prod, Obs_prod) values ($Lote, $den_prod, $pH, $ol_prod, $col_prod, $ap_prod, '$obs_prod')";
echo $qry;
$result=mysqli_query($link,$qry);
mysqli_close($link);
if($result)
{  
	$link=conectarServidor();
	$qryInv="update ord_prod set Estado='C' where Lote=$Lote";
	$resultInv=mysqli_query($link,$qryInv);
	//$perfil1=$_SESSION['Perfil'];
	$ruta="menu.php";
	/******LOG DE CREACION *********/
	//$IdUser=$_SESSION['IdUsuario'];
	//$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
    //$Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
	//$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','CREACION DE CATEGORIA')";
	//$ResutLog=mysql_db_query("users",$qryAcces);
	/*********FIN DEL LOG CREACION*****/
	echo'<form action="det_cal_produccion.php" method="post" name="formulario">';
	echo '<input name="Lote" type="hidden" value="'.$Lote.'"/>
	<input type="submit" name="Submit" value="Cambiar" />';
	echo'</form>';
	function mover_pag($ruta,$nota)
	{
	echo'<script language="Javascript">
	document.formulario.submit();
	</script>';
	}
	mysqli_close($link);
	mover_pag("Control de Calidad cargado correctamente");
}
else{
        $ruta="buscar_lote.php";
		$Mensaje="Error al ingresar el Control de Calidad";
		echo'<script language="Javascript">
   alert("'.$Mensaje.'")
   self.location="'.$ruta.'"
   </script>';

     }


?>




