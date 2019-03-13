<?php
require_once("../BD/connexion.inc.php");
$rep=array();

function envoyerMessageXML($leMsg){
	header ("Content-Type: text/xml");
	$rep="<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
	$rep.="<messages>\n";
	$rep.="<msg>".$leMsg."</msg>\n";
	$rep.="</messages>\n";
	echo $rep;
}
function enregistrer(){
	global $connexion, $rep;	
	$titre=$_POST['titre'];
	$res=$_POST['res'];
	$dossier="../pochettes/";
	$nomPochette=sha1($titre.time());
	$pochette="avatar.jpg";
	if($_FILES['pochette']['tmp_name']!==""){
		//Upload de la photo
		$tmp = $_FILES['pochette']['tmp_name'];
		$fichier= $_FILES['pochette']['name'];
		$extension=strrchr($fichier,'.');
		@move_uploaded_file($tmp,$dossier.$nomPochette.$extension);
		// Enlever le fichier temporaire chargé
		@unlink($tmp); //effacer le fichier temporaire
		$pochette=$nomPochette.$extension;
	}
	$requete="INSERT INTO films VALUES(0,?,?,?)";
	$stmt = $connexion->prepare($requete);
	$stmt->execute(array($titre,$res,$pochette));
	$idFilm=$connexion->lastInsertId();
	unset($connexion);
	unset($stmt);
	//echo "Film ".$idFilm." bien enregistre";
	//$rep['msg']="Film ".$idFilm." bien enregistre";
	//echo json_encode($rep);
	envoyerMessageXML("Film ".$idFilm." bien enregistre");
}
function lister(){
	global $connexion, $rep;	
	$requette="SELECT * FROM films";
	try{
		 $stmt = $connexion->prepare($requette);
		 $stmt->execute();
		 while($ligne=$stmt->fetch(PDO::FETCH_OBJ)){
			 $rep[]=$ligne;
		 }
	 }catch (Exception $e){
	   $rep['erreur']="Probleme pour lister";
	 }finally {
		unset($connexion);
		unset($stmt);
		echo json_encode($rep);
	 }
}
function enlever(){
	global $connexion, $rep;
	$num=$_POST['num'];
	$requete="SELECT pochette FROM films WHERE num=?";
	$stmt=$connexion->prepare($requete);
	$stmt->execute(array($num));
	$ligne=$stmt->fetch(PDO::FETCH_OBJ);
	if($ligne == null){
		$rep['msg']="Film ".$num." introuvable";
		echo json_encode($rep);
		unset($connexion);
		unset($stmt);
		exit;
	}
	$pochette=$ligne->pochette;
	if ($pochette !== "avatar.jpg"){
			$rmPoc='../pochettes/'.$pochette;
			$tabFichiers = glob('../pochettes/*');
			//print_r($tabFichiers);
			// parcourir les fichier
			foreach($tabFichiers as $fichier){
			  if(is_file($fichier) && $fichier==trim($rmPoc)) {
				// enlever le fichier
				unlink($fichier);
				break;
			  }
			}
	}
	//Enlever de la table films
	$requete="DELETE FROM films WHERE num=?";
	$stmt=$connexion->prepare($requete);
	$stmt->execute(array($num));
	$rep['msg']="Film $num a ete enleve";
	echo json_encode($rep);
}
function fiche(){
	global $connexion, $rep;
	$num=$_POST['num'];
	$requete="SELECT * FROM films WHERE num=?";
	$stmt=$connexion->prepare($requete);
	$stmt->execute(array($num));
	$ligne=$stmt->fetch(PDO::FETCH_OBJ);
	if($ligne == null){
		$rep['msg']="Film ".$num." introuvable";
	}else{
		$rep['msg']="OK";
		$rep['donnees']=$ligne;
	}
	
	unset($connexion);
	unset($stmt);
	echo json_encode($rep);
}

function modifier(){
	require_once("../librairie/gestionFichiers.inc.php");
	global $connexion, $rep;
	$num=$_POST['num'];
	$titre=$_POST['titre'];
	$res=$_POST['res'];
	$tmp=$_FILES['pochette']['tmp_name'];
	$requete="SELECT pochette FROM films WHERE num=?";
	$stmt=$connexion->prepare($requete);
	$stmt->execute(array($num));
	$ligne=$stmt->fetch(PDO::FETCH_OBJ);
	$pochette=$ligne->pochette;
	if($tmp !== ""){
		//Je dois enlever l'ancienne pochete
		$dossier='../pochettes/';
		if($pochette !== "avatar.jpg"){
			enleverFichier($dossier,$pochette);
		}
		$nomPochette=sha1($titre.time());
		$pochette=deposerFichier("pochette",$dossier,$nomPochette);
	}
	$requete="UPDATE films SET titre=?,res=?,pochette=? WHERE num=?";
	$stmt=$connexion->prepare($requete);
	$stmt->execute(array($titre,$res,$pochette,$num));
	$rep['msg']="Film $num bien modifie";
	unset($connexion);
	unset($stmt);
	echo json_encode($rep);
}

//controleur films
$action=$_POST['action'];
switch($action){
	case 'enregistrer':
		enregistrer();
	break;
	case 'lister':
		lister();
	break;
	case 'enlever':
		enlever();
	break;
	case 'fiche':
		fiche();
	break;
	case 'modifier':
		modifier();
	break;
}
?>