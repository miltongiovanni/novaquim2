<?php

class DetFacturaOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeDetFactura($datos)
    {
        $qry = "INSERT INTO det_factura (idFactura, codProducto, cantProducto, precioProducto, idTasaIvaProducto) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteDetFactura($datos)
    {
        $qry = "DELETE FROM det_factura WHERE idFactura= ? AND codProducto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function deleteAllDetFactura($idFactura)
    {
        $qry = "DELETE FROM det_factura WHERE idFactura= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFactura));
    }

    public function getDetFactura($idFactura)
    {
        $qry = "SELECT CONCAT('003000', codSiigo)              codigo,
                       presentacion as                         producto,
                       cantProducto,
                       CONCAT(ROUND( tasaIva*100, 0), ' %')   iva,
                       CONCAT('$ ', FORMAT(precioProducto, 2)) precioProducto,
                       CONCAT('$ ', FORMAT(precioProducto*cantProducto, 2)) subtotal,
                       1 orden
                FROM det_factura dp
                         LEFT JOIN prodpre p on dp.codProducto = p.codPresentacion
                         LEFT JOIN tasa_iva ti on ti.idTasaIva = dp.idTasaIvaProducto
                WHERE dp.idFactura = $idFactura
                  AND dp.codProducto > 10000
                  AND dp.codProducto < 100000
                UNION
                SELECT CONCAT('003000', codSiigo)             codigo,
                       producto as                            producto,
                       cantProducto,
                       CONCAT(ROUND( tasaIva*100, 0), ' %')  iva,
                       CONCAT('$', FORMAT(precioProducto, 2)) precioProducto,
                       CONCAT('$ ', FORMAT(precioProducto*cantProducto, 2)) subtotal,
                       2 orden
                FROM det_factura dp
                         LEFT JOIN distribucion d on dp.codProducto = d.idDistribucion
                         LEFT JOIN tasa_iva t on t.idTasaIva = dp.idTasaIvaProducto
                WHERE dp.idFactura = $idFactura
                  AND dp.codProducto > 100000
                UNION
                SELECT CONCAT('003000', codSiigo)            codigo,
                       desServicio as                        producto,
                       cantProducto,
                       CONCAT(ROUND( tasaIva*100, 0), ' %') iva,
                       CONCAT('$', FORMAT(precioProducto, 2)) precioProducto,
                       CONCAT('$ ', FORMAT(precioProducto*cantProducto, 2)) subtotal,
                       3 orden
                FROM det_factura dp
                         LEFT JOIN servicios s on dp.codProducto = s.idServicio
                         LEFT JOIN tasa_iva i on i.idTasaIva = dp.idTasaIvaProducto
                WHERE dp.idFactura = $idFactura
                  AND dp.codProducto < 100
                  ORDER BY orden, producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTotalSelFactura($selFactura)
    {
        $qry = "SELECT dp.codProducto, SUM(cantProducto) cantidad, presentacion producto, 1 orden
                FROM det_factura dp
                         LEFT JOIN prodpre p ON dp.codProducto = p.codPresentacion
                WHERE dp.codProducto < 100000
                  AND dp.codProducto > 10000
                  AND dp.idFactura IN ($selFactura)
                GROUP BY dp.codProducto, producto
                UNION
                SELECT dp.codProducto, SUM(cantProducto) cantidad, producto, 2 orden
                FROM det_factura dp
                         LEFT JOIN distribucion d ON dp.codProducto = d.idDistribucion
                WHERE dp.codProducto > 100000
                  AND dp.idFactura IN ($selFactura)
                GROUP BY dp.codProducto, producto
                ORDER BY orden, producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);;
        return $result;
    }

    public function getAcumuladoProductosEmpresaPorMesProducto($year)
    {
        $qry = "SELECT t.codigoGen,
                       t.producto,
                       MAX(CASE WHEN mes = 1 THEN cant ELSE 0 END)  AS cant_enero,
                       MAX(CASE WHEN mes = 2 THEN cant ELSE 0 END)  AS cant_febrero,
                       MAX(CASE WHEN mes = 3 THEN cant ELSE 0 END)  AS cant_marzo,
                       MAX(CASE WHEN mes = 4 THEN cant ELSE 0 END)  AS cant_abril,
                       MAX(CASE WHEN mes = 5 THEN cant ELSE 0 END)  AS cant_mayo,
                       MAX(CASE WHEN mes = 6 THEN cant ELSE 0 END)  AS cant_junio,
                       MAX(CASE WHEN mes = 7 THEN cant ELSE 0 END)  AS cant_julio,
                       MAX(CASE WHEN mes = 8 THEN cant ELSE 0 END)  AS cant_agosto,
                       MAX(CASE WHEN mes = 9 THEN cant ELSE 0 END)  AS cant_septiembre,
                       MAX(CASE WHEN mes = 10 THEN cant ELSE 0 END) AS cant_octubre,
                       MAX(CASE WHEN mes = 11 THEN cant ELSE 0 END) AS cant_noviembre,
                       MAX(CASE WHEN mes = 12 THEN cant ELSE 0 END) AS cant_diciembre,
                       CONCAT('$', FORMAT(MAX(CASE WHEN mes = 1 THEN sub ELSE 0 END), 0))   AS sub_enero,
                       CONCAT('$', FORMAT(MAX(CASE WHEN mes = 2 THEN sub ELSE 0 END), 0))   AS sub_febrero,
                       CONCAT('$', FORMAT(MAX(CASE WHEN mes = 3 THEN sub ELSE 0 END), 0))   AS sub_marzo,
                       CONCAT('$', FORMAT(MAX(CASE WHEN mes = 4 THEN sub ELSE 0 END), 0))   AS sub_abril,
                       CONCAT('$', FORMAT(MAX(CASE WHEN mes = 5 THEN sub ELSE 0 END), 0))   AS sub_mayo,
                       CONCAT('$', FORMAT(MAX(CASE WHEN mes = 6 THEN sub ELSE 0 END), 0))   AS sub_junio,
                       CONCAT('$', FORMAT(MAX(CASE WHEN mes = 7 THEN sub ELSE 0 END), 0))   AS sub_julio,
                       CONCAT('$', FORMAT(MAX(CASE WHEN mes = 8 THEN sub ELSE 0 END), 0))   AS sub_agosto,
                       CONCAT('$', FORMAT(MAX(CASE WHEN mes = 9 THEN sub ELSE 0 END), 0))   AS sub_septiembre,
                       CONCAT('$', FORMAT(MAX(CASE WHEN mes = 10 THEN sub ELSE 0 END), 0))  AS sub_octubre,
                       CONCAT('$', FORMAT(MAX(CASE WHEN mes = 11 THEN sub ELSE 0 END), 0))  AS sub_noviembre,
                       CONCAT('$', FORMAT(MAX(CASE WHEN mes = 12 THEN sub ELSE 0 END), 0))  AS sub_diciembre
                FROM (SELECT SUM(cantProducto) cant,
                             SUM(cantProducto*precioProducto) sub,
                             MONTH(fechaFactura) mes,
                             p.codigoGen,
                             p2.producto
                      FROM det_factura df
                               LEFT JOIN factura f on f.idFactura = df.idFactura
                               LEFT JOIN prodpre p on df.codProducto = p.codPresentacion
                               LEFT JOIN precios p2 on p2.codigoGen = p.codigoGen
                      WHERE df.codProducto < 100000 AND df.codProducto>10000
                        AND YEAR(fechaFactura) = $year
                      GROUP BY mes, p.codigoGen) t
                GROUP BY t.codigoGen, t.producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);;
        return $result;
    }

    public function getAcumuladoProductosEmpresaPorMesProductoVend($year, $codVendedor)
    {
        $qry = "SELECT t.codigoGen,
                       t.producto,
                       MAX(CASE WHEN mes = 1 THEN cant ELSE 0 END)  AS cant_enero,
                       MAX(CASE WHEN mes = 2 THEN cant ELSE 0 END)  AS cant_febrero,
                       MAX(CASE WHEN mes = 3 THEN cant ELSE 0 END)  AS cant_marzo,
                       MAX(CASE WHEN mes = 4 THEN cant ELSE 0 END)  AS cant_abril,
                       MAX(CASE WHEN mes = 5 THEN cant ELSE 0 END)  AS cant_mayo,
                       MAX(CASE WHEN mes = 6 THEN cant ELSE 0 END)  AS cant_junio,
                       MAX(CASE WHEN mes = 7 THEN cant ELSE 0 END)  AS cant_julio,
                       MAX(CASE WHEN mes = 8 THEN cant ELSE 0 END)  AS cant_agosto,
                       MAX(CASE WHEN mes = 9 THEN cant ELSE 0 END)  AS cant_septiembre,
                       MAX(CASE WHEN mes = 10 THEN cant ELSE 0 END) AS cant_octubre,
                       MAX(CASE WHEN mes = 11 THEN cant ELSE 0 END) AS cant_noviembre,
                       MAX(CASE WHEN mes = 12 THEN cant ELSE 0 END) AS cant_diciembre,
                       CONCAT('$', FORMAT(MAX(CASE WHEN mes = 1 THEN sub ELSE 0 END), 0))   AS sub_enero,
                       CONCAT('$', FORMAT(MAX(CASE WHEN mes = 2 THEN sub ELSE 0 END), 0))   AS sub_febrero,
                       CONCAT('$', FORMAT(MAX(CASE WHEN mes = 3 THEN sub ELSE 0 END), 0))   AS sub_marzo,
                       CONCAT('$', FORMAT(MAX(CASE WHEN mes = 4 THEN sub ELSE 0 END), 0))   AS sub_abril,
                       CONCAT('$', FORMAT(MAX(CASE WHEN mes = 5 THEN sub ELSE 0 END), 0))   AS sub_mayo,
                       CONCAT('$', FORMAT(MAX(CASE WHEN mes = 6 THEN sub ELSE 0 END), 0))   AS sub_junio,
                       CONCAT('$', FORMAT(MAX(CASE WHEN mes = 7 THEN sub ELSE 0 END), 0))   AS sub_julio,
                       CONCAT('$', FORMAT(MAX(CASE WHEN mes = 8 THEN sub ELSE 0 END), 0))   AS sub_agosto,
                       CONCAT('$', FORMAT(MAX(CASE WHEN mes = 9 THEN sub ELSE 0 END), 0))   AS sub_septiembre,
                       CONCAT('$', FORMAT(MAX(CASE WHEN mes = 10 THEN sub ELSE 0 END), 0))  AS sub_octubre,
                       CONCAT('$', FORMAT(MAX(CASE WHEN mes = 11 THEN sub ELSE 0 END), 0))  AS sub_noviembre,
                       CONCAT('$', FORMAT(MAX(CASE WHEN mes = 12 THEN sub ELSE 0 END), 0))  AS sub_diciembre
                FROM (SELECT SUM(cantProducto)                  cant,
                               SUM(cantProducto * precioProducto) sub,
                               MONTH(fechaFactura)                mes,
                               p.codigoGen,
                               p2.producto
                        FROM det_factura df
                                 LEFT JOIN factura f on f.idFactura = df.idFactura
                                 LEFT JOIN clientes c on c.idCliente = f.idCliente
                                 LEFT JOIN prodpre p on df.codProducto = p.codPresentacion
                                 LEFT JOIN precios p2 on p2.codigoGen = p.codigoGen
                        WHERE df.codProducto < 100000
                          AND df.codProducto > 10000
                          AND YEAR(fechaFactura) = $year
                          AND c.codVendedor = $codVendedor
                        GROUP BY mes, p.codigoGen) t
                                        GROUP BY t.codigoGen, t.producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);;
        return $result;
    }

    public function getAcumuladoProductosDistribucionPorMesProducto($year)
    {
        $qry = "SELECT t.idCatDis,
               t.catDis,
               MAX(CASE WHEN mes = 1 THEN cant ELSE 0 END)  AS cant_enero,
               MAX(CASE WHEN mes = 2 THEN cant ELSE 0 END)  AS cant_febrero,
               MAX(CASE WHEN mes = 3 THEN cant ELSE 0 END)  AS cant_marzo,
               MAX(CASE WHEN mes = 4 THEN cant ELSE 0 END)  AS cant_abril,
               MAX(CASE WHEN mes = 5 THEN cant ELSE 0 END)  AS cant_mayo,
               MAX(CASE WHEN mes = 6 THEN cant ELSE 0 END)  AS cant_junio,
               MAX(CASE WHEN mes = 7 THEN cant ELSE 0 END)  AS cant_julio,
               MAX(CASE WHEN mes = 8 THEN cant ELSE 0 END)  AS cant_agosto,
               MAX(CASE WHEN mes = 9 THEN cant ELSE 0 END)  AS cant_septiembre,
               MAX(CASE WHEN mes = 10 THEN cant ELSE 0 END) AS cant_octubre,
               MAX(CASE WHEN mes = 11 THEN cant ELSE 0 END) AS cant_noviembre,
               MAX(CASE WHEN mes = 12 THEN cant ELSE 0 END) AS cant_diciembre,
               CONCAT('$', FORMAT(MAX(CASE WHEN mes = 1 THEN sub ELSE 0 END) , 0))    AS sub_enero,
               CONCAT('$', FORMAT(MAX(CASE WHEN mes = 2 THEN sub ELSE 0 END) , 0))     AS sub_febrero,
               CONCAT('$', FORMAT(MAX(CASE WHEN mes = 3 THEN sub ELSE 0 END) , 0))     AS sub_marzo,
               CONCAT('$', FORMAT(MAX(CASE WHEN mes = 4 THEN sub ELSE 0 END) , 0))     AS sub_abril,
               CONCAT('$', FORMAT(MAX(CASE WHEN mes = 5 THEN sub ELSE 0 END) , 0))     AS sub_mayo,
               CONCAT('$', FORMAT(MAX(CASE WHEN mes = 6 THEN sub ELSE 0 END) , 0))     AS sub_junio,
               CONCAT('$', FORMAT(MAX(CASE WHEN mes = 7 THEN sub ELSE 0 END) , 0))     AS sub_julio,
               CONCAT('$', FORMAT(MAX(CASE WHEN mes = 8 THEN sub ELSE 0 END) , 0))     AS sub_agosto,
               CONCAT('$', FORMAT(MAX(CASE WHEN mes = 9 THEN sub ELSE 0 END) , 0))     AS sub_septiembre,
               CONCAT('$', FORMAT(MAX(CASE WHEN mes = 10 THEN sub ELSE 0 END) , 0))    AS sub_octubre,
               CONCAT('$', FORMAT(MAX(CASE WHEN mes = 11 THEN sub ELSE 0 END) , 0))    AS sub_noviembre,
               CONCAT('$', FORMAT(MAX(CASE WHEN mes = 12 THEN sub ELSE 0 END) , 0))    AS sub_diciembre
        FROM (SELECT IF(SUM(cantProducto) is null,0,SUM(cantProducto))  cant,
                     IF(SUM(cantProducto*precioProducto) is null, 0, SUM(cantProducto*precioProducto)) sub,
                     MONTH(fechaFactura) mes,
                     cd.idCatDis,
                     cd.catDis
              FROM det_factura df
                       LEFT JOIN factura f on f.idFactura = df.idFactura
                       LEFT JOIN distribucion d on df.codProducto = d.idDistribucion
                       LEFT JOIN cat_dis cd on cd.idCatDis = d.idCatDis
              WHERE df.codProducto > 100000
                AND YEAR(fechaFactura) = $year
              GROUP BY mes, idCatDis) t
        GROUP BY t.idCatDis, t.catDis";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);;
        return $result;
    }

    public function getAcumuladoProductosDistribucionPorMesProductoVend($year, $codVendedor)
    {
        $qry = "SELECT t.idCatDis,
               t.catDis,
               MAX(CASE WHEN mes = 1 THEN cant ELSE 0 END)  AS cant_enero,
               MAX(CASE WHEN mes = 2 THEN cant ELSE 0 END)  AS cant_febrero,
               MAX(CASE WHEN mes = 3 THEN cant ELSE 0 END)  AS cant_marzo,
               MAX(CASE WHEN mes = 4 THEN cant ELSE 0 END)  AS cant_abril,
               MAX(CASE WHEN mes = 5 THEN cant ELSE 0 END)  AS cant_mayo,
               MAX(CASE WHEN mes = 6 THEN cant ELSE 0 END)  AS cant_junio,
               MAX(CASE WHEN mes = 7 THEN cant ELSE 0 END)  AS cant_julio,
               MAX(CASE WHEN mes = 8 THEN cant ELSE 0 END)  AS cant_agosto,
               MAX(CASE WHEN mes = 9 THEN cant ELSE 0 END)  AS cant_septiembre,
               MAX(CASE WHEN mes = 10 THEN cant ELSE 0 END) AS cant_octubre,
               MAX(CASE WHEN mes = 11 THEN cant ELSE 0 END) AS cant_noviembre,
               MAX(CASE WHEN mes = 12 THEN cant ELSE 0 END) AS cant_diciembre,
               CONCAT('$', FORMAT(MAX(CASE WHEN mes = 1 THEN sub ELSE 0 END) , 0))    AS sub_enero,
               CONCAT('$', FORMAT(MAX(CASE WHEN mes = 2 THEN sub ELSE 0 END) , 0))     AS sub_febrero,
               CONCAT('$', FORMAT(MAX(CASE WHEN mes = 3 THEN sub ELSE 0 END) , 0))     AS sub_marzo,
               CONCAT('$', FORMAT(MAX(CASE WHEN mes = 4 THEN sub ELSE 0 END) , 0))     AS sub_abril,
               CONCAT('$', FORMAT(MAX(CASE WHEN mes = 5 THEN sub ELSE 0 END) , 0))     AS sub_mayo,
               CONCAT('$', FORMAT(MAX(CASE WHEN mes = 6 THEN sub ELSE 0 END) , 0))     AS sub_junio,
               CONCAT('$', FORMAT(MAX(CASE WHEN mes = 7 THEN sub ELSE 0 END) , 0))     AS sub_julio,
               CONCAT('$', FORMAT(MAX(CASE WHEN mes = 8 THEN sub ELSE 0 END) , 0))     AS sub_agosto,
               CONCAT('$', FORMAT(MAX(CASE WHEN mes = 9 THEN sub ELSE 0 END) , 0))     AS sub_septiembre,
               CONCAT('$', FORMAT(MAX(CASE WHEN mes = 10 THEN sub ELSE 0 END) , 0))    AS sub_octubre,
               CONCAT('$', FORMAT(MAX(CASE WHEN mes = 11 THEN sub ELSE 0 END) , 0))    AS sub_noviembre,
               CONCAT('$', FORMAT(MAX(CASE WHEN mes = 12 THEN sub ELSE 0 END) , 0))    AS sub_diciembre
        FROM (SELECT IF(SUM(cantProducto) is null, 0, SUM(cantProducto))                                   cant,
                   IF(SUM(cantProducto * precioProducto) is null, 0, SUM(cantProducto * precioProducto)) sub,
                   MONTH(fechaFactura)                                                                   mes,
                   cd.idCatDis,
                   cd.catDis
            FROM det_factura df
                     LEFT JOIN factura f on f.idFactura = df.idFactura
                     LEFT JOIN clientes c on c.idCliente = f.idCliente
                     LEFT JOIN distribucion d on df.codProducto = d.idDistribucion
                     LEFT JOIN cat_dis cd on cd.idCatDis = d.idCatDis
            WHERE df.codProducto > 100000
              AND YEAR(fechaFactura) = $year
              AND c.codVendedor = $codVendedor
            GROUP BY mes, idCatDis) t
                    GROUP BY t.idCatDis, t.catDis";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);;
        return $result;
    }

    public function getTotalProductosEmpresaPorMes($year)
    {
        $qry = "SELECT IF(SUM(cantProducto) is null,0,SUM(cantProducto))  cant,
                       IF(SUM(cantProducto*precioProducto) is null, 0, SUM(cantProducto*precioProducto)) sub,
                       MONTH(fechaFactura) mes
                FROM det_factura df
                         LEFT JOIN factura f on f.idFactura = df.idFactura
                WHERE df.codProducto < 100000 AND df.codProducto>10000
                  AND YEAR(fechaFactura) = $year
                GROUP BY mes";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);;
        return $result;
    }

    public function getCantTotalProductosEmpresaPorYear($year)
    {
        $qry = "SELECT IF(SUM(cantProducto) is null, 0, SUM(cantProducto))                                   cant,
                       IF(SUM(cantProducto * precioProducto) is null, 0, SUM(cantProducto * precioProducto)) sub,
                       YEAR(fechaFactura)                                                                   year,
                       p.codigoGen,
                       p2.producto
                FROM det_factura df
                         LEFT JOIN factura f on f.idFactura = df.idFactura
                         LEFT JOIN prodpre p on df.codProducto = p.codPresentacion
                         LEFT JOIN precios p2 on p2.codigoGen = p.codigoGen
                WHERE df.codProducto < 100000 AND df.codProducto>10000
                  AND YEAR(fechaFactura) = $year
                GROUP BY year, p.codigoGen
                ORDER BY cant DESC LIMIT 20";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);;
        return $result;
    }

    public function getCantTotalProductosEmpresaPorYearVend($year, $codVendedor)
    {
        $qry = "SELECT IF(SUM(cantProducto) is null, 0, SUM(cantProducto))                                   cant,
                       IF(SUM(cantProducto * precioProducto) is null, 0, SUM(cantProducto * precioProducto)) sub,
                       YEAR(fechaFactura)                                                                    year,
                       p.codigoGen,
                       p2.producto
                FROM det_factura df
                         LEFT JOIN factura f on f.idFactura = df.idFactura
                         LEFT JOIN clientes c on c.idCliente = f.idCliente
                         LEFT JOIN prodpre p on df.codProducto = p.codPresentacion
                         LEFT JOIN precios p2 on p2.codigoGen = p.codigoGen
                WHERE df.codProducto < 100000
                  AND df.codProducto > 10000
                  AND YEAR(fechaFactura) = $year
                  AND c.codVendedor = $codVendedor
                GROUP BY year, p.codigoGen
                ORDER BY cant DESC
                LIMIT 20";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);;
        return $result;
    }

    public function getValTotalProductosEmpresaPorYear($year)
    {
        $qry = "SELECT IF(SUM(cantProducto) is null, 0, SUM(cantProducto))                                   cant,
                       IF(SUM(cantProducto * precioProducto) is null, 0, ROUND(SUM(cantProducto * precioProducto))) sub,
                       YEAR(fechaFactura)                                                                   year,
                       p.codigoGen,
                       p2.producto
                FROM det_factura df
                         LEFT JOIN factura f on f.idFactura = df.idFactura
                         LEFT JOIN prodpre p on df.codProducto = p.codPresentacion
                         LEFT JOIN precios p2 on p2.codigoGen = p.codigoGen
                WHERE df.codProducto < 100000 AND df.codProducto>10000
                  AND YEAR(fechaFactura) = $year
                GROUP BY year, p.codigoGen
                ORDER BY sub DESC LIMIT 20";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);;
        return $result;
    }


    public function getValTotalProductosEmpresaPorYearVend($year, $codVendedor)
    {
        $qry = "SELECT IF(SUM(cantProducto) is null, 0, SUM(cantProducto))                                   cant,
                       IF(SUM(cantProducto * precioProducto) is null, 0, ROUND(SUM(cantProducto * precioProducto))) sub,
                       YEAR(fechaFactura)                                                                    year,
                       p.codigoGen,
                       p2.producto
                FROM det_factura df
                         LEFT JOIN factura f on f.idFactura = df.idFactura
                         LEFT JOIN clientes c on c.idCliente = f.idCliente
                         LEFT JOIN prodpre p on df.codProducto = p.codPresentacion
                         LEFT JOIN precios p2 on p2.codigoGen = p.codigoGen
                WHERE df.codProducto < 100000
                  AND df.codProducto > 10000
                  AND YEAR(fechaFactura) = $year
                  AND c.codVendedor = $codVendedor
                GROUP BY year, p.codigoGen
                ORDER BY sub DESC
                LIMIT 20";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);;
        return $result;
    }

    public function getTotalProductosEmpresaPorYear($year)
    {
        $qry = "SELECT IF(SUM(cantProducto) is null,0,SUM(cantProducto))  cant,
                       IF(SUM(cantProducto*precioProducto) is null, 0, SUM(cantProducto*precioProducto)) sub,
                       YEAR(fechaFactura) year
                FROM det_factura df
                         LEFT JOIN factura f on f.idFactura = df.idFactura
                WHERE df.codProducto < 100000 AND df.codProducto>10000
                  AND YEAR(fechaFactura) = $year
                GROUP BY year";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);;
        return $result;
    }

    public function getTotalProductosEmpresaPorYearVend($year, $codVendedor)
    {
        $qry = "SELECT IF(SUM(cantProducto) is null, 0, SUM(cantProducto))                                   cant,
                       IF(SUM(cantProducto * precioProducto) is null, 0, SUM(cantProducto * precioProducto)) sub,
                       YEAR(fechaFactura)                                                                    year
                FROM det_factura df
                         LEFT JOIN factura f on f.idFactura = df.idFactura
                         LEFT JOIN clientes c on c.idCliente = f.idCliente
                WHERE df.codProducto < 100000
                  AND df.codProducto > 10000
                  AND YEAR(fechaFactura) = $year
                  AND c.codVendedor = $codVendedor
                GROUP BY year";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);;
        return $result;
    }


    public function getTotalProductosDistribucionPorMes($year)
    {
        $qry = "SELECT IF(SUM(cantProducto) is null,0,SUM(cantProducto))  cant,
                       IF(SUM(cantProducto*precioProducto) is null, 0, ROUND(SUM(cantProducto*precioProducto)))r sub,
                       MONTH(fechaFactura) mes
                FROM det_factura df
                         LEFT JOIN factura f on f.idFactura = df.idFactura
                WHERE df.codProducto > 100000 
                  AND YEAR(fechaFactura) = $year
                GROUP BY mes";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);;
        return $result;
    }

    public function getTotalProductosDistribucionPorYear($year)
    {
        $qry = "SELECT IF(SUM(cantProducto) is null, 0, SUM(cantProducto))                                   cant,
                       IF(SUM(cantProducto * precioProducto) is null, 0, ROUND(SUM(cantProducto * precioProducto))) sub,
                       YEAR(fechaFactura)                                                                    year,
                       cd.idCatDis,
                       cd.catDis
                FROM det_factura df
                         LEFT JOIN factura f on f.idFactura = df.idFactura
                         LEFT JOIN distribucion d on df.codProducto = d.idDistribucion
                         LEFT JOIN cat_dis cd on cd.idCatDis = d.idCatDis
                WHERE df.codProducto > 100000
                  AND YEAR(fechaFactura) = $year
                GROUP BY year, cd.idCatDis";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);;
        return $result;
    }
    public function getTotalProductosDistribucionPorYearVend($year, $codVendedor)
    {
        $qry = "SELECT IF(SUM(cantProducto) is null, 0, SUM(cantProducto))                                   cant,
                       IF(SUM(cantProducto * precioProducto) is null, 0, ROUND(SUM(cantProducto * precioProducto))) sub,
                       YEAR(fechaFactura)                                                                    year,
                       cd.idCatDis,
                       cd.catDis
                FROM det_factura df
                         LEFT JOIN factura f on f.idFactura = df.idFactura
                         LEFT JOIN clientes c on c.idCliente = f.idCliente
                         LEFT JOIN distribucion d on df.codProducto = d.idDistribucion
                         LEFT JOIN cat_dis cd on cd.idCatDis = d.idCatDis
                WHERE df.codProducto > 100000
                  AND YEAR(fechaFactura) = $year
                  AND c.codVendedor = $codVendedor
                GROUP BY year, cd.idCatDis";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);;
        return $result;
    }

    public function getHistoricoVentas()
    {
        $qry = "SELECT p.year,
                       p.mes,
                       p.prod,
                       d.dist,
                       IF(s.serv IS NULL, 0, s.serv)                                                       servicio,
                       (p.prod + d.dist + IF(s.serv IS NULL, 0, s.serv))                                   total_bruto,
                       p.prod*100/(p.prod + d.dist + IF(s.serv IS NULL, 0, s.serv))                        p_productos,
                       d.dist * 100 /(p.prod + d.dist + IF(s.serv IS NULL, 0, s.serv))                     p_distribucion,
                       IF(s.serv IS NULL, 0, s.serv) *100 /(p.prod + d.dist + IF(s.serv IS NULL, 0, s.serv)) p_servicio,
                       IF(dev.dev IS NULL, 0, dev.dev)                                                     devolucion,
                       (p.prod + d.dist + IF(s.serv IS NULL, 0, s.serv) - IF(dev.dev IS NULL, 0, dev.dev)) total_neto
                FROM (SELECT ROUND(SUM(cantProducto * precioProducto)) prod,
                             MONTH(fechaFactura)                mes,
                             YEAR(fechaFactura)                 year
                      FROM det_factura df
                               LEFT JOIN factura f on f.idFactura = df.idFactura
                      WHERE df.codProducto < 100000
                        AND df.codProducto > 10000
                      GROUP BY year, mes) p
                         LEFT JOIN (SELECT ROUND(SUM(cantProducto * precioProducto)) dist,
                                           MONTH(fechaFactura)                mes,
                                           YEAR(fechaFactura)                 year
                                    FROM det_factura df
                                             LEFT JOIN factura f on f.idFactura = df.idFactura
                                    WHERE df.codProducto > 100000
                                    GROUP BY year, mes) d ON p.year = d.year AND p.mes = d.mes
                         LEFT JOIN (SELECT SUM(cantProducto * precioProducto) serv,
                                           MONTH(fechaFactura)                mes,
                                           YEAR(fechaFactura)                 year
                                    FROM det_factura df
                                             LEFT JOIN factura f on f.idFactura = df.idFactura
                                    WHERE df.codProducto < 10000
                                    GROUP BY year, mes) s ON p.year = s.year AND p.mes = s.mes
                         LEFT JOIN (SELECT MONTH(fechaNotaC) mes, YEAR(fechaNotaC) year, ROUND(SUM(subtotalNotaC)) dev
                                    FROM nota_c
                                    GROUP BY year, mes) dev ON p.year = dev.year AND p.mes = dev.mes
                ORDER BY p.year ASC, p.mes ASC";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);;
        return $result;
    }

    public function getTableDetFactura($idFactura)
    {
        $qry = "SELECT dcp.codProducto, p.presentacion producto, cantProducto, CONCAT('$', FORMAT(precioProducto, 2)) precioProducto,
                       CONCAT('$', FORMAT(precioProducto*cantProducto, 2)) subtotal, 1 orden
                FROM det_factura dcp
                         LEFT JOIN prodpre p on dcp.codProducto = p.codPresentacion
                WHERE idFactura = $idFactura
                  AND dcp.codProducto < 100000 AND dcp.codProducto > 10000
                UNION
                SELECT dcp.codProducto, producto, cantProducto, CONCAT('$', FORMAT(precioProducto, 2)) precioProducto,
                       CONCAT('$', FORMAT(precioProducto*cantProducto, 2)) subtotal, 2 orden
                FROM det_factura dcp
                         LEFT JOIN distribucion d on dcp.codProducto = d.idDistribucion
                WHERE idFactura = $idFactura
                  AND dcp.codProducto >= 100000
                UNION
                SELECT dcp.codProducto, s.desServicio producto, cantProducto, CONCAT('$', FORMAT(precioProducto, 2)) precioProducto,
                       CONCAT('$', FORMAT(precioProducto*cantProducto, 2)) subtotal, 3 orden
                FROM det_factura dcp
                         LEFT JOIN servicios s on dcp.codProducto = s.idServicio
                WHERE idFactura = $idFactura
                  AND dcp.codProducto < 10000
                ORDER BY orden, producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);;
        return $result;
    }

 public function getTotalFactura($idFactura)
    {
        $qry = "SELECT CONCAT('$', FORMAT(SUM(cantProducto*precioProducto), 2)) totalFactura
                FROM det_factura dp
                WHERE dp.idFactura= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFactura));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result){
            return $result['totalFactura'];
        }else{
            return 0;
        }

    }

 public function getTotalItemsFactura($idFactura)
    {
        $qry = "SELECT COUNT(*) c
                FROM det_factura dcp
                WHERE idFactura = ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFactura));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result){
            return $result['c'];
        }else{
            return 0;
        }
    }

    public function getDetProdFactura($idFactura, $codProducto)
    {
        if ($codProducto > 100000) {
            $qry = "SELECT producto, cantProducto, precioProducto
                    FROM det_factura dcp
                             LEFT JOIN distribucion d ON dcp.codProducto=d.idDistribucion
                    WHERE idFactura = ?
                      AND dcp.codProducto = ?";
        }elseif($codProducto < 10000){
            $qry = "SELECT desServicio producto, cantProducto, precioProducto
                    FROM det_factura dcp
                             LEFT JOIN servicios s on dcp.codProducto = s.idServicio
                    WHERE idFactura = ?
                      AND dcp.codProducto = ?;";
        }else{
            $qry = "SELECT presentacion producto, cantProducto, precioProducto
                    FROM det_factura dcp
                             LEFT JOIN prodpre p on dcp.codProducto = p.codPresentacion
                    WHERE idFactura = ?
                      AND dcp.codProducto = ?;";
        }
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idFactura, $codProducto));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);;
        return $result;
    }

    public function updateDetFactura($datos)
    {
        $qry = "UPDATE det_factura SET cantProducto=?, precioProducto=?  WHERE idFactura=? AND codProducto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
