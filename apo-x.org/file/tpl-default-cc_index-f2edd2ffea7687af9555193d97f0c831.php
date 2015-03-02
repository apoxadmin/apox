<?php if(!defined("PHORUM")) return; ?>
<table style="width: 100%">
<tr>
<td style="vertical-align: top; width: 170px" nowrap="nowrap">
<?php include_once phorum_get_template('cc_menu'); ?>
</td>
<td style="vertical-align: top;">
<!---<div style="padding-top: 1px;margin-left: 21%;width: 75%;">-->
<?php if(isset($PHORUM['DATA']['content_template']) && !empty($PHORUM['DATA']['content_template'])){ ?>
<?php include_once phorum_get_template( $PHORUM["DATA"]['content_template']); ?>
<?php } else { ?>
<div class="PhorumFloatingText"><?php echo $PHORUM['DATA']['MESSAGE']; ?></div>
<?php } ?>
</td>
</tr>
</table>
