<?
include "includes/valAcc.php";
?>
<?
include "includes/conect.php";
class Client{
    function makeClient($bd, $Nit_clien, $Nom_clien, $Dir_clien, $Contacto, $Cargo, $Tel_clien, $Fax_clien, $Id_cat_clien, $Estado, $Ciudad_clien, $Ret_iva, $Ret_ica, $Ret_fte, $localidad, $vendedor)
	{
        $qry="insert into clientes (Nit_clien, Nom_clien, Dir_clien, Contacto, Cargo, Tel_clien, Fax_clien, Id_cat_clien, Estado, Ciudad_clien, Ret_iva, Ret_ica, Ret_fte, loc_clien, cod_vend )
        values ('$Nit_clien', '$Nom_clien','$Dir_clien','$Contacto', '$Cargo', $Tel_clien, $Fax_clien, $Id_cat_clien, '$Estado', $Ciudad_clien, $Ret_iva, $Ret_ica, $Ret_fte, $localidad, $vendedor )";
        $link=conectarServidor();
		$result=mysql_db_query($bd,$qry);
		mysql_close($link);
		return $result;
    }

	function deleteClient($bd,$nit_cli)
	{
        $bd1=$bd;
		$link=conectarServidor();
		$qry="delete from clientes where Nit_clien='$nit_cli'";
		$result=mysql_db_query($bd1,$qry);
		if($result==1)
			return 1;
		else
			return 0;
		mysql_close($link);
    }	
	function updateClient($bd, $Nit_clien, $Nom_clien, $Dir_clien, $Contacto, $Cargo, $Cel_clien, $Tel_clien, $Fax_clien, $Eml_clien, $Id_cat_clien, $Estado, $Ciudad_clien, $Ret_iva, $Ret_ica, $Ret_fte, $localidad, $vendedor)	
	{
		if ($Cel_clien==NULL || $Eml_clien==NULL)
		{
			if ($Cel_clien==NULL && $Eml_clien!=NULL)
			{
				$qry="update clientes set 
				Nom_clien='$Nom_clien', 
				Dir_clien='$Dir_clien', 
				Contacto='$Contacto',
				Cargo='$Cargo', 
				Tel_clien=$Tel_clien, 
				Fax_clien=$Fax_clien,
				Eml_clien='$Eml_clien', 
				Id_cat_clien=$Id_cat_clien,
				Estado='$Estado',
				Ciudad_clien=$Ciudad_clien,
				loc_clien=$localidad, 
				cod_vend=$vendedor,
				Ret_iva=$Ret_iva,
				Ret_ica=$Ret_ica,
				Ret_fte=$Ret_fte
				where Nit_clien='$Nit_clien'";
				$link=conectarServidor();
				$result=mysql_db_query($bd,$qry);
				mysql_close($link);
				return $result;
			}
			if ($Cel_clien!=NULL && $Eml_clien==NULL)
			{
				$qry="update clientes set 
				Nom_clien='$Nom_clien', 
				Dir_clien='$Dir_clien', 
				Contacto='$Contacto',
				Cargo='$Cargo', 
				Tel_clien=$Tel_clien, 
				Fax_clien=$Fax_clien,
				Cel_clien=$Cel_clien, 
				Id_cat_clien=$Id_cat_clien,
				Estado='$Estado',
				Ciudad_clien=$Ciudad_clien,
				loc_clien=$localidad, 
				cod_vend=$vendedor,
				Ret_iva=$Ret_iva,
				Ret_ica=$Ret_ica,
				Ret_fte=$Ret_fte
				where Nit_clien='$Nit_clien'";
				$link=conectarServidor();
				$result=mysql_db_query($bd,$qry);
				mysql_close($link);
				return $result;			
			}
			if ($Cel_clien==NULL && $Eml_clien==NULL)
			{
				$qry="update clientes set 
				Nom_clien='$Nom_clien', 
				Dir_clien='$Dir_clien', 
				Contacto='$Contacto',
				Cargo='$Cargo', 
				Tel_clien=$Tel_clien, 
				Fax_clien=$Fax_clien,
				Id_cat_clien=$Id_cat_clien,
				Estado='$Estado',
				Ciudad_clien=$Ciudad_clien,
				loc_clien=$localidad, 
				cod_vend=$vendedor,
				Ret_iva=$Ret_iva,
				Ret_ica=$Ret_ica,
				Ret_fte=$Ret_fte
				where Nit_clien='$Nit_clien';";
				$link=conectarServidor();
				$result=mysql_db_query($bd,$qry);
				mysql_close($link);
				return $result;			
			}
		}
		else
		{
			$qry="update clientes set 
			Nom_clien='$Nom_clien', 
			Dir_clien='$Dir_clien', 
			Contacto='$Contacto',
			Cargo='$Cargo', 
			Tel_clien=$Tel_clien, 
			Fax_clien=$Fax_clien,
			Cel_clien=$Cel_clien, 
			Eml_clien='$Eml_clien', 
			Id_cat_clien=$Id_cat_clien,
			Estado='$Estado',
			Ciudad_clien=$Ciudad_clien,
			loc_clien=$localidad, 
			cod_vend=$vendedor,
			Ret_iva=$Ret_iva,
			Ret_ica=$Ret_ica,
			Ret_fte=$Ret_fte
			where Nit_clien='$Nit_clien'";
			$link=conectarServidor();
			$result=mysql_db_query($bd,$qry);
			mysql_close($link);
			return $result;
		}
    }
}
?>
