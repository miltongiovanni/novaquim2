<?php

class InvEtiquetasOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeInvEtiqueta($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO inv_etiquetas VALUES(?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteInvEtiqueta($datos)
    {
        $qry = "DELETE FROM inv_etiquetas WHERE codEtiq= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function getInvEtiqueta($codEtiq)
    {
        $qry = "SELECT invEtiq FROM inv_etiquetas WHERE codEtiq=? ";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codEtiq));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result === null) {
            return $result;
        } else {
            return $result['invEtiq'];
        }
    }

    public function getTableInvEtiqueta()
    {
        $qry = "SELECT codEtiq, nomEtiqueta, invEtiq
                FROM inv_etiquetas ie
                         LEFT JOIN etiquetas e on ie.codEtiq = e.codEtiqueta
                WHERE invEtiq > 0
                  AND codEtiq > 0";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableDetalleInvEtiqueta()
    {
        $qry = "SELECT codEtiq, nomEtiqueta, invEtiq, precEtiqueta
                FROM inv_etiquetas ie
                         LEFT JOIN etiquetas e on ie.codEtiq = e.codEtiqueta
                WHERE codEtiq > 0";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableStockInvEtiqueta()
    {
        $qry = "SELECT codEtiq, nomEtiqueta, invEtiq, stockEtiqueta
                FROM inv_etiquetas ie
                         LEFT JOIN etiquetas e on ie.codEtiq = e.codEtiqueta
                WHERE invEtiq > 0
                  AND codEtiq > 0
                  AND invEtiq < stockEtiqueta";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableInvEtiquetaFecha($fecha)
    {
        $qry = "SELECT i.codEtiq,
                       i.nomEtiqueta,
                       i.invEtiq,
                       ec.entradaCompra,
                       ec2.entradaCambio,
                       sp.salidaProduccion,
                       sj.salidaJabones,
                       sc.salidaCambios,
                       i.precEtiqueta
                FROM (SELECT codEtiq, nomEtiqueta, invEtiq, precEtiqueta
                      FROM inv_etiquetas ie
                               LEFT JOIN etiquetas e on ie.codEtiq = e.codEtiqueta
                      WHERE invEtiq > 0
                        AND codEtiq > 0) i
                         LEFT JOIN (SELECT codigo, ROUND(SUM(cantidad)) entradaCompra
                                    FROM compras c
                                             LEFT JOIN det_compras dc on c.idCompra = dc.idCompra
                                    WHERE tipoCompra = 3
                                      AND fechComp >= '$fecha'
                                    GROUP BY codigo) ec ON i.codEtiq = ec.codigo
                         LEFT JOIN (SELECT codEtiq, SUM(cantPresentacionNvo) entradaCambio
                                    FROM cambios c
                                             LEFT JOIN det_cambios2 d on c.idCambio = d.idCambio
                                             LEFT JOIN prodpre p on d.codPresentacionNvo = p.codPresentacion
                                    WHERE fechaCambio >= '$fecha'
                                    GROUP BY codEtiq) ec2 ON ec2.codEtiq = i.codEtiq
                         LEFT JOIN (SELECT codEtiq, SUM(cantPresentacion) salidaProduccion
                                    FROM ord_prod op
                                             LEFT JOIN envasado e on op.lote = e.lote
                                             LEFT JOIN prodpre p on e.codPresentacion = p.codPresentacion
                                    WHERE fechProd >= '$fecha'
                                      AND codEnvase > 0
                                    GROUP BY codEtiq) sp ON sp.codEtiq = i.codEtiq
                         LEFT JOIN (SELECT t.codEtiq, SUM(cantidad) salidaJabones
                                    FROM (SELECT codEtiq, ROUND(SUM(cantProducto)) cantidad
                                          FROM remision r
                                                   LEFT JOIN det_remision dr on r.idRemision = dr.idRemision
                                                   LEFT JOIN prodpre p on dr.codProducto = p.codPresentacion
                                          WHERE ((p.codProducto >= 504
                                              AND p.codProducto <= 516) OR p.codProducto = 519)
                                            AND fechaRemision > '$fecha'
                                          GROUP BY codEtiq
                                          UNION
                                          SELECT codEtiq, ROUND(SUM(cantProducto)) cantidad
                                          FROM remision1 r1
                                                   LEFT JOIN det_remision1 dr1 on r1.idRemision = dr1.idRemision
                                                   LEFT JOIN prodpre p on dr1.codProducto = p.codPresentacion
                                          WHERE ((p.codProducto >= 504
                                              AND p.codProducto <= 516) OR p.codProducto = 519)
                                            AND fechaRemision > '$fecha'
                                          GROUP BY codEtiq) t
                                    GROUP BY codEtiq) sj ON sj.codEtiq = i.codEtiq
                         LEFT JOIN (SELECT codEtiq, SUM(cantPresentacionAnt) salidaCambios
                                    FROM cambios c
                                             LEFT JOIN det_cambios dc on c.idCambio = dc.idCambio
                                             LEFT JOIN prodpre p on dc.codPresentacionAnt = p.codPresentacion
                                    WHERE fechaCambio >= '$fecha'
                                    GROUP BY codEtiq) sc ON sc.codEtiq = i.codEtiq";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getProdPorCategoria($idProv, $idCatProv)
    {
        switch (intval($idCatProv)) {
            case 1:
                $qry = "SELECT codEtiqrima Codigo, nomMPrima Producto FROM mprimas
                        LEFT JOIN inv_etiquetas dp ON dp.Codigo=codEtiqrima AND dp.idProv=? WHERE dp.Codigo IS NULL ORDER BY Producto";
                break;
            case 2:
                $qry = "SELECT codEtiq Codigo, nomEnvase Producto  FROM inv_etiquetas
                        LEFT JOIN inv_etiquetas ON Codigo=codEtiq AND idProv=? WHERE Codigo IS NULL
                        UNION
                        SELECT codTapa Codigo, tapa Producto FROM tapas_val
                        LEFT JOIN inv_etiquetas ON Codigo=codTapa AND idProv=? AND codTapa<>114 WHERE Codigo IS NULL ORDER BY Producto;
                        ";
                break;
            case 3:
                $qry = "SELECT codEtiqueta Codigo, nomEtiqueta Producto FROM etiquetas
                        LEFT JOIN inv_etiquetas ON Codigo=codEtiqueta and idProv=? WHERE Codigo IS NULL ORDER BY Producto;";
                break;
            case 5:
                $qry = "SELECT idDistribucion Codigo, producto Producto FROM distribucion
                        LEFT JOIN inv_etiquetas ON Codigo=idDistribucion AND idProv=? WHERE Codigo IS NULL order by Producto";
                break;
        }

        $stmt = $this->_pdo->prepare($qry);

        $stmt->execute(array($idProv));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateInvEtiqueta($datos)
    {
        $qry = "UPDATE inv_etiquetas SET invEtiq=? WHERE codEtiq=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
