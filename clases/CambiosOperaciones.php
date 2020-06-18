<?php

class CambiosOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }
    public function makeCambio($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO cambios (codPersonal, fechaCambio) VALUES (?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }
    public function deleteCambio($idCambio)
    {
        $qry = "DELETE FROM cambios WHERE idCambio= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCambio));
    }
    public function getCambiosTable()
    {
        $qry = "SELECT idCambio, nomPersonal, fechaCambio
                FROM cambios c
                LEFT JOIN personal p on c.codPersonal = p.idPersonal";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getLastCambio()
    {
        $qry = "SELECT MAX(idCambio) AS valor FROM cambios order by idCambio";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result["valor"];
    }

    public function getCambio($idCambio)
    {
        $qry = "SELECT idCambio, nomPersonal, fechaCambio 
                FROM cambios C 
                    LEFT JOIN personal p ON c.codPersonal = p.idPersonal 
                WHERE idCambio=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCambio));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateCambio($datos)
    {
        $qry = "UPDATE cambios SET desCambio=? WHERE idCambio=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
