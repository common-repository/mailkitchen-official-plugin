<?php
/*Gestion des traductions*/
function load_mkplugin_textdomain( $domain,$plugin_rel_path = false ) {

	$locale = get_locale();
	$lang	= explode("_",$locale);
	$tablang    = array (
		"fr"=>"fr_FR",
		"de"=>"de_DE",
		"es"=>"es_ES",
		"it"=>"it_IT",
		"pt"=>"pt_PT"
	);
	if( is_string($lang[0]) && array_key_exists($lang[0],$tablang)) {
		$locale	= $tablang[$lang[0]];
	}
	else {
		$locale = 'en_US';
	}
	
	$locale = apply_filters( 'plugin_locale', $locale, $domain );
	$path = WP_PLUGIN_DIR . '/' . trim( $plugin_rel_path, '/' );
	$mofile = $domain . '-' . $locale . '.mo';
	
	if ( $loaded = load_textdomain( $domain, $path . '/'. $mofile ) )
		return $loaded;

	$mofile = WP_LANG_DIR . '/plugins/' . $mofile;
	return load_textdomain( $domain, $mofile );
}

?>