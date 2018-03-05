<?php
include "valAcc.php";
?>
<?php
include "conect.php";



class distri
{
    function crearDis($bd, $Id_prod, $producto, $cod_iva, $cat_dist, $cuenta, $cotiza, $precio_vta, $Activo, $stock_dis)
	{
		
        $qry="insert into distribucion (Id_distribucion, Producto, Cod_iva, Id_Cat_dist, Cuenta_cont, Cotiza, precio_vta, Activo, stock_dis )
        values ($Id_prod, '$producto', $cod_iva, $cat_dist, $cuenta, $cotiza, $precio_vta, $Activo, $stock_dis )";
        $link=conectarServidor();
        $result=mysql_db_query($bd,$qry);
        mysql_close($link);//Cerrar la conexion
		return $result;
		
    }
	function deleteDis($bd,$Id_prod)
	{
        $bd1=$bd;
		$link=conectarServidor();
		if($Id_prod>0)
		{
			$qry="delete from distribucion where Id_distribucion=$Id_prod";
			$result=mysql_db_query($bd1,$qry);
			mysql_close($link);//Cerrar la conexion
			if($result==1)
				return 1;
			else
				return 0;
		}
		else{
			return 0;
		}
      }	

	function updateDis($bd, $Id_prod, $producto, $cod_iva, $cat_dist, $cuenta, $cotiza, $precio_vta, $Activo, $stock_dis)	
	{
        $qry="update distribucion set Producto='$producto', Cod_iva=$cod_iva, Id_Cat_dist=$cat_dist, Cuenta_cont=$cuenta, Cotiza=$cotiza, precio_vta=$precio_vta, Activo=$Activo, stock_dis=$stock_dis
		where Id_distribucion=$Id_prod";
        $link=conectarServidor();
        $result=mysql_db_query($bd,$qry);
       	mysql_close($link);//Cerrar la conexion
		return $result;
	
    }
	
	function updateUtilDis($bd, $Id_prod, $util_clien, $util_dist)	
	{
        $qry="update distribucion set util_clien=$util_clien, util_dist=$util_dist	where Id_distribucion=$Id_prod";
        $link=conectarServidor();
        $result=mysql_db_query($bd,$qry);
       	mysql_close($link);//Cerrar la conexion
		return $result;
	
    }
}
?>
