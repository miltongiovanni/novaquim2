
<?php
include "conect.php";
class distri
{
    function crearDis($Id_prod, $producto, $cod_iva, $cat_dist, $cuenta, $cotiza, $precio_vta, $Activo, $stock_dis)
	{
		
        $qry="insert into distribucion (Id_distribucion, Producto, Cod_iva, Id_Cat_dist, Cuenta_cont, Cotiza, precio_vta, Activo, stock_dis )
        values ($Id_prod, '$producto', $cod_iva, $cat_dist, $cuenta, $cotiza, $precio_vta, $Activo, $stock_dis )";
        $link=conectarServidor();
        $result=mysqli_query($link,$qry);
        mysqli_close($link);//Cerrar la conexion
		return $result;
		
    }
	function deleteDis($Id_prod)
	{
		$link=conectarServidor();
		if($Id_prod>0)
		{
			$qry="delete from distribucion where Id_distribucion=$Id_prod";
			$result=mysqli_query($link,$qry);
			
			if($result==1)
				return 1;
			else
				return 0;
		}
		else{
			return 0;
		}
		mysqli_close($link);//Cerrar la conexion
      }	

	function updateDis($Id_prod, $producto, $cod_iva, $cat_dist, $cuenta, $cotiza, $precio_vta, $Activo, $stock_dis)	
	{
        $qry="update distribucion set Producto='$producto', Cod_iva=$cod_iva, Id_Cat_dist=$cat_dist, Cuenta_cont=$cuenta, Cotiza=$cotiza, precio_vta=$precio_vta, Activo=$Activo, stock_dis=$stock_dis
		where Id_distribucion=$Id_prod";
        $link=conectarServidor();
        $result=mysqli_query($link,$qry);
       	mysqli_close($link);//Cerrar la conexion
		return $result;
	
    }
	
	function updateUtilDis($Id_prod, $util_clien, $util_dist)	
	{
        $qry="update distribucion set util_clien=$util_clien, util_dist=$util_dist	where Id_distribucion=$Id_prod";
        $link=conectarServidor();
        $result=mysqli_query($link,$qry);
       	mysqli_close($link);//Cerrar la conexion
		return $result;
	
    }
}
?>
