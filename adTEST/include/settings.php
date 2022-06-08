<?php

/*Enregistre notre zone de paramètres*/
add_action( 'admin_init', 'ad_settings_init' );
 
/*Options et paramètres personnalisés*/
function ad_settings_init() {
    //enregistre un nouveau paramètre
    register_setting( 'ad_settings', 'ad_options' );
 
    //enregistre une nouvelle section de paramètres
    add_settings_section(
        'ad_section', //ID
        __( '', 'ad_settings' ), //titre
		'ad_section_callback', //callback
        'ad_settings' //slug
    );
 
    //ajoute un nouveau champs de paramètre
	add_settings_field(
        'ad_taxo', //ID
        __( 'Taxonomie', 'ad_settings' ), //titre
        'ad_field_taxo', //callback
        'ad_settings', //slug
        'ad_section', //section où le champ se trouve
        array(
            'label_for'         => 'ad_taxo',
            'class'             => 'wporg_row',
            'ad_custom_data' 	=> 'custom',
        )
    );
	
    add_settings_field(
        'ad_parent', //ID
        __( 'Terme parent', 'ad_settings' ), //titre
        'ad_field_parent', //callback
        'ad_settings', //slug
        'ad_section', //section où le champ se trouve
        array(
            'label_for'         => 'ad_parent',
            'class'             => 'wporg_row',
            'ad_custom_data' 	=> 'custom',
        )
    );
	
	add_settings_field(
        'ad_div', //ID
        __( 'QuerySelector', 'ad_settings' ), //titre
        'ad_field_div', //callback
        'ad_settings', //slug
        'ad_section', //section où le champ se trouve
        array(
            'label_for'         => 'ad_div',
            'class'             => 'wporg_row',
            'ad_custom_data' 	=> 'custom',
        )
    );
	
	add_settings_field(
        'ad_size', //ID
        __( 'Version mobile', 'ad_settings' ), //titre
        'ad_field_size', //callback
        'ad_settings', //slug
        'ad_section', //section où le champ se trouve
        array(
            'label_for'         => 'ad_size',
            'class'             => 'wporg_row',
            'ad_custom_data' 	=> 'custom',
        )
    );
	
	add_settings_field(
        'ad_prefixe', //ID
        __( 'Préfixe (optionnel)', 'ad_settings' ), //titre
        'ad_field_prefixe', //callback
        'ad_settings', //slug
        'ad_section', //section où le champ se trouve
        array(
            'label_for'         => 'ad_prefixe',
            'class'             => 'wporg_row',
            'ad_custom_data' 	=> 'custom',
        )
    );
		add_settings_field(
        'ad_suffixe', //ID
        __( 'Suffixe (optionnel)', 'ad_settings' ), //titre
        'ad_field_suffixe', //callback
        'ad_settings', //slug
        'ad_section', //section où le champ se trouve
        array(
            'label_for'         => 'ad_suffixe',
            'class'             => 'wporg_row',
            'ad_custom_data' 	=> 'custom',
        )
    );
}
 
/*Fonction de callback*/
function ad_section_callback( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Tous les champs sont obligatoires.', 'ad_settings' ); ?></p>
    <?php
}
 
/*Fonctions qui affichent l'encard de texte pour y entrer son paramètre*/
function ad_field_taxo($args){
	$options = get_option('ad_options', array()); //récupère les options créées
    //créer un input de texte pour y entrer la taxonomie voulue
	?>
    <input  type="text"  
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            data-custom="<?php echo esc_attr( $args['ad_custom_data'] ); ?>"
            name="ad_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
			value="<?php echo isset( $options['ad_taxo'] ) ?  $options['ad_taxo'] : false; ?>">
    </input>
    <p class="description">
        <?php esc_html_e( 'Entrez le nom de la taxonomie voulue pour laquelle les termes parents seront récupérés.', 'ad_settings' ); ?>
    </p>
    <?php
}

function ad_field_parent( $args ) {
    $options = get_option('ad_options', array()); //récupère les options créées
    //créer un input de texte pour y entrer le terme parent voulu
	?>
    <input  type="text"  
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            data-custom="<?php echo esc_attr( $args['ad_custom_data'] ); ?>"
            name="ad_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
			value="<?php echo isset( $options['ad_parent'] ) ?  $options['ad_parent'] : false; ?>">
    </input>
    <p class="description">
        <?php esc_html_e( 'Entrez le nom du terme parent voulu pour afficher les catégories enfant sur la page de création ou d\'édition d\'une publicité.', 'ad_settings' ); ?>
    </p>
    <?php
}

function ad_field_div($args){
	wp_enqueue_script( 'pub-div', plugins_url( '/js/error.js', __FILE__), '', '', true );	
	$options = get_option('ad_options', array()); //récupère les options créées
    //créer un input de texte pour y entrer la class de la div qui contient tout le site
	?>
    <input  type="text"  
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            data-custom="<?php echo esc_attr( $args['ad_custom_data'] ); ?>"
            name="ad_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
			value="<?php echo isset( $options['ad_div'] ) ?  $options['ad_div'] : false; ?>">
    </input>
    <p class="description">
        <?php esc_html_e( 'Entrez le sélécteur pour la div qui contient tout le site (.class ou #id).', 'ad_settings' ); ?>
    </p>
    <?php
	add_settings_error(
			'ad_error',
			esc_attr( 'ad_err' ),
			__("Format de sélécteur non valide"),
			'error'
	);
	settings_errors('ad_error');
}

function ad_field_size($args){
	$options = get_option('ad_options', array()); //récupère les options créées
    //créer un input de nombre pour y entrer la taille pour laquelle le site passe en format mobile
	?>
    < <input  type="number"  
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            data-custom="<?php echo esc_attr( $args['ad_custom_data'] ); ?>"
            name="ad_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
			value="<?php echo isset( $options['ad_size'] ) ?  $options['ad_size'] : false; ?>">
    </input> px
    <p class="description">
        <?php esc_html_e( 'Entrez la largeur pour laquelle le site passe en version mobile.', 'ad_settings' ); ?>
    </p>
    <?php
}

function ad_field_prefixe($args){
	$options = get_option('ad_options', array()); //récupère les options créées
	//créer un input de texte pour y entrer le préfixe voulu pour la référence auto
	?>
    <input  type="text"  
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            data-custom="<?php echo esc_attr( $args['ad_custom_data'] ); ?>"
            name="ad_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
			value="<?php echo isset( $options['ad_prefixe'] ) ?  $options['ad_prefixe'] : false; ?>">
    </input>
    <p class="description">
        <?php esc_html_e( 'Entrez un préfixe pour la génération automatique des références.', 'ad_settings' ); ?>
    </p>
    <?php
}

function ad_field_suffixe($args){
	$options = get_option('ad_options', array()); //récupère les options créées
	//créer un input de texte pour y entrer le suffixe voulu pour la référence auto
	?>
    <input  type="text"  
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            data-custom="<?php echo esc_attr( $args['ad_custom_data'] ); ?>"
            name="ad_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
			value="<?php echo isset( $options['ad_suffixe'] ) ?  $options['ad_suffixe'] : false; ?>">
    </input>
    <p class="description">
        <?php esc_html_e( 'Entrez un suffixe pour la génération automatique des références.', 'ad_settings' ); ?>
    </p>
    <?php
}

/*Enregistre la page à l'aide d'un hook*/
add_action( 'admin_menu', 'wporg_options_page' );

/*Ajout la page dans le menu admin en tant que submenu du post-type regie_publicitaire*/
function wporg_options_page() {
	add_submenu_page(
		'edit.php?post_type=regie_publicitaire',
		'Réglages des publicités',
        'Réglages',
        'manage_options',
        'ad_settings',
        'wporg_options_page_html'
	);
} 
 
/*Fonction de callback pour afficher tous les éléments dans la page*/
function wporg_options_page_html() {
    //vérifie les droits de l'utilisateur
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
 
    //vérifie que l'utilisateur a passé des paramètres
    if ( isset( $_GET['settings-updated'] ) ) {
        add_settings_error( 'wporg_messages', 'wporg_message', __( 'Paramètres sauvegardés', 'ad_settings' ), 'updated' ); //affiche un message pour confirmer l'enregistrement des paramètres
    }
 
    settings_errors( 'wporg_messages' ); //affiche les messages d'actualisation ou d'erreur
    //affiche le contenu de la page ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php 
            settings_fields( 'ad_settings' ); //affiche les encards de paramètres créés plus tôt
            do_settings_sections( 'ad_settings' ); //affiche les sections de paramètres
            submit_button( 'Enregistrer' ); //affiche un bouton de sauvegarde
            ?>
        </form>
    </div>
    <?php
}