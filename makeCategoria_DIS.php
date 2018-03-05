<?php
include "includes/valAcc.php";
?>
<?php
include "includes/calcularDias.php";
include "includes/conect.php";
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
//	echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
$link=conectarServidor();  
$bd="novaquim";
$qry="insert into cat_dist (Id_cat_dist, Des_cat_dist) values ($cod_cat_mp,'$categoria')";
$result=mysqli_query($link, $qry);
if($result)
{
	//$perfil1=$_SESSION['Perfil'];
	$ruta="listarcateg_DIS.php";
	/******LOG DE CREACION *********/
	//$IdUser=$_SESSION['IdUsuario'];
	//$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
    //$Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
	//$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','CREACION DE CATEGORIA')";
	//$ResutLog=mysql_db_query("users",$qryAcces);
	/*********FIN DEL LOG CREACION*****/
    mover_pag($ruta,"Categoria de Producto de Distribución creada correctamente");
}
else{
        $ruta="crearCategoria_DIS.php";
        mover_pag($ruta,"Error al crear la Categoría de Producto de Distribución");
     }
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);

function mover_pag($ruta,$Mensaje){
echo'<script language="Javascript">
   alert("'.$Mensaje.'")
   self.location="'.$ruta.'"
   </script>';
}

?>
