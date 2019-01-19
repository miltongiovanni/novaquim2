
<?php
//include "conect.php";
class UsersManager{
private $_pdo; // Instance de PDO.

public function __construct()
{
	$this->setDb();
}
public function makeUser($user)

{
    
/*Preparo la insercion */

	$q = $this->_pdo->prepare('insert into tblusuarios (nombre, apellido, clave, usuario, estadoUsuario, fecCrea, fecCambio, idPerfil, intentos) 
	values (:nombre, :apellido, :clave, :usuario, :estadoUsuario, :fecCrea, :fecCambio, :idPerfil, :intentos)');
	$q->bindParam('nombre', $nombre, PDO::PARAM_STR);
	$q->bindParam('apellido', $apellido, PDO::PARAM_STR);
	$q->bindParam('clave', $clave, PDO::PARAM_STR);
	$q->bindParam('usuario', $usuario, PDO::PARAM_STR);
	$q->bindParam('estadoUsuario', $estadoUsuario, PDO::PARAM_INT);
	$q->bindParam('fecCrea', $fecCrea, PDO::PARAM_STR);
	$q->bindParam('fecCambio', $fecCambio, PDO::PARAM_STR);
	$q->bindParam('idPerfil', $idPerfil, PDO::PARAM_INT);
	$q->bindParam('intentos', $intentos, PDO::PARAM_INT);
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
	$last_id = $this->_pdo->lastInsertId();
    echo "New record created successfully. Last inserted ID is: " . $last_id;
}
public function deleteUser($idUsuario)
{
	if($idUsuario>0){
		$q = $this->_mysqli->prepare('delete from tblusuarios where idUsuario = :idUsuario');
		$q->bind_param('idUsuario', $idUsuario, PDO::PARAM_INT);
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

public function getUsers() {
    $q=$this->_pdo->prepare("SELECT  tblusuarios.Nombre as 'Nombre del Usuario', 
	tblusuarios.Apellido as 'Apellidos del Usuario',
	tblusuarios.Usuario, tblusuarios.FecCrea as 'Fecha de Creación', 
	tblestados.Descripcion as 'Estado',	tblperfiles.Descripcion as 'Perfil'
	FROM tblusuarios,tblperfiles, tblestados
	where tblusuarios.EstadoUsuario=tblestados.IdEstado and EstadoUsuario<=2
	and tblusuarios.IdPerfil=tblperfiles.IdPerfil order by tblusuarios.IdUsuario");
    $q->execute();
    $result = $q->fetchAll();
	$meta = $q->getColumnMeta(0);
	//var_dump($meta);
    return $result;
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

$this->_pdo =Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

}
}
?>
