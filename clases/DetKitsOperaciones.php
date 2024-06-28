<?php

class DetKitsOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }

    public function makeDetKit($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO det_kit (idKit, codProducto) VALUES ( ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteDetKit($idKit, $codProducto)
    {
        $qry = "DELETE FROM det_kit WHERE idKit=? AND codProducto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idKit, $codProducto));
    }

    public function getTableDetKits($idKit)
    {
        $qry = "SELECT dk.codProducto, presentacion producto
                FROM det_kit dk
                         LEFT JOIN prodpre p on dk.codProducto = p.codPresentacion
                WHERE idKit = $idKit
                  AND p.codPresentacion IS NOT NULL
                UNION
                SELECT dk.codProducto, producto
                FROM det_kit dk
                         LEFT JOIN distribucion d on dk.codProducto = d.idDistribucion
                WHERE idKit = $idKit
                  AND d.idDistribucion IS NOT NULL";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getDetKit()
    {
        $qry = "SELECT idKit, nomKit FROM det_kit ORDER BY nomKit;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getDetKitsEliminar()
    {
        $qry = "SELECT det_kit.idKit, nomKit
                FROM det_kit
                LEFT JOIN ord_prod op on det_kit.idKit = op.idKit
                WHERE op.idKit IS NULL
                ORDER BY nomKit";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getNomKit($idKit)
    {
        $qry = "SELECT nomKit FROM det_kit WHERE idKit=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idKit));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['nomKit'];
    }

    public function getKitById($idKit)
    {
        $qry = "SELECT idKit, det_kit.idProv, nomProv, numFact, fechKit, fechVenc, estadoKit, descEstado
                FROM det_kit
                         LEFT JOIN estados e on det_kit.estadoKit = e.idEstado
                         LEFT JOIN proveedores p on det_kit.idProv = p.idProv
                WHERE idKit=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idKit));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getProdNovaquim($idKit)
    {
        $qry = "SELECT codPresentacion codigo, presentacion producto
                FROM prodpre p
                LEFT JOIN det_kit dk on p.codPresentacion = dk.codProducto AND idKit=?
                WHERE p.presentacionActiva = 1 AND dk.codProducto IS NULL ORDER BY producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idKit));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getProdDistribucion($idKit)
    {
        $qry = "SELECT idDistribucion codigo, producto
                FROM distribucion d
                LEFT JOIN det_kit dk on d.idDistribucion = dk.codProducto AND idKit=?
                WHERE d.activo = 1 AND dk.codProducto IS NULL ORDER BY producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idKit));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function checkFactura($idProv, $numFact)
    {
        $qry = "SELECT idKit  FROM det_kit WHERE idProv= ? AND numFact= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idProv, $numFact));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateKit($datos)
    {
        $qry = "UPDATE det_kit SET idProv=?, numFact=?, fechKit=?, fechVenc=? WHERE idKit=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function cancelaKit($estadoKit, $fechPago, $idKit)
    {
        $qry = "UPDATE det_kit SET estadoKit=?, fechCancelacion=? WHERE idKit=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($estadoKit, $fechPago, $idKit));
    }

    public function updateEstadoKit($datos)
    {
        $qry = "UPDATE det_kit SET estadoKit=? WHERE idKit=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function updateTotalesKit($base, $idKit)
    {
        $qry = "UPDATE det_kit,
                (SELECT IF(SUM(precKit * cantKit) IS NULL, 0, ROUND(SUM(precKit * cantKit), 2)) subtotal,
                        IF(SUM(precKit * cantKit) IS NULL, 0,
                           ROUND(SUM(precKit * cantKit * tasaIva), 2)) AS iva,
                        IF(SUM(precKit * cantKit) IS NULL, 0,
                           ROUND((SUM(precKit * cantKit) + SUM(precKit * cantKit * tasaIva)),
                                 0)) total,
                        IF(autoretProv = 1, 0,
                           IF(SUM(precKit * cantKit) >= $base, ROUND(SUM(precKit * cantKit * tasaRetIca), 0),
                              0)) AS reteica,
                        IF(autoretProv = 1, 0,
                           IF(SUM(precKit * cantKit) >= $base, ROUND(SUM(precKit * cantKit * tasaRetefuente), 0),
                              0)) AS retefuente
                 FROM det_kit dg
                          LEFT JOIN det_kit g ON dg.idKit = g.idKit
                          LEFT JOIN tasa_iva ti ON dg.codIva = ti.idTasaIva
                          LEFT JOIN proveedores p ON g.idProv = p.idProv
                          LEFT JOIN tasa_reteica tr on p.idTasaIcaProv = tr.idTasaRetIca
                          LEFT JOIN tasa_retefuente t on p.idRetefuente = t.idTasaRetefuente
                      WHERE dg.idKit = $idKit) tabla
            SET totalKit=total,
                subtotalKit=subtotal,
                ivaKit=iva,
                retefuenteKit=retefuente,
                reteicaKit=reteica
            WHERE idKit = $idKit";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
    }
}
