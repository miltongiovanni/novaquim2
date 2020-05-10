<?php

class FormaPagoOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }
    public function makeFormaPago($formaPago)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO form_pago VALUES(0, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($formaPago));
        return $this->_pdo->lastInsertId();
    }
    public function deleteFormaPago($idFormaPago)
    {
        $qry = "DELETE FROM form_pago WHERE idFormaPago= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFormaPago));
    }
    public function getFormasPago()
    {
        $qry = "SELECT idFormaPago, formaPago FROM form_pago ORDER BY idFormaPago";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getFormaPago($idFormaPago)
    {
        $qry = "SELECT idFormaPago, formaPago  from form_pago where idFormaPago=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFormaPago));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateFormaPago($datos)
    {
        $qry = "UPDATE form_pago SET formaPago=? WHERE idFormaPago=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
