<!-- Affiche une liste déroulante pour choisir le statut de sa publicité -->
<p class="meta-options ad_field">
    <select id="statut" name="statut" disabled>
		<option value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'statut', true ) ); ?>"><?php echo esc_attr( get_post_meta( get_the_ID(), 'statut', true ) ); ?></option>
		<option value="À venir">À venir</option>
		<option value="Brouillon">Brouillon</option>
		<option value="Publiée">Publiée</option>
		<option value="Dépassée">Dépassée</option>
		<option value="Erreur">Erreur</option>
	</select>
</p>

