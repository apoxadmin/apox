<?php if(!defined("PHORUM")) return; ?>
<div align="center">

<div class="PhorumNavBlock PhorumNarrowBlock" style="text-align: left;">
<span class="PhorumNavHeading"><?php echo $PHORUM['DATA']['LANG']['Goto']; ?>:</span>&nbsp;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['INDEX']; ?>"><?php echo $PHORUM['DATA']['LANG']['ForumList']; ?></a>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['TOP']; ?>"><?php echo $PHORUM['DATA']['LANG']['MessageList']; ?></a>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['SEARCH']; ?>"><?php echo $PHORUM['DATA']['LANG']['Search']; ?></a><?php if(isset($PHORUM['DATA']['LOGGEDIN']) && $PHORUM['DATA']['LOGGEDIN']==true){ ?>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['REGISTERPROFILE']; ?>"><?php echo $PHORUM['DATA']['LANG']['MyProfile']; ?></a><?php if(isset($PHORUM['DATA']['ENABLE_PM']) && !empty($PHORUM['DATA']['ENABLE_PM'])){ ?>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['PRIVATE_MESSAGES']['inbox_url']; ?>"><?php echo $PHORUM['DATA']['LANG']['PrivateMessages']; ?></a><?php } ?><?php } ?></a>
</div>

<div class="PhorumStdBlockHeader PhorumNarrowBlock PhorumHeaderText" style="text-align: left;"><?php echo $PHORUM['DATA']['LANG']['UserProfile']; ?>&nbsp;:&nbsp;<?php echo $PHORUM['DATA']['PROFILE']['username']; ?></div>

<div class="PhorumStdBlock PhorumNarrowBlock" style="text-align: left;">
<table cellspacing="0" border="0">
<tr>
    <td nowrap="nowrap"><?php echo $PHORUM['DATA']['LANG']['Email']; ?>:&nbsp;</td>
    <td><?php echo $PHORUM['DATA']['PROFILE']['email']; ?></td>
</tr>
<?php if(isset($PHORUM['DATA']['PROFILE']['real_name']) && !empty($PHORUM['DATA']['PROFILE']['real_name'])){ ?>
<tr>
    <td nowrap="nowrap"><?php echo $PHORUM['DATA']['LANG']['RealName']; ?>:&nbsp;</td>
    <td><?php echo $PHORUM['DATA']['PROFILE']['real_name']; ?></td>
</tr>
<?php } ?>
<?php if(isset($PHORUM['DATA']['PROFILE']['date_added']) && !empty($PHORUM['DATA']['PROFILE']['date_added'])){ ?>
<tr>
    <td nowrap="nowrap"><?php echo $PHORUM['DATA']['LANG']['DateReg']; ?>:&nbsp;</td>
    <td><?php echo $PHORUM['DATA']['PROFILE']['date_added']; ?></td>
</tr>
<?php } ?>
<?php if(isset($PHORUM['DATA']['PROFILE']['date_last_active']) && !empty($PHORUM['DATA']['PROFILE']['date_last_active'])){ ?>
<tr>
    <td nowrap="nowrap"><?php echo $PHORUM['DATA']['LANG']['DateActive']; ?>:&nbsp;</td>
    <td><?php echo $PHORUM['DATA']['PROFILE']['date_last_active']; ?></td>
</tr>
<?php } ?>
</table>

</div>

<?php if(isset($PHORUM['DATA']['ENABLE_PM']) && !empty($PHORUM['DATA']['ENABLE_PM'])){ ?>
<div class="PhorumNavBlock PhorumNarrowBlock" style="text-align: left;">
<span class="PhorumNavHeading"><?php echo $PHORUM['DATA']['LANG']['Options']; ?>:</span>&nbsp;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['PROFILE']['pm_url']; ?>"><?php echo $PHORUM['DATA']['LANG']['SendPM']; ?></a>
</div>
<?php } ?>
</div>