<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Cotizaci&oacute;n</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>
        <link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue2.css" title="blue">
    <script type="text/javascript" src="scripts/calendar.js"></script>
    <script type="text/javascript" src="scripts/calendar-sp.js"></script>
    <script type="text/javascript" src="scripts/calendario.js"></script>
    	<script type="text/javascript">
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
	  //echo "no escogi� productos de novaquim <br>";
		echo' <script language="Javascript">
		alert("Debe escoger alguna Familia de los productos Nova");
		history.back();
		</script>';
	}
	else
	{
		$opciones_prod = implode(",", $_POST['seleccion1']);
	}
	//SELECCIONA LOS PRODUCTOS DE DISTRIBUCI�N
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
		echo'<script language="Javascript">
			document.form3.submit();
			</script>';
		
	}
	else
	{
		mysqli_close($link);
		mover_pag("buscarCotiza.php","Error al ingresar la Cotizaci�n");
	}
function mover_pag($ruta,$nota)
{	
//Funcion que permite el redireccionamiento de los usuarios a otra pagina 
echo' <script language="Javascript">
alert("'.$nota.'")
self.location="'.$ruta.'"
</script>';
}	
	
		
?>
</body>
</html>
	   