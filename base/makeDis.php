<?php
include "includes/valAcc.php";
?>
<?php
include "includes/DisObj.php";
include "includes/calcularDias.php";
//include "conect.php" ;
foreach ($_POST as $nombre_campo => $valor) 
{ 
  $asignacion = "\$".$nombre_campo."='".$valor."';"; 
  //echo $nombre_campo." = ".$valor."<br>";  
  eval($asignacion); 
}  
$bd="novaquim";
$link=conectarServidor();
$sql="SELECT  MAX(Id_distribucion) as Codigo FROM distribucion where Id_Cat_dist=$Cat_Dist";
$result=mysqli_query($link,$sql);
$row= mysqli_fetch_row($result);
$codigo=$row[0];
if ($codigo>0)
	$Id_prod = $codigo+1;
else
	$Id_prod = $Cat_Dist*100000 +1;
if ($tasa_iva==1)
	$cuenta=41353803;
if ($tasa_iva==5)
	$cuenta=41353802;
if ($tasa_iva==3)
	$cuenta=41353801;
mysql_close($link);

$dist=new distri();
if($result=$dist->crearDis($Id_prod, $producto_dist, $tasa_iva, $Cat_Dist, $cuenta, $Cotiza, $precio_vta, 0, $stock_dis))
{
	$link=conectarServidor();
	$qryOP="insert into inv_distribucion (Id_distribucion, inv_dist) values ($Id_prod, 0);";
	//echo $qryOP;
	$resultOP=mysqli_query($link, $qryOP);
	//$perfil1=$_SESSION['Perfil'];
	$ruta="listarDis.php";
	mysqli_close($link);//Cerrar la conexion
	/******LOG DE CREACION *********/
	//$IdUser=$_SESSION['IdUsuario'];
	//$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
    //$Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
	//$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','CREACION DE CATEGORIA')";
	//$ResutLog=mysql_db_query("users",$qryAcces);
	/*********FIN DEL LOG CREACION*****/
    mover_pag($ruta,"Producto de Distribución creado correctamente");
}
else{
        $ruta="crearDis.php";
        mover_pag($ruta,"Error al crear el Producto de Distribución");
     }


function mover_pag($ruta,$Mensaje){
echo'<script language="Javascript">
   alert("'.$Mensaje.'")
   self.location="'.$ruta.'"
   </script>';
}

?>
