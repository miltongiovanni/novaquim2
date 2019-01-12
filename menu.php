<?php
	include("includes/valAcc.php");
	include("includes/functions.php");
	include "includes/conect.php";
	$perfil1=$_SESSION['Perfil'];


	//Crea el objeto Menu
	$db = new PHP_fun;


	//Esto toca quitarlo de aquí
	$con=conectarServidor();
	$QRY="select IdPerfil, Descripcion from tblperfiles;";
	$result = $con->query($QRY);


	while($row = $result->fetch(PDO::FETCH_ASSOC))
	{
		$idPerfil=$row['IdPerfil'];
		if(md5($idPerfil)==$perfil1)
		{
			$perfil=$idPerfil;	
		}
	}
	//echo "perfil1 ".$perfil1;
	//echo "perfil ".$perfil;
	
?>
 <!DOCTYPE html> 
<html lang="es">
	<head>
    <meta charset="UTF-8"> 
    <link href='images/favicon.ico' rel='shortcut icon' type='image/x-icon'>
	<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script src="js/md5.js"></script>
	<title>Menú Principal</title>
    <!-- comentario -->
    <script>
	function redirect(url)
	{
		window.open(url)  ;
		return false;
	}
	function showId(id)
	{
		var obj = document.getElementById(id);
		obj.style.display = 'block';
		return false;
	}
	function hideId(id)
	{
		var obj = document.getElementById(id);
		obj.style.display = 'none';
		return false;
	}
	</script>
</head>
	<body>
    <div id="contenedor"> 
    <table id="menuTable">
  <!-- <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>-->
  <tr>
	<td><?=$db->getMenu(0, $perfil);?>  </td>
  </tr>
	</table> 
<div id="saludo"> <p>
<?php 

$user1=$_SESSION['User'];
$qry="select Nombre from tblusuarios WHERE Usuario='$user1'";	
$result = $con->query($qry);


$row=$row = $result->fetch(PDO::FETCH_ASSOC);
echo $row['Nombre']; 
$result = null;
/* cerrar la conexión */
$con = null;
?> está usando el Sistema de Información de Industrias Novaquim S.A.S.</p>
	</div> 
    </div> 
</body>
</html>
