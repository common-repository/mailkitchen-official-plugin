/*JS pour le formulaires*/

jQuery('.mk-form').on( "submit", function(event) {
    event.preventDefault(); 

    var mk_form = jQuery(this),
        ident = mk_form.data('id'),
        email = mk_form.find('input[name="mk_insert_mail"]').val(),
        numform = mk_form.find('input[name="mk_num_form"]').val();

    mkAjaxFormRequest(email, numform, ident);
});

function mkAjaxFormRequest(email, numform, ident) {
    jQuery(".mk-loader-form[data-id='"+ident+"']").parent().css("position","relative");
    jQuery(".mk-loader-form[data-id='"+ident+"']").css("background-color","rgba(0, 0, 0, 0.7)").css("width","100%").css("height","100%").css("position","absolute").css("top","0");
    jQuery.ajax({
        url: ajax_object.ajax_url,
        method: "post",
        data: {
            'action': 'mk_ajax_form',
            'numform': numform,
            'email': email
        },
        dataType: 'JSON',
        success: function(data) {
            jQuery(".mk-loader-form").hide();
            /*'fn':'get_latest_posts',*/
            jQuery(".mk-form[data-id='"+ident+"']").hide();
            jQuery(".mk-form-valide[data-id='"+ident+"']").show();
        },
        error: function(errorThrown) {
            jQuery(".mk-loader-form[data-id='"+ident+"']").hide();
            jQuery(".mk-form-erreur[data-id='"+ident+"']").show();
        }
    });
}