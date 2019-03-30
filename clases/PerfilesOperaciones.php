<?php

class PerfilesOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }
    public function makePerfil($descripcion)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO perfiles VALUES(0, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($descripcion));
        return $this->_pdo->lastInsertId();
    }
    public function deletePerfil($idPerfil)
    {
        $qry = "DELETE FROM perfiles WHERE idPerfil= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idPerfil));
    }
    public function getPerfiles()
    {
        $qry = "SELECT idPerfil, descripcion FROM perfiles order by idPerfil";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getPerfil($idPerfil)
    {
        $qry = "SELECT * from perfiles where idPerfil=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idPerfil));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updatePerfil($datos)
    {
        $qry = "UPDATE perfiles SET descripcion=? WHERE idPerfil=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
