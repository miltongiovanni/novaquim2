<?php

class TasaRetefuenteOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }
    public function makeTasaRetefuente($tasaRetefuente, $descRetefuente)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO tasa_retefuente VALUES(0, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($tasaRetefuente, $descRetefuente));
        return $this->_pdo->lastInsertId();
    }
    public function deleteTasaRetefuente($idTasaRetefuente)
    {
        $qry = "DELETE FROM tasa_retefuente WHERE idTasaRetefuente= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idTasaRetefuente));
    }
    public function getTasasRetefuente()
    {
        $qry = "SELECT idTasaRetefuente, CONCAT(descRetefuente, ' - ', format((tasaRetefuente*100),2), ' %') retefuente FROM tasa_retefuente order by tasaRetefuente";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTasaRetefuente($idTasaRetefuente)
    {
        $qry = "SELECT idTasaRetefuente, tasaRetefuente  from tasa_retefuente where idTasaRetefuente=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idTasaRetefuente));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateTasaRetefuente($datos)
    {
        $qry = "UPDATE tasa_retefuente SET tasaRetefuente=?, descRetefuente=? WHERE idTasaRetefuente=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
