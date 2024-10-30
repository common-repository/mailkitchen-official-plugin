<?php
	if(isset($_POST)){
		if(isset($_POST['mk-login'])){
			mk_save_id($_POST);
		}
		if (isset($_POST['mk-desabonnement'])){
			mk_delete_id();
		}
	}
	$mk_connect= mk_connexion();
	$liste=$mk_connect['liste'];
	$token=$mk_connect['token'];
	if (($token!==FALSE)&&(!empty($token))) {
		$_SESSION['mk_token']=TRUE;
	}
?>
<div class="wrap">
	<h2><?php echo __("titre_account_information","mailkitchen"); ?></h2>
	<div class="welcome-panel" id="welcome-panel">
		<div class="welcome-panel-content">
		<?php if(!isset($_SESSION['mk_token'])){ ?>
			<h3><?php echo __("soustitre_account_information","mailkitchen"); ?></h3>
			<p class="about-description"><?php echo __("description_account_information","mailkitchen"); ?></p>
			<div class="welcome-panel-column-container">
				<div class="welcome-panel-column">
				<form method="POST" action="">
					<h4><?php echo __("titre_connexion_account_information","mailkitchen"); ?></h4>
					<div id="mk_authentification">
						<label for="mk-login" 	class="mk-log"><?php echo __("login_connexion_account_information","mailkitchen"); ?></label>
						<input type="text" name="mk-login"/>
						<br />
						<label for="mk-mdp" 	class="mk-log"><?php echo __("mdp_connexion_account_information","mailkitchen"); ?></label>
						<input type="password" name="mk-mdp"/>
						<br />
						<input class="button button-primary button-hero" type="submit" value="<?php echo __("btn_val_connexion_account_information","mailkitchen"); ?>"/><br />
						<p class="hide-if-no-customize"><?php echo __("oublimdp_connexion_account_information","mailkitchen"); ?></p>
					</div>
				</form>
				</div>
			</div>
		<?php } else { ?>
			<h3><?php echo __("soustitre_account_information","mailkitchen"); ?></h3>
				<div class="welcome-panel-column">
					<h4><?php echo __("soustitre2_account_information","mailkitchen"); ?></h4>
					<div id="mk_authentification">
						<p class="hide-if-no-customize"><?php echo __("description2_account_information","mailkitchen"); ?><br />	
						
							<form method="POST" action="">
								<input type="hidden" name="mk-desabonnement" value="true"/>
								<input class="button button-primary button-hero" type="submit" value="<?php echo __("btn_sup_account_information","mailkitchen"); ?>"/>
							</form>
						</p>
					</div>
					
				</div>
				<div class="welcome-panel-column">
					<h4><?php echo __("titre_menu_account_information","mailkitchen"); ?></h4>
					<ul>
						<li><a class="welcome-icon welcome-write-blog" href="admin.php?page=create-your-form"><?php echo __("lien1_menu_account_information","mailkitchen"); ?></a></li>
					</ul>
				</div>
		<?php } ?>
		</div>
	</div>
</div>