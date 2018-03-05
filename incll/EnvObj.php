<?
include "includes/valAcc.php";
?>
<?
include "includes/conect.php";
class envas{
    function crearEnv($bd,$cod_env,$nom_env, $min_stock)
	{
		
        $qry="insert into envase (Cod_envase, Nom_envase, stock_envase) values ($cod_env,'$nom_env', $min_stock)";
        $link=conectarServidor();
        $result=mysql_db_query($bd,$qry);
        mysql_close($link);//Cerrar la conexion
		return $result;
    }
	function deleteEnv($bd,$cod_env)
	{
        $bd1=$bd;
		$link=conectarServidor();
		if($cod_env>0)
		{
			$qry="delete from envase where Cod_envase=$cod_env";
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

	function updateEnv($bd,$cod_env,$nom_env, $min_stock)	
	{
        $qry="update envase set Nom_envase='$nom_env', stock_envase=$min_stock where Cod_envase=$cod_env";
        $link=conectarServidor();
        $result=mysql_db_query($bd,$qry);
       	mysql_close($link);//Cerrar la conexion
		return $result;
	
    }
}
?>
