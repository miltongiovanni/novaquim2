<?php

class TapasOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }
    public function makeTapa($datos)
    {
        /*Preparo la inserción */
        $qry = "INSERT INTO tapas_val (codTapa, tapa,  stockTapa, codIva) VALUES(?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }
    
    public function deleteTapa($codTapa)
    {
        $qry = "DELETE FROM tapas_val WHERE codTapa= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codTapa));
    }

    public function getTapas()
    {
        $qry = "SELECT codTapa, tapa FROM tapas_val ORDER BY tapa;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getPrecioTapa($codTapa)
    {
        $qry = "SELECT preTapa FROM  tapas_val WHERE codTapa=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codTapa));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['preTapa'];
    }
    public function getTableTapas()
    {
        $qry = "select codTapa, tapa, stockTapa from tapas_val;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTapa($codTapa)
    {
        $qry = "SELECT codTapa, tapa, stockTapa, codIva  FROM  tapas_val WHERE codTapa=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codTapa));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getUltimaTapa()
    {
        $qry = "SELECT MAX(codTapa) as Codigo FROM tapas_val";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['Codigo'];
    }

    public function updatePrecioTapa($datos)
    {
        $qry = "UPDATE tapas_val SET preTapa=? WHERE codTapa=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function updateTapa($datos)
    {                                     
        $qry = "UPDATE tapas_val SET tapa=?, stockTapa=?, codIva=? WHERE codTapa=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
