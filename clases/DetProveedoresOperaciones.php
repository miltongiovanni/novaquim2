<?php

class DetProveedoresOperaciones
{
    private $_pdo; // Instance de PDO.

    public function __construct()
    {
        $this->setDb();
    }

    public function makeDetProveedor($datos)
    {
        /*Preparo la insercion */
        $qry = "INSERT INTO det_proveedores VALUES(?, ?)";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
        return $this->_pdo->lastInsertId();
    }

    public function deleteDetProveedor($datos)
    {
        $qry = "DELETE FROM det_proveedores WHERE idProv= ? AND Codigo=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function deleteAllDetProveedor($idProv)
    {
        $qry = "DELETE FROM det_proveedores WHERE idProv= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idProv));
    }

    public function getDetProveedores($actif)
    {
        if ($actif == true) {
            $qry = "SELECT idProv, nomProv FROM proveedores WHERE estProv=1 ORDER BY nomProv;";
        } else {
            $qry = "SELECT idProv, nomProv FROM proveedores ORDER BY nomProv;";
        }

        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getTableDetProveedores($idProv)
    {
        $qry = "SELECT Codigo, nomMPrima Producto FROM mprimas, det_proveedores dp
                LEFT JOIN proveedores p on dp.idProv = p.idProv
                WHERE Codigo=codMPrima  AND p.idCatProv=1 AND dp.idProv = $idProv 
                UNION
                SELECT Codigo, nomEnvase Producto FROM envases, det_proveedores dp
                LEFT JOIN proveedores p on dp.idProv = p.idProv
                WHERE Codigo=codEnvase  AND p.idCatProv=2 AND dp.idProv = $idProv
                UNION
                SELECT Codigo, tapa Producto FROM tapas_val, det_proveedores dp
                LEFT JOIN proveedores p on dp.idProv = p.idProv
                WHERE Codigo=codTapa  AND p.idCatProv=2 AND dp.idProv = $idProv
                UNION
                SELECT Codigo, nomEtiqueta Producto FROM etiquetas, det_proveedores dp
                LEFT JOIN proveedores p on dp.idProv = p.idProv
                WHERE Codigo=codEtiqueta  AND p.idCatProv=3 AND dp.idProv = $idProv
                UNION
                SELECT Codigo, producto Producto FROM distribucion, det_proveedores dp
                LEFT JOIN proveedores p on dp.idProv = p.idProv
                WHERE Codigo=idDistribucion  AND p.idCatProv=5 AND dp.idProv = $idProv
                ORDER BY Producto";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getProdPorCategoria($idProv, $idCatProv)
    {
        switch (intval($idCatProv)) {
            case 1:
                $qry = "SELECT codMPrima Codigo, nomMPrima Producto FROM mprimas
                        LEFT JOIN det_proveedores dp ON dp.Codigo=codMPrima AND dp.idProv=? WHERE dp.Codigo IS NULL ORDER BY Producto";
                break;
            case 2:
                $qry = "SELECT codEnvase Codigo, nomEnvase Producto  FROM envases
                        LEFT JOIN det_proveedores ON Codigo=codEnvase AND idProv=? WHERE Codigo IS NULL
                        UNION
                        SELECT codTapa Codigo, tapa Producto FROM tapas_val
                        LEFT JOIN det_proveedores ON Codigo=codTapa AND idProv=? AND codTapa<>114 WHERE Codigo IS NULL ORDER BY Producto;
                        ";
                break;
            case 3:
                $qry = "SELECT codEtiqueta Codigo, nomEtiqueta Producto FROM etiquetas
                        LEFT JOIN det_proveedores ON Codigo=codEtiqueta and idProv=? WHERE Codigo IS NULL ORDER BY Producto;";
                break;
            case 5:
                $qry = "SELECT idDistribucion Codigo, producto Producto FROM distribucion
                        LEFT JOIN det_proveedores ON Codigo=idDistribucion AND idProv=? WHERE Codigo IS NULL order by Producto";
                break;
        }

        $stmt = $this->_pdo->prepare($qry);

        $stmt->execute(array($idProv));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getProdPorProveedor($idProv, $idCatProv)
    {
        switch (intval($idCatProv)) {
            case 1:
                $qry = "SELECT codMPrima Codigo, nomMPrima Producto FROM det_proveedores
                        LEFT JOIN mprimas mp ON mp.codMPrima=Codigo
                        WHERE idProv=$idProv ORDER BY Producto";
                break;
            case 2:
                $qry = "SELECT codEnvase Codigo, nomEnvase Producto FROM det_proveedores
                        LEFT JOIN envases e ON e.codEnvase=Codigo
                        WHERE idProv=$idProv AND Codigo < 100
                        UNION
                        SELECT codTapa Codigo, tapa Producto FROM det_proveedores
                        LEFT JOIN tapas_val tv ON tv.codTapa=Codigo
                        WHERE idProv=$idProv AND Codigo > 100 ORDER BY Producto";
                break;
            case 3:
                $qry = "SELECT codEtiqueta Codigo, nomEtiqueta Producto FROM det_proveedores
                            LEFT JOIN etiquetas e ON e.codEtiqueta=Codigo
                        WHERE idProv=$idProv ORDER BY Producto";
                break;
            case 5:
                $qry = "SELECT idDistribucion Codigo, producto Producto FROM det_proveedores
                            LEFT JOIN distribucion d ON d.idDistribucion=Codigo
                        WHERE idProv=$idProv ORDER BY Producto;";
                break;
        }
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
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


    public function updateDetProveedor($datos)
    {
        $qry = "UPDATE proveedores SET nomProveedor=?, idCatProd=?, prodActivo=?, densMin=?, densMax=?, pHmin=?,  pHmax=?, fragancia=?, color=?, apariencia=? WHERE codProveedor=?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute($datos);
    }

    public function setDb()
    {

        $this->_pdo = Conectar::conexion(); //Almacenamos en _pdo la llamada la clase estática Conectar;

    }
}
