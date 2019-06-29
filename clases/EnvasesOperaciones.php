<?php

class EnvasesOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }
    public function makeEnvase($datos)
    {
        /*Preparo la inserción */
        $qry = "INSERT INTO envases (codEnvase, nomEnvase,  stockEnvase, codIva) VALUES(?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }
    
    public function deleteEnvase($codEnvase)
    {
        $qry = "DELETE FROM envases WHERE codEnvase= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codEnvase));
    }

    public function getEnvases()
    {
        $qry = "SELECT codEnvase, nomEnvase FROM envases ORDER BY nomEnvase;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getTableEnvases()
    {
        $qry = "select codEnvase as 'Código', nomEnvase as Envase, stockEnvase as 'Stock Mínimo' from envases;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        //$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        return $result;
    }

    public function getEnvase($codEnvase)
    {
        $qry = "SELECT codEnvase, nomEnvase, stockEnvase, codIva  FROM  envases WHERE codEnvase=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codEnvase));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getUltimoEnvase()
    {
        $qry = "SELECT MAX(codEnvase) as Codigo FROM envases";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['Codigo'];
    }


    public function updateEnvase($datos)
    {                                     
        $qry = "UPDATE envases SET nomEnvase=?, stockEnvase=?, codIva=? WHERE codEnvase=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
