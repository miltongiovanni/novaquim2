<?php

class ComprasOperaciones
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

    public function makeCompra($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO compras (idProv, numFact, fechComp, fechVenc, estadoCompra, tipoCompra, idUsuario, descuentoCompra) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function getTableCompras($tipoCompra)
    {
        $qry = "SELECT idCompra, nitProv, nomProv, numFact, fechComp, fechVenc, descEstado, CONCAT('$', FORMAT(totalCompra, 2)) totalCompra,
                CONCAT('$', FORMAT(retefuenteCompra, 2)) retefuenteCompra, CONCAT('$', FORMAT(reteicaCompra, 2)) reteicaCompra, CONCAT('$', FORMAT(reteivaCompra, 2)) reteivaCompra,
                CONCAT('$', FORMAT(totalCompra-retefuenteCompra-reteicaCompra-reteivaCompra, 2))  vreal
                FROM compras
                   LEFT JOIN estados e on compras.estadoCompra = e.idEstado
                   LEFT JOIN proveedores p on compras.idProv = p.idProv
                WHERE tipoCompra=?
                ORDER BY idCompra DESC;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($tipoCompra));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getFechaCompra($id){
        $qry = "SELECT fechComp FROM compras WHERE idCompra = $id";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['fechComp'];
    }
    public function getTableComprasPorFecha($fechaIni, $fechaFin)
    {
        $qry = "SELECT idCompra,
                       nitProv,
                       nomProv,
                       numFact,
                       tc.tipoComp,
                       fechComp,
                       CONCAT('$', FORMAT(subtotalCompra, 2))                                 subtotalCompra,
                       CONCAT('$', FORMAT(ivaCompra, 2))                                      ivaCompra,
                       CONCAT('$', FORMAT(retefuenteCompra, 2))                               retefuenteCompra,
                       CONCAT('$', FORMAT(reteicaCompra, 2))                                  reteicaCompra,
                       CONCAT('$', FORMAT(totalCompra, 2))                                    totalCompra,
                       CONCAT('$', FORMAT(totalCompra - retefuenteCompra - reteicaCompra, 2)) vreal
                FROM compras
                         LEFT JOIN proveedores p on compras.idProv = p.idProv
                         LEFT JOIN tip_compra tc on compras.tipoCompra = tc.idTipo
                WHERE fechComp >= ?
                  AND fechComp <= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($fechaIni, $fechaFin));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    public function getTotalesComprasPorFecha($fechaIni, $fechaFin)
    {
        $qry = "SELECT
                       CONCAT('$', FORMAT(SUM(subtotalCompra), 2))                                 subtotalPeriodo,
                       CONCAT('$', FORMAT(SUM(ivaCompra), 2))                                      ivaPeriodo,
                       CONCAT('$', FORMAT(SUM(totalCompra), 2))                                    totalPeriodo,
                       CONCAT('$', FORMAT(SUM(retefuenteCompra), 2))                               retefuentePeriodo,
                       CONCAT('$', FORMAT(SUM(reteicaCompra), 2))                                  reteicaPeriodo
                FROM compras
                WHERE fechComp >= ?
                  AND fechComp <= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($fechaIni, $fechaFin));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }


    public function getCompra($idCompra, $tipoCompra)
    {
        $qry = "SELECT idCompra,
                       compras.idProv,
                       nitProv,
                       nomProv,
                       numFact,
                       fechComp,
                       fechVenc,
                       estadoCompra,
                       descEstado,
                       subtotalCompra subtotal,
                       ivaCompra iva,
                       retefuenteCompra retefuente,
                       reteicaCompra reteica,
                       reteivaCompra reteiva,
                       CONCAT('$', FORMAT(subtotalCompra, 2))                                 subtotalCompra,
                       CONCAT('$', FORMAT(descuentoCompra, 2))                                descuentoCompra,
                       CONCAT('$', FORMAT(ivaCompra, 2))                                      ivaCompra,
                       CONCAT('$', FORMAT(totalCompra, 2))                                    totalCompra,
                       CONCAT('$', FORMAT(retefuenteCompra, 2))                               retefuenteCompra,
                       CONCAT('$', FORMAT(reteicaCompra, 2))                                  reteicaCompra,
                       CONCAT('$', FORMAT(reteivaCompra, 2))                                  reteivaCompra,
                       CONCAT('$', FORMAT((totalCompra - retefuenteCompra - reteicaCompra - reteivaCompra), 2)) vreal
                FROM compras
                         LEFT JOIN estados e on compras.estadoCompra = e.idEstado
                         LEFT JOIN proveedores p on compras.idProv = p.idProv
                WHERE tipoCompra = ?
                  AND idCompra = ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($tipoCompra, $idCompra));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCompraById($idCompra)
    {
        $qry = "SELECT idCompra, tipoCompra, compras.idProv, nomProv, numFact, fechComp, fechVenc, estadoCompra, descEstado, descuentoCompra
                FROM compras
                         LEFT JOIN estados e on compras.estadoCompra = e.idEstado
                         LEFT JOIN proveedores p on compras.idProv = p.idProv
                WHERE idCompra=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCompra));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function checkFactura($idProv, $numFact)
    {
        $qry = "SELECT idCompra  FROM compras WHERE idProv= ? AND numFact= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idProv, $numFact));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function isValidIdCompra($idCompra)
    {
        $qry = "SELECT * FROM compras WHERE idCompra=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCompra));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function updateCompra($datos)
    {
        $qry = "UPDATE compras SET idProv=?, numFact=?, fechComp=?, fechVenc=?, descuentoCompra=? WHERE idCompra=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function updateEstadoCompra($datos)
    {
        $qry = "UPDATE compras SET estadoCompra=? WHERE idCompra=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function cancelaCompra($estadoCompra, $fechPago, $idCompra)
    {
        $qry = "UPDATE compras SET estadoCompra=?, fechCancelacion=? WHERE idCompra=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($estadoCompra, $fechPago, $idCompra));
    }

    public function updateTotalesCompra($tipoCompra, $base, $baseReteica, $idCompra)
    {
        if ($tipoCompra == 2) {
            $qry = "UPDATE compras, (
                        SELECT IF(subtotal_c = 0, 0 , ROUND((subtotal_c ),2)) subtotal,
                        IF(iva_c = 0, 0 , ROUND((iva_c - descuentoCompra * tasa_iva_avg ),2)) iva,
                        IF(subtotal_c = 0, 0 , ROUND((subtotal_c + iva_c - descuentoCompra - descuentoCompra * tasa_iva_avg),2)) total,
                        IF(autoretProv=1, 0, IF((subtotal_c - descuentoCompra) >=$baseReteica, ROUND((subtotal_c - descuentoCompra)*tasaRetIca/1000,2),0)) AS reteica,
                        IF(autoretProv=1, 0, IF((subtotal_c - descuentoCompra) >=$base, ROUND((subtotal_c - descuentoCompra)*tasaRetefuente,2),0)) AS retefuente,
                        IF(regProv=2, ROUND((iva_c - descuentoCompra * tasa_iva_avg )*0.15,2), 0) AS reteiva
                        FROM (
                        SELECT IF(SUM(precio*cantidad) IS NULL, 0, SUM(precio*cantidad)) subtotal_c, 
                        c.descuentoCompra,
                        IF(SUM(precio*cantidad) IS NULL, 0, SUM(precio*cantidad*tasaIva)) AS iva_c, 
                        SUM(precio*cantidad*tasaIva)/SUM(precio*cantidad) tasa_iva_avg,
                        tasaRetIca,
                        autoretProv,
                        regProv,
                        tasaRetefuente
                        FROM (SELECT dc.idCompra, codigo, cantidad, precio, lote, tasaIva
                         FROM det_compras dc
                                  LEFT JOIN envases e ON e.codEnvase = codigo
                                  LEFT JOIN tasa_iva ti on e.codIva = ti.idTasaIva
                         WHERE dc.idCompra = $idCompra AND codigo < 100
                         UNION
                         SELECT dc.idCompra, codigo, cantidad, precio, lote, tasaIva
                         FROM det_compras dc
                                  LEFT JOIN tapas_val tv ON tv.codTapa = codigo
                                  LEFT JOIN tasa_iva ti on tv.codIva = ti.idTasaIva
                         WHERE dc.idCompra = $idCompra AND codigo > 100) tb
                        LEFT JOIN compras c ON tb.idCompra = c.idCompra
                        LEFT JOIN proveedores p ON c.idProv = p.idProv
                        LEFT JOIN tasa_reteica tr ON p.idTasaIcaProv = tr.idTasaRetIca
                        LEFT JOIN tasa_retefuente t ON p.idRetefuente = t.idTasaRetefuente
                        WHERE tb.idCompra = $idCompra) t) tabla SET totalCompra=total, subtotalCompra=subtotal, ivaCompra=iva, retefuenteCompra=retefuente, reteicaCompra=reteica, reteivaCompra=reteiva
                        WHERE idCompra=$idCompra";
        } else {
            $qry = "UPDATE compras, (
                    SELECT IF(subtotal_c = 0, 0 , ROUND((subtotal_c),2)) subtotal,
                    IF(iva_c = 0, 0 , ROUND((iva_c - descuentoCompra * tasa_iva_avg ),2)) iva,
                    IF(subtotal_c = 0, 0 , ROUND((subtotal_c + iva_c - descuentoCompra - descuentoCompra * tasa_iva_avg),2)) total,
                    IF(autoretProv=1, 0, IF((subtotal_c - descuentoCompra) >=$base, ROUND((subtotal_c - descuentoCompra)*tasaRetIca/1000,2),0)) AS reteica,
                    IF(autoretProv=1, 0, IF((subtotal_c - descuentoCompra) >=$base, ROUND((subtotal_c - descuentoCompra)*tasaRetefuente,2),0)) AS retefuente,
                    IF(regProv=2, ROUND((iva_c - descuentoCompra * tasa_iva_avg )*0.15,2), 0) AS reteiva
                    FROM (
                    SELECT IF(SUM(precio*cantidad) IS NULL, 0, SUM(precio*cantidad)) subtotal_c, 
                    c.descuentoCompra,
                    IF(SUM(precio*cantidad) IS NULL, 0, SUM(precio*cantidad*tasaIva)) AS iva_c, 
                    AVG(tasaIva) tasa_iva_avg,
                    tasaRetIca,
                    autoretProv,
                    regProv,
                    tasaRetefuente
                    FROM det_compras dc
                    LEFT JOIN compras c ON dc.idCompra = c.idCompra
                    LEFT JOIN proveedores p ON c.idProv = p.idProv ";
            switch (intval($tipoCompra)) {
                case 1:
                    $qry .= "LEFT JOIN mprimas mp ON dc.codigo = mp.codMPrima
                        LEFT JOIN tasa_iva ti on mp.codIva = ti.idTasaIva ";
                    break;
                case 3:
                    $qry .= "LEFT JOIN etiquetas e ON dc.codigo = e.codEtiqueta
                        LEFT JOIN tasa_iva ti on e.codIva = ti.idTasaIva ";
                    break;
                case 5:
                    $qry .= "LEFT JOIN distribucion d ON dc.codigo = d.idDistribucion
                        LEFT JOIN tasa_iva ti on d.codIva = ti.idTasaIva ";
                    break;
            }
            $qry .= "LEFT JOIN tasa_reteica tr on p.idTasaIcaProv = tr.idTasaRetIca
                    LEFT JOIN tasa_retefuente t on p.idRetefuente = t.idTasaRetefuente
                    WHERE dc.idCompra = $idCompra)t ) tabla
                    SET totalCompra=total, subtotalCompra=subtotal, ivaCompra=iva, retefuenteCompra=retefuente, reteicaCompra=reteica, reteivaCompra=reteiva
                    WHERE idCompra=$idCompra";
        }

        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();

    }
}
