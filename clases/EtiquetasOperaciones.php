<?php

class EtiquetasOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }
    public function makeEtiqueta($datos)
    {
        /*Preparo la inserción */
        $qry = "INSERT INTO etiquetas (codEtiqueta, nomEtiqueta,  stockEtiqueta, codIva) VALUES(?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }
    
    public function deleteEtiqueta($codEtiqueta)
    {
        $qry = "DELETE FROM etiquetas WHERE codEtiqueta= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codEtiqueta));
    }

    public function getEtiquetas()
    {
        $qry = "SELECT codEtiqueta, nomEtiqueta FROM etiquetas ORDER BY nomEtiqueta;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getTableEtiquetas()
    {
        $qry = "select codEtiqueta, nomEtiqueta, stockEtiqueta from etiquetas;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        //$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        return $result;
    }

    public function getEtiqueta($codEtiqueta)
    {
        $qry = "SELECT codEtiqueta, nomEtiqueta, stockEtiqueta, codIva  FROM  etiquetas WHERE codEtiqueta=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codEtiqueta));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getUltimaEtiqueta()
    {
        $qry = "SELECT MAX(codEtiqueta) as Codigo FROM etiquetas";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['Codigo'];
    }


    public function updateEtiqueta($datos)
    {                                     
        $qry = "UPDATE etiquetas SET nomEtiqueta=?, stockEtiqueta=?, codIva=? WHERE codEtiqueta=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
