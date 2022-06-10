<?php

/*Suppression de la colonne par défaut "date"*/
add_filter('manage_regie_publicitaire_posts_columns', function ( $columns ){
    unset($columns['date']);
    return array_merge($columns, 
	array('dateDeb' => __('Date de début (YYYY-MM-JJ)'),'dateFin' => __('Date de fin (YYYY-MM-JJ)'),'cpt' => __('Type de contenu d\'affichage'),'categ' => __('Catégorie'),'ref' => __('Référence'),'statut' => __('Statut')));
} );

add_action( 'manage_regie_publicitaire_posts_custom_column' , 'RPJP_data_colonne' );

function RPJP_data_colonne($name) {
	global $post;
	switch ($name) {
		case 'dateDeb': //affiche la date de début de la publicité
			echo esc_attr( get_post_meta( get_the_ID(), 'dateDeb', true ));
		break;
		case 'dateFin': //affiche la date de fin de la publicité
			echo esc_attr( get_post_meta( get_the_ID(), 'dateFin', true ));
		break;
		case 'cpt': //affiche le post-type où apparaitra la publicité
			echo esc_attr( get_post_meta( get_the_ID(), 'cpt', true ));
		break;
		case 'categ': //affiche la catégorie où apparaitra la publicité
			echo esc_attr( get_post_meta( get_the_ID(), 'categ', true ));
		break;
		case 'ref': //affiche la référence de la publicité
			echo esc_attr( get_post_meta( get_the_ID(), 'ref', true ));
		break;
		case 'statut': //affiche le statut de production de la publicité 
			//on teste si la publicité est expirée ou non
			$expirationtime = get_post_custom_values('dateFin'); //récupère la date de fin
			$debut = get_post_custom_values('dateDeb'); //récupère la date de début
			if (is_array($expirationtime) || is_array($debut)) {
				$expirestring = implode($expirationtime);
				$debstring = implode($debut);
			}
			$secondsbetween = strtotime($expirestring)-time();
			$deb = strtotime($debstring)-time();
			if ( $deb > 0 && $secondsbetween > $deb){ //si la date de début n'est pas encore arrivée et que les paramètres sont valides
				?><div style="color:lightblue"><?php echo "À venir"; ?> </div> <?php //on met le statut "à venir"
			}else if(get_post_status(get_the_ID()) == 'draft' && $secondsbetween > $deb){  //si le post est en statut brouillon et que les paramètres sont valides
					?><div style="color:#7ebd77"><?php echo "Brouillon"; ?> </div> <?php //on met le statut "brouillon"
			}else if(get_post_status(get_the_ID()) == 'publish' && $secondsbetween > 0 && $secondsbetween > $deb){ //si la publicité est publiée, a commencé et a des paramètres valides
					?><div style="color:blue"><?php echo "Publiée"; ?> </div> <?php //on met le statut "publiée"
			}else if(get_post_status(get_the_ID()) == 'publish' && $secondsbetween < 0 && $secondsbetween > $deb){ //si sa date de fin est dépassée et que les paramètres sont valides
				?><div style="color:gray"><?php echo "Dépassée"; ?> </div> <?php //on met le statut "dépassée"
			}else if($deb > $secondsbetween){ //si les paramètres sont invalides
				?><div style="color:red"><?php echo "Erreur"; ?> </div> <?php //on met le statut "erreur"
			}
		break;
	}
}