<?php

class TasaIvaOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }
    public function makeTasaIva($tasaIva)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO tasa_iva VALUES(0, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($tasaIva));
        return $this->_pdo->lastInsertId();
    }
    public function deleteTasaIva($idTasaIva)
    {
        $qry = "DELETE FROM tasa_iva WHERE idTasaIva= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idTasaIva));
    }
    public function getTasasIva()
    {
        $qry = "SELECT idTasaIva, CONCAT(format((tasaIva*100),1), ' %') iva FROM tasa_iva order by tasaIva";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTasaIva($idTasaIva)
    {
        $qry = "SELECT idTasaIva, tasaIva  from tasa_iva where idTasaIva=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idTasaIva));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateTasaIva($datos)
    {
        $qry = "UPDATE tasa_iva SET tasaIva=? WHERE idTasaIva=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
