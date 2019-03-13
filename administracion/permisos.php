<?php	
	include("includes/valAcc.php");
	include "includes/conect.php";
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Asignación de Permisos al Usuario</title>
	<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/md5.js"></script>
	<script type="text/javascript" src="scripts/block.js"></script>
    <script language="javascript">
	function todos(form) 
	{
		for (i = 0; i < form.casilla1.length; i++)
		form.casilla1[i].checked = true;
		form.desmarcatodos.checked = false;
	}	
	function ninguno(form) 
	{
		for (i = 0; i < form.casilla1.length; i++)
		form.casilla1[i].checked = false;
		form.marcatodos.checked = false;
	}
	function seleccionar1(form)
	{ 
		for (i=0;i<form.casilla1.length;i++) 
			if(form.casilla1[i].type == "checkbox") 
				if(form.seleccionar.checked == true)
					form.casilla1[i].checked=true 
				else if(form.seleccionar.checked == false)
					form.casilla1[i].checked=false 
	}
	function seleccionar2(form)
	{ //seleccion2[][]
		document.writeln (perr1.value);
		for (i=0;i<form.casilla1.length;i++) 
			if(form.casilla1[i].type == "checkbox") 
				if(form.seleccionar.checked == true)
					form.casilla1[i].checked=true 
				else if(form.seleccionar.checked == false)
					form.casilla1[i].checked=false 
	}
	/*function buscar2(form, texto)
	{
		//document.writeln (form.seleccion3[2][2][2].value);
		var sel2[][] = document.getElementsByName('seleccion2[][]');
		document.writeln (sel2[1][1].value);
		document.writeln (document.forms[1].seleccion3[2][2][2].value);
		//document.writeln (texto);
		for(ind=0; ind<lista.length; ind++)
	    {
			if (lista[ind] == valor)
		  	break;
		}
		for (i=0;i<10;i++)
		{ 
			for (j=0;j<10;j++) 
			{ 
		 		document.write(i + "-" + j) 
			} 
		} 
	}*/
	</script>
</head>
<body>
<div id="contenedor"> 
<div id="saludo1"> 
                <?php 
				foreach ($_POST as $nombre_campo => $valor) 
				{ 
					$asignacion = "\$".$nombre_campo."='".$valor."';"; 
					//echo $nombre_campo." = ".$valor."<br>";  
					eval($asignacion); 
				}  	
				$user = explode(",", $Personal);
                //$link=conectarServidor();
                $mysqli=conectarServidor();
                $qry="select Nombre from tblusuarios WHERE IdUsuario=$user[0]";	
                //$result=mysqli_query($link,$qry);
                $result = $mysqli->query($qry);
                $row=$result->fetch_assoc();
                echo "Permisos para el usuario <strong>".iconv("iso-8859-1", "UTF-8",$row['Nombre'])."</strong>";
				?> en el Sistema de Inventarios de Industrias Novaquim
                </div>
                <form name="PERMISOS"  method="post" action="asig_permisos.php">
                <?php
				$perfil=$user[1];
				//$sql="select id, title, link, parentid, cod_user from menu where cod_user LIKE '%$perfil%';";
				$sql="select id, title, link, parentid, cod_user from menu";
				$result= $mysqli->query($sql);
				$k=0;	
				

				while($row=$result->fetch_assoc())
				{
					$id=$row['id'];
					$title=$row['title'];
					$parentid=$row['parentid'];
					$cod_user=$row['cod_user'];
					$usuarios_p = explode(",", $cod_user);
					
					$k++;
					$menu_1[0]="";$menu_1_i[0] = "";
					if($parentid==0)
					{
						$menu_1[] = $title;
						$menu_1_i[] = $id;

					}
					else
					{
						if($clave = array_search($parentid, $menu_1_i))
						{
							$menu_2[$clave][0] = "";
							$menu_2_i[$clave][0] = "";
							$menu_2[$clave][] = $title;
							$menu_2_i[$clave][] = $id;
						}
						else
						{
							foreach($menu_2_i as $indice=>$elemento) 
							{
								foreach ( $elemento as $clave=>$valor) 
								{
									if ($parentid==$valor)
									{
										$menu_3[$indice][$clave][0] = "";
										$menu_3_i[$indice][$clave][0] = "";
										$menu_3[$indice][$clave][] = $title;
										$menu_3_i[$indice][$clave][] = $id;
										break;
									}
								}
							}
						}
					}
				}
				$id2=0;
				foreach($menu_3 as $indice1=>$auxiliar) 
				{
					//echo "El indice1 es $indice1 <br>";
					if($indice1>0)
					{
					  echo '<table width="40%" align="center" summary="Tabla" border="0"><tr><td align="center" colspan="2" class="titulo">';
					  //echo iconv("iso-8859-1", "UTF-8",$menu_1[$indice1]).'<input type="checkbox" name="seleccion1[]"  id="menu1'.$id1++.'" align="left" value="'.$menu_1_i[$indice1].'" CHECKED>';
					  //echo iconv("iso-8859-1", "UTF-8",$menu_1[$indice1]);
					  echo $menu_1[$indice1];
					  echo "</td></tr><tr>";
					}
					$id3=0;
					foreach($auxiliar as $indice2=>$elemento) 
					{
						//echo "El indice2 es $indice2 <br>";
						echo '<td align="center" width="50%" class="resaltado">';
						$idmenu2="menu2".$id2++;
						//echo iconv("iso-8859-1", "UTF-8",$menu_2[$indice1][$indice2]).'<input type="checkbox" name="seleccion2[][]"  id="'.$idmenu2.'"  align="left" value="'.$menu_2_i[$indice1][$indice2].'" onclick="buscar2(this.form, document.getElementById(\''.$idmenu2.'\').value)">';
						echo $menu_2[$indice1][$indice2];
						echo "</td>";
						echo '<td align="right">';
						foreach ($elemento as $clave=>$valor) 
						{
							if ($clave>0)
							{	
								$aaaaa=$menu_3_i[$indice1][$indice2][$clave];
								$sqlb="select id, title, link, parentid, cod_user from menu where id=$aaaaa";
								$resultb=$mysqli->query($sqlb);
								$rowb=$resultb->fetch_assoc();
								$cod_user=$rowb['cod_user'];
								$usuarios_p = explode(",", $cod_user);
								if(in_array ($perfil, $usuarios_p))
								{
									echo $valor.'<input type="checkbox" name="seleccion3[][][]" id="menu3'.$id3++.'" align="right" value="'.$menu_3_i[$indice1][$indice2][$clave].'" checked ><br>';
								}
								else
								{
									echo $valor.'<input type="checkbox" name="seleccion3[][][]" id="menu3'.$id3++.'" align="right" value="'.$menu_3_i[$indice1][$indice2][$clave].'" ><br>';
								}
								
							}
						}
						echo "</td></tr><tr><td>&nbsp;</td></tr><tr>";
					}
					echo "</tr>";
					echo "</table>";
				}
				//echo "el valor del indice1 final es $indice";
				?>
<table width="30%" align="center">
<tr>
                <td width="50%" align="center"><input type="hidden" name="perfil" value="<?php echo $perfil ?>"><input type="hidden" name="usuario" value="<?php echo $user[0] ?>">
				<button class="button" style="vertical-align:middle" onclick="return Enviar(this.form)"><span>Continuar</span></button>
      			<td width="50%" align="center" ><button class="button" style="vertical-align:middle" type="reset"><span>Borrar</span></button></td>
                </tr>
                </table>
                </form>
                <div align="center"><button class="button" style="vertical-align:middle" onClick="window.location='menu.php'"><span>Terminar</span></button></div>
</div> 
</div> 
</body>
</html>