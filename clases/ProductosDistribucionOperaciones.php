<?php

class ProductosDistribucionOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeProductoDistribucion($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO distribucion (idDistribucion, producto, codIva, idCatDis, cotiza, precioVta, activo, stockDis, codSiigo ) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteProductoDistribucion($idDistribucion)
    {
        $qry = "DELETE FROM distribucion WHERE idDistribucion= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idDistribucion));
    }

    public function getPrecioProductoDistribucion($idDistribucion)
    {
        $qry = "SELECT precioCom FROM distribucion WHERE idDistribucion=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idDistribucion));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['precioCom'];
    }

    public function getPrecioVtaProductoDistribucion($idDistribucion)
    {
        $qry = "SELECT precioVta FROM distribucion WHERE idDistribucion=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idDistribucion));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return $result['precioVta'];
        } else {
            return false;
        }

    }

    public function getProductosDistribucion($actif)
    {
        if ($actif == true) {
            $qry = "SELECT idDistribucion, producto FROM distribucion WHERE activo=1 ORDER BY producto;";
        } else {
            $qry = "SELECT idDistribucion, producto FROM distribucion WHERE activo=0 ORDER BY producto;";
        }

        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableProductosDistribucion()
    {
        $qry = "SELECT DISTINCT idDistribucion,
                       producto,
                       round(precioVta) precio,
                       tasaIva*100 iva,
                       catDis,
                       cd.idCatDis,
                       t1.ultima_compra,
                       round(d.precioCom) precioCompra,
                       REPLACE(format(round(dc.precio),0), ',', '.') precio_ultima_compra,
                       p.nomProv,
                       CONCAT ('003000', codSiigo) coSiigo
                FROM distribucion d
                LEFT JOIN   
                  (SELECT dc.codigo,
                          MAX(c.fechComp) ultima_compra
                   FROM det_compras dc
                   INNER JOIN compras c ON dc.idCompra = c.idCompra
                   WHERE codigo > 100000
                     AND codigo < 1000000
                   GROUP BY dc.codigo) t1 ON t1.codigo= d.idDistribucion
                LEFT JOIN det_compras dc ON t1.codigo=dc.codigo
                INNER JOIN compras c ON dc.idCompra = c.idCompra
                INNER JOIN proveedores p ON c.idProv=p.idProv
                LEFT JOIN cat_dis cd ON d.idCatDis = cd.idCatDis
                LEFT JOIN tasa_iva ti ON d.codIva = ti.idTasaIva
                WHERE activo=1
                  AND c.fechComp = t1.ultima_compra
                ORDER BY cd.idCatDis,
                 producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getProductoDistribucion($idDistribucion)
    {
        $qry = "SELECT idDistribucion, producto, precioCom, catDis, distribucion.idCatDis, activo, codSiigo, codIva, CONCAT(format((tasaIva*100),1), ' %') iva, precioVta, stockDis, cotiza
        FROM  distribucion
        LEFT JOIN cat_dis cd on distribucion.idCatDis = cd.idCatDis
        LEFT JOIN tasa_iva ti on distribucion.codIva = ti.idTasaIva
        WHERE idDistribucion=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idDistribucion));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getNomProductoDistribucion($idDistribucion)
    {
        $qry = "SELECT producto
        FROM  distribucion
        WHERE idDistribucion=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idDistribucion));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['producto'];
    }

    public function getUltimoProdDisxCat($idCatDis)
    {
        $qry = "SELECT MAX(idDistribucion) as Cod from distribucion where idCatDis=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCatDis));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['Cod'];
    }

    public function updatePrecioCompraProductoDistribucion($datos)
    {
        $qry = "UPDATE distribucion SET precioCom=? WHERE idDistribucion=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function updateProductoDistribucion($datos)
    {
        $qry = "UPDATE distribucion SET producto=?, codIva=?, precioVta=?, cotiza=?, activo=?, stockDis=? WHERE idDistribucion=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }
    public function updateProductoPrecioDistribucion($datos)
    {
        $qry = "UPDATE distribucion SET precioCom=? WHERE idDistribucion=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }
    public function desactivarProductoDistribucion($idDistribucion)
    {
        $qry = "UPDATE distribucion SET activo=0 WHERE idDistribucion=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idDistribucion));
    }
    public function activarProductoDistribucion($idDistribucion)
    {
        $qry = "UPDATE distribucion SET activo=1 WHERE idDistribucion=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idDistribucion));
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
