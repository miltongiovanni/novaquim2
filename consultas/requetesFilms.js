function envoyerEnregistrer(){
	var enregForm = new FormData(document.getElementById('enregForm'));
	enregForm.append('action','enregistrer');
	$.ajax({
		url:'serveur/controleurFilms.php',
		type:'POST',
		data:enregForm,
		dataType:'xml',
		async : false,
		cache : false,
		contentType : false,
		processData : false,
		success: function(message){
			//alert(message);
			//vue('enregistrer',message);
			//vue('enregistrerJSON',message);
			vue('enregistrerXML',message);
		},
		fail:function(){
			alert("Vous avez un GROS problème");
		}
	});
}
function envoyerLister(){
	$.ajax({
		url:'serveur/controleurFilms.php',
		type:'POST',
		data:{"action":'lister'},
		dataType:'json',
		success: function(listeFilms){
			vue('listerJSON',listeFilms);
		},
		fail:function(){
			alert("Vous avez un GROS problème");
		}
	});
}
function envoyerEnlever(){
	var idf=$('#numE').val();
	$.ajax({
		url:'serveur/controleurFilms.php',
		type:'POST',
		data:{"action":'enlever',"num":idf},
		dataType:'json',
		success: function(message){
			//alert(JSON.stringify(message));
			vue('enleverJSON',message);
		},
		fail:function(){
			alert("Vous avez un GROS problème");
		}
	});
}


function envoyerFiche(){
	var idf=$('#numM').val();
	$.ajax({
		url:'serveur/controleurFilms.php',
		type:'POST',
		data:{"action":'fiche',"num":idf},
		dataType:'json',
		success: function(leFilm){
			cacher('divModifier');
			//alert(JSON.stringify(leFilm));
			if(leFilm.msg==="OK")
				vue('montrerFiche',leFilm.donnees);
			else
				vue('ficheJSON',leFilm);
		},
		fail:function(){
			alert("Vous avez un GROS problème");
		}
	});
}

function modifier(){
	var enregForm = new FormData(document.getElementById('enregForm'));
	enregForm.append('action','modifier');
	$.ajax({
		url:'serveur/controleurFilms.php',
		type:'POST',
		data:enregForm,
		dataType:'json',
		async : false,
		cache : false,
		contentType : false,
		processData : false,
		success: function(message){
			vue('modifierJSON',message);
		},
		fail:function(){
			alert("Vous avez un GROS problème");
		}
	});
}
//controleur des requetes
var requetes=function(action){
switch(action){
	case 'enregistrer' :
		envoyerEnregistrer();
	break;
	case 'lister' :
		envoyerLister();
	break;
	case 'enlever' :
		envoyerEnlever();
	break;
	case 'fiche' :
		envoyerFiche();
	break;
	case 'modifier' :
		modifier();
	break;
	default :
}	
}