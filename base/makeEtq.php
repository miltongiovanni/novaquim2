<?php
include "includes/valAcc.php";
?>
<?php
include "includes/EtqObj.php";
include "includes/calcularDias.php";
$min_stock = $_POST['min_stock'];
$nom_etq = $_POST['etiqueta'];

$link=conectarServidor();
$sql="SELECT MAX(Cod_etiq) as Codigo FROM etiquetas";	
$result=mysqli_query($link, $sql);
$row= mysqli_fetch_row($result);
$cod_etq=$row[0]+1;
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
$etiqu=new etiq();
if($result=$etiqu->crearEtq($cod_etq,$nom_etq, $min_stock))
{  
	$link=conectarServidor();
	$qryInv="insert into inv_etiquetas (Cod_etiq, inv_etiq) values ($cod_etq, 0)";
	$resultInv=mysqli_query($link,$qryInv);
	//$perfil1=$_SESSION['Perfil'];
	$ruta="listarEtq.php";
	/******LOG DE CREACION *********/
	//$IdUser=$_SESSION['IdUsuario'];
	//$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
    //$Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
	//$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','CREACION DE CATEGORIA')";
	//$ResutLog=mysql_db_query("users",$qryAcces);
	/*********FIN DEL LOG CREACION*****/
	//mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
    mover_pag($ruta,"Etiqueta creada correctamente");
}
else{
        $ruta="crearEtq.php";
        mover_pag($ruta,"Error al crear el Envase");
     }


function mover_pag($ruta,$Mensaje){
echo'<script language="Javascript">
   alert("'.$Mensaje.'")
   self.location="'.$ruta.'"
   </script>';
}
?>




