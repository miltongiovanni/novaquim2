<?
include "includes/valAcc.php";
?>

<?
include "conect.php";
class user{
    function makeUser($bd,$Nombre,$Apellido, $clave, $cedula,$usuario, $estadousuario, $fecCrea,$fecCambio,$Perfil, $Intentos,$email)
	{
        $qry="insert into tblusuarios (Nombre,Apellido, clave,cedula, usuario, estadousuario, fecCrea, FecCambio, IdPerfil, Intentos,email)
        values ('$Nombre','$Apellido','$clave', $cedula,'$usuario', $estadousuario, '$fecCrea','$fecCambio', $Perfil, $Intentos,'$email	')";
        $link=conectarServidor();
        $result=mysql_db_query($bd,$qry);
		mysql_close($link);
        return $result;
    }

	function deleteUser($bd,$IdUsuario)
	{
        $bd1=$bd;
		$link=conectarServidor();
		if($IdUsuario>0)
		{
			$qry="delete from tblusuarios where IdUsuario=$IdUsuario";
			$result=mysql_db_query($bd1,$qry);
			mysql_close($link);
			if($result==1)
				return 1;
			else
				return 0;
		}
		else{
			return 0;
		}
      }	

	function updateUser($bd,$Nombre,$Apellido, $cedula,$usuario, $estadousuario, $fecCrea,$fecCambio,$Perfil,$Intentos, $email)	
	{
        $qry="update tblusuarios set Nombre='$Nombre',
		Apellido='$Apellido', 
		cedula=$cedula,
		usuario='$usuario',
		estadousuario=$estadousuario, 
		fecCrea='$fecCrea', 
		FecCambio='$fecCambio', 
		IdPerfil=$Perfil,
		Intentos=$Intentos,
		email='$email'
		where Usuario='$usuario'";
        $link=conectarServidor();
        $result=mysql_db_query($bd,$qry);
		mysql_close($link);
        return $result;
    }
}
?>
