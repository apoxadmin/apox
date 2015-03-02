<?php if(!defined("PHORUM")) return; ?>
<?php if(isset($PHORUM['DATA']['ERROR']) && !empty($PHORUM['DATA']['ERROR'])){ ?>
<div class="PhorumUserError"><?php echo $PHORUM['DATA']['ERROR']; ?></div>
<?php } ?>

<div align="center">
<a id="REPLY"></a>
<form action="<?php echo $PHORUM['DATA']['URL']['ACTION']; ?>" method="post" style="display: inline;">
<input type="hidden" name="thread" value="<?php echo $PHORUM['DATA']['POST']['thread']; ?>" />
<input type="hidden" name="parent_id" value="<?php echo $PHORUM['DATA']['POST']['parentid']; ?>" />
<input type="hidden" name="forum_id" value="<?php echo $PHORUM['DATA']['POST']['forumid']; ?>" />
<?php echo $PHORUM['DATA']['POST_VARS']; ?>
<div class="PhorumNavBlock PhorumNarrowBlock" style="text-align: left;">
<span class="PhorumNavHeading PhorumHeadingLeft"><?php echo $PHORUM['DATA']['LANG']['Goto']; ?>:</span>&nbsp;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['INDEX']; ?>"><?php echo $PHORUM['DATA']['LANG']['ForumList']; ?></a>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['TOP']; ?>"><?php echo $PHORUM['DATA']['LANG']['MessageList']; ?></a>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['SEARCH']; ?>"><?php echo $PHORUM['DATA']['LANG']['Search']; ?></a><?php if(isset($PHORUM['DATA']['LOGGEDIN']) && $PHORUM['DATA']['LOGGEDIN']==true){ ?>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['REGISTERPROFILE']; ?>"><?php echo $PHORUM['DATA']['LANG']['MyProfile']; ?></a><?php if(isset($PHORUM['DATA']['ENABLE_PM']) && !empty($PHORUM['DATA']['ENABLE_PM'])){ ?>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['PRIVATE_MESSAGES']['inbox_url']; ?>"><?php echo $PHORUM['DATA']['LANG']['PrivateMessages']; ?></a><?php } ?><?php } ?>
</div>
<?php if(isset($PHORUM['DATA']['POLLFORM']) && !empty($PHORUM['DATA']['POLLFORM'])){ ?><?php echo $PHORUM['DATA']['POLLFORM']; ?><?php } ?>
<div class="PhorumStdBlockHeader PhorumNarrowBlock" style="text-align: left;">
<table class="PhorumFormTable" cellspacing="0" border="0">
<?php if(isset($PHORUM['DATA']['LOGGEDIN']) && $PHORUM['DATA']['LOGGEDIN']==true){ ?>
<tr>
    <td><?php echo $PHORUM['DATA']['LANG']['YourName']; ?>:&nbsp;</td>
    <td><?php echo $PHORUM['DATA']['POST']['username']; ?></td>
</tr>
<?php } ?>
<?php if(isset($PHORUM['DATA']['LOGGEDIN']) && $PHORUM['DATA']['LOGGEDIN']==false){ ?>
<tr>
    <td><?php echo $PHORUM['DATA']['LANG']['YourName']; ?>:&nbsp;</td>
    <td><input type="text" name="author" size="30" value="<?php echo $PHORUM['DATA']['POST']['author']; ?>" /></td>
</tr>
<tr>
    <td><?php echo $PHORUM['DATA']['LANG']['YourEmail']; ?>:&nbsp;</td>
    <td><input type="text" name="email" size="30" value="<?php echo $PHORUM['DATA']['POST']['email']; ?>" /></td>
</tr>
<?php } ?>
<tr>
    <td><?php echo $PHORUM['DATA']['LANG']['Subject']; ?>:&nbsp;</td>
    <td><input type="text" name="subject" size="50" value="<?php echo $PHORUM['DATA']['POST']['subject']; ?>" /></td>
</tr>
<?php if(isset($PHORUM['DATA']['POST']['parentid']) && $PHORUM['DATA']['POST']['parentid']==0){ ?>
<?php if(isset($PHORUM['DATA']['POST']['show_special']) && $PHORUM['DATA']['POST']['show_special']==true){ ?>
<tr>
    <td><?php echo $PHORUM['DATA']['LANG']['Special']; ?>:&nbsp;</td>
    <td><select name="special">
    <option value=""<?php if(isset($PHORUM['DATA']['POST']['special']) && $PHORUM['DATA']['POST']['special']==""){ ?> selected<?php } ?>></option>
    <option value="sticky"<?php if(isset($PHORUM['DATA']['POST']['special']) && $PHORUM['DATA']['POST']['special']=="sticky"){ ?> selected<?php } ?>><?php echo $PHORUM['DATA']['LANG']['MakeSticky']; ?></option>
    <?php if(isset($PHORUM['DATA']['POST']['show_announcement']) && $PHORUM['DATA']['POST']['show_announcement']==true){ ?><option value="announcement"<?php if(isset($PHORUM['DATA']['POST']['special']) && $PHORUM['DATA']['POST']['special']=="announcement"){ ?> selected<?php } ?>><?php echo $PHORUM['DATA']['LANG']['MakeAnnouncement']; ?></option><?php } ?>
    </select></td>
</tr>
<?php } ?>
<?php } ?>
<?php if(isset($PHORUM['DATA']['LOGGEDIN']) && $PHORUM['DATA']['LOGGEDIN']==true){ ?>
<tr>
    <td colspan="2"><input type="checkbox" name="email_reply" value="1"<?php if(isset($PHORUM['DATA']['POST']['email_reply']) && !empty($PHORUM['DATA']['POST']['email_reply'])){ ?> checked="checked" <?php } ?> /> <?php echo $PHORUM['DATA']['LANG']['EmailReplies']; ?></td>
</tr>
<tr>
    <td colspan="2"><input type="checkbox" name="show_signature" value="1"<?php if(isset($PHORUM['DATA']['POST']['show_signature']) && !empty($PHORUM['DATA']['POST']['show_signature'])){ ?> checked="checked" <?php } ?> /> <?php echo $PHORUM['DATA']['LANG']['AddSig']; ?></td>
</tr>
<?php } ?>
</table>
</div>

<div class="PhorumStdBlock PhorumNarrowBlock">
<textarea name="body" rows="20" cols="50" style="width: 100%;"><?php echo $PHORUM['DATA']['POST']['body']; ?></textarea><br />
<?php if(isset($PHORUM['DATA']['MODERATED']) && !empty($PHORUM['DATA']['MODERATED'])){ ?>
<?php echo $PHORUM['DATA']['LANG']['ModeratedForum']; ?><br />
<?php } ?>
<div style="margin-top: 3px;" align="right"><?php if(isset($PHORUM['DATA']['ATTACHMENTS']) && !empty($PHORUM['DATA']['ATTACHMENTS'])){ ?><input name="attach" class="PhorumSubmit" type="submit" value=" <?php echo $PHORUM['DATA']['LANG']['Attach']; ?> " />&nbsp;<?php } ?><input name="preview" type="submit" class="PhorumSubmit" value=" <?php echo $PHORUM['DATA']['LANG']['Preview']; ?> " />&nbsp;<input type="submit" class="PhorumSubmit" value=" <?php echo $PHORUM['DATA']['LANG']['Post']; ?> " /></div>

</div>

</form>
</div>
