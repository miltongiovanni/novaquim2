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
    public function getUsers()
    {
        $qry = "SELECT idUsuario, nombre, apellido, usuario, estadoUsuario, idPerfil, fecCrea, fecCambio FROM usuarios ORDER BY idUsuario";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getTableUsers()
    {
        $qry = "SELECT usuarios.idUsuario 'Id Usuario', usuarios.Nombre AS 'Nombre del Usuario',
        usuarios.Apellido AS 'Apellidos del Usuario',
        usuarios.Usuario, usuarios.FecCrea AS 'Fecha de Creación',
        estados_usuarios.Descripcion AS 'Estado',	perfiles.Descripcion AS 'Perfil'
        FROM usuarios,perfiles, estados_usuarios
        WHERE usuarios.EstadoUsuario=estados_usuarios.IdEstado AND EstadoUsuario<=2
        AND usuarios.IdPerfil=perfiles.IdPerfil ORDER BY usuarios.IdUsuario";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        //$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        return $result;
    }

    public function getUser($idUsuario)
    {
        $qry = "SELECT * from usuarios WHERE idUsuario=?";
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
        $qry = "UPDATE usuarios SET nombre=?, apellido=?, usuario=?, estadousuario=?, fecCrea=?, fecCambio=?, idPerfil=?, intentos=? WHERE idUsuario=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
