<?php
/*
Plugin Name: TestAD
Plugin URI: 
Description: Plugin permettant la mise en place d'une régie publicitaire.
Author: Justine Pruliere
Version: 1.0
Author URI: 
*/

require_once plugin_dir_path(__FILE__) . 'include/function.php'; //gestion des metabox
require_once plugin_dir_path(__FILE__) . 'include/columns.php'; //gestion de l'affichage des colonnes dans "toutes les publicités"
require_once plugin_dir_path(__FILE__) . 'include/widget.php'; //création du widget associé au plugin 

/*Ajout de scripts et de CSS au plugin*/
add_action( 'admin_print_scripts-post-new.php', 'banner_admin_script', 11 );
add_action( 'admin_print_scripts-post.php', 'banner_admin_script', 11 );

function banner_admin_script() {

    global $post_type;
    if ( $post_type == 'regie_publicitaire' ){ //teste si l'on se situe dans le bon post-type
        wp_enqueue_script( 'pub-admin-statut', plugins_url( '/include/js/statut.js', __FILE__), '', '', true ); //ajout du script pour gérer le statut
		//wp_enqueue_script( 'pub-admin-date', plugins_url( '/include/js/date.js', __FILE__), '', '', true ); //ajout du script pour gérer les dates
		wp_register_style( 'style', plugins_url( '/include/css/style.css', __FILE__) ); //enregistrement du style css
		wp_enqueue_style('style'); //ajout du style css
	}
}

/*Permet de tester s'il n'y a pas d'erreur à l'activation du plugin*/
function activate() {
	
   if ($error) {
      die($error); //si une erreur est rencontrée, on annule l'activation
   }
}

register_activation_hook(__DIR__, '/adTEST.php', 'activate' );

/*Ajoute un lien vers la page de réglages sous le nom du plugin dans la page d'extensions*/
function adtest_add_settings_link( $links ) {
    $settings_link = '<a href="edit.php?post_type=regie_publicitaire&page=ad_settings">' . __( 'Settings' ) . '</a>';
    array_push( $links, $settings_link );
  	return $links;
}
$plugin = plugin_basename( __FILE__ );

add_filter( "plugin_action_links_$plugin", 'adtest_add_settings_link' );