<?php
include "includes/valAcc.php";
?>
<?php
include "includes/EnvObj.php";
include "includes/calcularDias.php";
$min_stock = $_POST['min_stock'];
$nom_env = $_POST['envase'];
$bd="novaquim";

$link=conectarServidor();
$sql="SELECT MAX(Cod_envase) as Codigo FROM envase";	
$result=mysqli_query($link,$sql);
$row= mysqli_fetch_row($result);
$cod_env=$row[0]+1;

$enva=new envas();
if($result=$enva->crearEnv($cod_env,$nom_env, $min_stock))
{  
	$link=conectarServidor();
	$qryInv="insert into inv_envase (Cod_envase, Nom_envase) values ($cod_env,'$nom_env')";
	$resultInv=mysqli_query($link,$qryInv);
	//$perfil1=$_SESSION['Perfil'];
	$ruta="listarEnv.php";
	/******LOG DE CREACION *********/
	//$IdUser=$_SESSION['IdUsuario'];
	//$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
    //$Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
	//$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','CREACION DE CATEGORIA')";
	//$ResutLog=mysql_db_query("users",$qryAcces);
	/*********FIN DEL LOG CREACION*****/

mysqli_free_result($resultInv);
/* cerrar la conexión */

    mover_pag($ruta,"Envase creado correctamente");
}
else{
        $ruta="crearEnv.php";
        mover_pag($ruta,"Error al crear el Envase");
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




