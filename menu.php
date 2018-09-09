<?php
	include("includes/valAcc.php");
	include("includes/functions.php");
	include "includes/conect.php";
	$perfil1=$_SESSION['Perfil'];
	$db = new PHP_fun;
	$link=conectarServidor();
	$sql="select IdPerfil, Descripcion from tblperfiles;";
	$result=mysqli_query($link, $sql);
	while($row=mysqli_fetch_array($result))
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
<html>
	<head>
    <meta charset="utf-8"> 
    <link href='images/favicon.ico' rel='shortcut icon' type='image/x-icon'>
	<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
    
	<link href="css/main.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/md5.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>
	<title>Men&uacute; Principal</title>
    <!-- comentario -->
    <script language="javascript">
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
    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <!-- <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>-->
  <tr>
	<td align="center" valign="top" height="10"><?=$db->getMenu(0, $perfil);?>  </td>
  </tr>
	</table> 
<div id="saludo"> <p>
<?php 

$user1=$_SESSION['User'];
$qry="select Nombre from tblusuarios WHERE Usuario='$user1'";	
$result=mysqli_query($link, $qry);
$row=mysqli_fetch_array($result);
echo $row['Nombre']; 
mysqli_free_result($result);
/* cerrar la conexi?n */
mysqli_close($link);
?> est&aacute; usando el Sistema de Informaci&oacute;n de Industrias Novaquim S.A.S.</p>
	</div> 
    </div> 
</body>
</html>
