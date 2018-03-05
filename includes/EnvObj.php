<?php
include "conect.php";
class envas{
    function crearEnv($cod_env,$nom_env, $min_stock)
	{
		
        $qry="insert into envase (Cod_envase, Nom_envase, stock_envase) values ($cod_env,'$nom_env', $min_stock)";
        $link=conectarServidor();
        $result=mysqli_query($link,$qry);
		return $result;
		mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
    }
	function deleteEnv($cod_env)
	{
		$link=conectarServidor();
		if($cod_env>0)
		{
			$qry="delete from envase where Cod_envase=$cod_env";
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

	function updateEnv($cod_env,$nom_env, $min_stock)	
	{
        $qry="update envase set Nom_envase='$nom_env', stock_envase=$min_stock where Cod_envase=$cod_env";
        $link=conectarServidor();
        $result=mysqli_query($link,$qry);
		return $result;
	mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
    }
}
?>
