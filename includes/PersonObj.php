<?php
include "conect.php";
class person{
    function makePerson($Nombre,$Estado, $Area, $celular, $email, $cargo)
	{
        $qry="insert into personal (nom_personal, activo, Area, cel_personal, Eml_personal, cargo_personal)
        values ('$Nombre', $Estado, $Area, $celular, '$email', $cargo)";
        $mysqli=conectarServidor();
        $result = $mysqli->query($qry);
        return $result;
		$result->free();
		/* cerrar la conexión */
		$mysqli->close();
    }
	function deletePerson($IdPersonal)
	{
		$mysqli=conectarServidor();
		$qry="delete from personal where Id_personal=$IdPersonal";
		$result = $mysqli->query($qry);
		if($result==1)
			return 1;
		else
			return 0;
			
		$result->free();
		/* cerrar la conexión */
		$mysqli->close();
      }	
	function updatePerson($IdPersonal, $Nombre,$Estado, $Area, $celular, $email, $cargo)	
	{
		$qry="update personal set nom_personal='$Nombre',
		activo=$Estado, 
		Area=$Area,
		cel_personal=$celular, 
		Eml_personal='$email', 
		cargo_personal=$cargo 
		where Id_personal=$IdPersonal";
        $mysqli=conectarServidor();
        $result = $mysqli->query($qry);
        return $result;
		mysqli_free_result($result);
		/* cerrar la conexión */
		mysqli_close($link);
		    }
}
?>
