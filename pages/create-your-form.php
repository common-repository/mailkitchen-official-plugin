<?php
$id=NULL;
if(isset($_POST)){

	if(isset($_POST['btn'])){
		$tab= 	array( "id"=>	$_POST['id_form'],"form"=>array(
						array(	"name" => "list_name"	,"val"=> ((isset($_POST['list_name'])) ? $_POST['list_name']:MK_ABS_LIST)) ,
						array(	"name" => "titre"		,"val"=>$_POST['titre']),
						array(	"name" => "presentation","val"=>$_POST['presentation']),
						array(	"name" => "lab-email"	,"val"=>$_POST['lab-email']),
						array(	"name" => "chp-email"	,"val"=>$_POST['chp-email']),
						array(	"name" => "btn"			,"val"=>$_POST['btn']),
						array(	"name" => "msg-valide"	,"val"=>$_POST['msg-valide']),
						array(	"name" => "msg-erreur"	,"val"=>$_POST['msg-erreur']),
						array(	"name" => "mention"		,"val"=>$_POST['mention'])
					)
				);
		$id	=	$_POST['id_form'];
		mk_save_content_form($tab);
	}
	if(isset($_POST['new_form'])){
		$id = mk_save_form($_POST);
	}
	if(isset($_POST['form_name'])){
		$id = $_POST['form_name'];
	}
	if(isset($_POST['form_name_delete'])){
		$name = mk_delete_form($_POST['form_name_delete']);
	}
	$listform = mk_list_form();
}


?>
<div class="wrap">
	<h2><?php echo __("titre_create_your_form","mailkitchen"); ?> </h2>
	<div class="mk-content">
		<p >
			<?php echo __("description_create_your_form","mailkitchen"); ?>
			<br/ >
		</p>
		<h3><?php echo __("titre_action_create_your_form","mailkitchen"); ?></h3>
		<p></p>
		<div id="create-form" class="welcome-panel-column-container">
		<form method="POST" action="" id="choose_form">
			<select name="form_name" id="form_name">
				<option value="0"><?php echo __("soustitre_action_create_your_form","mailkitchen"); ?></option>
				<?php
					foreach($listform as $liste) {
						echo "<option value='".$liste['id']."' ".(($id==$liste['id'])?"selected='selected'":"").">".$liste['title']."</option>";
					}
				?>
			</select>
			<?php echo __("btn_action_create_your_form","mailkitchen"); ?>
			</form>
		</div>
		<hr>
		<?php
			if( (isset($id)) &&(!empty($id))) {
			$rows = mk_read_form($id);
			
		?>
		<div id="content-form" class="welcome-panel-column-container">
			
			<div class="mk-create-form">
			
				<!--Creation form-->
				<div class="mk-create">
					<h4><?php echo __("titre_form_action_create_your_form","mailkitchen"); ?></h4>
					<form method="POST" action="">
					<input type="hidden" name="id_form" value="<?php echo $id; ?>" />
					
					<!--choix liste diffusion-->
					<label><?php echo __("label_liste_form_action_create_your_form","mailkitchen"); ?></label>
					<select name="list_name">
						<option value="0"><?php echo __("champ_liste_form_action_create_your_form","mailkitchen"); ?></option>
						<?php
							$listediffusion = view_member_list();
							foreach($listediffusion as $liste) {
								echo "<option value='".$liste['id']."'". ( ($rows['list_name']==$liste['id'])?"selected='selected'" :"") ." >".$liste['name']." (".$liste['nb_member'].")</option>";
							}
						?>				
					</select>
					<br/ >
					
					<!--personnalisation formulaire -->
					<label for="titre"><?php echo __("label_titre_form_action_create_your_form","mailkitchen"); ?></label><input type="text" name="titre" placeholder="" value="<?php echo(isset($rows['titre']))?$rows['titre']:"Subscribe";?>"/><br/ >
					<label for="presentation"><?php echo __("label_description_form_action_create_your_form","mailkitchen"); ?></label><textarea type="text" name="presentation" placeholder="lorem ipsum dolor sit amet" rows="3" ><?php echo(isset($rows['presentation']))?$rows['presentation']:"";?></textarea><br/ >
					<label for="lab-email"><?php echo __("label_labemail_form_action_create_your_form","mailkitchen"); ?></label><input type="text" name="lab-email" placeholder="" value="<?php echo(isset($rows['lab-email']))?$rows['lab-email']:"email :";?>"/><br/ >
					<label for="chp-email"><?php echo __("label_chpemail_form_action_create_your_form","mailkitchen"); ?></label><input type="text" name="chp-email" placeholder="" value="<?php echo(isset($rows['chp-email']))?$rows['chp-email']:"email@email.com";?>"/><br/ >
					
					<!--ajout champs next update -->
					
					<label for="btn"><?php echo __("label_btnvalidation_form_action_create_your_form","mailkitchen"); ?></label><input type="text" name="btn" placeholder="" value="<?php echo(isset($rows['btn']))?$rows['btn']:"Validate";?>"/><br/ >
					
					<label for="msg-valide"><?php echo __("label_msgvalidation_form_action_create_your_form","mailkitchen"); ?></label><textarea type="text" name="msg-valide" placeholder="lorem ipsum dolor sit amet" rows="3" ><?php echo(isset($rows['msg-valide']))?$rows['msg-valide']:"";?></textarea><br />
					<label for="msg-erreur"><?php echo __("label_msgerreur_form_action_create_your_form","mailkitchen"); ?></label><textarea type="text" name="msg-erreur" placeholder="lorem ipsum dolor sit amet" rows="3" ><?php echo(isset($rows['msg-erreur']))?$rows['msg-erreur']:"";?></textarea><br />
					
					<label for="mention"><?php echo __("label_mention_form_action_create_your_form","mailkitchen"); ?></label><textarea type="text" name="mention" placeholder="lorem ipsum dolor sit amet" rows="3" ><?php echo(isset($rows['mention']))?$rows['mention']:"";?></textarea><br />
					
					
					<input class="button button-primary button-hero mk-btn-save" type="submit" value="<?php echo __("btn_val_form_action_create_your_form","mailkitchen"); ?>"/>
					</br>
				</div>
				
				<!--affichage form-->
				<div class="mk-form-view">
					<h4><?php echo __("titre_apercu_action_create_your_form","mailkitchen"); ?></h4>
					<div class="mk-view">
					<h2><?php echo(isset($rows['titre']))?$rows['titre']:"Subscribe";?></h2>
					<p><?php echo(isset($rows['presentation']))?$rows['presentation']:"";?></p>
					<label><?php echo(isset($rows['lab-email']))?$rows['lab-email']:"email :";?></label><br/>
					<input type="text" placeholder="<?php echo(isset($rows['chp-email']))?$rows['chp-email']:"email@email.com";?>"><br/><br/>
					<input type="button" value="<?php echo(isset($rows['btn']))?$rows['btn']:"Validate";?>"/>
					<p><?php echo(isset($rows['mention']))?$rows['mention']:"";?></p>
					</div>
					<p class="mk-valide"><?php echo(isset($rows['msg-valide']))?$rows['msg-valide']:"";?></p>
					<p class="mk-erreur"><?php echo(isset($rows['msg-erreur']))?$rows['msg-erreur']:"";?></p>
				</div>
				
			</div>
			
		</div>
		<?php
			} else {
		?>
		<h3><?php echo __("titre_action_delete_your_form","mailkitchen"); ?></h3>
		<p></p>
		<div id="delete-form" class="welcome-panel-column-container">
		<form method="POST" action="" id="delete_form">
			<select name="form_name_delete" id="form_name_delete">
				<option><?php echo __("soustitre_action_create_your_form","mailkitchen"); ?></option>
				<?php
					foreach($listform as $liste) {
						echo "<option value='".$liste['id']."' ".(($id==$liste['id'])?"selected='selected'":"").">".$liste['title']."</option>";
					}
				?>
			</select>
			<?php echo __("btn_action_delete_your_form","mailkitchen"); ?>
			<?php if(isset($name)&& !empty($name)){ ?>
			<p><?php echo str_replace("#name#",'"'.$name[0]->title.'"',__("txt_validation_delete_your_form","mailkitchen")); ?></p>
			<?php }?>
			</form>
		</div>
		<hr>
		<?php
			}
		?>
	</div>
</div>