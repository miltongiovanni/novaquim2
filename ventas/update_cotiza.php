<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Cotización</title>
<meta charset="utf-8">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="../js/validar.js"></script>
	<script  src="scripts/block.js"></script>
        <link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue2.css" title="blue">
    <script  src="scripts/calendar.js"></script>
    <script  src="scripts/calendar-sp.js"></script>
    <script  src="scripts/calendario.js"></script>
    	<script >
	document.onkeypress = stopRKey; 
	</script>
</head>
<body> 
<?php
	include "includes/conect.php";
	$link=conectarServidor();
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  
	if($_POST['seleccion1']==NULL)
	{
	  //echo "no escogió productos de novaquim <br>";
		echo' <script >
		alert("Debe escoger alguna Familia de los productos Nova");
		history.back();
		</script>';
	}
	else
	{
		$opciones_prod = implode(",", $_POST['seleccion1']);
	}
	//SELECCIONA LOS PRODUCTOS DE DISTRIBUCIÓN
	if($_POST['seleccion'])
	{
		$opciones_dist = implode(",", $_POST['seleccion']);
		$No_dist=0;
	} 
	else
	{
		$No_dist=1;
	}
	$link=conectarServidor();   
	$qryUpd="update cotizaciones set cliente=$cliente, Fech_Cotizacion='$FchCot', precio=$precio, presentaciones=$Presentaciones, distribucion='$opciones_dist', productos='$opciones_prod'  where Id_cotizacion=$cotiza";	
	if($resultUpd=mysqli_query($link,$qryUpd))
	{
		mysqli_close($link);
		echo '<form method="post" action="det_cotiza2.php" name="form3">';
		echo'<input name="Destino" type="hidden" value="'.$Destino.'">';
		echo'<input name="Cotizacion" type="hidden" value="'.$cotiza.'">';
		echo'<input name="No_dist" type="hidden" value="'.$No_dist.'">';
		echo '<input type="submit" name="Submit" value="Analizar">'; 
		echo '</form>';
		echo'<script >
			document.form3.submit();
			</script>';
		
	}
	else
	{
		mysqli_close($link);
		mover_pag("buscarCotiza.php","Error al ingresar la Cotización");
	}
function mover_pag($ruta,$mensaje)
{	
//Funcion que permite el redireccionamiento de los usuarios a otra pagina 
echo' <script >
alert("'.$mensaje.'")
self.location="'.$ruta.'"
</script>';
}	
	
		
?>
</body>
</html>
	   