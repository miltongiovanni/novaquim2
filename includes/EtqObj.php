
<?php
include "includes/conect.php";
class etiq{
    function crearEtq($cod_etq,$nom_etq, $min_stock)
	{
		
        $qry="insert into etiquetas (Cod_etiq, Nom_etiq, stock_etiq) values ($cod_etq,'$nom_etq', $min_stock)";
        $link=conectarServidor();
        $result=mysqli_query($link,$qry);
		return $result;
		mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
    }
	function deleteEtq($cod_etq)
	{
		$link=conectarServidor();
		if($cod_etq>0)
		{
			$qry="delete from etiquetas where Cod_etiq=$cod_etq";
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

	function updateEtq($cod_etq,$nom_etq, $min_stock)	
	{
        $qry="update etiquetas set Nom_etiq='$nom_etq', stock_etiq=$min_stock where Cod_etiq=$cod_etq";
        $link=conectarServidor();
        $result=mysqli_query($link,$qry);
		return $result;
	mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
    }
}
?>
