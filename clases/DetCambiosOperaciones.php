<?php

class DetCambiosOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }
    public function makeDetCambio($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO det_cambios (idCambio, codPresentacionAnt, cantPresentacionAnt, loteProd) VALUES (?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }
    public function makeDetCambio2($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO det_cambios2 (idCambio, codPresentacionNvo, cantPresentacionNvo, loteProd) VALUES (?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }
    public function deleteCambio($idCambio)
    {
        $qry = "DELETE FROM cambios WHERE idCambio= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCambio));
    }
    public function getDetCambiosTable($idCambio)
    {
        $qry = "SELECT idCambio, codPresentacionAnt, presentacion, cantPresentacionAnt
                FROM det_cambios dc
                LEFT JOIN prodpre p on dc.codPresentacionAnt = p.codPresentacion
                WHERE idCambio=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCambio));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getDetCambio($idCambio)
    {
        $qry = "SELECT idCambio, codPresentacionAnt, presentacion, cantPresentacionAnt, loteProd
                FROM det_cambios dc
                LEFT JOIN prodpre p on dc.codPresentacionAnt = p.codPresentacion
                WHERE idCambio=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCambio));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getDetCambios2Table($idCambio)
    {
        $qry = "SELECT idCambio, codPresentacionNvo, presentacion, cantPresentacionNvo
                FROM det_cambios2 dc2
                LEFT JOIN prodpre p on dc2.codPresentacionNvo = p.codPresentacion
                WHERE idCambio=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCambio));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getDetCambio2($idCambio)
    {
        $qry = "SELECT idCambio, codPresentacionNvo, presentacion, cantPresentacionNvo, loteProd
                FROM det_cambios2 dc2
                LEFT JOIN prodpre p on dc2.codPresentacionNvo = p.codPresentacion
                WHERE idCambio=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCambio));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getPresentacionesByCod($codPresentacion, $idCambio, $volCambiar)
    {

        $qry = "SELECT t.codPresentacion, t.presentacion
                    FROM
                (SELECT codPresentacion, presentacion
                FROM prodpre
                         LEFT JOIN medida m on prodpre.codMedida = m.idMedida
                WHERE codProducto=(SELECT codProducto FROM prodpre WHERE codPresentacion=$codPresentacion)
                  AND m.cantMedida<$volCambiar
                  AND presentacionActiva=1) t
                LEFT JOIN det_cambios2 dc2 ON t.codPresentacion=dc2.codPresentacionNvo AND dc2.idCambio=$idCambio
                WHERE dc2.codPresentacionNvo IS NULL";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getCantidadPorCambiar($idCambio)
    {
        $qry = "SELECT ROUND((cantPresentacionAnt* m.cantMedida - IF(cantCambiada>0, cantCambiada, 0)),0) cantPendXCambiar
                FROM det_cambios dc
                    LEFT JOIN prodpre p ON dc.codPresentacionAnt = p.codPresentacion
                    LEFT JOIN medida m ON p.codMedida = m.idMedida
                    LEFT JOIN (SELECT idCambio, SUM(cantPresentacionNvo*cantMedida) cantCambiada
                                FROM det_cambios2 dc2
                                    LEFT JOIN prodpre p on dc2.codPresentacionNvo = p.codPresentacion
                                    LEFT JOIN medida m on p.codMedida = m.idMedida
                                WHERE dc2.idCambio=$idCambio
                                GROUP BY idCambio) tab ON dc.idCambio=tab.idCambio
                WHERE dc.idCambio=$idCambio";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['cantPendXCambiar'];
    }

    public function getLastCambio()
    {
        $qry = "SELECT MAX(idCambio) AS valor FROM cambios order by idCambio";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result["valor"];
    }
    
    public function getCambio($idCambio)
    {
        $qry = "SELECT idCambio, desCambio from cambios where idCambio=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCambio));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateCambio($datos)
    {
        $qry = "UPDATE cambios SET desCambio=? WHERE idCambio=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
