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

    public function getProductosDistribucion($actif)
    {
        if ($actif == true) {
            $qry = "SELECT idDistribucion, producto FROM distribucion WHERE activo=1 ORDER BY producto;";
        } else {
            $qry = "SELECT idDistribucion, producto FROM distribucion ORDER BY producto;";
        }

        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getTableProductosDistribucion()
    {
        $qry = "SELECT idDistribucion, producto, CONCAT('$ ',format(round(precioVta),0)) precio, CONCAT(format((tasaIva*100),1), ' %') iva, catDis, CONCAT ('003000', codSiigo) coSiigo
        FROM distribucion
        LEFT JOIN cat_dis cd on distribucion.idCatDis = cd.idCatDis
        LEFT JOIN tasa_iva ti on distribucion.codIva = ti.idTasaIva
        WHERE activo=1 and cotiza=1
        ORDER BY cd.idCatDis , producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getProductoDistribucion($idDistribucion)
    {
        $qry = "SELECT idDistribucion, producto, catDis, distribucion.idCatDis, activo, codSiigo, codIva, CONCAT(format((tasaIva*100),1), ' %') iva, precioVta, stockDis, cotiza
        FROM  distribucion
        LEFT JOIN cat_dis cd on distribucion.idCatDis = cd.idCatDis
        LEFT JOIN tasa_iva ti on distribucion.codIva = ti.idTasaIva
        WHERE idDistribucion=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idDistribucion));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getUltimoProdDisxCat($idCatDis)
    {
        $qry = "SELECT MAX(idDistribucion) as Cod from distribucion where idCatDis=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCatDis));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['Cod'];
    }


    public function updateProductoDistribucion($datos)
    {
        $qry = "UPDATE distribucion SET producto=?, codIva=?, precioVta=?, cotiza=?, activo=?, stockDis=? WHERE idDistribucion=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
