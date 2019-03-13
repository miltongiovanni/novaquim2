<?php
include "includes/valAcc.php";
?>
<?php
include "includes/MPObj.php";
include "includes/calcularDias.php";
$cod_cat_mp = $_POST['Cate_MP'];
$min_stock = $_POST['min_stock'];
$mprima = $_POST['mprima'];
$tasa_iva= $_POST['tasa_iva'];
$link=conectarServidor();
$sql="SELECT MAX(Cod_mprima) as Codigo
		FROM mprimas where Id_Cat_mp=$cod_cat_mp";	
$result=mysqli_query($link,$sql);
$row= mysqli_fetch_row($result);
if ($row[0]>0)
	$cod_mp = $row[0]+1;
else
	$cod_mp = $cod_cat_mp*100 +1;


$mpri=new mprim();
if($result=$mpri->crearMP($cod_mp,$mprima, $cod_cat_mp, $min_stock, $tasa_iva))
{  
	//$perfil1=$_SESSION['Perfil'];
	$ruta="listarMP.php";
	/******LOG DE CREACION *********/
	//$IdUser=$_SESSION['IdUsuario'];
	//$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
    //$Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
	//$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','CREACION DE CATEGORIA')";
	//$ResutLog=mysql_db_query("users",$qryAcces);
	/*********FIN DEL LOG CREACION*****/
    mover_pag($ruta,"Materia Prima creada correctamente");
}
else{
        $ruta="crearMP.php";

        mover_pag($ruta,"Error al crear la Materia Prima");
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




