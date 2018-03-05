<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
	<head>
    <meta charset="utf-8">
    <link href='images/favicon.ico' rel='shortcut icon' type='image/x-icon'>
	<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/md5.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>
	<title>Men&uacute; Principal</title>
    <!-- comentario -->
    <script type="text/javascript" language="JavaScript" src="scripts/menu.js"></script>
    <script type="text/javascript" language="JavaScript" src="scripts/menu_items.js"></script>
    <script type="text/javascript" language="JavaScript" src="scripts/menu_tpl.js"></script>
    <link rel="stylesheet" href="css/menu.css" type="text/css">
</head>
	<body>
    <div id="contenedor"> 
    <form name="form1"  method="post" id="form1" action="menu.php">
    <input Id="Per"  name="Per" type="hidden" value="<?php=$_SESSION['Perfil']; ?>">
    </form>
    <script type="text/javascript" language="JavaScript">
	var perr1 = document.getElementById("Per");
	//document.writeln (perr1.value);
	//var perr1 = form1.Per.value;
	//document.writeln (perr1);
	</script>
	<script type="text/javascript"  language="JavaScript">
		if(perr1.value==hex_md5("1"))
			new menu (MENU_ITEMS1, MENU_TPL);
		if(perr1.value==hex_md5("2"))
			new menu (MENU_ITEMS2, MENU_TPL);
		if(perr1.value==hex_md5("3"))
			new menu (MENU_ITEMS3, MENU_TPL);
		if(perr1.value==hex_md5("4"))
			new menu (MENU_ITEMS4, MENU_TPL);
		if(perr1.value==hex_md5("5"))
			new menu (MENU_ITEMS5, MENU_TPL);
		if(perr1.value==hex_md5("6"))
			new menu (MENU_ITEMS6, MENU_TPL);
		if(perr1.value==hex_md5("7"))
			new menu (MENU_ITEMS7, MENU_TPL);
		if(perr1.value==hex_md5("8"))
			new menu (MENU_ITEMS8, MENU_TPL);
		if(perr1.value==hex_md5("9"))
			new menu (MENU_ITEMS9, MENU_TPL);
	</script>
<div id="saludo"> <p>
                <?php include "includes/conect.php";
                $link=conectarServidor();
                $user1=$_SESSION['User'];
                $qry="select Nombre from tblusuarios WHERE Usuario='$user1'";	
                $result=mysql_db_query("novaquim",$qry);
                $row=mysql_fetch_array($result);
                echo $row['Nombre'];
				mysql_close($link);?> est&aacute; usando el Sistema de Informaci&oacute;n de Industrias Novaquim S.A.S.</p>
	</div> 
    </div> 
</body>
</html>
