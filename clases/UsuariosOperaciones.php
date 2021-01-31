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
            $qry = "SELECT idUsuario,
                           nombre,
                           apellido,
                           usuario,
                           estadoUsuario,
                           u.idPerfil,
                           p.descripcion         perfil,
                           eu.descripcion estado,
                           fecCrea,
                           fecCambio
                    FROM usuarios u
                    LEFT JOIN perfiles p on u.idPerfil = p.idPerfil
                    LEFT JOIN estados_usuarios eu on eu.idEstado = u.estadoUsuario
                    WHERE  estadoUsuario = 2
                    ORDER BY idUsuario";
        }
        else{
            $qry = "SELECT idUsuario,
                           nombre,
                           apellido,
                           usuario,
                           estadoUsuario,
                           u.idPerfil,
                           p.descripcion         perfil,
                           eu.descripcion estado,
                           fecCrea,
                           fecCambio
                    FROM usuarios u
                    LEFT JOIN perfiles p on u.idPerfil = p.idPerfil
                    LEFT JOIN estados_usuarios eu on eu.idEstado = u.estadoUsuario
                    ORDER BY idUsuario";
        }
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getTableUsers()
    {
        $qry = "SELECT idUsuario,
                       nombre,
                       apellido,
                       usuario,
                       estadoUsuario,
                       u.idPerfil,
                       p.descripcion  perfil,
                       eu.descripcion estado,
                       fecCrea,
                       fecCambio
                FROM usuarios u
                         LEFT JOIN perfiles p on u.idPerfil = p.idPerfil
                         LEFT JOIN estados_usuarios eu on eu.idEstado = u.estadoUsuario
                WHERE estadoUsuario = 2 OR estadoUsuario = 1
                ORDER BY idUsuario";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getUser($idUsuario)
    {
        $qry = "SELECT idUsuario,
                       nombre,
                       apellido,
                       usuario,
                       estadoUsuario,
                       u.idPerfil,
                       p.descripcion  perfil,
                       eu.descripcion estado,
                       fecCrea,
                       intentos,
                       fecCambio
                FROM usuarios u
                         LEFT JOIN perfiles p on u.idPerfil = p.idPerfil
                         LEFT JOIN estados_usuarios eu on eu.idEstado = u.estadoUsuario
                WHERE idUsuario = ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idUsuario));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getUserByUsername($username)
    {
        $qry = "SELECT idUsuario,
                       nombre,
                       apellido,
                       usuario,
                       estadoUsuario,
                       u.idPerfil,
                       p.descripcion  perfil,
                       eu.descripcion estado,
                       fecCrea,
                       intentos,
                       fecCambio
                FROM usuarios u
                         LEFT JOIN perfiles p on u.idPerfil = p.idPerfil
                         LEFT JOIN estados_usuarios eu on eu.idEstado = u.estadoUsuario
                WHERE usuario = ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($username));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function validarUsuario($username, $password)
    {
        $qry = "SELECT idUsuario,
                       nombre,
                       apellido,
                       usuario,
                       estadoUsuario,
                       u.idPerfil,
                       p.descripcion  perfil,
                       eu.descripcion estado,
                       fecCrea,
                       intentos,
                       fecCambio
                FROM usuarios u
                         LEFT JOIN perfiles p on u.idPerfil = p.idPerfil
                         LEFT JOIN estados_usuarios eu on eu.idEstado = u.estadoUsuario
                WHERE usuario = ?
                  AND clave = ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($username, $password));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getResponsableCalidad()
    {
        $qry = "SELECT CONCAT(nombre,' ',apellido) as nombre, descripcion
                FROM usuarios
                LEFT JOIN perfiles p on usuarios.idPerfil = p.idPerfil
                WHERE estadoUsuario=2 AND p.idPerfil=9";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
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

    public function updateIntentos($datos)
    {
        $qry = "UPDATE usuarios SET intentos=? WHERE idUsuario=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
