<?php
include "conect.php";
class produ{
    function crearProd($codigo,$producto, $Cate, $cuenta, $den_min, $den_max, $ph_min, $ph_max, $fragancia, $color, $Apariencia)
	{
		$densidad=($den_min + $den_max)/2;
        $qry="insert into productos (Cod_produc, Nom_produc, Id_cat_prod, Cuenta_cont, densidad, prod_activo, Den_min, Den_max, pH_min, pH_max, Fragancia, Color, Apariencia)
        values ($codigo,'$producto', $Cate, $cuenta, $densidad, 0, $den_min, $den_max, $ph_min, $ph_max, '$fragancia', '$color', '$Apariencia')";
        $link=conectarServidor();
        $result=mysqli_query($link,$qry);
		return $result;
		mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
    }
	function validarProd($cod_prod, &$valida)
	{
		
        $qry="select * from productos where Cod_produc=$cod_prod";
        $link=conectarServidor();
        $result=mysqli_query($link, $qry);
		$row=mysqli_fetch_array($result);
		if ($row['Cod_produc']>0)
			$valida=1;
		return $result;
		mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
    }

	function deleteProd($cod_prod)
	{
		$link=conectarServidor();
		if($cod_prod>0)
		{
			$qry="delete from productos  where Cod_produc=$cod_prod";
			$result=mysqli_query($link, $qry);
			if($result==1)
				return 1;
			else
				return 0;
		}
		else{
			return 0;
		}
/* cerrar la conexión */
mysqli_close($link);
      }	

	function updateProd($Cod_prod, $Producto, $IdCat, $cuenta, $prod_act, $den_min, $den_max, $ph_min, $ph_max, $fragancia, $color, $Apariencia )	
	{
		$densidad=($den_max+$den_min)/2;
        $qry="update productos set Nom_produc='$Producto', Id_cat_prod=$IdCat, Cuenta_cont=$cuenta,densidad=$densidad, prod_activo=$prod_act, Den_min=$den_min, Den_max=$den_max, pH_min=$ph_min, pH_max=$ph_max, Fragancia='$fragancia', Color='$color', Apariencia='$Apariencia' 
		where Cod_produc=$Cod_prod";
        $link=conectarServidor();
        $result=mysqli_query($link, $qry);
		return $result;
	mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
    }
}
?>
