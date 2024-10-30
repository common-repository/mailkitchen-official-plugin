<?php

/* Table name form */
function mk_list_form()
{
	global $table_prefix, $wpdb;
	$tmp = array();
	$i   = 0;

	$wp_my_new_table_name    = $table_prefix . "mk_form_name";
	$wp_my_new_table_content = $table_prefix . "mk_form_content";

	$sql = 'SELECT id, title, val
			FROM `'.$wp_my_new_table_name.'`
			JOIN `'.$wp_my_new_table_content.'` ON id_form = id
			WHERE name = "list_name"';

	$myrows = $wpdb->get_results($sql);

	foreach ($myrows AS $rows) {
		$tmp[$i]          = array();
		$tmp[$i]['id']    = $rows->id;
		$tmp[$i]['title'] = $rows->title;
		$tmp[$i]['val']   = ($rows->val!=NULL)?$rows->val:0;

		$i++;
	}

	return $tmp;
}

function mk_save_form($tab)
{
	global $table_prefix, $wpdb;
	$tmp = array();

	$wp_my_new_table = $table_prefix . "mk_form_name";

	$sql = 'INSERT INTO `' . $wp_my_new_table . '` (`title`)
			VALUES (%s)';

	$wpdb->query($wpdb->prepare($sql, $tab['new_form']));

	$sql = 'SELECT LAST_INSERT_ID() AS id
			FROM `' . $wp_my_new_table . '`';

	$myrows= $wpdb->get_results($sql);

	foreach ($myrows AS $rows) {
		$tmp = $rows->id;
	}

	return $tmp;
}

function mk_delete_form($id)
{
	global $table_prefix, $wpdb;

	$mk_form_name    = $table_prefix . "mk_form_name";
	$mk_form_content = $table_prefix . "mk_form_content";

	$sql = 'SELECT title
			FROM `' . $mk_form_name . '`
			WHERE id = ' . $id;

	$name = $wpdb->get_results($sql);

	$sql = 'DELETE FROM `' . $mk_form_name . '` 
			WHERE id = ' . $id;

	$wpdb->query($sql);

	$sql = 'DELETE FROM `' . $mk_form_content . '`
			WHERE id_form = ' . $id;

	$wpdb->query($sql);

	return $name;
}

/* Table form content */
function mk_read_form($id)
{
	global $table_prefix, $wpdb;
	$tmp = array();

	$wp_my_new_table = $table_prefix . "mk_form_content";

	$sql = 'SELECT * FROM
			`' . $wp_my_new_table . '`
			WHERE id_form = ' . $id;

	$myrows = $wpdb->get_results($sql);

	foreach ($myrows AS $rows) {
		$tmp[$rows->name] = $rows->val;
	}

	return $tmp;
}

function mk_save_content_form($tab)
{
	global $table_prefix, $wpdb;

	$wp_my_new_table = $table_prefix . "mk_form_content";

	foreach($tab["form"] AS $data){
		$sql = 'INSERT INTO `' . $wp_my_new_table . '` (`name`,`val`,`id_form`)
				VALUES (%s, %s, %d)
				ON DUPLICATE KEY UPDATE
					val = VALUES( val )';

		$wpdb->query($wpdb->prepare($sql, $data['name'], $data['val'], $tab['id']));
	}
}

/* Plugin form */
class mk_plugin_form extends WP_widget
{
	public function __construct() {
		$options = array(
			"classname"   => "mk-form-plugin",
			"description" => __("description_plugin_barchoix", "mailkitchen")
		);
		parent::__construct("mk-form-plugin", __("titre_plugin_barchoix","mailkitchen"), $options);
	}

	public function widget($args, $instance) {
		extract($args);
		$rows  = mk_read_form($instance["form_name"]);
		$ident = (uniqid(rand(), TRUE));

		if (!empty($rows)) {
			echo $before_widget;
			echo $before_title.$rows["titre"].$after_title;
?>
			<p><?php echo $rows["presentation"]; ?></p>
			<form method="post" action="#" class="mk-form" data-id="<?php echo $ident;?>">
				<label><?php echo $rows["lab-email"];?></label><br/>
				<input type="hidden" class="mk_num_form" name="mk_num_form" value="<?php echo $instance["form_name"];?>" />
				<input type="text" class="mk_insert_mail" name="mk_insert_mail" placeholder="<?php echo $rows["chp-email"];?>"><br/><br/>
				<input type="submit" class="mk_form_validate" value="<?php echo $rows["btn"];?>"/>
				<p style="font-size=0.7em;"><?php echo $rows["mention"];?></p>
			</form>
			<p class="mk-form-valide" data-id="<?php echo $ident;?>" style="display:none;background-color:green;color: #FFFFFF;font-weight:bold;text-align:center;" ><?php echo $rows["msg-valide"];?></p>
			<p class="mk-form-erreur" data-id="<?php echo $ident;?>" style="display:none;background-color:red;color: #FFFFFF;font-weight:bold;text-align:center;" ><?php echo $rows["msg-erreur"];?></p>

			<div class="mk-loader-form" data-id="<?php echo $ident;?>"></div>
<?php
			echo $after_widget;
		}
	}

	public function form($instance) {
		$listform = mk_list_form();

		if (!empty($listform)) {
?>
			<p>
			<select name="<?php echo $this->get_field_name("form_name"); ?>">
					<option><?php echo __("titre_plugin_edition","mailkitchen"); ?></option>
<?php
					$listform = mk_list_form();
					foreach($listform as $liste) {
						echo "<option data-list='".$liste['val']."'value='".$liste['id']."'>".$liste['title']."</option>";
					}
?>
			</select>
			</p/>
			<p class="noList"><?php echo __("abs_list_plugin_edition","mailkitchen"); ?></p>
			<p><?php echo __("lien_plugin_edition","mailkitchen"); ?></p>
<?php
		}
		else {
?>
		<p><?php echo __("description_plugin_edition","mailkitchen"); ?><a href="admin.php?page=create-your-form"><?php echo __("lien_plugin_edition","mailkitchen"); ?></a></p>
<?php
		}
	}

	public function update($new, $old) {
		return $new;
	}

	public function save_form() {
		if (isset($_POST['mk_insert_mail']) && !empty($_POST['mk_insert_mail'])) {
			$tab     = mk_connexion();
			$service = $tab['service'];
			$token   = $tab['token'];
			$liste   = $service->ImportMember(array(),array($_POST['mk_insert_mail']),$token);
		}
	}
}

?>