<?php

class CargosPersonalOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }
    public function makeCargoPersonal($descripcion)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO cargos_personal VALUES(0, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($descripcion));
        return $this->_pdo->lastInsertId();
    }
    public function deleteCargoPersonal($idCargo)
    {
        $qry = "DELETE FROM cargos_personal WHERE idCargo= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCargo));
    }
    public function getCargosPersonal()
    {
        $qry = "SELECT idCargo, cargo FROM cargos_personal order by idCargo";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCargoPersonal($idCargo)
    {
        $qry = "SELECT idCargo, cargo  from cargos_personal where idCargo=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCargo));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateCargoPersonal($datos)
    {
        $qry = "UPDATE cargos_personal SET cargo=? WHERE idCargo=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
