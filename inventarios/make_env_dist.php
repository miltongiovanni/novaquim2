<?php
include "../includes/valAcc.php";
include "includes/conect.php";
?>
<?php
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
$link=conectarServidor();
$qry="insert into rel_dist_mp (Cod_MP, Cod_umedid, Cod_envase, Cod_tapa, Cod_dist) values ($Cod_MP, $IdMedida, $IdEnvase, $IdTapa, $Cod_dist)";
$result=mysqli_query($link,$qry);
mysqli_close($link);
if($result)
{  
	$link=conectarServidor();
	$qryInv="insert into inv_envase (codEnvase, Nom_envase) values ($cod_env,'$nom_env')";
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
	mysqli_close($link);
    mover_pag($ruta,"Relación Envase de Producto de Distribución creada con éxito");
}
else{
        $ruta="rel_env_dist.php";
        mover_pag($ruta,"Error al crear el Envase");
     }



?>




