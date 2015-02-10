<?php if(!defined("PHORUM")) return; ?>
<div class="PhorumStdBlockHeader PhorumHeaderText" style="text-align: left;"><?php echo $PHORUM['DATA']['LANG']['PersProfile']; ?></div>
<div class="PhorumStdBlock" style="text-align: left;">
<table class="PhorumFormTable" cellspacing="0" border="0">
<tr><td><?php echo $PHORUM['DATA']['LANG']['Username']; ?>:</td><td><?php echo $PHORUM['DATA']['PROFILE']['username']; ?></td></tr>
<tr><td><?php echo $PHORUM['DATA']['LANG']['RealName']; ?>:</td><td><?php echo $PHORUM['DATA']['PROFILE']['real_name']; ?></td></tr>
<tr><td><?php echo $PHORUM['DATA']['LANG']['Email']; ?>:</td><td><?php echo $PHORUM['DATA']['PROFILE']['email']; ?></td></tr>
<tr><td><?php echo $PHORUM['DATA']['LANG']['DateReg']; ?>:</td><td><?php echo $PHORUM['DATA']['PROFILE']['date_added']; ?></td></tr>
<?php if(isset($PHORUM['DATA']['PROFILE']['date_last_active']) && !empty($PHORUM['DATA']['PROFILE']['date_last_active'])){ ?>
<tr>
    <td><?php echo $PHORUM['DATA']['LANG']['DateActive']; ?>:</td>
    <td><?php echo $PHORUM['DATA']['PROFILE']['date_last_active']; ?></td>
</tr>
<?php } ?>
<tr><td><?php echo $PHORUM['DATA']['LANG']['Posts']; ?>:</td><td><?php echo $PHORUM['DATA']['PROFILE']['posts']; ?></td></tr>
<tr><td><?php echo $PHORUM['DATA']['LANG']['Signature']; ?>:</td><td><?php echo $PHORUM['DATA']['PROFILE']['signature']; ?></td></tr>
</table>
</div>
<br />
<div class="PhorumStdBlockHeader PhorumHeaderText" style="text-align: left;"><?php echo $PHORUM['DATA']['LANG']['UserPermissions']; ?></div>
<div class="PhorumStdBlock" style="text-align: left;">
<table class="PhorumFormTable" cellspacing="0" border="0">
<?php if(isset($PHORUM['DATA']['PROFILE']['admin']) && !empty($PHORUM['DATA']['PROFILE']['admin'])){ ?>
<tr><td colspan="2">
<?php echo $PHORUM['DATA']['LANG']['PermAdministrator']; ?>
</td></tr>
<?php } ?>
<tr><th><?php echo $PHORUM['DATA']['LANG']['Forum']; ?></th><th><?php echo $PHORUM['DATA']['LANG']['Permission']; ?></th></tr>
<?php if(isset($PHORUM['DATA']['UserPerms']) && is_array($PHORUM['DATA']['UserPerms'])) foreach($PHORUM['DATA']['UserPerms'] as $PHORUM['TMP']['UserPerms']){ ?>
<tr><td><?php echo $PHORUM['TMP']['UserPerms']['forum']; ?>&nbsp;&nbsp;</td><td><?php echo $PHORUM['TMP']['UserPerms']['perm']; ?></td></tr>
<?php } unset($PHORUM['TMP']['UserPerms']); ?>
</table>
</div>
