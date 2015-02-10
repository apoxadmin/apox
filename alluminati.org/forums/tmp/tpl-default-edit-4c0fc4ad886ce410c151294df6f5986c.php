<?php if(!defined("PHORUM")) return; ?>
<?php if(isset($PHORUM['DATA']['ERROR']) && !empty($PHORUM['DATA']['ERROR'])){ ?>
<div class="PhorumUserError"><?php echo $PHORUM['DATA']['ERROR']; ?></div>
<?php } ?>
<?php if(isset($PHORUM['DATA']['EDIT']['edit_allowed']) && !empty($PHORUM['DATA']['EDIT']['edit_allowed'])){ ?>
<div align="center">
<form action="<?php echo $PHORUM['DATA']['URL']['ACTION']; ?>" method="post" style="display: inline;">
<?php echo $PHORUM['DATA']['POST_VARS']; ?>
<input type="hidden" name="mod_step" value="<?php echo $PHORUM['DATA']['EDIT']['mod_step']; ?>" />
<input type="hidden" name="message_id" value="<?php echo $PHORUM['DATA']['EDIT']['message_id']; ?>" />

<input type="hidden" name="thread" value="<?php echo $PHORUM['DATA']['EDIT']['thread']; ?>" />
<input type="hidden" name="forum_id" value="<?php echo $PHORUM['DATA']['EDIT']['forum_id']; ?>" />
<input type="hidden" name="parent_id" value="<?php echo $PHORUM['DATA']['EDIT']['parent_id']; ?>" />
<input type="hidden" name="user_id" value="<?php echo $PHORUM['DATA']['EDIT']['user_id']; ?>" />

<div class="PhorumNavBlock PhorumNarrowBlock" style="text-align: left;">
<span class="PhorumNavHeading"><?php echo $PHORUM['DATA']['LANG']['Goto']; ?>:</span>&nbsp;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['INDEX']; ?>"><?php echo $PHORUM['DATA']['LANG']['ForumList']; ?></a>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['TOP']; ?>"><?php echo $PHORUM['DATA']['LANG']['MessageList']; ?></a>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['SEARCH']; ?>"><?php echo $PHORUM['DATA']['LANG']['Search']; ?></a><?php if(isset($PHORUM['DATA']['LOGGEDIN']) && $PHORUM['DATA']['LOGGEDIN']==true){ ?>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['REGISTERPROFILE']; ?>"><?php echo $PHORUM['DATA']['LANG']['MyProfile']; ?></a><?php if(isset($PHORUM['DATA']['ENABLE_PM']) && !empty($PHORUM['DATA']['ENABLE_PM'])){ ?>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['PRIVATE_MESSAGES']['inbox_url']; ?>"><?php echo $PHORUM['DATA']['LANG']['PrivateMessages']; ?></a><?php } ?><?php } ?></a>
</div>

<div class="PhorumStdBlockHeader PhorumNarrowBlock PhorumHeaderText" style="text-align: left;"><?php echo $PHORUM['DATA']['LANG']['EditPost']; ?></div>

<div class="PhorumStdBlockHeader PhorumNarrowBlock" style="text-align: left;">
<table cellspacing="0" border="0">
<?php if(isset($PHORUM['DATA']['EDIT']['useredit']) && !empty($PHORUM['DATA']['EDIT']['useredit'])){ ?>
<tr>
    <td><?php echo $PHORUM['DATA']['LANG']['YourName']; ?>:&nbsp;</td>
    <td><?php echo $PHORUM['DATA']['EDIT']['author']; ?></td>
</tr>
<?php } elseif(isset($PHORUM['DATA']['EDIT']['moderator_useredit']) && !empty($PHORUM['DATA']['EDIT']['moderator_useredit'])){ ?>
<tr>
    <td><?php echo $PHORUM['DATA']['LANG']['Author']; ?>:&nbsp;</td>
    <td><input type="text" name="author" size="30" value="<?php echo $PHORUM['DATA']['EDIT']['author']; ?>" /></td>
</tr>
<?php } else { ?>
<tr>
    <td><?php echo $PHORUM['DATA']['LANG']['Author']; ?>:&nbsp;</td>
    <td><input type="text" name="author" size="30" value="<?php echo $PHORUM['DATA']['EDIT']['author']; ?>" /></td>
</tr>
<tr>
    <td><?php echo $PHORUM['DATA']['LANG']['Email']; ?>:&nbsp;</td>
    <td><input type="text" name="email" size="30" value="<?php echo $PHORUM['DATA']['EDIT']['email']; ?>" /></td>
</tr>
<?php } ?>

<tr>
    <td><?php echo $PHORUM['DATA']['LANG']['Subject']; ?>:&nbsp;</td>
    <td><input type="text" name="subject" size="50" value="<?php echo $PHORUM['DATA']['EDIT']['subject']; ?>" /></td>
</tr>
<?php if(isset($PHORUM['DATA']['EDIT']['parent_id']) && $PHORUM['DATA']['EDIT']['parent_id']==0){ ?>
<?php if(isset($PHORUM['DATA']['EDIT']['useredit']) && $PHORUM['DATA']['EDIT']['useredit']==0){ ?>
<tr>
    <td><?php echo $PHORUM['DATA']['LANG']['Special']; ?>:&nbsp;</td>
    <td><select name="special"><option value=""></option><option value="sticky"<?php if(isset($PHORUM['DATA']['EDIT']['special']) && $PHORUM['DATA']['EDIT']['special']==PHORUM_SORT_STICKY){ ?> selected<?php } ?>><?php echo $PHORUM['DATA']['LANG']['MakeSticky']; ?></option><?php if(isset($PHORUM['DATA']['EDIT']['show_announcement']) && $PHORUM['DATA']['EDIT']['show_announcement']==true){ ?><option value="announcement"<?php if(isset($PHORUM['DATA']['EDIT']['special']) && $PHORUM['DATA']['EDIT']['special']==PHORUM_SORT_ANNOUNCEMENT){ ?> selected<?php } ?>><?php echo $PHORUM['DATA']['LANG']['MakeAnnouncement']; ?></option><?php } ?></select></td>
</tr>
<?php } ?>
<?php } ?>
<tr>
    <td colspan="2"><input type="checkbox" name="email_reply" value="1" <?php if(isset($PHORUM['DATA']['EDIT']['emailreply']) && $PHORUM['DATA']['EDIT']['emailreply']==true){ ?> checked<?php } ?> /> <?php echo $PHORUM['DATA']['LANG']['EmailReplies']; ?></td>
</tr>
<tr>
    <td colspan="2"><input type="checkbox" name="show_signature" value="1" <?php if(isset($PHORUM['DATA']['EDIT']['meta']['show_signature']) && !empty($PHORUM['DATA']['EDIT']['meta']['show_signature'])){ ?> checked<?php } ?> /> <?php echo $PHORUM['DATA']['LANG']['AddSig']; ?></td>
</tr>
<?php if(isset($PHORUM['DATA']['EDIT']['attachments']) && !empty($PHORUM['DATA']['EDIT']['attachments'])){ ?>
<tr>
    <td colspan="2"><?php echo $PHORUM['DATA']['LANG']['Attachments']; ?> (<?php echo $PHORUM['DATA']['LANG']['CheckToDelete']; ?>):<br /><?php if(isset($PHORUM['DATA']['EDIT']['attachments']) && is_array($PHORUM['DATA']['EDIT']['attachments'])) foreach($PHORUM['DATA']['EDIT']['attachments'] as $PHORUM['TMP']['EDIT']['attachments']){ ?><input type="checkbox" name="attachments[]" value="<?php echo $PHORUM['TMP']['EDIT']['attachments']['file_id']; ?>" /> <?php echo $PHORUM['TMP']['EDIT']['attachments']['file_name']; ?><br /><?php } unset($PHORUM['TMP']['EDIT']['attachments']); ?></td>
</tr>
<?php } ?>
</table>
</div>

<div class="PhorumStdBlock PhorumNarrowBlock">
<textarea name="body" rows="20" cols="50" style="width: 100%;"><?php echo $PHORUM['DATA']['EDIT']['body']; ?></textarea><br />
<?php if(isset($PHORUM['DATA']['MODERATED']) && !empty($PHORUM['DATA']['MODERATED'])){ ?>
<?php echo $PHORUM['DATA']['LANG']['ModeratedForum']; ?><br />
<?php } ?>
<div style="margin-top: 3px;" align="right"><input type="submit" class="PhorumSubmit" value=" <?php echo $PHORUM['DATA']['LANG']['Update']; ?> " /></div>

</form>
</div>
</div>
<?php } ?>