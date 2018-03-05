<?php
include "conect.php";
class Client{
    function makeClient($Nit_clien, $Nom_clien, $Dir_clien, $Contacto, $Cargo, $Tel_clien, $Fax_clien, $Id_cat_clien, $Estado, $Ciudad_clien, $Ret_iva, $Ret_ica, $Ret_fte, $celular, $vendedor, $Fecha)
	{
        $qry="insert into clientes (Nit_clien, Nom_clien, Dir_clien, Contacto, Cargo, Tel_clien, Fax_clien, Id_cat_clien, Estado, Ciudad_clien, Ret_iva, Ret_ica, Ret_fte, Cel_clien, cod_vend, Fch_Cr_clien )
        values ('$Nit_clien', '$Nom_clien','$Dir_clien','$Contacto', '$Cargo', $Tel_clien, $Fax_clien, $Id_cat_clien, '$Estado', $Ciudad_clien, $Ret_iva, $Ret_ica, $Ret_fte, $celular, $vendedor, '$Fecha' )";
        $link=conectarServidor();
		$result=mysqli_query($link,$qry);
		mysqli_close($link);
		return $result;
    }

	function deleteClient($nit_cli)
	{
		$link=conectarServidor();
		$qry="delete from clientes where Nit_clien='$nit_cli'";
		$result=mysqli_query($link,$qry);
		if($result==1)
			return 1;
		else
			return 0;
		mysqli_close($link);
    }	                 
	function updateClient($Nit_clien, $Nom_clien, $Dir_clien, $Contacto, $Cargo, $Cel_clien, $Tel_clien, $Fax_clien, $Eml_clien, $Id_cat_clien, $Estado, $Ciudad_clien, $Ret_iva, $Ret_ica, $Ret_fte, $vendedor)	
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
				cod_vend=$vendedor,
				Ret_iva=$Ret_iva,
				Ret_ica=$Ret_ica,
				Ret_fte=$Ret_fte
				where Nit_clien='$Nit_clien'";
				$link=conectarServidor();
				$result=mysqli_query($link,$qry);
				mysqli_close($link);
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
				cod_vend=$vendedor,
				Ret_iva=$Ret_iva,
				Ret_ica=$Ret_ica,
				Ret_fte=$Ret_fte
				where Nit_clien='$Nit_clien'";
				$link=conectarServidor();
				$result=mysqli_query($link,$qry);
				mysqli_close($link);
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
				cod_vend=$vendedor,
				Ret_iva=$Ret_iva,
				Ret_ica=$Ret_ica,
				Ret_fte=$Ret_fte,
				Ret_cree=$Ret_cree
				where Nit_clien='$Nit_clien';";
				$link=conectarServidor();
				$result=mysqli_query($link,$qry);
				mysqli_close($link);
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
			cod_vend=$vendedor,
			Ret_iva=$Ret_iva,
			Ret_ica=$Ret_ica,
			Ret_fte=$Ret_fte
			where Nit_clien='$Nit_clien'";
			$link=conectarServidor();
			$result=mysqli_query($link,$qry);
			mysqli_close($link);
			return $result;
		}
    }
}
?>
