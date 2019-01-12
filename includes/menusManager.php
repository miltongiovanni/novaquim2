<?php //include "conect.php";

class menusManager {
  private $_pdo; // Instance de PDO.

  public function __construct() {
    $this->setDb();
  }

  public function makeMenuItem($menuItem) {
    $q=$this->_pdo->prepare('insert into tblusuarios (nombre, apellido, clave, usuario, estadoUsuario, fecCrea, fecCambio, idPerfil, intentos) 
    values (:nombre, : apellido, :clave, :usuario, :estadoUsuario, :fecCrea, :fecCambio, :idPerfil, :intentos)');
    $q->bindParam('nombre', $nombre, PDO::PARAM_STR);
    $q->bindParam('apellido', $apellido, PDO::PARAM_STR);
    $q->bindParam('clave', $clave, PDO::PARAM_STR);
    $q->bindParam('usuario', $usuario, PDO::PARAM_STR);
    $q->bindParam('estadoUsuario', $estadoUsuario, PDO::PARAM_INT);
    $q->bindParam('fecCrea', $fecCrea, PDO::PARAM_STR);
    $q->bindParam('fecCambio', $fecCambio, PDO::PARAM_STR);
    $q->bindParam('idPerfil', $idPerfil, PDO::PARAM_INT);
    $q->bindParam('intentos', $intentos, PDO::PARAM_INT);
    /*Preparo la insercion */

    $q=$this->_pdo->prepare('insert into menu (id, title, link, parentId, codUser) values (:id, :title, :link, :parentId, :codUser)');
    $q->bind_param('id', $id, PDO::PARAM_INT);
    $q->bind_param('title', $title,  PDO::PARAM_STR);
    $q->bind_param('link', $link,  PDO::PARAM_STR);
    $q->bind_param('parentId', $parentId, PDO::PARAM_INT);
    $q->bind_param('codUser', $codUser,  PDO::PARAM_STR);
    $id=$menuItem->id();
    $title=$menuItem->title();
    $link=$menuItem->link();
    $parentId=$menuItem->parentId();
    $codUser=$menuItem->codUser();

    return $q->execute();
  }

  public function deleteMenuItem($id) {
    if($id>0) {
      $q=$this->_pdo->prepare('delete from menu where id = ?');
      $q->bind_param('i', $id);
      return $q->execute();
    }
  }

  public function getMenuItems($perfil) {
    $q=$this->_pdo->prepare("SELECT id, title, link, parentId, codUser FROM menu where codUser LIKE '%$perfil%'");
    $q->execute();
    $result = $q->fetchAll();
    
    return $result;
  }

  public function getMenuItem($id) {
    $id=(int) $id;
    $q=$this->_mysqli->query("SELECT id, title, link, parentId, codUser FROM menu WHERE id = $id");
    $datos=$q->fetch_array(MYSQLI_BOTH);
    return new menuItem($datos);
  }
/*
  public function update(menuItem $item) {
    $q=$this->_db->prepare('UPDATE personnages SET forcePerso = :forcePerso, degats = :degats, niveau = :niveau, experience = :experience WHERE id = :id');

    $q->bindValue('forcePerso', $perso->forcePerso(), PDO: :PARAM_INT);
    $q->bindValue('degats', $perso->degats(), PDO: :PARAM_INT);
    $q->bindValue('niveau', $perso->niveau(), PDO: :PARAM_INT);
    $q->bindValue('experience', $perso->experience(), PDO: :PARAM_INT);
    $q->bindValue('id', $perso->id(), PDO: :PARAM_INT);

    $q->execute();
  }
*/
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
  public function setDb() {

    $this->_pdo=Conectar::conexion(); //Almacenamos en _mysqli la llamada la clase estática Conectar;

  }
}

?>