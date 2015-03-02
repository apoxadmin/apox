<?php if(!defined("PHORUM")) return; ?>
<?php if(isset($PHORUM['DATA']['Message']) && !empty($PHORUM['DATA']['Message'])){ ?>
<div class="PhorumUserError"><?php echo $PHORUM['DATA']['Message']; ?></div>
<?php } ?>

<?php if(isset($PHORUM['DATA']['GROUP']['name']) && !empty($PHORUM['DATA']['GROUP']['name'])){ ?>
<div class="PhorumStdBlockHeader PhorumHeaderText" style="text-align: left;"><?php echo $PHORUM['DATA']['LANG']['AddToGroup']; ?> <?php echo $PHORUM['DATA']['GROUP']['name']; ?></div>
<div class="PhorumStdBlock" style="text-align: left;">
<form method="post" action="<?php echo $PHORUM['DATA']['GROUP']['url']; ?>">
<input type="hidden" name="forum_id" value="<?php echo $PHORUM['DATA']['PROFILE']['forum_id']; ?>" />
<?php if(isset($PHORUM['DATA']['NEWMEMBERS']) && !empty($PHORUM['DATA']['NEWMEMBERS'])){ ?>
<select name="adduser">
<option value="0">&nbsp;</option>
<?php if(isset($PHORUM['DATA']['NEWMEMBERS']) && is_array($PHORUM['DATA']['NEWMEMBERS'])) foreach($PHORUM['DATA']['NEWMEMBERS'] as $PHORUM['TMP']['NEWMEMBERS']){ ?>
<option value="<?php echo $PHORUM['TMP']['NEWMEMBERS']['username']; ?>"><?php echo $PHORUM['TMP']['NEWMEMBERS']['displayname']; ?></option>
<?php } unset($PHORUM['TMP']['NEWMEMBERS']); ?>
</select>
<?php } else { ?>
<input type="text" name="adduser" />
<?php } ?>
 <input type="submit" value="<?php echo $PHORUM['DATA']['LANG']['Add']; ?>" />
</form>
</div>

<br />

<div class="PhorumStdBlockHeader PhorumHeaderText" style="text-align: left;"><?php echo $PHORUM['DATA']['LANG']['GroupMemberList']; ?> <?php echo $PHORUM['DATA']['GROUP']['name']; ?></div>
<div class="PhorumStdBlock" style="text-align: left;">
<?php echo $PHORUM['DATA']['LANG']['Filter']; ?>:
<?php if(isset($PHORUM['DATA']['FILTER']) && is_array($PHORUM['DATA']['FILTER'])) foreach($PHORUM['DATA']['FILTER'] as $PHORUM['TMP']['FILTER']){ ?>
[<?php if(isset($PHORUM['TMP']['FILTER']['enable']) && !empty($PHORUM['TMP']['FILTER']['enable'])){ ?><a href="<?php echo $PHORUM['TMP']['FILTER']['url']; ?>"><?php } ?><?php echo $PHORUM['TMP']['FILTER']['name']; ?><?php if(isset($PHORUM['TMP']['FILTER']['enable']) && !empty($PHORUM['TMP']['FILTER']['enable'])){ ?></a><?php } ?>]
<?php } unset($PHORUM['TMP']['']); ?>
<br /><br />
<table class="PhorumFormTable" cellspacing="0" border="0">
<form method="post" action="<?php echo $PHORUM['DATA']['GROUP']['url']; ?>">
<input type="hidden" name="forum_id" value="<?php echo $PHORUM['DATA']['PROFILE']['forum_id']; ?>" />
<tr><th><?php echo $PHORUM['DATA']['LANG']['Username']; ?></th><th><?php echo $PHORUM['DATA']['LANG']['MembershipType']; ?></th></tr>
<?php if(isset($PHORUM['DATA']['USERS']) && is_array($PHORUM['DATA']['USERS'])) foreach($PHORUM['DATA']['USERS'] as $PHORUM['TMP']['USERS']){ ?>
<tr><td><?php if(isset($PHORUM['TMP']['USERS']['flag']) && !empty($PHORUM['TMP']['USERS']['flag'])){ ?><strong><em><?php } ?><a href="<?php echo $PHORUM['TMP']['USERS']['profile']; ?>"><?php echo $PHORUM['TMP']['USERS']['displayname']; ?></a><?php if(isset($PHORUM['TMP']['USERS']['flag']) && !empty($PHORUM['TMP']['USERS']['flag'])){ ?></em></strong><?php } ?></td>
<td>
<?php if(isset($PHORUM['TMP']['USERS']['disabled']) && !empty($PHORUM['TMP']['USERS']['disabled'])){ ?>
<?php echo $PHORUM['TMP']['USERS']['statustext']; ?>
<?php } else { ?>
<select name="status[<?php echo $PHORUM['TMP']['USERS']['userid']; ?>]">
<?php if(isset($PHORUM['DATA']['STATUS_OPTIONS']) && is_array($PHORUM['DATA']['STATUS_OPTIONS'])) foreach($PHORUM['DATA']['STATUS_OPTIONS'] as $PHORUM['TMP']['STATUS_OPTIONS']){ ?>
<?php
// to get around a minor templating problem, we'll figure out if we have this line selected here
$PHORUM['TMP']['STATUS_OPTIONS']['selected'] = ($PHORUM['TMP']['STATUS_OPTIONS']['value'] == $PHORUM['TMP']['USERS']['status']);
?>
<option value="<?php echo $PHORUM['TMP']['STATUS_OPTIONS']['value']; ?>"<?php if(isset($PHORUM['TMP']['STATUS_OPTIONS']['selected']) && !empty($PHORUM['TMP']['STATUS_OPTIONS']['selected'])){ ?> selected="selected"<?php } ?>><?php echo $PHORUM['TMP']['STATUS_OPTIONS']['name']; ?></option>
<?php } unset($PHORUM['TMP']['']); ?>
</select>
<?php } ?></td></tr>
<?php } unset($PHORUM['TMP']['USERS']); ?>
<tr><td><input type="submit" value="<?php echo $PHORUM['DATA']['LANG']['SaveChanges']; ?>" /></td><td></td></tr>
</form>
</table>
</div>

<?php } else { ?>
<div class="PhorumStdBlockHeader PhorumHeaderText" style="text-align: left;"><?php echo $PHORUM['DATA']['LANG']['SelectGroupMod']; ?></div>
<div class="PhorumStdBlock" style="text-align: left;">
<table class="PhorumFormTable" cellspacing="0" border="0">
<?php if(isset($PHORUM['DATA']['GROUPS']) && is_array($PHORUM['DATA']['GROUPS'])) foreach($PHORUM['DATA']['GROUPS'] as $PHORUM['TMP']['GROUPS']){ ?>
<tr><td><a href="<?php echo $PHORUM['TMP']['GROUPS']['url']; ?>"><?php echo $PHORUM['TMP']['GROUPS']['name']; ?></a></td><td><a href="<?php echo $PHORUM['TMP']['GROUPS']['unapproved_url']; ?>"><?php echo $PHORUM['TMP']['GROUPS']['unapproved']; ?> <?php echo $PHORUM['DATA']['LANG']['Unapproved']; ?></a></td></tr>
<?php } unset($PHORUM['TMP']['GROUPS']); ?>
</table>
</div>
<?php } ?>