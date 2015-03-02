<?php if(!defined("PHORUM")) return; ?>
<form action="<?php echo $PHORUM['DATA']['URL']['ACTION']; ?>" method="POST">
<?php echo $PHORUM['DATA']['POST_VARS']; ?>
<div class="PhorumStdBlockHeader PhorumHeaderText" style="text-align: left;"><?php echo $PHORUM['DATA']['LANG']['Subscriptions']; ?></div>
<div class="PhorumStdBlock PhorumFloatingText" style="text-align: left;">
<input type="hidden" name="panel" value="<?php echo $PHORUM['DATA']['PROFILE']['PANEL']; ?>" />
<input type="hidden" name="forum_id" value="<?php echo $PHORUM['DATA']['PROFILE']['forum_id']; ?>" />
<?php echo $PHORUM['DATA']['LANG']['Activity']; ?>:&nbsp;
<select name="subdays">
<option value="1"<?php if(isset($PHORUM['DATA']['SELECTED']) && $PHORUM['DATA']['SELECTED']==1){ ?> selected<?php } ?>>1 <?php echo $PHORUM['DATA']['LANG']['Day']; ?></option>
<option value="2"<?php if(isset($PHORUM['DATA']['SELECTED']) && $PHORUM['DATA']['SELECTED']==2){ ?> selected<?php } ?>>2 <?php echo $PHORUM['DATA']['LANG']['Days']; ?></option>
<option value="7"<?php if(isset($PHORUM['DATA']['SELECTED']) && $PHORUM['DATA']['SELECTED']==7){ ?> selected<?php } ?>>7 <?php echo $PHORUM['DATA']['LANG']['Days']; ?></option>
<option value="30"<?php if(isset($PHORUM['DATA']['SELECTED']) && $PHORUM['DATA']['SELECTED']==30){ ?> selected<?php } ?>>1 <?php echo $PHORUM['DATA']['LANG']['Month']; ?></option>
<option value="180"<?php if(isset($PHORUM['DATA']['SELECTED']) && $PHORUM['DATA']['SELECTED']==180){ ?> selected<?php } ?>>6 <?php echo $PHORUM['DATA']['LANG']['Months']; ?></option>
<option value="365"<?php if(isset($PHORUM['DATA']['SELECTED']) && $PHORUM['DATA']['SELECTED']==365){ ?> selected<?php } ?>>1 <?php echo $PHORUM['DATA']['LANG']['Year']; ?></option>
<option value="0"<?php if(isset($PHORUM['DATA']['SELECTED']) && $PHORUM['DATA']['SELECTED']==0){ ?> selected<?php } ?>><?php echo $PHORUM['DATA']['LANG']['AllDates']; ?></option>
</select>
<input type="submit" class="PhorumSubmit" value="<?php echo $PHORUM['DATA']['LANG']['Go']; ?>" />
</div>
</form>
<br />
<form action="<?php echo $PHORUM['DATA']['URL']['ACTION']; ?>" method="POST">
<?php echo $PHORUM['DATA']['POST_VARS']; ?>
<input type="hidden" name="forum_id" value="<?php echo $PHORUM['DATA']['PROFILE']['forum_id']; ?>" />
<input type="hidden" name="panel" value="<?php echo $PHORUM['DATA']['PROFILE']['PANEL']; ?>" />
<input type="hidden" name="subdays" value="<?php echo $PHORUM['DATA']['SELECTED']; ?>" />
<table border="0" cellspacing="0" class="PhorumStdTable">
<tr>
<th align="left" class="PhorumTableHeader"><?php echo $PHORUM['DATA']['LANG']['Delete']; ?></th>
<th align="left" class="PhorumTableHeader"><?php echo $PHORUM['DATA']['LANG']['Subject']; ?></th>
<th align="left" class="PhorumTableHeader"><?php echo $PHORUM['DATA']['LANG']['Author']; ?></th>
<th align="left" class="PhorumTableHeader"><?php echo $PHORUM['DATA']['LANG']['LastPost']; ?></th>
<th align="left" class="PhorumTableHeader"><?php echo $PHORUM['DATA']['LANG']['Email']; ?></th>
</tr>
<?php if(isset($PHORUM['DATA']['subscriptions']) && is_array($PHORUM['DATA']['subscriptions'])) foreach($PHORUM['DATA']['subscriptions'] as $PHORUM['TMP']['subscriptions']){ ?>
<tr>
<td class="PhorumTableRow"><input type="checkbox" name="delthreads[]" value="<?php echo $PHORUM['TMP']['subscriptions']['thread']; ?>" /></td>
<td class="PhorumTableRow"><a href="<?php echo $PHORUM['TMP']['subscriptions']['readurl']; ?>"><?php echo $PHORUM['TMP']['subscriptions']['subject']; ?></a><br /><span class="PhorumListSubText">Forum: <?php echo $PHORUM['TMP']['subscriptions']['forum']; ?></span></td>
<td class="PhorumTableRow"><?php echo $PHORUM['TMP']['subscriptions']['linked_author']; ?></td>
<td class="PhorumTableRow"><?php echo $PHORUM['TMP']['subscriptions']['datestamp']; ?></td>
<td class="PhorumTableRow"><input type="hidden" name="thread_forum_id[<?php echo $PHORUM['TMP']['subscriptions']['thread']; ?>]" value="<?php echo $PHORUM['TMP']['subscriptions']['forum_id']; ?>" /><input type="hidden" name="old_sub_type[<?php echo $PHORUM['TMP']['subscriptions']['thread']; ?>]" value="<?php echo $PHORUM['TMP']['subscriptions']['sub_type']; ?>" /><select name="sub_type[<?php echo $PHORUM['TMP']['subscriptions']['thread']; ?>]"><option <?php if(isset($PHORUM['TMP']['subscriptions']['sub_type']) && $PHORUM['TMP']['subscriptions']['sub_type']==PHORUM_SUBSCRIPTION_MESSAGE){ ?>selected<?php } ?> value="<?php echo PHORUM_SUBSCRIPTION_MESSAGE; ?>"><?php echo $PHORUM['DATA']['LANG']['Yes']; ?></option><option <?php if(isset($PHORUM['TMP']['subscriptions']['sub_type']) && $PHORUM['TMP']['subscriptions']['sub_type']==PHORUM_SUBSCRIPTION_BOOKMARK){ ?>selected<?php } ?> value="<?php echo PHORUM_SUBSCRIPTION_BOOKMARK; ?>"><?php echo $PHORUM['DATA']['LANG']['No']; ?></option></select></td>
</tr>
<?php } unset($PHORUM['TMP']['subscriptions']); ?>
<tr>
<th colspan="5" align="right" class="PhorumTableHeader"><input type="submit" class="PhorumSubmit" name="button_update" value="<?php echo $PHORUM['DATA']['LANG']['Update']; ?>" /></th>
</tr>
</table>
</form>
<div class="PhorumFloatingText"><?php echo $PHORUM['DATA']['LANG']['HowToFollowThreads']; ?></div>
