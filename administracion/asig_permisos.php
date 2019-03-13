<?php
include("includes/valAcc.php");
?>
<!DOCTYPE html>
<html>
<head>
<title>Detalle de la Cotizaci&oacute;n</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>
        <link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue2.css" title="blue">
    <script type="text/javascript" src="scripts/calendar.js"></script>
    <script type="text/javascript" src="scripts/calendar-sp.js"></script>
    <script type="text/javascript" src="scripts/calendario.js"></script>
</head>
<body> 
<div id="contenedor">
<div id="saludo1"><strong>DETALLE DE LOS PERMISOS</strong></div>
<?php
	include "includes/conect.php";
	$mysqli=conectarServidor();
	/*foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  	*/
	//$permisos[]="";
	$perfil=$_POST['perfil'];
	$usuario=$_POST['usuario'];
	foreach($_POST['seleccion3'] as $indice1=>$auxiliar) 
	{
		foreach($auxiliar as $indice2=>$elemento) 
		{
			foreach ( $elemento as $clave=>$valor) 
			{
				$permisos[]=$valor;
			}
		}
	}
	//print_r($permisos);
	//echo "<br>";

	
	$sql="select id, title, link, parentid, cod_user from menu";
	$result=$mysqli->query($sql);
	while($row=$result->fetch_assoc())
	{
		$id=$row['id'];
		$title=$row['title'];
		$parentid=$row['parentid'];
		$cod_user=$row['cod_user'];
		$usuarios_p = explode(",", $cod_user);
		$menu_1[0]="";$menu_1_i[0] = "";
		if($parentid==0)
		{
			$menu_1_i[] = $id;
		}
		else
		{
			if($clave = array_search($parentid, $menu_1_i))
			{
				$menu_2_i[] = $id;
			}
			else
			{
				$menu_3_i[] = $id;
			}
		}
	}
	//echo "menu 1 ";
	//print_r($menu_1_i);
	//echo "<br>";
	//echo "menu 2 ";
	//print_r($menu_2_i);
	//echo "<br>";
	//echo "menu 3 ";
	//print_r($menu_3_i);
	//echo "<br>";
	
	     // arreglo     indice valor
	foreach($menu_3_i as $i => $id3)
	{
		$sql3="select id, title, link, parentid, cod_user from menu where id=$id3";
		$result3=$mysqli->query($sql3);
		$row3=$result3->fetch_assoc();
		$id=$row3['id'];
		$parentid=$row3['parentid'];
		$cod_user=$row3['cod_user'];
		$usuarios_p = explode(",", $cod_user);
		if(in_array ($perfil, $usuarios_p))
		  {	
			  if(in_array ($id, $permisos))
			  {
				/*$usuarios_p[]=$perfil;
				$opciones_us = implode(",", $usuarios_p);
				$sqlup="update menu set cod_user='$opciones_us' where id=$id";
				$resultb=mysql_db_query($database,$sqlup);*/
				//echo "Tiene permiso y se asigna de nuevo $id <br>";
				$sql2="select id, title, link, parentid, cod_user from menu where id=$parentid";
				$result2=$mysqli->query($sql2);
				$row2=$result2->fetch_assoc();
				$id2=$row2['id'];
				$parentid2=$row2['parentid'];
				$cod_user2=$row2['cod_user'];
				$usuarios_p2 = explode(",", $cod_user2);
				if(in_array ($perfil, $usuarios_p2))
		  		{	
					
				}
				else
				{
					$usuarios_p2[]=$perfil;
					$opciones_us2 = implode(",", $usuarios_p2);
					$sqlup="update menu set cod_user='$opciones_us2' where id=$id2";
					//echo $sqlup."<br>";
					$resultb=$mysqli->query($sqlup);
				}
				
				
				
			  }
			  else
			  {
				  //echo "tiene permiso y lo va a revocar  $id <br>";
				  
				  foreach($usuarios_p as $item => $perm_asig)
				  {
					  if($perm_asig!=$perfil)
						  $nvo_permisos[]=$perm_asig;
				  }
				  $opciones_us = implode(",", $nvo_permisos);
				  $sqlup="update menu set cod_user='$opciones_us' where id=$id";
				  unset($nvo_permisos);
				 // echo $sqlup."<br>";
				  $resultb=$mysqli->query($sqlup);
			  }
			  
		  }
		  else
		  {
			  if(in_array ($id, $permisos))
			  {
				//  echo "no tiene permiso y se le va asignar  $id <br>";
				$usuarios_p[]=$perfil;
				$opciones_us = implode(",", $usuarios_p);
				$sqlup="update menu set cod_user='$opciones_us' where id=$id";
				//echo $sqlup."<br>";
				$resultb=$mysqli->query($sqlup);
			  }
			  else
				  {
					  //echo "no tiene permiso y no se le va asignar  $id <br>";
				  	  echo "";
				  }
		  }
		

	}

	
	echo '<form name="form3"  method="post" action="permisos.php">';
	echo '<input type="hidden" name="Personal" value="'.$usuario.','.$perfil.'">';
	echo '</form>';
	echo'<script language="Javascript">
	document.form3.submit();
	</script>';
//mysqli_free_result($result);
/* cerrar la conexión */
$mysqli->close();

?>

</div>
</body>
</html>
	   