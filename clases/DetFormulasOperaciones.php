<?php

class DetGastosOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeDetGasto($datos)
    {
        $qry = "INSERT INTO det_gastos (idGasto, producto, cantGasto, precGasto, codIva)VALUES(?, ?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteDetGasto($datos)
    {
        $qry = "DELETE FROM det_gastos WHERE idGasto= ? AND producto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }


    public function getTableDetGastos($idGasto)
    {
        $qry = "SELECT idGasto, producto, cantGasto, CONCAT('$', FORMAT(precGasto, 0)) precGasto,
                CONCAT(format((tasaIva*100),0), ' %') iva
                FROM det_gastos
                LEFT JOIN tasa_iva ti on det_gastos.codIva = ti.idTasaIva
                WHERE idGasto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idGasto));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getDetGasto($idGasto, $producto)
    {
        $qry = "SELECT idGasto, producto, cantGasto, precGasto,
                codIva, CONCAT(format((tasaIva*100),0), ' %') iva
                FROM det_gastos
                LEFT JOIN tasa_iva ti on det_gastos.codIva = ti.idTasaIva
                WHERE idGasto=? AND producto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idGasto, $producto));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);;
        return $result;
    }


    public function productoExiste($idGasto, $producto)
    {
        $qry = "SELECT COUNT(*) c from det_gastos where idGasto=? AND producto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idGasto, $producto));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $productoExiste = $result['c'] > 0;
        return $productoExiste;
    }


    public function updateDetGasto($datos)
    {
        $qry = "UPDATE det_gastos SET cantGasto=?, precGasto=?, codIva=? WHERE idGasto=? AND producto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
