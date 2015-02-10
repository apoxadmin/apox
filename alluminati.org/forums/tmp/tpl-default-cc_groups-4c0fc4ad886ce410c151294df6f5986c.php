<?php if(!defined("PHORUM")) return; ?>
<?php if(isset($PHORUM['DATA']['Message']) && !empty($PHORUM['DATA']['Message'])){ ?>
<div class="PhorumUserError"><?php echo $PHORUM['DATA']['Message']; ?></div>
<?php } ?>

<div class="PhorumStdBlockHeader PhorumHeaderText" style="text-align: left;"><?php echo $PHORUM['DATA']['LANG']['JoinAGroup']; ?></div>
<div class="PhorumStdBlock" style="text-align: left;">
<?php echo $PHORUM['DATA']['LANG']['JoinGroupDescription']; ?>

<form method="POST" action="<?php echo $PHORUM['DATA']['GROUP']['url']; ?>">
<input type="hidden" name="forum_id" value="<?php echo $PHORUM['DATA']['PROFILE']['forum_id']; ?>" />
<select name="joingroup">
<option value="0">&nbsp;</option>
<?php if(isset($PHORUM['DATA']['JOINGROUP']) && is_array($PHORUM['DATA']['JOINGROUP'])) foreach($PHORUM['DATA']['JOINGROUP'] as $PHORUM['TMP']['JOINGROUP']){ ?>
<option value="<?php echo $PHORUM['TMP']['JOINGROUP']['group_id']; ?>"><?php echo $PHORUM['TMP']['JOINGROUP']['name']; ?></option>
<?php } unset($PHORUM['TMP']['JOINGROUP']); ?>
</select>
 <input type="submit" value="<?php echo $PHORUM['DATA']['LANG']['Join']; ?>" />
</form>
</div>
<br />
<div class="PhorumStdBlockHeader PhorumHeaderText" style="text-align: left;"><?php echo $PHORUM['DATA']['LANG']['GroupMembership']; ?></div>
<div class="PhorumStdBlock" style="text-align: left;">
<table class="PhorumFormTable" cellspacing="0" border="0">
<tr><th><?php echo $PHORUM['DATA']['LANG']['Group']; ?></th><th><?php echo $PHORUM['DATA']['LANG']['Permission']; ?></th></tr>
<?php if(isset($PHORUM['DATA']['Groups']) && is_array($PHORUM['DATA']['Groups'])) foreach($PHORUM['DATA']['Groups'] as $PHORUM['TMP']['Groups']){ ?>
<tr><td><?php echo $PHORUM['TMP']['Groups']['groupname']; ?>&nbsp;&nbsp;</td><td><?php echo $PHORUM['TMP']['Groups']['perm']; ?></td></tr>
<?php } unset($PHORUM['TMP']['Groups']); ?>
</table>
</div>
