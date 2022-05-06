<?php

class DetComprasOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeDetCompra($tipoCompra, $datos)
    {
        /*Preparo la insercion */
        if($tipoCompra==1){
            $qry = "INSERT INTO det_compras (idCompra, codigo, cantidad, precio, lote)VALUES(?, ?, ?, ?, ?)";
        }
        else{
            $qry = "INSERT INTO det_compras (idCompra, codigo, cantidad, precio)VALUES(?, ?, ?, ?)";
        }
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteDetCompra($datos)
    {
        $qry = "DELETE FROM det_compras WHERE idCompra= ? AND codigo=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function getTableDetCompras($idCompra, $tipoCompra)
    {
        switch (intval($tipoCompra)) {
            case 1:
                $qry = "SELECT idCompra, codigo, nomMPrima Producto, lote, cantidad, CONCAT('$', FORMAT(precio, 2)) precio,
                        CONCAT(format((tasaIva*100),0), ' %') iva
                        FROM det_compras
                        LEFT JOIN mprimas ON codigo=codMPrima
                        LEFT JOIN tasa_iva ti on mprimas.codIva = ti.idTasaIva
                        WHERE idCompra=$idCompra";
                break;
            case 2:
                $qry = "SELECT idCompra, codigo, nomEnvase Producto, lote, cantidad, CONCAT('$', FORMAT(precio, 2)) precio,
                        CONCAT(format((tasaIva*100),0), ' %') iva
                        FROM det_compras
                        LEFT JOIN envases ON codigo=codEnvase
                        LEFT JOIN tasa_iva ti on envases.codIva = ti.idTasaIva
                        WHERE idCompra=$idCompra AND codigo < 100
                        UNION
                        SELECT idCompra, codigo, tapa Producto, lote, cantidad, CONCAT('$', FORMAT(precio, 2)) precio,
                        CONCAT(format((tasaIva*100),0), ' %') iva
                        FROM det_compras
                        LEFT JOIN tapas_val ON codigo=codTapa
                        LEFT JOIN tasa_iva t on tapas_val.codIva = t.idTasaIva
                        WHERE idCompra=$idCompra AND codigo > 100";
                break;
            case 3:
                $qry = "SELECT idCompra, codigo, nomEtiqueta Producto, lote, cantidad, CONCAT('$', FORMAT(precio, 2)) precio,
                        CONCAT(format((tasaIva*100),0), ' %') iva
                        FROM det_compras
                        LEFT JOIN etiquetas ON codigo=codEtiqueta
                        LEFT JOIN tasa_iva ti on etiquetas.codIva = ti.idTasaIva
                        WHERE idCompra=$idCompra ;";
                break;
            case 5:
                $qry = "SELECT idCompra, codigo, producto Producto, lote, cantidad, CONCAT('$', FORMAT(precio, 2)) precio,
                        CONCAT(format((tasaIva*100),0), ' %') iva
                        FROM det_compras
                        LEFT JOIN distribucion ON codigo=idDistribucion
                        LEFT JOIN tasa_iva ti on distribucion.codIva = ti.idTasaIva
                        WHERE idCompra=$idCompra";
                break;
        }
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCompra));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getProdPorProveedorCompra($idProv, $idCatProv, $idCompra)
    {
        switch (intval($idCatProv)) {
            case 1:
                $qry = "SELECT dp.Codigo, dp.Producto FROM
                        (SELECT codMPrima Codigo, nomMPrima Producto FROM det_proveedores
                        LEFT JOIN mprimas mp ON mp.codMPrima=Codigo
                        WHERE idProv=$idProv) dp
                        LEFT JOIN (SELECT codigo from det_compras WHERE idCompra=$idCompra) dc ON dp.Codigo=dc.codigo
                        WHERE dc.codigo IS NULL
                        ORDER BY dp.Producto";
                break;
            case 2:
                $qry = "SELECT dp.Codigo, dp.Producto FROM
                        (SELECT codEnvase Codigo, nomEnvase Producto FROM det_proveedores
                        LEFT JOIN envases e ON e.codEnvase=Codigo
                        WHERE idProv=$idProv AND Codigo<100 ORDER BY nomEnvase) dp
                        LEFT JOIN (SELECT codigo from det_compras WHERE idCompra=$idCompra) dc ON dp.Codigo=dc.codigo
                        WHERE dc.codigo IS NULL
                        UNION
                        SELECT dp.Codigo, dp.Producto FROM
                        (SELECT codTapa Codigo, tapa Producto FROM det_proveedores
                        LEFT JOIN tapas_val tv ON tv.codTapa=Codigo
                        WHERE idProv=$idProv AND Codigo>100 ORDER BY tapa) dp
                        LEFT JOIN (SELECT codigo from det_compras WHERE idCompra=$idCompra) dc ON dp.Codigo=dc.codigo
                        WHERE dc.codigo IS NULL
                        ORDER BY Producto";
                break;
            case 3:
                $qry = "SELECT dp.Codigo, dp.Producto FROM
                        (SELECT codEtiqueta Codigo, nomEtiqueta Producto FROM det_proveedores
                        LEFT JOIN etiquetas e ON e.codEtiqueta=Codigo
                        WHERE idProv=$idProv) dp
                        LEFT JOIN (SELECT codigo from det_compras WHERE idCompra=$idCompra) dc ON dp.Codigo=dc.codigo
                        WHERE dc.codigo IS NULL ORDER BY Producto";
                break;
            case 5:
                $qry = "SELECT dp.Codigo, dp.Producto FROM
                        (SELECT idDistribucion Codigo, producto Producto FROM det_proveedores
                        LEFT JOIN distribucion d ON d.idDistribucion=Codigo
                        WHERE idProv=$idProv) dp
                        LEFT JOIN (SELECT codigo from det_compras WHERE idCompra=$idCompra) dc ON dp.Codigo=dc.codigo
                        WHERE dc.codigo IS NULL ORDER BY Producto";
                break;
        }
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getDetCompra($idCompra, $tipoCompra, $codigo)
    {
        switch (intval($tipoCompra)) {
            case 1:
                $qry = "SELECT idCompra, codigo, nomMPrima Producto, lote, cantidad, precio
                        FROM det_compras
                        LEFT JOIN mprimas ON codigo=codMPrima
                        WHERE idCompra=$idCompra AND codigo=$codigo";
                break;
            case 2:
                if($codigo < 100){
                    $qry = "SELECT codigo, nomEnvase Producto, lote, cantidad, precio FROM det_compras
                        LEFT JOIN envases ON codigo=codEnvase
                        WHERE idCompra=$idCompra AND codigo < 100  AND codigo=$codigo";
                }
                else{
                    $qry = "SELECT codigo, tapa Producto, lote, cantidad, precio FROM det_compras
                        LEFT JOIN tapas_val ON codigo=codTapa
                        WHERE idCompra=$idCompra AND codigo > 100  AND codigo=$codigo";
                }

                break;
            case 3:
                $qry = "SELECT codigo, nomEtiqueta Producto, lote, cantidad, precio FROM det_compras
                        LEFT JOIN etiquetas ON codigo=codEtiqueta
                        WHERE idCompra=$idCompra AND codigo=$codigo";
                break;
            case 5:
                $qry = "SELECT codigo, producto Producto, lote, cantidad, precio FROM det_compras
                        LEFT JOIN distribucion ON codigo=idDistribucion
                        WHERE idCompra=$idCompra  AND codigo=$codigo";
                break;
        }
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCompra));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);;
        return $result;
    }

    public function getHistoricoComprasDistribucion($idDistribucion)
    {
        $qry = "SELECT fechComp, nomProv, CONCAT('$', FORMAT(precio, 0)) precioSinIva, CONCAT('$', FORMAT(precio*(1+tasaIva), 2)) precioConIva,  FORMAT(cantidad, 0) cantidad  FROM det_compras dc
                LEFT JOIN compras c on dc.idCompra = c.idCompra
                LEFT JOIN proveedores pr ON c.idProv = pr.idProv
                LEFT JOIN distribucion d on dc.codigo = d.idDistribucion
                LEFT JOIN tasa_iva ti on d.codIva = ti.idTasaIva
                WHERE codigo=? AND c.tipoCompra=5";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idDistribucion));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getHistoricoComprasMPrimas($codMPrima)
    {
        $qry = "SELECT fechComp, nomProv, CONCAT('$', FORMAT(precio, 0)) precioSinIva, CONCAT('$', FORMAT(precio*(1+tasaIva), 2)) precioConIva, FORMAT(cantidad, 0) cantidad  FROM det_compras dc
                LEFT JOIN compras c on dc.idCompra = c.idCompra
                LEFT JOIN proveedores pr ON c.idProv = pr.idProv
                LEFT JOIN mprimas mp on dc.codigo = mp.codMPrima
                LEFT JOIN tasa_iva ti on mp.codIva = ti.idTasaIva
                WHERE codigo=? AND c.tipoCompra=1";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codMPrima));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getHistoricoComprasEnvases($codEnvase)
    {
        $qry = "SELECT fechComp, nomProv, CONCAT('$', FORMAT(precio, 0)) precioSinIva, CONCAT('$', FORMAT(precio*(1+tasaIva), 2)) precioConIva, FORMAT(cantidad, 0) cantidad  FROM det_compras dc
                LEFT JOIN compras c on dc.idCompra = c.idCompra
                LEFT JOIN proveedores pr ON c.idProv = pr.idProv
                LEFT JOIN envases e on dc.codigo = e.codEnvase
                LEFT JOIN tasa_iva ti on e.codIva = ti.idTasaIva
                WHERE codigo=? AND c.tipoCompra=2";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codEnvase));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getHistoricoComprasTapas($codTapa)
    {
        $qry = "SELECT fechComp, nomProv, CONCAT('$', FORMAT(precio, 0)) precioSinIva, CONCAT('$', FORMAT(precio*(1+tasaIva), 2)) precioConIva, FORMAT(cantidad, 0) cantidad  FROM det_compras dc
                LEFT JOIN compras c on dc.idCompra = c.idCompra
                LEFT JOIN proveedores pr ON c.idProv = pr.idProv
                LEFT JOIN tapas_val tv on dc.codigo = tv.codTapa
                LEFT JOIN tasa_iva ti on tv.codIva = ti.idTasaIva
                WHERE codigo=? AND c.tipoCompra=2";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codTapa));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getDetComprasMPTrazabilidad($codMPrima, $loteMP )
    {
        $qry = "SELECT fechComp, nomProv, cantidad
                FROM det_compras dc
                         LEFT JOIN compras c on c.idCompra = dc.idCompra
                         LEFT JOIN proveedores p on c.idProv = p.idProv
                WHERE codigo = ?
                  AND lote = ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codMPrima, $loteMP));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function productoExiste($idCompra, $codigo)
    {
        $qry = "SELECT COUNT(*) c from det_compras where idCompra=? AND codigo=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCompra, $codigo));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $productoExiste = $result['c']>0;
        return $productoExiste;
    }


    public function updateDetCompra($tipoCompra, $datos)
    {
        if($tipoCompra==1){
            $qry = "UPDATE det_compras SET cantidad=?, precio=?, lote=? WHERE idCompra=? AND codigo=?";
        }
        else{
            $qry = "UPDATE det_compras SET cantidad=?, precio=? WHERE idCompra=? AND codigo=?";
        }

        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
