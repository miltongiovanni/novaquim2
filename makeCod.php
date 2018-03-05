<?php
include "includes/valAcc.php";
?>
<?php
include "includes/CodObj.php";
include "includes/calcularDias.php";

foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
$distribuidor=(round($fabrica*2*1.12,-2))/2;
$detal=(round($fabrica*2*1.4,-2))/2;
$mayor= (round($distribuidor*2*0.93,-2))/2;
$super= (round($fabrica*2*0.93,-2))/2;
$link=conectarServidor();

//BUSCA SI EXISTE EL CODIGO 
$qry0="select Cod_ant from prodpre where Cod_produc=$CodProd;";
//echo $qry0."<br>";	
$result0=mysqli_query($link,$qry0);
$row0=mysqli_fetch_array($result0);
mysqli_free_result($result0);
/* cerrar la conexión */
mysqli_close($link);
if ($row0)
{
	$cod= $row0['Cod_ant'];
	$cod= ($cod - $cod%100)/100;
	$codigo=$cod*100+$IdMedida;
	$cdi=new codi();
	if($result=$cdi->crearCod($codigo, $Generico, $fabrica, $distribuidor, $detal, $mayor, $super))
	{
		//$perfil1=$_SESSION['Perfil'];
		$ruta="listarCod.php";
		/******LOG DE CREACION *********/
		//$IdUser=$_SESSION['IdUsuario'];
		//$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
		//$Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
		//$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','CREACION DE CATEGORIA')";
		//$ResutLog=mysql_db_query("users",$qryAcces);
		/*********FIN DEL LOG CREACION*****/
	   mover_pag($ruta,"Producto creado correctamente");
	}
	else
	{
		$ruta="crearCod.php";
		mover_pag($ruta,"Error al crear el Producto");
	 }
}
else
{
	$link=conectarServidor();
	//BUSCA EL ÚLTIMO CÓDIGO CREADO
	$qry1="select MAX(codigo_ant) as cod from precios where codigo_ant LIKE '$CodCat%';";
	//echo $qry1."<br>";	
	$result1=mysqli_query($link, $qry1);
	$row1=mysql_fetch_array($result1);
	$cod=$row1['cod'];
	//echo $cod."<br>";
	$mod=$cod%100;
	$cod=(($cod-$mod)/100)+1;
	$codigo=$cod*100+$IdMedida;
	$cdi=new codi();
	//echo "El codigo es ".$codigo."<br>";
	mysqli_free_result($result1);
/* cerrar la conexión */
mysqli_close($link);
	if($result=$cdi->crearCod($codigo, $Generico, $fabrica, $distribuidor, $detal, $mayor, $super))
	{
		//$perfil1=$_SESSION['Perfil'];
		$ruta="listarCod.php";
		/******LOG DE CREACION *********/
		//$IdUser=$_SESSION['IdUsuario'];
		//$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
		//$Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
		//$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','CREACION DE CATEGORIA')";
		//$ResutLog=mysql_db_query("users",$qryAcces);
		/*********FIN DEL LOG CREACION*****/
	   mover_pag($ruta,"Producto creado correctamente");
	}
	else
	{
		$ruta="crearCod.php";
		mover_pag($ruta,"Error al crear el Producto");
	 }
}

function mover_pag($ruta,$Mensaje){
echo'<script language="Javascript">
   alert("'.$Mensaje.'")
   self.location="'.$ruta.'"
   </script>';
}

?>
