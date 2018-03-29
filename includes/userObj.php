
<?php
include "conect.php";
class user{
    function makeUser($Nombre, $Apellido, $clave, $usuario, $estadousuario, $fecCrea,$fecCambio, $Perfil, $Intentos)
	{
        $qry="insert into tblusuarios (Nombre, Apellido, clave, Usuario, Estadousuario, FecCrea, FecCambio, IdPerfil, Intentos)
        values ('$Nombre','$Apellido','$clave', '$usuario', $estadousuario, '$fecCrea','$fecCambio', $Perfil, 0)";
        $mysqli=conectarServidor();
        $result = $mysqli->query($qry);
        return $result;
		$result->free();
		/* cerrar la conexión */
		$mysqli->close();
    }

	function deleteUser($IdUsuario)
	{
		$mysqli=conectarServidor();
		if($IdUsuario>0)
		{
			$qry="delete from tblusuarios where IdUsuario=$IdUsuario";
			$result = $mysqli->query($qry);
			if($result==1)
				return 1;
			else
				return 0;
		}
		else{
			return 0;
		}
		$result->free();
		/* cerrar la conexión */
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
        $mysqli=conectarServidor();
        $result = $mysqli->query($qry);
        return $result;
		$result->free();
		/* cerrar la conexión */
		$mysqli->close();

    }
}
?>
