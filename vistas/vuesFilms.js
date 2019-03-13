function formEnregistrer(pourQui){
	var rep = '<div id="divEnreg">'+
'			<span onClick="cacher(\'divEnreg\')">X</span>'+
'			<h1>Enregistrer un film</h1>'+
'			<form id="enregForm"">';
if(pourQui=="M")
	rep+='				Numero:<input type="text" id="num" name="num" readonly><br><br>';
rep+='				Titre:<input type="text" id="titre" name="titre" value=""><br><br>'+
'				Realisateur:<input type="text" id="res" name="res" value=""><br><br>'+
'				Pochette : <input type="file" name="pochette"><br><br>';
if(pourQui=="E"){
	rep+='<input type="button" value="Envoyer" onClick="requetes(\'enregistrer\');">';
}else
	if(pourQui=="M"){
	  rep+='<input type="button" value="Envoyer" onClick="requetes(\'modifier\');">';
	}
rep+='</form></div>';
return rep;
}

function listerJSON(listeFilms){
	dossier="../pochettes/";
	rep="<table border=1>";
	rep+="<caption>Liste des films</caption>";
	rep+="<tr><th>NUMERO</th><th>TITRE</th><th>REALISATEUR</th><th>POCHETTE</th></tr>";
	var taille=listeFilms.length;
	for(i=0;i<taille;i++){
		ligne=listeFilms[i];
		rep+="<tr><td>"+(ligne.num)+"</td><td>"+(ligne.titre)+"</td><td>"+(ligne.res)+"</td><td><img src='pochettes/"+(ligne.pochette)+"' width=80 height=80></td></tr>";		 
	}
	rep+="</table>";
	$('#contenu').html(rep);			
}

function montrerFiche(fiche){
	$('#contenuEnreg').html(formEnregistrer('M'));
	$('#num').val(fiche.num);
	$('#titre').val(fiche.titre);
	$('#res').val(fiche.res);
	montrer('divEnreg');
}
var vue=function(action,donnees){
	switch(action){
		case 'enregistrer':
			$('#message').html(donnees);
			setTimeout(function(){ $('#message').html(""); }, 3000);
		break;
		case 'enregistrerJSON':
		case 'enleverJSON' :
		case 'ficheJSON' :
		case 'modifierJSON':
			$('#message').html(donnees.msg);
			setTimeout(function(){ $('#message').html(""); }, 3000);
		break;
		case 'enregistrerXML':
			var msg=donnees.getElementsByTagName('msg')[0].firstChild.nodeValue;
			$('#message').html(msg);
			setTimeout(function(){ $('#message').html(""); }, 3000);
		break;
		case 'listerJSON':
			listerJSON(donnees);
		break;
		case 'montrerFiche':
			montrerFiche(donnees);
		break;
		
	}
	
}