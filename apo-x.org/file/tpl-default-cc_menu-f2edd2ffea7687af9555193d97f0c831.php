<?php if(!defined("PHORUM")) return; ?>
<div class="PhorumNavBlock" style="text-align: left;">
<span class="PhorumNavHeading"><?php echo $PHORUM['DATA']['LANG']['PersProfile']; ?></span><br />
&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['CC0']; ?>"><?php echo $PHORUM['DATA']['LANG']['ViewProfile']; ?></a><br />
&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['CC3']; ?>"><?php echo $PHORUM['DATA']['LANG']['EditUserinfo']; ?></a><br />
&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['CC4']; ?>"><?php echo $PHORUM['DATA']['LANG']['EditSignature']; ?></a><br />
<!--&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['CC5']; ?>"><?php echo $PHORUM['DATA']['LANG']['EditMailsettings']; ?></a><br />-->
&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['CC14']; ?>"><?php echo $PHORUM['DATA']['LANG']['EditPrivacy']; ?></a><br />
&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['CC16']; ?>"><?php echo $PHORUM['DATA']['LANG']['ViewJoinGroups']; ?></a><br />
<br />
<?php if(isset($PHORUM['DATA']['ENABLE_PM']) && !empty($PHORUM['DATA']['ENABLE_PM'])){ ?>
<span class="PhorumNavHeading"><?php echo $PHORUM['DATA']['LANG']['PrivateMessages']; ?></span><br />
&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['CC11']; ?>"><?php echo $PHORUM['DATA']['LANG']['INBOX']; ?></a><br />
&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['CC12']; ?>"><?php echo $PHORUM['DATA']['LANG']['SentItems']; ?></a><br />
&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['CC13']; ?>"><?php echo $PHORUM['DATA']['LANG']['SendPM']; ?></a><br />
<br />
<?php } ?>
<span class="PhorumNavHeading"><?php echo $PHORUM['DATA']['LANG']['Subscriptions']; ?></span><br />
&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['CC1']; ?>"><?php echo $PHORUM['DATA']['LANG']['ListThreads']; ?></a><br />
<!--&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['CC2']; ?>"><?php echo $PHORUM['DATA']['LANG']['ListForums']; ?></a><br />-->
<br />
<span class="PhorumNavHeading"><?php echo $PHORUM['DATA']['LANG']['Options']; ?></span><br />
&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['CC6']; ?>"><?php echo $PHORUM['DATA']['LANG']['EditBoardsettings']; ?></a><br />
<!--&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['CC7']; ?>"><?php echo $PHORUM['DATA']['LANG']['ChangePassword']; ?></a><br />-->
<br />
<?php if(isset($PHORUM['DATA']['MYFILES']) && !empty($PHORUM['DATA']['MYFILES'])){ ?>
<span class="PhorumNavHeading"><?php echo $PHORUM['DATA']['LANG']['Files']; ?></span><br />
&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['CC9']; ?>"><?php echo $PHORUM['DATA']['LANG']['EditMyFiles']; ?></a><br />
<br />
<?php } ?>
<?php if(isset($PHORUM['DATA']['MODERATOR']) && !empty($PHORUM['DATA']['MODERATOR'])){ ?>
<span class="PhorumNavHeading"><?php echo $PHORUM['DATA']['LANG']['Moderate']; ?></span><br />
<?php if(isset($PHORUM['DATA']['MESSAGE_MODERATOR']) && !empty($PHORUM['DATA']['MESSAGE_MODERATOR'])){ ?>
&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['CC8']; ?>"><?php echo $PHORUM['DATA']['LANG']['UnapprovedMessages']; ?></a><br />
<?php } ?>
<?php if(isset($PHORUM['DATA']['USER_MODERATOR']) && !empty($PHORUM['DATA']['USER_MODERATOR'])){ ?>
&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['CC10']; ?>"><?php echo $PHORUM['DATA']['LANG']['UnapprovedUsers']; ?></a><br />
<?php } ?>
<?php if(isset($PHORUM['DATA']['GROUP_MODERATOR']) && !empty($PHORUM['DATA']['GROUP_MODERATOR'])){ ?>
&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['CC15']; ?>"><?php echo $PHORUM['DATA']['LANG']['GroupMembership']; ?></a><br />
<?php } ?>
<br />
<?php } ?>
<div align="center"><a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['BACK']; ?>"><?php echo $PHORUM['DATA']['URL']['BACKTITLE']; ?></a></div>
</div>
