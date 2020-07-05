<?php

class ProductosOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeProducto($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO productos VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, 365)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteProducto($codProducto)
    {
        $qry = "DELETE FROM productos WHERE codProducto= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codProducto));
    }

    public function getProductos($actif)
    {
        if ($actif == true) {
            $qry = "SELECT codProducto, nomProducto FROM productos WHERE prodActivo=1 ORDER BY nomProducto;";
        } else {
            $qry = "SELECT codProducto, nomProducto FROM productos ORDER BY nomProducto;";
        }

        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getProductosEliminar()
    {
        $qry = "SELECT productos.codProducto, nomProducto
                FROM productos
                LEFT JOIN ord_prod op on productos.codProducto = op.codProducto
                LEFT JOIN prodpre p on productos.codProducto = p.codProducto
                WHERE op.codProducto IS NULL AND p.codProducto IS NULL
                ORDER BY nomProducto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableProductos()
    {
        $qry = "SELECT codProducto, nomProducto, catProd, densMin, densMax, pHmin, pHmax, fragancia, color, apariencia FROM productos
        LEFT JOIN cat_prod cp on productos.idCatProd = cp.idCatProd
        WHERE prodActivo=1
        ORDER BY codProducto;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getProducto($codProducto)
    {
        $qry = "SELECT codProducto, nomProducto, catProd, productos.idCatProd, prodActivo, densMin, densMax, pHmin, pHmax, fragancia, color, apariencia
        FROM  productos
        LEFT JOIN cat_prod cp on productos.idCatProd = cp.idCatProd
        WHERE codProducto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codProducto));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getNameProducto($codProducto)
    {
        $qry = "SELECT nomProducto
        FROM  productos
        WHERE codProducto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codProducto));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['nomProducto'];
    }

    public function getUltimoProdxCat($idCatProd)
    {
        $qry = "SELECT MAX(codProducto) as Cod from productos where idCatProd=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCatProd));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['Cod'];
    }


    public function updateProducto($datos)
    {
        $qry = "UPDATE productos SET nomProducto=?, idCatProd=?, prodActivo=?, densMin=?, densMax=?, pHmin=?,  pHmax=?, fragancia=?, color=?, apariencia=? WHERE codProducto=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
