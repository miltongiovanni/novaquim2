<?php
include "conect.php";
class mprim{
    function crearMP($cod_mp,$mprima, $cod_cat_mp, $min_stock, $tasa_iva)
	{
		
        $qry="insert into mprimas (Cod_mprima, Nom_mprima, Id_cat_mp, Min_stock_mp, Cod_iva)
        values ($cod_mp,'$mprima', $cod_cat_mp, $min_stock, $tasa_iva)";
        $link=conectarServidor();
        $result=mysqli_query($link,$qry);
		return $result;
		mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
    }
	function deleteMP($cod_mp)
	{
		$link=conectarServidor();
		if($cod_mp>0)
		{
			$qry="delete from mprimas where Cod_mprima=$cod_mp";
			$result=mysqli_query($link,$qry);
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

	function updateMP($cod_mp,$mprima, $cod_cat_mp, $min_stock, $tasa_iva)	
	{
        $qry="update mprimas set Nom_mprima='$mprima', Id_cat_mp=$cod_cat_mp, Min_stock_mp=$min_stock, Cod_iva=$tasa_iva 
		where Cod_mprima=$cod_mp";
        $link=conectarServidor();
        $result=mysqli_query($link,$qry);
		return $result;
	mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
    }
}
?>
