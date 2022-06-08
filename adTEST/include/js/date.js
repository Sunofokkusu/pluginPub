/*Fonction qui permet de vérifier si la date de début est bien située avant la date de fin*/
function date_deb_valide(){
	let dateDeb = new Date(document.querySelector('#dateDeb').value); //on récupère la valeur de la date de fin entrée par l'utilisateur
	let dateFin = new Date(document.querySelector('#dateFin').value); //on récupère la valeur de la date de fin entrée par l'utilisateur
	if(dateDeb > dateFin){
		window.alert("La date de début est plus grande que la date de fin, réessayez.");
	}
}

/*Appel de la fonction*/
date_deb_valide();