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
        $qry = "SELECT idUsuario, nombre, apellido, usuario, estadoUsuario, idPerfil, fecCrea, fecCambio FROM usuarios order by idUsuario";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getTableUsers()
    {
        $qry = "SELECT usuarios.idUsuario 'Id Usuario', usuarios.Nombre as 'Nombre del Usuario',
        usuarios.Apellido as 'Apellidos del Usuario',
        usuarios.Usuario, usuarios.FecCrea as 'Fecha de Creación',
        tblestados.Descripcion as 'Estado',	tblperfiles.Descripcion as 'Perfil'
        FROM usuarios,tblperfiles, tblestados
        where usuarios.EstadoUsuario=tblestados.IdEstado and EstadoUsuario<=2
        and usuarios.IdPerfil=tblperfiles.IdPerfil order by usuarios.IdUsuario";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getUser($idUsuario)
    {
        $qry = "SELECT * from usuarios where idUsuario=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idUsuario));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getUserPassword($idUsuario, $password)
    {
        $qry = "SELECT * from usuarios where idUsuario=?";
        $q = $this->_pdo->prepare("select * from usuarios where Usuario='$usuario' and clave ='$password'");
        $q->execute();
        $result = $q->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    public function changeClave($newPass, $fec, $nombre)
    {
        $qry = "Update usuarios Set clave=md5('$newPass'), FecCambio='$fec', Intentos=0, estadousuario=2 Where usuario='$nombre'";
        $q = $this->_pdo->prepare($qry);
        $result = $q->execute();
        return $result;
    }

    public function updateUser($datos)
    {
        $qry = "UPDATE usuarios SET nombre=?, apellido=?, usuario=?, estadousuario=?, fecCrea=?, fecCambio=?, idPerfil=?, intentos=? WHERE idUsuario=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
