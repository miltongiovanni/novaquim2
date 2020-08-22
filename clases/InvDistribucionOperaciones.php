<?php

class InvDistribucionOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeInvDistribucion($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO inv_distribucion (codDistribucion, invDistribucion) VALUES(?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteInvDistribucion($datos)
    {
        $qry = "DELETE FROM inv_distribucion WHERE codDistribucion= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function getInvDistribucion($codDistribucion)
    {
        $qry = "SELECT invDistribucion FROM inv_distribucion WHERE codDistribucion=? ";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codDistribucion));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result == null) {
            return 0;
        } else {
            return $result['invDistribucion'];
        }
    }

    public function getTableInvDistribucion()
    {
        $qry = "SELECT codDistribucion, producto, round(invDistribucion, 0) invDistribucion
                FROM inv_distribucion id
                         LEFT JOIN distribucion d on id.codDistribucion = d.idDistribucion
                WHERE invDistribucion > 0
                ORDER BY producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getProdPorDesempacar()
    {
        $qry = "SELECT d.idDistribucion, d.producto
                FROM distribucion d
                         LEFT JOIN inv_distribucion id on d.idDistribucion = id.codDistribucion
                         LEFT JOIN rel_dist_emp rde on d.idDistribucion = rde.codPaca
                WHERE rde.codPaca IS NOT NULL
                  AND invDistribucion > 0
                ORDER BY d.producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getProdPorEmpacar()
    {
        $qry = "SELECT d.idDistribucion, d.producto
                FROM distribucion d
                         LEFT JOIN inv_distribucion id on d.idDistribucion = id.codDistribucion
                         LEFT JOIN rel_dist_emp rde on d.idDistribucion = rde.codUnidad
                WHERE rde.codUnidad IS NOT NULL
                  AND invDistribucion > rde.cantidad
                ORDER BY d.producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableStockInvDistribucion()
    {
        $qry = "SELECT codDistribucion, producto, round(invDistribucion, 0) invDistribucion, stockDis
                FROM inv_distribucion id
                         LEFT JOIN distribucion d on id.codDistribucion = d.idDistribucion
                WHERE invDistribucion > 0
                  AND invDistribucion < stockDis";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableInvDistribucionFecha($fecha)
    {
        $qry = "SELECT i.codDistribucion,
                       i.producto,
                       i.invDistribucion,
                       ec.entradaCompras,
                       eak.entradaArmKits,
                       edk.entradaDesarmKits,
                       eed.entradaEnvDistribucion,
                       sv.salidaVentas,
                       sr.salidaRemision,
                       sdk.salidaDesarmadoKits,
                       sak.salidaArmadoKits
                FROM (SELECT codDistribucion, producto, round(invDistribucion, 0) invDistribucion
                      FROM inv_distribucion id
                               LEFT JOIN distribucion d on id.codDistribucion = d.idDistribucion
                      WHERE invDistribucion > 0) i
                         LEFT JOIN (SELECT codigo, ROUND(SUM(cantidad)) entradaCompras
                                    FROM compras c
                                             LEFT JOIN det_compras dc on c.idCompra = dc.idCompra
                                    WHERE tipoCompra = 5
                                      AND fechComp >= '$fecha'
                                    GROUP BY codigo) ec ON i.codDistribucion = ec.codigo
                         LEFT JOIN (SELECT codigo, SUM(cantArmado) entradaArmKits
                                    FROM arm_kit ak
                                             LEFT JOIN kit k on ak.codKit = k.idKit
                                             LEFT JOIN distribucion ON codigo = idDistribucion
                                    WHERE fechArmado >= '$fecha'
                                    GROUP BY codigo) eak ON eak.codigo = i.codDistribucion
                         LEFT JOIN (SELECT codProducto, SUM(cantDesarmado) entradaDesarmKits
                                    FROM desarm_kit dk
                                             LEFT JOIN kit k on dk.codKit = k.idKit
                                             LEFT JOIN det_kit d on k.idKit = d.idKit
                                             LEFT JOIN distribucion ON codProducto = idDistribucion
                                    WHERE fechDesarmado >= '$fecha'
                                    GROUP BY codProducto) edk ON edk.codProducto = i.codDistribucion
                         LEFT JOIN (SELECT ed.codDist, SUM(cantidad) entradaEnvDistribucion
                                    FROM envasado_dist ed
                                             LEFT JOIN rel_dist_mp rdm on ed.codDist = rdm.codDist
                                             LEFT JOIN mprimadist m on rdm.codMPrimaDist = m.codMPrimaDist
                                    WHERE fechaEnvDist >= '$fecha'
                                    GROUP BY codDist) eed ON eed.codDist = i.codDistribucion
                         LEFT JOIN (SELECT codProducto, ROUND(SUM(cantProducto)) salidaVentas
                                    FROM remision r
                                             LEFT JOIN det_remision dr on r.idRemision = dr.idRemision
                                    WHERE fechaRemision >= '$fecha'
                                    GROUP BY codProducto) sv ON sv.codProducto = i.codDistribucion
                         LEFT JOIN (SELECT codProducto, ROUND(SUM(cantProducto)) salidaRemision
                                    FROM remision1
                                             LEFT JOIN det_remision1 d on remision1.idRemision = d.idRemision
                                    WHERE fechaRemision >= '$fecha'
                                    GROUP BY codProducto) sr ON sr.codProducto = i.codDistribucion
                         LEFT JOIN (SELECT codigo, SUM(cantDesarmado) salidaDesarmadoKits
                                    FROM desarm_kit dk
                                             LEFT JOIN kit k on dk.codKit = k.idKit
                                             LEFT JOIN distribucion d ON k.codigo = d.idDistribucion
                                    WHERE fechDesarmado >= '$fecha'
                                    GROUP BY codigo) sdk ON sdk.codigo = i.codDistribucion
                         LEFT JOIN (SELECT codProducto, SUM(cantArmado) salidaArmadoKits
                                    FROM arm_kit ak
                                             LEFT JOIN kit k on ak.codKit = k.idKit
                                             LEFT JOIN det_kit dk on k.idKit = dk.idKit
                                             LEFT JOIN distribucion d ON dk.codProducto = d.idDistribucion
                                    WHERE fechArmado >= '$fecha'
                                    GROUP BY codProducto) sak ON sak.codProducto = i.codDistribucion";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getProdPorCategoria($idProv, $idCatProv)
    {
        switch (intval($idCatProv)) {
            case 1:
                $qry = "SELECT codDistribucionrima Codigo, nomMPrima Producto FROM mprimas
                        LEFT JOIN inv_distribucion dp ON dp.Codigo=codDistribucionrima AND dp.idProv=? WHERE dp.Codigo IS NULL ORDER BY Producto";
                break;
            case 2:
                $qry = "SELECT codDistribucion Codigo, nomEnvase Producto  FROM inv_distribucion
                        LEFT JOIN inv_distribucion ON Codigo=codDistribucion AND idProv=? WHERE Codigo IS NULL
                        UNION
                        SELECT codTapa Codigo, tapa Producto FROM tapas_val
                        LEFT JOIN inv_distribucion ON Codigo=codTapa AND idProv=? AND codTapa<>114 WHERE Codigo IS NULL ORDER BY Producto;
                        ";
                break;
            case 3:
                $qry = "SELECT codEtiqueta Codigo, nomEtiqueta Producto FROM etiquetas
                        LEFT JOIN inv_distribucion ON Codigo=codEtiqueta and idProv=? WHERE Codigo IS NULL ORDER BY Producto;";
                break;
            case 5:
                $qry = "SELECT idDistribucion Codigo, producto Producto FROM distribucion
                        LEFT JOIN inv_distribucion ON Codigo=idDistribucion AND idProv=? WHERE Codigo IS NULL order by Producto";
                break;
        }

        $stmt = $this->_pdo->prepare($qry);

        $stmt->execute(array($idProv));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateInvDistribucion($datos)
    {
        $qry = "UPDATE inv_distribucion SET invDistribucion=? WHERE codDistribucion=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
