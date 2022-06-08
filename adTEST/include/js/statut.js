/*Fonction qui met le statut d'une publicité à jour en fonction de son statut et de ses dates de début et fin*/
function set_statut(){
	let dateFin = new Date(document.querySelector('#dateFin').value); //on récupère la valeur de la date de fin entrée par l'utilisateur
	let dateDeb = new Date(document.querySelector('#dateDeb').value); //on récupère la valeur de la date de début entrée par l'utilisateur
	let dateJour = new Date(); //on récupère la date du jour
	let select = document.querySelector('#statut'); //on séléctionne l'objet HTML correspondant à la liste déroulante de statut
	let etat = document.querySelector('#post-status-display').innerText; //on récupère la valeur du texte de l'état
	
	if(etat == 'Publié ' && dateJour > dateFin && dateFin > dateDeb){ //on test si la date du jour est plus grande que la date de fin donnée
		select.value = 'Dépassée'; //le statut se met sur dépassée
	}else if(etat == 'Publié ' && dateJour < dateFin && dateJour > dateDeb){ //teste la valeur de l'état
		select.value = 'Publiée'; //change le statut
	}else if(etat == 'Brouillon ' && dateJour < dateFin && dateJour > dateDeb){ //teste la valeur de l'état
		select.value = 'Brouillon'; //change le statut
	}else if(etat == 'Publié ' && dateJour < dateDeb){
		select.value = 'À venir'; //change le statut
	}else{
		select.value = 'Erreur';
	}
}

/*Appel de la fonction*/
set_statut();
