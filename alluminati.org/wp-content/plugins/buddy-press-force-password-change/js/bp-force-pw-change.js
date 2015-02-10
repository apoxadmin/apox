// JavaScript Document

function bp_forcepw_addCheckbox(checkit){
    var strChkHtml = '<tr><th>&nbsp;</th>' +
		'<td><input type="checkbox" name="force_password_change" id="force_password_change" ' +
		(checkit ? 'checked="checked"' : '') +
		'value="yes" />&nbsp;<span class="description">Checking this box forces user to change their password at next login.</span></td></tr>';	
	jQuery(document).ready(function(jQuery) {
		jQuery('tr#password').parent().append(strChkHtml);
	});    
}

function bp_forcepw_showPwResetForm(pw,cpw,nonce,btn,uid, url){
	//alert(pw + ':' + cpw + ':' + nonce + ':' + btn + ':' + uid);
    var strHTML = '<div id="bp-force-pw-change-container">' +
        '<div id="bp-force-pw-change-container-inner">' +
		'<h4 style="margin-bottom: 1em;">Please change your password</h4>' +
        '<div id="bp-force-pw-error">&nbsp;</div>' +
        '<form class="standard-form">' +
		'<p>' +
			'<label for="bp-force-pw-pw">' + pw + '</label>' +
			'<input name="bp-force-pw-pw" id="bp-force-pw-pw" type="password" />' +
		'</p>' +
		'<p>' +
			'<label for="bp-force-pw-confirm">' + cpw + '</label>' +
			'<input name="bp-force-pw-confirm" id="bp-force-pw-confirm" type="password" />' +
		'</p>' +
		'<p>' +
			'<input type="hidden" name="bp-force-pw-uid" value="' + uid + '" />' +
			'<input type="hidden" name="bp_password_nonce" value="' + nonce + '"/>' +
			'<input type="hidden" name="action" value="dopwchange"/>' +
			'<input id="bp-force-pw-submit" class="btn-gray" type="button" value="' + btn + '" onclick="bp_forcepw_submit(\'' + url + '\')" />' +
		'</p></form></div>' +
        '<div id="bp-force-pw-change-confirmationbox" class="bp-force-pw-conf">' +
            '<h4 style="text-align:center;">Success!</h4>' +
            '<p>Your password has been changed</p>' +
            '<p><button class="btn-gray" onclick="jQuery().colorbox.close();">OK</button>' +
        '</div>' +
        '<div id="bp-force-pw-change-problembox" class="bp-force-pw-conf">' +
            '<h4 style="text-align:center;">Error!</h4>' +
            '<p style="color: red; font-weight: bold;">Oops. The server encountered an error!</p>' +
            '<p>Your password has NOT been changed.</p>' +
            '<p><button class="btn-gray" onclick="jQuery().colorbox.close();">OK</button>' +
        '</div>' +
	'</div>';
	//alert('1');
    jQuery('body').prepend(strHTML);
	//alert('2');
    jQuery.colorbox({
        html : jQuery('#bp-force-pw-change-container').html(),
        overlayClose : false,
        escKey : false
    });
	//alert('3');
    jQuery("#bp-force-pw-error", jQuery('#colorbox')).hide();
    jQuery('#cboxClose').hide();
	
}

function bp_forcepw_submit(url) {   
    
    	jQuery("#bp-force-pw-error", jQuery("#colorbox")).hide();
		var hasError = false;
		var passwordVal = jQuery("#bp-force-pw-pw", jQuery("#colorbox")).val();
		var checkVal = jQuery("#bp-force-pw-confirm", jQuery("#colorbox")).val();
		if (passwordVal == '') {
			jQuery("#bp-force-pw-error", jQuery("#colorbox")).html('Please enter a password.').fadeIn();
            return false;
		} else if (checkVal.length < 5) {
    		jQuery("#bp-force-pw-error", jQuery("#colorbox")).html('Password must be at least 5 characters.').fadeIn();
            return false;
		} else if (checkVal == '') {
			jQuery("#bp-force-pw-error", jQuery("#colorbox")).html('Please re-enter your password.').fadeIn();
            return false;
		} else if (passwordVal != checkVal ) {
			jQuery("#bp-force-pw-error", jQuery("#colorbox")).html('Passwords do not match.').fadeIn();
			return false;
		}
        jQuery('#colorbox #bp-force-pw-change-container-inner').fadeOut('fast', function(){
            jQuery('#cboxLoadingGraphic').show();
            jQuery.ajax({
                url: url,
                dataType: 'json',
                type: 'post',
                data: jQuery('#colorbox form').serialize(),
                success: function(data){
                    if(data.confirm == 'success'){
                        jQuery('#cboxLoadingGraphic').fadeOut('fast', function(){
                            jQuery('#colorbox #bp-force-pw-change-confirmationbox').fadeIn();
                        });
                    }
                    else {
                        jQuery('#cboxLoadingGraphic').fadeOut('fast', function(){
                            jQuery('#colorbox #bp-force-pw-change-problembox').fadeIn();
                        });
                    }
                }
        	});
        });
};