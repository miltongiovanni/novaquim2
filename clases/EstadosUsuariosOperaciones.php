<?php

class EstadosUsuariosOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }
    public function makeEstado($descripcion)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO estados_usuarios VALUES(0, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($descripcion));
        return $this->_pdo->lastInsertId();
    }
    public function deleteEstado($idEstado)
    {
        $qry = "DELETE FROM estados_usuarios WHERE idEstado= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idEstado));
    }
    public function getEstados()
    {
        $qry = "SELECT idEstado, descripcion estado FROM estados_usuarios order by idEstado";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getEstado($idEstado)
    {
        $qry = "SELECT idEstado, descripcion estado from estados_usuarios where idEstado=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idEstado));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateEstado($datos)
    {
        $qry = "UPDATE estados_usuarios SET descripcion=? WHERE idEstado=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
