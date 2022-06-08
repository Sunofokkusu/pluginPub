<div class="ad_box">
    <style scoped>
        .ad_box{
            display: grid;
            grid-template-columns: max-content 1fr;
            grid-row-gap: 10px;
            grid-column-gap: 20px;
        }
        .ad_field{
            display: contents;
        }
    </style>
	
	<!-- Liste déroulante affichant tous les post-type du site -->
	<p class="meta-options ad_field">
        <label for="cpt">Page d'affichage<strong style="color:red">*</strong></label>
        <select id="cpt" name="cpt" required>
			<option value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'cpt', true ) ); ?>">-- <?php echo esc_attr( get_post_meta( get_the_ID(), 'cpt', true ) ); ?> --</option>
			<?php 
			$args = array(
								'public'   => true,
						);
			$cpt = get_post_types($args);
			foreach($cpt as $key => $value){
				echo '<option value='.$value.'>'.$value.'</option>';
			}?>
		</select>
    </p>
	
	<!-- Liste déroulante affichant les catégories disponibles pour le post-type choisi -->
	<p class="meta-options ad_field">
        <label for="categ">Catégorie d'affichage<strong style="color:red">*</strong></label>
        <select id="categ" name="categ" required>
			<option value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'categ', true ) ); ?>">-- <?php echo esc_attr( get_post_meta( get_the_ID(), 'categ', true ) ); ?> --</option>
			<option value="toutes">afficher sur toutes les pages</option>
			<?php	
			
			$options = get_option( 'ad_options', array() ); //on récupère les données de la page d'options
			
			//on récupère tous les termes parents
			$term = get_terms(array(
				'taxonomy' => 'mots-cles',
				'hide_empty' => false,
				'parent' => 0,
			) );
			
			//pour chaque terme parent, on cherche si son slug correspond à celui donné dans les paramètres
			foreach($term as $t){
				if($t->slug == isset( $options['ad_parent'] ) ?  $options['ad_parent'] : false){
					$id = $t->term_id;
				}
			}
			
			$term_id = $id; //on récupère l'id obtenu après le parcours
			$taxonomy_name = isset( $options['ad_taxo'] ) ?  $options['ad_taxo'] : false; //on récupère le nom de la taxonomie
			$termchildren = get_term_children( $term_id, $taxonomy_name ); //on récupère la liste des enfants du terme parent
			
			//on affiche tout ces enfants dans une liste déroulante
			foreach ( $termchildren as $child ) {
				$term = get_term_by( 'id', $child, $taxonomy_name );
				echo '<option value='.$term->slug.'>'.$term->slug.'</option>';
			}
			?>
		</select>
    </p>
	
	<!-- Zone de texte où définir le lien de redirection de la publicité -->
    <p class="meta-options ad_field">
        <label for="lien">Lien de redirection<strong style="color:red">*</strong></label>
        <input id="lien"
            type="text"
            name="lien"
			required
            value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'lien', true ) ); ?>">
    </p>
	
	<!-- Checkbox pour demander l'option "NoFollow" dans le lien -->
	<p class="meta-options ad_field"> 
	<label for="follow">No follow</label>
		<?php
			global $post;
			$custom = get_post_custom($post->ID);
			$follow = $custom["follow"][0]; 
		?>
		<input type="checkbox" name="follow" <?php if( $follow == true ) { ?>checked="checked"<?php } ?> /> 
    </p>
	
	<!-- Calendrier pour saisir une date de début de publication de la publicité -->
    <p class="meta-options ad_field">
        <label for="dateDeb">Date de début<strong style="color:red">*</strong></label>
        <input id="dateDeb"
            type="date"
            name="dateDeb"
			required
           value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'dateDeb', true ) ); ?>">
    </p>
	
	<!-- Calendrier pour saisir une date de fin de publication de la publicité -->
	<p class="meta-options ad_field">
        <label for="dateFin">Date de fin<strong style="color:red">*</strong></label>
        <input id="dateFin"
            type="date"
            name="dateFin"
			required
           value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'dateFin', true ) ); ?>">
    </p>
	
	<!-- Ajout d'une checkbox pour activer ou désactiver la mise en page de pub sur mobile !!!!à déplacer dans une page réglages à venir -->
	<p class="meta-options ad_field"> 
	<label for="mobile">Pub sur mobile</label>
		<?php
			global $post;
			$custom = get_post_custom($post->ID);
			$mobile = $custom["mobile"][0]; 
		?>
		<input type="checkbox" name="mobile" <?php if( $mobile == true ) { ?>checked="checked"<?php } ?> /> 
    </p>
</div>

