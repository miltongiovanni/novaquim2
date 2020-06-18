<?php

class InvProdTerminadosOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeInvProdTerminado($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO inv_prod (codPresentacion, loteProd, invProd) VALUES(?, ?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteInvProdTerminado($datos)
    {
        $qry = "DELETE FROM inv_prod WHERE codPresentacion= ? AND loteProd=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function deleteAllDetCompra($idProv)
    {
        $qry = "DELETE FROM inv_prod WHERE idProv= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idProv));
    }

    public function getFechaLoteInvProdTerminado($codPresentacion, $loteProd)
    {
        $qry = "SELECT fechLote FROM inv_prod WHERE codPresentacion=? AND loteProd=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codPresentacion, $loteProd));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['fechLote'];
    }

    public function getInvProdTerminadoByLote($codPresentacion, $loteProd)
    {
        $qry = "SELECT invProd FROM inv_prod WHERE codPresentacion=? AND loteProd=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codPresentacion, $loteProd));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result == null) {
            return 0;
        } else {
            return $result['invProd'];
        }
    }

    public function getInvTotalProdTerminado($codPresentacion)
    {
        $qry = "SELECT SUM(invProd) invProd FROM inv_prod WHERE codPresentacion=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codPresentacion));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result == null) {
            return 0;
        } else {
            return $result['invProd'];
        }
    }

    public function getInvProdTerminado($codPresentacion)
    {
        $qry = "SELECT codPresentacion, loteProd, invProd FROM inv_prod WHERE codPresentacion=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codPresentacion));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableInvProdTerminado($idCompra, $tipoCompra)
    {
        switch (intval($tipoCompra)) {
            case 1:
                $qry = "SELECT idCompra, codigo, nomMPrima Producto, lote, cantidad, CONCAT('$', FORMAT(precio, 0)) precio FROM det_compras
                        LEFT JOIN mprimas ON codigo=codPresentacion
                        WHERE idCompra=$idCompra";
                break;
            case 2:
                $qry = "SELECT codigo, nomEnvase Producto, lote, cantidad, CONCAT('$', FORMAT(precio, 0)) precio FROM det_compras
                        LEFT JOIN envases ON codigo=codEnvase
                        WHERE idCompra=$idCompra AND codigo < 100
                        UNION
                        SELECT codigo, tapa Producto, lote, cantidad, CONCAT('$', FORMAT(precio, 0)) precio FROM det_compras
                        LEFT JOIN tapas_val ON codigo=codTapa
                        WHERE idCompra=$idCompra AND codigo > 100";
                break;
            case 3:
                $qry = "SELECT codigo, nomEtiqueta Producto, lote, cantidad, CONCAT('$', FORMAT(precio, 0)) precio FROM det_compras
                        LEFT JOIN etiquetas ON codigo=codEtiqueta
                        WHERE idCompra=$idCompra ;";
                break;
            case 5:
                $qry = "SELECT codigo, producto Producto, lote, cantidad, CONCAT('$', FORMAT(precio, 0)) precio FROM det_compras
                        LEFT JOIN distribucion ON codigo=idDistribucion
                        WHERE idCompra=$idCompra";
                break;
        }
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCompra));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getProdInv()
    {
        $qry = "SELECT DISTINCT ip.codPresentacion, presentacion
                FROM inv_prod ip
                LEFT JOIN prodpre p on ip.codPresentacion = p.codPresentacion
                WHERE invProd>0
                ORDER BY presentacion";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getLotesByProd($codPresentacion)
    {
        $qry = "SELECT loteProd
                FROM inv_prod
                WHERE codPresentacion=? AND invProd>0;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codPresentacion));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getInvByLoteAndProd($codPresentacion, $loteProd)
    {
        $qry = "SELECT invProd
                FROM inv_prod
                WHERE codPresentacion=? AND loteProd =? AND invProd>0;";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codPresentacion, $loteProd));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['invProd'];
    }

    public function getDetProveedor($idProv)
    {
        $qry = "SELECT codProveedor, nomProveedor, catProd, proveedores.idCatProd, prodActivo, densMin, densMax, pHmin, pHmax, fragancia, color, apariencia
        FROM  proveedores
        LEFT JOIN cat_prod cp on proveedores.idCatProd = cp.idCatProd
        WHERE codProveedor=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($codProveedor));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getUltimoProdxCat($idCatProd)
    {
        $qry = "SELECT MAX(codProveedor) as Cod from proveedores where idCatProd=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCatProd));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['Cod'];
    }


    public function updateInvProdTerminado($datos)
    {
        $qry = "UPDATE inv_prod SET invProd=? WHERE codPresentacion=? AND loteProd=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
