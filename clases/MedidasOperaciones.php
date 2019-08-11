<?php

class MedidasOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }
    public function makeMedida($datos)
    {
        /*Preparo la inserción */
        $qry = "INSERT INTO medida (idMedida, desMedida,  cantMedida) VALUES(?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }
    
    public function deleteMedida($idMedida)
    {
        $qry = "DELETE FROM medida WHERE idMedida= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idMedida));
    }

    public function getMedidas()
    {
        $qry = "SELECT idMedida, desMedida, cantMedida FROM medida ORDER BY desMedida;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getTableMedidas()
    {
        $qry = "select idMedida as 'Código', desMedida as Medida, cantMedida as 'Stock Mínimo' from medida;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        //$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        return $result;
    }

    public function getMedida($idMedida)
    {
        $qry = "SELECT idMedida, desMedida, cantMedida  FROM  medida WHERE idMedida=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idMedida));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getUltimaMedida()
    {
        $qry = "SELECT MAX(idMedida) as Codigo FROM medida";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['Codigo'];
    }


    public function updateMedida($datos)
    {                                     
        $qry = "UPDATE medida SET desMedida=?, cantMedida=? WHERE idMedida=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
