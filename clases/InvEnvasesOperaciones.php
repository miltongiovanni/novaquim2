<?php

class InvEnvasesOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeInvEnvase($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO inv_envase VALUES(?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteInvEnvase($datos)
    {
        $qry = "DELETE FROM inv_envase WHERE codEnvase= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function getInvEnvase($codEnvase)
    {
        $qry = "SELECT invEnvase FROM inv_envase WHERE codEnvase=? ";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codEnvase));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result == null) {
            return $result;
        } else {
            return $result['invEnvase'];
        }
    }

    public function getTableInvEnvase()
    {
        $qry = "SELECT ie.codEnvase, nomEnvase, ROUND(invEnvase) invEnvase
                FROM inv_envase ie
                LEFT JOIN envases e on ie.codEnvase = e.codEnvase
                WHERE invEnvase>0 AND ie.codEnvase>0";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableDetalleInvEnvase()
    {
        $qry = "SELECT ie.codEnvase, nomEnvase, ROUND(invEnvase) invEnvase, precEnvase
                FROM inv_envase ie
                         LEFT JOIN envases e on ie.codEnvase = e.codEnvase
                WHERE ie.codEnvase>0";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableStockInvEnvase()
    {
        $qry = "SELECT ie.codEnvase, nomEnvase, ROUND(invEnvase) invEnvase, stockEnvase
                FROM inv_envase ie
                         LEFT JOIN envases e on ie.codEnvase = e.codEnvase
                WHERE invEnvase > 0
                  AND ie.codEnvase > 0
                  AND invEnvase < stockEnvase";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableInvEnvaseFecha($fecha)
    {
        $qry = "SELECT i.codEnvase,
       i.nomEnvase,
       i.invEnvase,
       ec.entradaCompra,
       ec2.entradaCambio,
       edk.entradaDesarmadoKits,
       sp.salidaProduccion,
       sed.salidaEnvasadoDist,
       sak.salidaArmadoKits,
       sj.salidaJabones,
       sc.salidaCambios,
       i.precEnvase
FROM (SELECT ie.codEnvase, nomEnvase, ROUND(invEnvase) invEnvase, e.precEnvase
      FROM inv_envase ie
               LEFT JOIN envases e on ie.codEnvase = e.codEnvase
      WHERE invEnvase > 0
        AND ie.codEnvase > 0) i
         LEFT JOIN (SELECT codigo, ROUND(SUM(cantidad)) entradaCompra
                    FROM compras c
                             LEFT JOIN det_compras dc on c.idCompra = dc.idCompra
                    WHERE tipoCompra = 2
                      AND codigo < 100
                      AND fechComp >= '$fecha'
                    GROUP BY codigo) ec ON i.codEnvase = ec.codigo
         LEFT JOIN (SELECT codEnvase, SUM(cantPresentacionNvo) entradaCambio
                    FROM cambios c
                             LEFT JOIN det_cambios2 d on c.idCambio = d.idCambio
                             LEFT JOIN prodpre p on d.codPresentacionNvo = p.codPresentacion
                    WHERE fechaCambio >= '$fecha'
                    GROUP BY codEnvase) ec2 ON ec2.codEnvase = i.codEnvase
         LEFT JOIN (SELECT codEnvase, SUM(cantDesarmado) entradaDesarmadoKits
                    FROM desarm_kit dk
                             LEFT JOIN kit k on dk.codKit = k.idKit
                    WHERE fechDesarmado >= '$fecha'
                    GROUP BY codEnvase) edk ON edk.codEnvase = i.codEnvase
         LEFT JOIN (SELECT codEnvase, SUM(cantPresentacion) salidaProduccion
                    FROM ord_prod op
                             LEFT JOIN envasado e on op.lote = e.lote
                             LEFT JOIN prodpre p on e.codPresentacion = p.codPresentacion
                    WHERE fechProd >= '$fecha'
                      AND codEnvase > 0
                    GROUP BY codEnvase) sp ON sp.codEnvase = i.codEnvase
         LEFT JOIN (SELECT codEnvase, SUM(cantidad) salidaEnvasadoDist
                    FROM envasado_dist ed
                             LEFT JOIN rel_dist_mp rdm on ed.codDist = rdm.codDist
                    WHERE fechaEnvDist >= '$fecha'
                    GROUP BY codEnvase) sed ON sed.codEnvase = i.codEnvase
         LEFT JOIN (SELECT codEnvase, SUM(cantArmado) salidaArmadoKits
                    FROM arm_kit ak
                             LEFT JOIN kit k on ak.codKit = k.idKit
                    WHERE fechArmado >= '$fecha' AND codEnvase>0
                    GROUP BY codEnvase) sak ON sak.codEnvase = i.codEnvase
         LEFT JOIN (SELECT t.codEnvase, SUM(cantidad) salidaJabones
                    FROM
                        (SELECT codEnvase, ROUND(SUM(cantProducto)) cantidad
                         FROM remision r
                                  LEFT JOIN det_remision dr on r.idRemision = dr.idRemision
                                  LEFT JOIN prodpre p on dr.codProducto = p.codPresentacion
                         WHERE ((p.codProducto >= 504
                             AND p.codProducto <= 516) OR p.codProducto = 519)
                           AND fechaRemision > '$fecha'
                         GROUP BY codEnvase
                         UNION
                         SELECT codEnvase, ROUND(SUM(cantProducto)) cantidad
                         FROM remision1 r1
                                  LEFT JOIN det_remision1 dr1 on r1.idRemision = dr1.idRemision
                                  LEFT JOIN prodpre p on dr1.codProducto = p.codPresentacion
                         WHERE ((p.codProducto >= 504
                             AND p.codProducto <= 516) OR p.codProducto = 519)
                           AND fechaRemision > '$fecha'
                         GROUP BY codEnvase) t
                    GROUP BY codEnvase) sj ON sj.codEnvase = i.codEnvase
         LEFT JOIN (SELECT codEnvase, SUM(cantPresentacionAnt) salidaCambios
                    FROM cambios c
                             LEFT JOIN det_cambios dc on c.idCambio = dc.idCambio
                             LEFT JOIN prodpre p on dc.codPresentacionAnt = p.codPresentacion
                    WHERE fechaCambio >= '$fecha'
                    GROUP BY codEnvase) sc ON sc.codEnvase = i.codEnvase";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getProdPorCategoria($idProv, $idCatProv)
    {
        switch (intval($idCatProv)) {
            case 1:
                $qry = "SELECT codEnvaserima Codigo, nomMPrima Producto FROM mprimas
                        LEFT JOIN inv_envase dp ON dp.Codigo=codEnvaserima AND dp.idProv=? WHERE dp.Codigo IS NULL ORDER BY Producto";
                break;
            case 2:
                $qry = "SELECT codEnvase Codigo, nomEnvase Producto  FROM inv_envase
                        LEFT JOIN inv_envase ON Codigo=codEnvase AND idProv=? WHERE Codigo IS NULL
                        UNION
                        SELECT codTapa Codigo, tapa Producto FROM tapas_val
                        LEFT JOIN inv_envase ON Codigo=codTapa AND idProv=? AND codTapa<>114 WHERE Codigo IS NULL ORDER BY Producto;
                        ";
                break;
            case 3:
                $qry = "SELECT codEtiqueta Codigo, nomEtiqueta Producto FROM etiquetas
                        LEFT JOIN inv_envase ON Codigo=codEtiqueta and idProv=? WHERE Codigo IS NULL ORDER BY Producto;";
                break;
            case 5:
                $qry = "SELECT idDistribucion Codigo, producto Producto FROM distribucion
                        LEFT JOIN inv_envase ON Codigo=idDistribucion AND idProv=? WHERE Codigo IS NULL order by Producto";
                break;
        }

        $stmt = $this->_pdo->prepare($qry);

        $stmt->execute(array($idProv));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateInvEnvase($datos)
    {
        $qry = "UPDATE inv_envase SET invEnvase=? WHERE codEnvase=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
