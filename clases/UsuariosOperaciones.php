<?php

class UsuariosOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }
    public function makeUser($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO usuarios VALUES(0, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }
    public function deleteUser($idUsuario)
    {
        $qry = "DELETE FROM usuarios WHERE idUsuario= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idUsuario));
    }
    public function getUsers($actif)
    {
        if($actif==true){
            $qry = "SELECT idUsuario, nombre, apellido, usuario, estadoUsuario, usuarios.idPerfil, perfiles.descripcion perfil, estados_usuarios.descripcion estado, fecCrea, fecCambio 
            FROM usuarios, perfiles, estados_usuarios WHERE usuarios.idPerfil=perfiles.idPerfil AND estadoUsuario=idEstado AND estadoUsuario=2 ORDER BY idUsuario;";
        }
        else{
            $qry = "SELECT idUsuario, nombre, apellido, usuario, estadoUsuario, usuarios.idPerfil, perfiles.descripcion perfil, estados_usuarios.descripcion estado, fecCrea, fecCambio 
            FROM usuarios, perfiles, estados_usuarios WHERE usuarios.idPerfil=perfiles.idPerfil AND estadoUsuario=idEstado ORDER BY idUsuario;";
        }
        
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getTableUsers()
    {
        $qry = "SELECT idUsuario, nombre, apellido, usuario, estadoUsuario, usuarios.idPerfil, perfiles.descripcion perfil, estados_usuarios.descripcion estado, fecCrea, fecCambio 
        FROM usuarios, perfiles, estados_usuarios WHERE usuarios.idPerfil=perfiles.idPerfil AND estadoUsuario=idEstado AND (estadoUsuario=2 OR estadoUsuario=1) ORDER BY idUsuario;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getUser($idUsuario)
    {
        $qry = "SELECT idUsuario, nombre, apellido, usuario, estadoUsuario, usuarios.idPerfil, perfiles.descripcion perfil, estados_usuarios.descripcion estado, fecCrea, fecCambio 
        FROM usuarios, perfiles, estados_usuarios WHERE usuarios.idPerfil=perfiles.idPerfil AND estadoUsuario=idEstado AND idUsuario=? ORDER BY idUsuario;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idUsuario));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getUserPassword($idUsuario, $password)
    {
        $qry = "SELECT * from usuarios WHERE usuario=? AND clave=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idUsuario, $password));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    public function changeClave($newPass, $fec, $nombre)
    {
        $qry = "UPDATE usuarios SET clave=?, FecCambio=?, Intentos=0, estadousuario=2 WHERE usuario=?";
        $stmt = $this->_pdo->prepare($qry);
        $result = $stmt->execute(array(md5($newPass), $fec, $nombre));
        return $result;
    }

    public function updateUser($datos)
    {
        $qry = "UPDATE usuarios SET nombre=?, apellido=?, usuario=?, estadousuario=?, idPerfil=?, fecCambio=?,  intentos=? WHERE idUsuario=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
