<?php
include "includes/valAcc.php";
?>
<?php
//ESTOS SON LOS DATOS QUE RECIBE PARA CREAR EL KIT
include "includes/conect.php";
foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  
$link=conectarServidor();   
/*CREACIÓN DEL KIT*/
$sql="select MAX(Id_kit) AS Cod_kit from kit;";						
$result = mysqli_query($link, $sql);
$row= mysqli_fetch_array($result);
if ($row)
	$cod=$row['Cod_kit'];	
else
	$cod=0;
$codkit=$cod+1;  
$qry1="insert into kit (Id_kit, Codigo, Cod_env) values ($codkit, $Codigo, $Cod_env)";
if($result1=mysqli_query($link,$qry1))
{
	mysqli_close($link);
	mover("listarkits.php","Kit Creado con Éxito");
}
else
{	
	mysqli_close($link);
	mover("crear_kits.php","Error al Crear el Kit");
}
function mover($ruta,$nota)
{
	//Funcion que permite el redireccionamiento de los usuarios a otra pagina 
	echo'<script >
	alert("'.$nota.'")
	self.location="'.$ruta.'"
	</script>';
}
?>
