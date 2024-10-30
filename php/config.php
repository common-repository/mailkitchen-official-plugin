<?php

/* Liens utiles */
DEFINE( 'MK_PLUGIN','../wp-content/plugins/mailkitchen-official-plugin/');
DEFINE( 'MK_SELF','/wp-content/plugins/mailkitchen-official-plugin/');
DEFINE( 'MK_FILES','../../../../wp-admin/');
DEFINE( 'MK_ABSPATH','../');
DEFINE( 'MK_ABS_LIST',__("abs_liste_diffusion","mailkitchen"));
ini_set('soap.wsdl_cache_enabled', 0);

/* Ecriture wordpress */
function mk_init() {
	$plugin_dir = 'mailkitchen-official-plugin/i18n';
	load_mkplugin_textdomain( 'mailkitchen', $plugin_dir);
}
function afficher_lien_menu() {
	add_menu_page('MK', __("mon_compte","mailkitchen"), 'manage_options', 'mailkitchen', 'open_account_information', 'http://mailkitchen.com/images/sign_up.png');
	add_submenu_page( 'mailkitchen', __("creer_form","mailkitchen"), __("creer_form","mailkitchen"), 'manage_options', 'create-your-form', 'open_signup_form');
}
function mk_styles() {
	echo '<link rel="stylesheet" href="'.MK_PLUGIN.'style/mk.css" type="text/css" media="all" />';
}
function mk_scripts() {
	echo '<script>';include (MK_PLUGIN.'script/mk_script.js');echo'</script>';
}
function open_account_information() {
	include(MK_PLUGIN . 'pages/account-information.php');
}
function open_signup_form() {
	include(MK_PLUGIN . 'pages/create-your-form.php');
}
function mk_plugin() {
	register_widget("mk_plugin_form");
}

/*appel pour le coté client WP*/
function mk_form_script() {
	wp_enqueue_script( 'my-js', plugins_url( 'script/mk_form.js', __DIR__ ), array('jquery'), false, true );
	wp_localize_script( 'my-js', 'ajax_object', array('ajax_url' => admin_url( 'admin-ajax.php' )));
}

function mk_form_ajax() {
	$send = insert_member($_REQUEST['numform'],$_REQUEST['email']);
	if($send==1) {
		echo json_encode(TRUE);
		die();
	}
	else{
		echo json_encode(FALSE);
		die();
	}
}

/*Gestion des traductions*/
include("translate.php");

/* Appel webservice */
include("ws.php");

/* Gestion des tables */
include("editsql.php");

/* Plugin form */
include("pluginform.php");

?>