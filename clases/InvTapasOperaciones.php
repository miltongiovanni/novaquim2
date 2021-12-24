<?php

class InvTapasOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeInvTapas($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO inv_tapas_val VALUES(?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteInvTapas($datos)
    {
        $qry = "DELETE FROM inv_tapas_val WHERE codTapa= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function getInvTapas($codTapa)
    {
        $qry = "SELECT invTapa FROM inv_tapas_val WHERE codTapa=? ";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codTapa));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result == null) {
            return $result;
        } else {
            return $result['invTapa'];
        }
    }

    public function getTableInvTapas()
    {
        $qry = "SELECT itv.codTapa, tapa, invTapa
                FROM inv_tapas_val itv
                LEFT JOIN tapas_val tv on itv.codTapa = tv.codTapa
                WHERE invTapa>0 AND itv.codTapa !=114";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableDetalleInvTapas()
    {
        $qry = "SELECT itv.codTapa, tapa, invTapa, preTapa
                FROM inv_tapas_val itv
                         LEFT JOIN tapas_val tv on itv.codTapa = tv.codTapa
                WHERE itv.codTapa !=114";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableStockInvTapas()
    {
        $qry = "SELECT itv.codTapa, tapa, invTapa, stockTapa
                FROM inv_tapas_val itv
                         LEFT JOIN tapas_val tv on itv.codTapa = tv.codTapa
                WHERE invTapa > 0
                  AND itv.codTapa != 114
                  AND invTapa < stockTapa";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableInvTapasFecha($fecha)
    {
        $qry = "SELECT i.codTapa,
                       i.tapa,
                       i.invTapa,
                       ec.entradaCompra,
                       ec2.entradaCambio,
                       sp.salidaProduccion,
                       sed.salidaEnvasadoDist,
                       sj.salidaJabones,
                       sc.salidaCambios
                FROM (SELECT itv.codTapa, tapa, invTapa
                      FROM inv_tapas_val itv
                               LEFT JOIN tapas_val tv on itv.codTapa = tv.codTapa
                      WHERE invTapa > 0
                        AND itv.codTapa != 114) i
                         LEFT JOIN (SELECT codigo, ROUND(SUM(cantidad)) entradaCompra
                                    FROM compras c
                                             LEFT JOIN det_compras dc on c.idCompra = dc.idCompra
                                    WHERE tipoCompra = 2
                                      AND codigo > 100
                                      AND fechComp >= '$fecha'
                                    GROUP BY codigo) ec ON i.codTapa = ec.codigo
                         LEFT JOIN (SELECT codTapa, SUM(cantPresentacionNvo) entradaCambio
                                    FROM cambios c
                                             LEFT JOIN det_cambios2 d on c.idCambio = d.idCambio
                                             LEFT JOIN prodpre p on d.codPresentacionNvo = p.codPresentacion
                                    WHERE fechaCambio >= '$fecha'
                                    GROUP BY codTapa) ec2 ON ec2.codTapa = i.codTapa
                         LEFT JOIN (SELECT codTapa, SUM(cantPresentacion) salidaProduccion
                                    FROM ord_prod op
                                             LEFT JOIN envasado e on op.lote = e.lote
                                             LEFT JOIN prodpre p on e.codPresentacion = p.codPresentacion
                                    WHERE fechProd >= '$fecha'
                                      AND codEnvase > 0
                                    GROUP BY codTapa) sp ON sp.codTapa = i.codTapa
                         LEFT JOIN (SELECT codTapa, SUM(cantidad) salidaEnvasadoDist
                                    FROM envasado_dist ed
                                             LEFT JOIN rel_dist_mp rdm on ed.codDist = rdm.codDist
                                    WHERE fechaEnvDist >= '$fecha'
                                    GROUP BY codTapa) sed ON sed.codTapa = i.codTapa
                         LEFT JOIN (SELECT t.codTapa, SUM(cantidad) salidaJabones
                                    FROM (SELECT codTapa, ROUND(SUM(cantProducto)) cantidad
                                          FROM remision r
                                                   LEFT JOIN det_remision dr on r.idRemision = dr.idRemision
                                                   LEFT JOIN prodpre p on dr.codProducto = p.codPresentacion
                                          WHERE ((p.codProducto >= 504
                                              AND p.codProducto <= 516) OR p.codProducto = 519)
                                            AND fechaRemision > '$fecha'
                                          GROUP BY codTapa
                                          UNION
                                          SELECT codTapa, ROUND(SUM(cantProducto)) cantidad
                                          FROM remision1 r1
                                                   LEFT JOIN det_remision1 dr1 on r1.idRemision = dr1.idRemision
                                                   LEFT JOIN prodpre p on dr1.codProducto = p.codPresentacion
                                          WHERE ((p.codProducto >= 504
                                              AND p.codProducto <= 516) OR p.codProducto = 519)
                                            AND fechaRemision > '$fecha'
                                          GROUP BY codTapa) t
                                    GROUP BY codTapa) sj ON sj.codTapa = i.codTapa
                         LEFT JOIN (SELECT codTapa, SUM(cantPresentacionAnt) salidaCambios
                                    FROM cambios c
                                             LEFT JOIN det_cambios dc on c.idCambio = dc.idCambio
                                             LEFT JOIN prodpre p on dc.codPresentacionAnt = p.codPresentacion
                                    WHERE fechaCambio >= '$fecha'
                                    GROUP BY codTapa) sc ON sc.codTapa = i.codTapa";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getProdPorCategoria($idProv, $idCatProv)
    {
        switch (intval($idCatProv)) {
            case 1:
                $qry = "SELECT codTaparima Codigo, nomMPrima Producto FROM mprimas
                        LEFT JOIN inv_tapas_val dp ON dp.Codigo=codTaparima AND dp.idProv=? WHERE dp.Codigo IS NULL ORDER BY Producto";
                break;
            case 2:
                $qry = "SELECT codTapa Codigo, nomEnvase Producto  FROM inv_tapas_val
                        LEFT JOIN inv_tapas_val ON Codigo=codTapa AND idProv=? WHERE Codigo IS NULL
                        UNION
                        SELECT codTapa Codigo, tapa Producto FROM tapas_val
                        LEFT JOIN inv_tapas_val ON Codigo=codTapa AND idProv=? AND codTapa<>114 WHERE Codigo IS NULL ORDER BY Producto;
                        ";
                break;
            case 3:
                $qry = "SELECT codTapaueta Codigo, nomEtiqueta Producto FROM etiquetas
                        LEFT JOIN inv_tapas_val ON Codigo=codTapaueta and idProv=? WHERE Codigo IS NULL ORDER BY Producto;";
                break;
            case 5:
                $qry = "SELECT idDistribucion Codigo, producto Producto FROM distribucion
                        LEFT JOIN inv_tapas_val ON Codigo=idDistribucion AND idProv=? WHERE Codigo IS NULL order by Producto";
                break;
        }

        $stmt = $this->_pdo->prepare($qry);

        $stmt->execute(array($idProv));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateInvTapas($datos)
    {
        $qry = "UPDATE inv_tapas_val SET invTapa=? WHERE codTapa=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
