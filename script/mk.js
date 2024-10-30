<?php 
if(isset ($_GET) && (isset($_GET['page'])) ){
	switch($_GET['page']){
		case "create-your-form":
?>
/*JS pour les formulaires*/

jQuery('#wpcontent').on( "click", "#new_form", function(event){
	event.preventDefault(); 
	 event.stopPropagation();
	 form	=	jQuery('<form>',{"method":"POST","action":""});
	 label	=	jQuery('<label>',{"for":"new_form"});
	 nom	=	jQuery('<input/>',{"type":"text","name":"new_form"});
	 validation	=	jQuery('<input>',{"type":"submit","value":"<?php echo __("btn_val_form_action_create_your_form","mailkitchen"); ?>"});
	 jQuery("#create-form").html(form.clone().append(label.clone().html("<?php echo __("label_titre_form_action_create_your_form","mailkitchen"); ?>")).append(nom.clone()).append(validation.clone()));
});

jQuery('#choose_form').on( "change", "#form_name", function(event){
	jQuery("#choose_form").submit();
});

<?php
		break;
	}
}
?>