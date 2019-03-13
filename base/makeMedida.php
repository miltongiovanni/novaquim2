<?php
include "includes/valAcc.php";
?>
<?php
include "includes/MedObj.php";
include "includes/calcularDias.php";

foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
//echo $cod_pres;
$cod_pres= ($IdProducto * 100)+$IdMedida;
$link=conectarServidor();
$qryb="SELECT fabrica, distribuidor, detal, super, mayor from precios where codigo_ant=$IdCodAnt;";	
$resultb=mysqli_query($link,$qryb);
$rowb=mysqli_fetch_array($resultb);
$fabrica=$rowb['fabrica'];
$distribuidor=$rowb['distribuidor'];
$detal=$rowb['detal'];
$super=$rowb['super'];
$mayor=$rowb['mayor'];
mysqli_free_result($resultb);
/* cerrar la conexión */
mysqli_close($link);
$prodpres=new ProdPre();
$valida=0;
if($result=$prodpres->validarMed($cod_pres, $valida))
{
	$ruta="crearMedida.php";
	if($valida==1)
	{
	    mover_pag($ruta,"Código de Presentación ya existente");
		mysql_close($link);
	}
}

if($result=$prodpres->crearMed($cod_pres,$ProdPresen, $IdProducto, $IdMedida, $IdEnvase, $IdTapa, $IdCodAnt, $Etiq, $Stock, $fabrica, $distribuidor, $detal, $mayor, $super, $Cotiza))
{
	//$qryinv="insert into inv_prod (Cod_prese, Nombre) values ($cod_pres,'$producto')";
    $link=conectarServidor();
    //$result=mysql_db_query($bd,$qryinv);
    mysqli_close($link);//Cerrar la conexion
	//$perfil1=$_SESSION['Perfil'];
	$ruta="listarmed.php";
	/******LOG DE CREACION *********/
	//$IdUser=$_SESSION['IdUsuario'];
	//$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
    //$Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
	//$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','CREACION DE CATEGORIA')";
	//$ResutLog=mysql_db_query("users",$qryAcces);
	/*********FIN DEL LOG CREACION*****/
    mover_pag($ruta,"Presentación de Producto creada correctamente");
}
else{
        $ruta="crearMedida.php";
        mover_pag($ruta,"Error al crear la presentación de Producto");
     }


function mover_pag($ruta,$Mensaje){
echo'<script language="Javascript">
   alert("'.$Mensaje.'")
   self.location="'.$ruta.'"
   </script>';
}

?>
