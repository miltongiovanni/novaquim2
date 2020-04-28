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
            return 0;
        } else {
            return $result['invTapa'];
        }
    }

    public function getTableInvTapas($idCompra, $tipoCompra)
    {
        switch (intval($tipoCompra)) {
            case 1:
                $qry = "SELECT idCompra, codigo, nomMPrima Producto, lote, cantidad, CONCAT('$', FORMAT(precio, 0)) precio FROM det_compras
                        LEFT JOIN mprimas ON codigo=codTaparima
                        WHERE idCompra=$idCompra";
                break;
            case 2:
                $qry = "SELECT codigo, nomEnvase Producto, lote, cantidad, CONCAT('$', FORMAT(precio, 0)) precio FROM det_compras
                        LEFT JOIN inv_tapas_val ON codigo=codTapa
                        WHERE idCompra=$idCompra AND codigo < 100
                        UNION
                        SELECT codigo, tapa Producto, lote, cantidad, CONCAT('$', FORMAT(precio, 0)) precio FROM det_compras
                        LEFT JOIN tapas_val ON codigo=codTapa
                        WHERE idCompra=$idCompra AND codigo > 100";
                break;
            case 3:
                $qry = "SELECT codigo, nomEtiqueta Producto, lote, cantidad, CONCAT('$', FORMAT(precio, 0)) precio FROM det_compras
                        LEFT JOIN etiquetas ON codigo=codTapaueta
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
