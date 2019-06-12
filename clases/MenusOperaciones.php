<?php //include "conect.php";

class MenusOperaciones {
  private $_pdo; // Instance de PDO.

  public function __construct() {
    $this->setDb();
  }

  public function makeMenuItem($datos) {
    /*Preparo la insercion */
    $qry = "INSERT INTO menu VALUES(?, ?, ?, ?, ?)";
    $stmt = $this->_pdo->prepare($qry);
    $stmt->execute($datos);
    return $this->_pdo->lastInsertId();
  }

  public function deleteMenuItem($id) {
    $qry = "DELETE FROM menu WHERE id= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($id));
  }

  public function getMenuItems(){
    $qry = "SELECT id, title, link, parentId, codUser FROM menu ORDER BY id;";
    $stmt = $this->_pdo->prepare($qry);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  public function getMenuItemsPerfil($perfil) {
    $qry = "SELECT id, title, link, parentId, codUser FROM menu WHERE codUser LIKE '%$perfil%' ORDER BY id;";
    $stmt = $this->_pdo->prepare($qry);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  public function getMenuItem($id) {
    $qry = "SELECT id, title, link, parentId, codUser FROM menu WHERE id =?";
    $stmt = $this->_pdo->prepare($qry);
    $stmt->execute(array($id));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  public function updateMenuItem($datos)
    {
        $qry = "UPDATE menu SET codUser=? WHERE id=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
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

    $this->_pdo=conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

  }
}

?>