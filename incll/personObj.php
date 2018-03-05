<?
include "includes/valAcc.php";
?>
<?
include "includes/conect.php";
class person{
    function makePerson($bd,$Nombre,$Estado, $Area, $celular, $email, $cargo)
	{
        $qry="insert into personal (nom_personal, activo, Area, cel_personal, Eml_personal, cargo_personal)
        values ('$Nombre', $Estado, $Area, $celular, '$email', $cargo)";
        $link=conectarServidor();
        $result=mysql_db_query($bd,$qry);
		mysql_close($link);
        return $result;
    }
	function deletePerson($bd, $IdPersonal)
	{
		$link=conectarServidor();
		$qry="delete from personal where Id_personal=$IdPersonal";
		$result=mysql_db_query($bd,$qry);
		mysql_close($link);
		if($result==1)
			return 1;
		else
			return 0;
      }	
	function updatePerson($bd, $Id_personal, $Nombre,$Estado, $Area, $celular, $email, $cargo)	
	{
        $IdPersonal=$_POST['IdPersonal'];
		$qry="update personal set nom_personal='$Nombre',
		activo=$Estado, 
		Area=$Area,
		cel_personal=$celular, 
		Eml_personal='$email', 
		cargo_personal=$cargo 
		where Id_personal=$IdPersonal";
        $link=conectarServidor();
        $result=mysql_db_query($bd,$qry);
		mysql_close($link);
        return $result;
    }
}
?>
