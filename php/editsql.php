<?php
/* Create table */
function mk_create_table_form (){
	global $table_prefix, $wpdb;
	$wp_table_connect		= $table_prefix . "mk_connect";
	$wp_table_form_name 	= $table_prefix . "mk_form_name";
	$wp_table_form_content 	= $table_prefix . "mk_form_content";
	
	if($wpdb->get_var("show tables like '$wp_table_connect'") != $wp_table_connect) { 
		$sql0 = "CREATE TABLE `". $wp_table_connect . "` ( ";
		$sql0 .= " `pass` varchar(255)  PRIMARY KEY NOT NULL, ";
		$sql0 .= " UNIQUE KEY `login` (`pass`) ";
		$sql0 .= ") DEFAULT CHARSET=UTF8; ";
		require_once(MK_ABSPATH . 'wp-admin/upgrade-functions.php');
		dbDelta($sql0);
	}
	
	if($wpdb->get_var("show tables like '$wp_table_form_name'") != $wp_table_form_name) { 
		$sql0 = "CREATE TABLE `". $wp_table_form_name . "` ( ";
		$sql0 .= " `id` int(2) PRIMARY KEY NOT NULL auto_increment, ";
		$sql0 .= " `title` varchar(255) NOT NULL, ";
		$sql0 .= " UNIQUE KEY `id` (`id`) ";
		$sql0 .= ") DEFAULT CHARSET=UTF8; ";
		require_once(MK_ABSPATH . 'wp-admin/upgrade-functions.php');
		dbDelta($sql0);
	}
	
	if($wpdb->get_var("show tables like '$wp_table_form_content'") != $wp_table_form_content) { 
		$sql0 = "CREATE TABLE `". $wp_table_form_content . "` ( ";
		$sql0 .= " `name` varchar(255) NOT NULL, ";
		$sql0 .= " `val` text NULL, ";
		$sql0 .= " `id_form` int(2) NOT NULL, ";
		$sql0 .= " PRIMARY KEY(`name`,`id_form`) ";
		$sql0 .= ") DEFAULT CHARSET=UTF8; ";
		require_once(MK_ABSPATH . 'wp-admin/upgrade-functions.php');
		dbDelta($sql0);
	}
}

/* Delet table*/
function mk_delete_table_form (){
	global $table_prefix, $wpdb;
    $wp_table_connect		= $table_prefix . "mk_connect";
	$wp_table_form_name 	= $table_prefix . "mk_form_name";
	$wp_table_form_content 	= $table_prefix . "mk_form_content";
	
	if(($wpdb->get_var("show tables like '$wp_table_connect'") == $wp_table_connect)) { 
        $sql = "DROP TABLE `$wp_table_connect`";
        $wpdb->query($sql);
	}
	if(($wpdb->get_var("show tables like '$wp_table_form_name'") == $wp_table_form_name)) { 
		$sql = "DROP TABLE `$wp_table_form_name`";
		$wpdb->query($sql);
	}
	if(($wpdb->get_var("show tables like '$wp_table_form_content'") == $wp_table_form_content)) { 
		$sql = "DROP TABLE `$wp_table_form_content`";
		$wpdb->query($sql);
	}
	
}
/* connect to mailkitchen */
function mk_read_id() {
	global $table_prefix, $wpdb;
	$wp_my_new_table = $table_prefix . "mk_connect";
	$myrows= $wpdb->get_results("SELECT * FROM `".$wp_my_new_table."`");
	$tmp = array();
	foreach($myrows AS $rows){
		$tmp["pass"] = $rows->pass;
	}
	return $tmp;
}

function mk_save_id($tab) {
	$service = new SoapClient("http://webservices.mailkitchen.com/server.wsdl", array('trace' => 1, 'soap_version'   => SOAP_1_2));
	$token = $service->Authenticate($tab['mk-login'],$tab['mk-mdp']);
	if($token!=FALSE) {
	
		$pass= $service->GetAccountInformation();
		global $table_prefix, $wpdb;
		$wp_my_new_table = $table_prefix . "mk_connect";

		$wpdb->query(
			$wpdb->prepare(
				"INSERT INTO `".$wp_my_new_table."`
				VALUES (%s)",
				$pass['pass_phrase']
			)
		);
	}
}

/* delete id*/
function mk_delete_id() {
	global $table_prefix, $wpdb;
	$wp_my_new_table = $table_prefix . "mk_connect";
	$wpdb->query(
		"DELETE from `".$wp_my_new_table."`"
	);
}
?>