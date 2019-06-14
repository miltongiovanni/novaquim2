<?php

class AreasPersonalOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }
    public function makeAreaPersonal($descripcion)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO areas_personal VALUES(0, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($descripcion));
        return $this->_pdo->lastInsertId();
    }
    public function deleteAreaPersonal($idArea)
    {
        $qry = "DELETE FROM areas_personal WHERE idArea= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idArea));
    }
    public function getAreasPersonal()
    {
        $qry = "SELECT idArea, area FROM areas_personal order by idArea";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAreaPersonal($idArea)
    {
        $qry = "SELECT idArea, area  from areas_personal where idArea=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idArea));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateAreaPersonal($datos)
    {
        $qry = "UPDATE areas_personal SET area=? WHERE idArea=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
