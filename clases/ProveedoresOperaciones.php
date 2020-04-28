<?php

class ProveedoresOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeProveedor($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO proveedores VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteProveedor($idProv)
    {
        $qry = "DELETE FROM proveedores WHERE idProv= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idProv));
    }

    public function getProveedores($actif)
    {
        if ($actif == true) {
            $qry = "SELECT idProv, nomProv FROM proveedores WHERE estProv=1 ORDER BY nomProv;";
        } else {
            $qry = "SELECT idProv, nomProv FROM proveedores ORDER BY nomProv;";
        }

        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getProveedoresByTipo($tipoCompra)
    {
        $qry = "SELECT idProv, nomProv FROM proveedores WHERE idCatProv = $tipoCompra ORDER BY nomProv;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getProveedoresByName($q)
    {
        $qry = "SELECT idProv, nomProv FROM proveedores WHERE nomProv like '%" . $q . "%' ORDER BY nomProv;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getProveedoresByNameAndTipoCompra($q, $tipoCompra)
    {
        $qry = "SELECT idProv, nomProv FROM proveedores WHERE idCatProv=? AND nomProv like '%" . $q . "%' ORDER BY nomProv;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($tipoCompra));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableProveedores()
    {
        $qry = "SELECT idProv, nitProv, nomProv, dirProv, contProv, telProv, emailProv, desCatProv FROM proveedores
                LEFT JOIN cat_prov cp on proveedores.idCatProv = cp.idCatProv
                WHERE estProv=1 ORDER BY nomProv;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getProveedor($idProv)
    {
        $qry = "SELECT idProv, nitProv, nomProv, dirProv, contProv, autoretProv, regProv, estProv, telProv, emailProv, proveedores.idCatProv,
                       desCatProv, idTasaIcaProv, CONCAT(format((tasaRetIca),2), ' por mil') reteica, idRetefuente,
                       CONCAT(descRetefuente, ' - ', format((tasaRetefuente*100),2), ' %') retefuente
                FROM proveedores
                LEFT JOIN cat_prov cp on proveedores.idCatProv = cp.idCatProv
                LEFT JOIN tasa_reteica tr on proveedores.idTasaIcaProv = tr.idTasaRetIca
                LEFT JOIN tasa_retefuente t on proveedores.idRetefuente = t.idTasaRetefuente
                WHERE idProv=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idProv));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function checkNit($nitProv)
    {
        $qry = "SELECT idProv, nitProv  FROM proveedores WHERE nitProv= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($nitProv));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateProveedor($datos)
    {
        $qry = "UPDATE proveedores SET nitProv=?, nomProv=?, dirProv=?, contProv=?, telProv=?, emailProv=?, idCatProv=?,  autoretProv=?, regProv=?, idTasaIcaProv=?, estProv=?, idRetefuente=? WHERE idProv=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
