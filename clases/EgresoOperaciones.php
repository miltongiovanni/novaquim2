<?php

class EgresoOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeEgreso($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO egreso VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteEgreso($idProv)
    {
        $qry = "DELETE FROM egreso WHERE idProv= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idProv));
    }

    public function getEgresoes($actif)
    {
        if ($actif == true) {
            $qry = "SELECT idProv, nomProv FROM egreso WHERE estProv=1 ORDER BY nomProv;";
        } else {
            $qry = "SELECT idProv, nomProv FROM egreso ORDER BY nomProv;";
        }

        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getEgresoesByTipo($tipoCompra)
    {
        $qry = "SELECT idProv, nomProv FROM egreso WHERE idCatProv = $tipoCompra ORDER BY nomProv;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAllEgresoesGastos()
    {
        $qry = "SELECT idProv, nomProv FROM egreso WHERE (idCatProv = 5 OR idCatProv = 6) ORDER BY nomProv;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getEgresoesByName($q)
    {
        $qry = "SELECT idProv, nomProv FROM egreso WHERE nomProv like '%" . $q . "%' ORDER BY nomProv;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array());
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getEgresoesByNameAndTipoCompra($q, $tipoCompra)
    {
        $qry = "SELECT idProv, nomProv FROM egreso WHERE idCatProv=? AND nomProv like '%" . $q . "%' ORDER BY nomProv;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($tipoCompra));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getEgresoesGastos($q)
    {
        $qry = "SELECT idProv, nomProv FROM egreso WHERE (idCatProv=5 OR idCatProv=6) AND nomProv like '%" . $q . "%' ORDER BY nomProv;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableEgresoes()
    {
        $qry = "SELECT idProv, nitProv, nomProv, dirProv, contProv, telProv, emailProv, desCatProv FROM egreso
                LEFT JOIN cat_prov cp on egreso.idCatProv = cp.idCatProv
                WHERE estProv=1 ORDER BY nomProv;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getEgreso($idProv)
    {
        $qry = "SELECT idProv, nitProv, nomProv, dirProv, contProv, autoretProv, regProv, estProv, telProv, emailProv, egreso.idCatProv,
                       desCatProv, idTasaIcaProv, CONCAT(format((tasaRetIca),2), ' por mil') reteica, idRetefuente,
                       CONCAT(descRetefuente, ' - ', format((tasaRetefuente*100),2), ' %') retefuente
                FROM egreso
                LEFT JOIN cat_prov cp on egreso.idCatProv = cp.idCatProv
                LEFT JOIN tasa_reteica tr on egreso.idTasaIcaProv = tr.idTasaRetIca
                LEFT JOIN tasa_retefuente t on egreso.idRetefuente = t.idTasaRetefuente
                WHERE idProv=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idProv));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getPagoXIdTipoCompra($id, $tipoCompra){
        $qry = "SELECT SUM(pago) parcial FROM egreso WHERE idCompra=? and tipoCompra=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($id, $tipoCompra));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result && $result!=null){
            return $result['parcial'];
        }
        else{
            return 0;
        }
    }

    public function getTableComprasXPagar(){
        $qry = "SELECT idCompra id, tipoCompra, numFact, fechComp, fechVenc, totalCompra total, subtotalCompra subtotal,
                nomProv, retefuenteCompra retefuente, reteicaCompra reteica
                FROM compras c
                LEFT JOIN proveedores p on c.idProv = p.idProv
                WHERE estadoCompra=3
                UNION
                SELECT idGasto id, tipoCompra, numFact, fechGasto fechComp, fechVenc, totalGasto total, subtotalGasto subtotal,
                nomProv, retefuenteGasto retefuente, reteicaGasto reteica
                FROM gastos g
                LEFT JOIN proveedores p on g.idProv = p.idProv
                WHERE estadoGasto=3
                ORDER BY fechVenc";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function checkNit($nitProv)
    {
        $qry = "SELECT idProv, nitProv  FROM egreso WHERE nitProv= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($nitProv));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateEgreso($datos)
    {
        $qry = "UPDATE egreso SET nitProv=?, nomProv=?, dirProv=?, contProv=?, telProv=?, emailProv=?, idCatProv=?,  autoretProv=?, regProv=?, idTasaIcaProv=?, estProv=?, idRetefuente=? WHERE idProv=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
