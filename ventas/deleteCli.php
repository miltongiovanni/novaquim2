<?php
	include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BORRADO DE USUARIOS</title>
</head>
<body>
<?php
	include "includes/cliObj.php";
	$nit_cliente=$_POST['cliente'];
	$qry="select * from clientes where Nit_clien='$nit_cliente'";
	$link=conectarServidor();
	$result=mysqli_query($link,$qry);
	$row=mysqli_fetch_array($result);
	$Estado=$row['Estado'];
	mysqli_close($link);
	$cliente=new Client();
	$result=$cliente->deleteClient($nit_cliente);
	if($result==1)
	{
		/******LOG DE CREACION ********
		$IdUser=$IdUsuario;
		$hh=strftime("%H:").strftime("%M:").strftime("%S");	              
        $Fecha=date("Y")."-".date("m")."-".date("d")." ".$hh;
   		$qryAcces="insert into logusuarios(IdUsuario, Fecha, Motivo) values($IdUser,'$Fecha','BORRADO DE USUARIO')";
		$ResutLog=mysql_db_query("users",$qryAcces);
	    /*********FIN DEL LOG CREACION*****/
		$link=conectarServidor();
		$qrys="delete from clientes_sucursal where Nit_clien='$nit_cliente'";
		$results=mysqli_query($link,$qrys);
		echo '<form method="post" action="listarClien.php" name="form3">';
		echo'<input name="Estado" type="hidden" value="'.$Estado.'">';
		//echo '<input type="submit" name="Submit" value="" >'; 
		echo '</form>';
		echo'<script >
			alert("Cliente Eliminado Correctamente");
			document.form3.submit();
			</script>';	
	}
	else
	{	$ruta="deleteClienForm.php";
		mover_pag($ruta,"No se pudo eliminar el Cliente");
	}
	
function mover_pag($ruta,$nota)
	{
	echo'<script >
	alert("'.$nota.'")
	self.location="'.$ruta.'"
	</script>';
	}
?>
</body>
</html>
