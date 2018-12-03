
<?php
//include "conect.php";
class menusManager{
private $_mysqli; // Instance de mysqli.

public function __construct()
{
	$this->setDb();
}
public function makeMenuItem($menuItem)

{
    
/*Preparo la insercion */

	$q = $this->_mysqli->prepare('insert into menu (id, title, link, parentId, codUser) values (?, ?, ?, ?, ?)');
    $q->bind_param('issis', $id, $title, $link, $parentId, $codUser );
    $id = $menuItem->id();
    $title = $menuItem->title();
    $link = $menuItem->link();
    $parentId = $menuItem->parentId();
    $codUser = $menuItem->codUser();
    
  	return $q->execute();
}
public function deleteMenuItem($id)
{
	if($id>0){
		$q = $this->_mysqli->prepare('delete from menu where id = ?');
		$q->bind_param('i', $id);
		return $q->execute();
	}
}
public function getMenuItems()
  {
    $menuItems = [];

    $q = $this->_db->query('SELECT (id, title, link, parentId, codUser FROM menu');

    while ($datos = $q->fetch_array(MYSQLI_BOTH))
    {
      $menuItems[] = new menuItem($datos);
    }

    return $menuItems;
  }

  public function getMenuItem($id)
  {
    $id = (int) $id;

    $q = $this->_db->query('SELECT id, title, link, parentId, codUser FROM menu WHERE id = '.$id);
    $datos = $q->fetch_array(MYSQLI_BOTH);

    return new menuItem($datos);
  }
  
  public function update(menuItem $item)
  {
    $q = $this->_db->prepare('UPDATE personnages SET forcePerso = :forcePerso, degats = :degats, niveau = :niveau, experience = :experience WHERE id = :id');

    $q->bindValue(':forcePerso', $perso->forcePerso(), PDO::PARAM_INT);
    $q->bindValue(':degats', $perso->degats(), PDO::PARAM_INT);
    $q->bindValue(':niveau', $perso->niveau(), PDO::PARAM_INT);
    $q->bindValue(':experience', $perso->experience(), PDO::PARAM_INT);
    $q->bindValue(':id', $perso->id(), PDO::PARAM_INT);

    $q->execute();
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
