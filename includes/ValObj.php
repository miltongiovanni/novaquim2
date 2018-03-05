
<?php
include "conect.php";
class valv{
    function crearVal($cod_val,$nom_val, $min_stock)
	{
		
        $qry="insert into tapas_val (Cod_tapa, Nom_tapa, stock_tapa) values ($cod_val,'$nom_val', $min_stock)";
        $link=conectarServidor();
        $result=mysqli_query($link,$qry);
		return $result;
		mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
    }
	function deleteVal($cod_val)
	{
		$link=conectarServidor();
		if($cod_val>0)
		{
			$qry="delete from tapas_val where Cod_tapa=$cod_val";
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

	function updateVal($cod_val,$nom_val, $min_stock)	
	{
        $qry="update tapas_val set Nom_tapa='$nom_val', stock_tapa=$min_stock where Cod_tapa=$cod_val";
        $link=conectarServidor();
        $result=mysqli_query($link,$qry);
		return $result;
	mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
    }
}
?>
