
<?php
include "conect.php";
class user{
    function makeUser($Nombre, $Apellido, $clave, $usuario, $estadousuario, $fecCrea,$fecCambio, $Perfil, $Intentos)
	{
        $qry="insert into tblusuarios (Nombre, Apellido, clave, Usuario, Estadousuario, FecCrea, FecCambio, IdPerfil, Intentos)
        values ('$Nombre','$Apellido','$clave', '$usuario', $estadousuario, '$fecCrea','$fecCambio', $Perfil, 0)";
        //$link=conectarServidor();
        $mysqli=conectarServidor();
        //$result=mysqli_query($link, $qry);
        $result = $mysqli->query($qry);
        return $result;
		//mysqli_free_result($result);
		$result->free();
		/* cerrar la conexión */
		//mysqli_close($link);
		$mysqli->close();
    }

	function deleteUser($IdUsuario)
	{
		//$link=conectarServidor();
		$mysqli=conectarServidor();
		if($IdUsuario>0)
		{
			$qry="delete from tblusuarios where IdUsuario=$IdUsuario";
			//$result=mysqli_query($link, $qry);
			$result = $mysqli->query($qry);
			if($result==1)
				return 1;
			else
				return 0;
		}
		else{
			return 0;
		}
		//mysqli_free_result($result);
		$result->free();
		/* cerrar la conexión */
		//mysqli_close($link);
		$mysqli->close();

      }	

	function updateUser($Nombre,$Apellido, $usuario, $estadousuario, $fecCrea, $fecCambio, $Perfil, $Intentos)	
	{
        $qry="update tblusuarios set Nombre='$Nombre',
		Apellido='$Apellido', 
		usuario='$usuario',
		estadousuario=$estadousuario, 
		fecCrea='$fecCrea', 
		FecCambio='$fecCambio', 
		IdPerfil=$Perfil,
		Intentos=$Intentos
		where Usuario='$usuario'";
        //$link=conectarServidor();
        $mysqli=conectarServidor();
        //$result=mysqli_query($link, $qry);
        $result = $mysqli->query($qry);
        return $result;
		//mysqli_free_result($result);
		$result->free();
		/* cerrar la conexión */
		//mysqli_close($link);
		$mysqli->close();

    }
}
?>
