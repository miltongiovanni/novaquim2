
<?php
//include "conect.php";
class UsersManager{
private $_mysqli; // Instance de mysqli.

public function __construct()
{
	$this->setDb();
}
public function makeUser($user)

{
    
/*Preparo la insercion */

	$q = $this->_mysqli->prepare('insert into tblusuarios (nombre, apellido, clave, usuario, estadoUsuario, fecCrea, fecCambio, idPerfil, intentos) values (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $q->bind_param('ssssissii', $nombre, $apellido, $clave, $usuario, $estadoUsuario, $fecCrea, $fecCambio, $idPerfil, $intentos );
    $nombre = $user->nombre();
    $apellido = $user->apellido();
    $clave = $user->clave();
    $usuario = $user->usuario();
    $estadoUsuario = $user->estadoUsuario();
    $fecCrea = $user->fecCrea();
    $fecCambio = $user->fecCambio();
    $idPerfil = $user->idPerfil();
    $intentos = $user->intentos();
  	return $q->execute();
}
public function deleteUser($idUsuario)
{
	if($idUsuario>0){
		$q = $this->_mysqli->prepare('delete from tblusuarios where idUsuario = ?');
		$q->bind_param('i', $idUsuario);
		return $q->execute();







		/*$qry="delete from tblusuarios where idUsuario=$idUsuario";
		echo $qry;
		$result = this->_mysqli->query($qry);
		if($result==1)
			return 1;
		else
			return 0;
	}
	else{
		return 0;*/
	}
}	
/*
public function updateUser($Nombre,$Apellido, $usuario, $estadousuario, $fecCrea, $fecCambio, $Perfil, $Intentos)	
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
    $result = this->_mysqli->query($qry);
    return $result;
}
public function changeClave($Nombre,$Apellido, $usuario, $estadousuario, $fecCrea, $fecCambio, $Perfil, $Intentos)	
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
    $result = this->_mysqli->query($qry);
    return $result;
}*/
 public function setDb()

{

$this->_mysqli =Conectar::conexion(); //Almacenamos en _mysqli la llamada la clase estática Conectar;

}
}
?>
