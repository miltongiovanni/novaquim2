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

    public function deleteAllDetCompra($idProv)
    {
        $qry = "DELETE FROM det_compras WHERE idProv= ?";
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idProv));
    }

    public function getTableDetCompras($idCompra, $tipoCompra)
    {
        switch (intval($tipoCompra)) {
            case 1:
                $qry = "SELECT idCompra, codigo, nomMPrima Producto, lote, cantidad, CONCAT('$', FORMAT(precio, 0)) precio,
                        CONCAT(format((tasaIva*100),0), ' %') iva
                        FROM det_compras
                        LEFT JOIN mprimas ON codigo=codMPrima
                        LEFT JOIN tasa_iva ti on mprimas.codIva = ti.idTasaIva
                        WHERE idCompra=$idCompra";
                break;
            case 2:
                $qry = "SELECT idCompra, codigo, nomEnvase Producto, lote, cantidad, CONCAT('$', FORMAT(precio, 0)) precio,
                        CONCAT(format((tasaIva*100),0), ' %') iva
                        FROM det_compras
                        LEFT JOIN envases ON codigo=codEnvase
                        LEFT JOIN tasa_iva ti on envases.codIva = ti.idTasaIva
                        WHERE idCompra=$idCompra AND codigo < 100
                        UNION
                        SELECT idCompra, codigo, tapa Producto, lote, cantidad, CONCAT('$', FORMAT(precio, 0)) precio,
                        CONCAT(format((tasaIva*100),0), ' %') iva
                        FROM det_compras
                        LEFT JOIN tapas_val ON codigo=codTapa
                        LEFT JOIN tasa_iva t on tapas_val.codIva = t.idTasaIva
                        WHERE idCompra=$idCompra AND codigo > 100";
                break;
            case 3:
                $qry = "SELECT idCompra, codigo, nomEtiqueta Producto, lote, cantidad, CONCAT('$', FORMAT(precio, 0)) precio,
                        CONCAT(format((tasaIva*100),0), ' %') iva
                        FROM det_compras
                        LEFT JOIN etiquetas ON codigo=codEtiqueta
                        LEFT JOIN tasa_iva ti on etiquetas.codIva = ti.idTasaIva
                        WHERE idCompra=$idCompra ;";
                break;
            case 5:
                $qry = "SELECT idCompra, codigo, producto Producto, lote, cantidad, CONCAT('$', FORMAT(precio, 0)) precio,
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
                        WHERE idCompra=$idCompra AND codigo < 100";
                }
                else{
                    $qry = "SELECT codigo, tapa Producto, lote, cantidad, precio FROM det_compras
                        LEFT JOIN tapas_val ON codigo=codTapa
                        WHERE idCompra=$idCompra AND codigo > 100";
                }

                break;
            case 3:
                $qry = "SELECT codigo, nomEtiqueta Producto, lote, cantidad, precio FROM det_compras
                        LEFT JOIN etiquetas ON codigo=codEtiqueta
                        WHERE idCompra=$idCompra ;";
                break;
            case 5:
                $qry = "SELECT codigo, producto Producto, lote, cantidad, precio FROM det_compras
                        LEFT JOIN distribucion ON codigo=idDistribucion
                        WHERE idCompra=$idCompra";
                break;
        }
        $stmt = $this->_pdo->prepare($qry);
        $stmt->execute(array($idCompra));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);;
        return $result;
    }

    public function getProdPorCategoria($idCompra, $tipoCompra)
    {
        switch (intval($idCatProv)) {
            case 1:
                $qry = "SELECT codMPrima Codigo, nomMPrima Producto FROM mprimas
                        LEFT JOIN det_compras dp ON dp.Codigo=codMPrima AND dp.idProv=? WHERE dp.Codigo IS NULL ORDER BY Producto";
                break;
            case 2:
                $qry = "SELECT codEnvase Codigo, nomEnvase Producto  FROM envases
                        LEFT JOIN det_compras ON Codigo=codEnvase AND idProv=? WHERE Codigo IS NULL
                        UNION
                        SELECT codTapa Codigo, tapa Producto FROM tapas_val
                        LEFT JOIN det_compras ON Codigo=codTapa AND idProv=? AND codTapa<>114 WHERE Codigo IS NULL ORDER BY Producto;
                        ";
                break;
            case 3:
                $qry = "SELECT codEtiqueta Codigo, nomEtiqueta Producto FROM etiquetas
                        LEFT JOIN det_compras ON Codigo=codEtiqueta and idProv=? WHERE Codigo IS NULL ORDER BY Producto;";
                break;
            case 5:
                $qry = "SELECT idDistribucion Codigo, producto Producto FROM distribucion
                        LEFT JOIN det_compras ON Codigo=idDistribucion AND idProv=? WHERE Codigo IS NULL order by Producto";
                break;
        }

        $stmt = $this->_pdo->prepare($qry);

        $stmt->execute(array($idProv));
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
