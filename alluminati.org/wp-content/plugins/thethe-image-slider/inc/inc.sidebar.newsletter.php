<?php /** @version $Id: inc.sidebar.newsletter.php 952 2011-08-19 08:06:14Z lexx-ua $ */ ?>
<?php 
	$current_user = wp_get_current_user();
	$affiliateRefValue ='';
	if (isset($_COOKIE["PAPVisitorId"])) {
		$affiliateRefValue = $_COOKIE["PAPVisitorId"];
    }	
 ?>
<div class="postbox">
  <div class="handlediv" title="<?php _e( 'Click to toggle' ); ?>"><br />
  </div>
  <h3 class="hndle"> <span>Free WordPress Newsletter</span> </h3>
  <div class="inside">
    <div id="box_subscribe">
      <p>Subscribe to our monthly newsletter:</p>
	<p><strong><q>WordPress Tips, Tricks &amp; Hacks</q></strong></p>
	
      <p>
		<form method="post" action="http://em.marketingmixture.com/form.php?form=4" id="frmSS4" onsubmit="return CheckForm4(this);" class="myForm">
          		<input type="text" name="CustomFields[2]" id="CustomFields_2_4" size="8" maxlength="100" value="<?php echo $current_user->user_firstname.' '.$current_user->user_lastname;?>" />
			<input name="email" value="<?php echo $current_user->user_email;?>" size="16" maxlength="100" type="text" />	
			<input type="hidden" name="CustomFields[12]" id="CustomFields_12_4" value="<?php echo $affiliateRefValue; ?>" />
          		<input type="hidden" name="format" value="t" />
			<input type="submit" value="OK" name="submit" class="button-primary" />
      	</form>
	</p>
	<p align="center"><small>Your <a href="http://thethefly.com/privacy.html" target="_blank">privacy</a> is guaranteed!</small></p>
      <script type="text/javascript">
    // <![CDATA[

    function CheckMultiple4(frm, name) {
        for (var i = 0; i < frm.length; i++) {
            fldObj = frm.elements[i];
            fldId = fldObj.id;
            if (fldId) {
                var fieldnamecheck = fldObj.id.indexOf(name);
                if (fieldnamecheck != -1) {
                    if (fldObj.checked) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
    function CheckForm4(f) {
        var email_re = /[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/i;
        if (!email_re.test(f.email.value)) {
            alert("Please enter your email address.");
            f.email.focus();
            return false;
        }

        var fname = "CustomFields_2_4";
        var fld = document.getElementById(fname);
        if ((fld.value == "") || (fld.value == "your name...")) {
            alert("Please enter your name.");
            fld.focus();
            return false;
        }
        return true;
    }
    // ]]>    
	</script> 
    </div>
  </div>
</div>
