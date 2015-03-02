<?php if(!defined("PHORUM")) return; ?>
<?php if(isset($PHORUM['DATA']['ERROR']) && !empty($PHORUM['DATA']['ERROR'])){ ?><div class="PhorumUserError"><?php echo $PHORUM['DATA']['ERROR']; ?></div><?php } ?>
<?php if(isset($PHORUM['DATA']['OKMSG']) && !empty($PHORUM['DATA']['OKMSG'])){ ?><div class="PhorumOkMsg"><?php echo $PHORUM['DATA']['OKMSG']; ?></div><?php } ?>

<div class="PhorumStdBlockHeader PhorumHeaderText" style="text-align: left;"><?php echo $PHORUM['DATA']['PROFILE']['block_title']; ?></div>
<form action="<?php echo $PHORUM['DATA']['URL']['ACTION']; ?>" method="POST">
<?php echo $PHORUM['DATA']['POST_VARS']; ?>
<input type="hidden" name="panel" value="<?php echo $PHORUM['DATA']['PROFILE']['PANEL']; ?>" />
<input type="hidden" name="forum_id" value="<?php echo $PHORUM['DATA']['PROFILE']['forum_id']; ?>" />
<div class="PhorumStdBlock" style="text-align: left;">
<table class="PhorumFormTable" cellspacing="0" border="0">
<?php if(isset($PHORUM['DATA']['PROFILE']['USERPROFILE']) && !empty($PHORUM['DATA']['PROFILE']['USERPROFILE'])){ ?>
<tr>
    <td nowrap="nowrap"><?php echo $PHORUM['DATA']['LANG']['RealName']; ?>:&nbsp;</td>
    <td><input type="text" name="real_name" size="30" value="<?php echo $PHORUM['DATA']['PROFILE']['real_name']; ?>" /></td>
</tr>
<?php } ?>
<?php if(isset($PHORUM['DATA']['PROFILE']['SIGSETTINGS']) && !empty($PHORUM['DATA']['PROFILE']['SIGSETTINGS'])){ ?>
<tr>
    <td valign="top" nowrap="nowrap"><?php echo $PHORUM['DATA']['LANG']['Signature']; ?>:&nbsp;</td>
    <td width="100%"><textarea name="signature" rows="15" cols="50" style="width: 100%"><?php echo $PHORUM['DATA']['PROFILE']['signature']; ?></textarea></td>
</tr>
<?php } ?>
<?php if(isset($PHORUM['DATA']['PROFILE']['MAILSETTINGS']) && !empty($PHORUM['DATA']['PROFILE']['MAILSETTINGS'])){ ?>
<tr>
    <td valign="top"><?php echo $PHORUM['DATA']['LANG']['Email']; ?>*:&nbsp;<?php if(isset($PHORUM['DATA']['PROFILE']['EMAIL_CONFIRM']) && !empty($PHORUM['DATA']['PROFILE']['EMAIL_CONFIRM'])){ ?><br /><?php echo $PHORUM['DATA']['LANG']['EmailConfirmRequired']; ?><?php } ?></td>
    <td><input type="text" name="email" size="30" value="<?php echo $PHORUM['DATA']['PROFILE']['email']; ?>" /></td>
</tr>
<?php if(isset($PHORUM['DATA']['PROFILE']['email_temp_part']) && !empty($PHORUM['DATA']['PROFILE']['email_temp_part'])){ ?>
<tr>
    <td valign="top"><?php echo $PHORUM['DATA']['LANG']['EmailVerify']; ?>:&nbsp;</td>
    <td><?php echo $PHORUM['DATA']['LANG']['EmailVerifyDesc']; ?> <?php echo $PHORUM['DATA']['PROFILE']['email_temp_part']; ?><br>
    <?php echo $PHORUM['DATA']['LANG']['EmailVerifyEnterCode']; ?>: <input type="text" name="email_verify_code" value="" />
    </td>
</tr>
<?php } ?>
<tr>
    <td colspan="2"><input type="checkbox" name="hide_email" value="1"<?php echo $PHORUM['DATA']['PROFILE']['hide_email_checked']; ?> /> <?php echo $PHORUM['DATA']['LANG']['AllowSeeEmail']; ?></td>
</tr>
<?php } ?>
<?php if(isset($PHORUM['DATA']['PROFILE']['PRIVACYSETTINGS']) && !empty($PHORUM['DATA']['PROFILE']['PRIVACYSETTINGS'])){ ?>
<tr>
    <td colspan="2"><input type="checkbox" name="hide_email" value="1"<?php echo $PHORUM['DATA']['PROFILE']['hide_email_checked']; ?> /> <?php echo $PHORUM['DATA']['LANG']['AllowSeeEmail']; ?></td>
</tr>
<tr>
    <td colspan="2"><input type="checkbox" name="hide_activity" value="1"<?php echo $PHORUM['DATA']['PROFILE']['hide_activity_checked']; ?> /> <?php echo $PHORUM['DATA']['LANG']['AllowSeeActivity']; ?></td>
</tr>
<?php } ?>
<?php if(isset($PHORUM['DATA']['PROFILE']['BOARDSETTINGS']) && !empty($PHORUM['DATA']['PROFILE']['BOARDSETTINGS'])){ ?>
<tr>
    <td nowrap="nowrap"><?php echo $PHORUM['DATA']['LANG']['Language']; ?>:&nbsp;</td>
    <td><select name="user_language">
    <?php if(isset($PHORUM['DATA']['LANGUAGES']) && is_array($PHORUM['DATA']['LANGUAGES'])) foreach($PHORUM['DATA']['LANGUAGES'] as $PHORUM['TMP']['LANGUAGES']){ ?>
    <option value="<?php echo $PHORUM['TMP']['LANGUAGES']['file']; ?>"<?php echo $PHORUM['TMP']['LANGUAGES']['sel']; ?>><?php echo $PHORUM['TMP']['LANGUAGES']['name']; ?></option>
    <?php } unset($PHORUM['TMP']['LANGUAGES']); ?>
    
    </select></td>
</tr>  
  <?php if(isset($PHORUM['DATA']['PROFILE']['TMPLSELECTION']) && !empty($PHORUM['DATA']['PROFILE']['TMPLSELECTION'])){ ?>
<tr>
    <td nowrap="nowrap"><?php echo $PHORUM['DATA']['LANG']['Template']; ?>:&nbsp;</td>
    <td><select name="user_template">
    <?php if(isset($PHORUM['DATA']['TEMPLATES']) && is_array($PHORUM['DATA']['TEMPLATES'])) foreach($PHORUM['DATA']['TEMPLATES'] as $PHORUM['TMP']['TEMPLATES']){ ?>
    <option value="<?php echo $PHORUM['TMP']['TEMPLATES']['file']; ?>"<?php echo $PHORUM['TMP']['TEMPLATES']['sel']; ?>><?php echo $PHORUM['TMP']['TEMPLATES']['name']; ?></option>
    <?php } unset($PHORUM['TMP']['TEMPLATES']); ?>
    
    </select></td>
</tr>  
  <?php } ?>
<tr>
    <td nowrap="nowrap"><?php echo $PHORUM['DATA']['LANG']['ThreadViewList']; ?>:&nbsp;</td>
    <td><select name="threaded_list"><option value="0"><?php echo $PHORUM['DATA']['LANG']['Default']; ?></option><option value="1" <?php if(isset($PHORUM['DATA']['PROFILE']['threaded_list']) && !empty($PHORUM['DATA']['PROFILE']['threaded_list'])){ ?>selected<?php } ?>><?php echo $PHORUM['DATA']['LANG']['ViewThreaded']; ?></option><option value="2" <?php if(isset($PHORUM['DATA']['PROFILE']['threaded_list']) && $PHORUM['DATA']['PROFILE']['threaded_list']==2){ ?>selected<?php } ?>><?php echo $PHORUM['DATA']['LANG']['ViewFlat']; ?></option></select></td>
</tr>
<tr>
    <td nowrap="nowrap"><?php echo $PHORUM['DATA']['LANG']['ThreadViewRead']; ?>:&nbsp;</td>
    <td><select name="threaded_read"><option value="0"><?php echo $PHORUM['DATA']['LANG']['Default']; ?></option><option value="1" <?php if(isset($PHORUM['DATA']['PROFILE']['threaded_read']) && !empty($PHORUM['DATA']['PROFILE']['threaded_read'])){ ?>selected<?php } ?>><?php echo $PHORUM['DATA']['LANG']['ViewThreaded']; ?></option><option value="2" <?php if(isset($PHORUM['DATA']['PROFILE']['threaded_read']) && $PHORUM['DATA']['PROFILE']['threaded_read']==2){ ?>selected<?php } ?>><?php echo $PHORUM['DATA']['LANG']['ViewFlat']; ?></option></select></td>
</tr>
<tr>
    <td nowrap="nowrap"><?php echo $PHORUM['DATA']['LANG']['EnableNotifyDefault']; ?>:&nbsp;</td>
    <td><select name="email_notify">
            <option value="0"<?php if(isset($PHORUM['DATA']['PROFILE']['email_notify']) && $PHORUM['DATA']['PROFILE']['email_notify']==0){ ?> selected="selected" <?php } ?>><?php echo $PHORUM['DATA']['LANG']['No']; ?></option>
            <option value="1"<?php if(isset($PHORUM['DATA']['PROFILE']['email_notify']) && $PHORUM['DATA']['PROFILE']['email_notify']==1){ ?> selected="selected" <?php } ?>><?php echo $PHORUM['DATA']['LANG']['Yes']; ?></option>
            </select>
    </td>
</tr>
<tr>
    <td nowrap="nowrap"><?php echo $PHORUM['DATA']['LANG']['AddSigDefault']; ?>:&nbsp;</td>
    <td><select name="show_signature">
            <option value="0"<?php if(isset($PHORUM['DATA']['PROFILE']['show_signature']) && $PHORUM['DATA']['PROFILE']['show_signature']==0){ ?> selected="selected" <?php } ?>><?php echo $PHORUM['DATA']['LANG']['No']; ?></option>
            <option value="1"<?php if(isset($PHORUM['DATA']['PROFILE']['show_signature']) && $PHORUM['DATA']['PROFILE']['show_signature']==1){ ?> selected="selected" <?php } ?>><?php echo $PHORUM['DATA']['LANG']['Yes']; ?></option>
            </select>
    </td>
</tr>
<?php } ?>
<?php if(isset($PHORUM['DATA']['PROFILE']['CHANGEPASSWORD']) && !empty($PHORUM['DATA']['PROFILE']['CHANGEPASSWORD'])){ ?>
<tr>
    <td nowrap="nowrap"><?php echo $PHORUM['DATA']['LANG']['Password']; ?>*:&nbsp;</td>
    <td><input type="password" name="password" size="30" value="" /></td>
</tr>
<tr>
    <td nowrap="nowrap">&nbsp;</td>
    <td><input type="password" name="password2" size="30" value="" /> (<?php echo $PHORUM['DATA']['LANG']['again']; ?>)</td>
</tr>
<?php } ?>
</table>
<div style="float: left; margin-top: 5px;">*<?php echo $PHORUM['DATA']['LANG']['Required']; ?></div>
<div style="margin-top: 3px;" align="center"><input type="submit" class="PhorumSubmit" value=" <?php echo $PHORUM['DATA']['LANG']['Submit']; ?> " /></div>

</div>
</form>
