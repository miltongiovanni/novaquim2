<?php
include "includes/valAcc.php";
?>
<?php
include "includes/calcularDias.php";
include "includes/conect.php" ;
foreach ($_POST as $nombre_campo => $valor) 
{ 
  $asignacion = "\$".$nombre_campo."='".$valor."';"; 
  echo $nombre_campo." = ".$valor."<br>";  
  eval($asignacion); 
}  
$bd="novaquim";
$link=conectarServidor();
$sql="SELECT  MAX(IdServicio) as Codigo FROM servicios";
$result=mysqli_query($link,$sql);
$row= mysqli_fetch_row($result);
$codigo=$row[0];
if ($codigo>0)
	$Id_serv = $codigo+1;
else
	$Id_serv = 1;
$cuenta=415570;

$qryi="insert into servicios (IdServicio, DesServicio, Cod_iva, Cuenta_cont, Activo)
        values ($Id_serv, '$servicio', $tasa_iva, $cuenta, 0)";
$resulti=mysqli_query($link,$qryi);
/* cerrar la conexión */
mysqli_close($link);
if($resulti)
{
	$ruta="listarServ.php";
	/******LOG DE CREACION *********/
	//$IdUser=$_SESSION['IdUsuario'];
	//$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
    //$Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
	//$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','CREACION DE CATEGORIA')";
	//$ResutLog=mysql_db_query("users",$qryAcces);
	/*********FIN DEL LOG CREACION*****/
    mover_pag($ruta,"Servicio creado correctamente");
}
else{
        $ruta="crearServ.php";
        mover_pag($ruta,"Error al crear el Servicio");
     }


function mover_pag($ruta,$Mensaje){
echo'<script language="Javascript">
   alert("'.$Mensaje.'")
   self.location="'.$ruta.'"
   </script>';
}

?>
