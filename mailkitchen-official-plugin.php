<?php
/*
Plugin Name: Mailkitchen
Plugin URI: http://mailkitchen.com
Description: Create a new subscription form and add contacts to your MailKitchen account
Version: 1.2.1
Author: Mailkitchen
*/

require_once( 'php/config.php' );
/*admin*/
add_action('admin_menu', 'afficher_lien_menu');
add_action('admin_head', 'mk_styles');
add_action('admin_footer', 'mk_scripts');
add_action('widgets_init', 'mk_plugin');
add_action('plugins_loaded', 'mk_init');

/*user*/
add_action( 'wp_enqueue_scripts', 'mk_form_script' );
add_action( 'wp_ajax_mk_ajax_form', 'mk_form_ajax' );
add_action( 'wp_ajax_nopriv_mk_ajax_form', 'mk_form_ajax' );

/*Intal ,unistal, delete*/
register_activation_hook( __FILE__, 'mk_create_table_form' );
//register_deactivation_hook(__FILE__, 'mk_delete_table_form');
//register_uninstall_hook(__FILE__, 'mk_delete_table_form');
?>