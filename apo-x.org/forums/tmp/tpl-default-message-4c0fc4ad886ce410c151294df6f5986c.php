<?php if(!defined("PHORUM")) return; ?>
<div align="center">

<div class="PhorumNavBlock PhorumNarrowBlock" style="text-align: left;">
<span class="PhorumNavHeading"><?php echo $PHORUM['DATA']['LANG']['Goto']; ?>:</span>&nbsp;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['INDEX']; ?>"><?php echo $PHORUM['DATA']['LANG']['ForumList']; ?></a>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['TOP']; ?>"><?php echo $PHORUM['DATA']['LANG']['MessageList']; ?></a>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['SEARCH']; ?>"><?php echo $PHORUM['DATA']['LANG']['Search']; ?></a><?php if(isset($PHORUM['DATA']['LOGGEDIN']) && $PHORUM['DATA']['LOGGEDIN']==true){ ?>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['REGISTERPROFILE']; ?>"><?php echo $PHORUM['DATA']['LANG']['MyProfile']; ?></a><?php if(isset($PHORUM['DATA']['ENABLE_PM']) && !empty($PHORUM['DATA']['ENABLE_PM'])){ ?>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['PRIVATE_MESSAGES']['inbox_url']; ?>"><?php echo $PHORUM['DATA']['LANG']['PrivateMessages']; ?></a><?php } ?><?php } ?>
</div>


<div class="PhorumStdBlock PhorumNarrowBlock">

<?php if(isset($PHORUM['DATA']['ERROR']) && !empty($PHORUM['DATA']['ERROR'])){ ?>
<div class="PhorumUserError"><?php echo $PHORUM['DATA']['ERROR']; ?></div>
<?php } ?>

<?php if(isset($PHORUM['DATA']['MESSAGE']) && !empty($PHORUM['DATA']['MESSAGE'])){ ?>
<div class="PhorumFloatingText"><?php echo $PHORUM['DATA']['MESSAGE']; ?></div>
<?php } ?>

<?php if(isset($PHORUM['DATA']['URL']['REDIRECT']) && !empty($PHORUM['DATA']['URL']['REDIRECT'])){ ?>
<div class="PhorumFloatingText"><a href="<?php echo $PHORUM['DATA']['URL']['REDIRECT']; ?>"><?php echo $PHORUM['DATA']['BACKMSG']; ?></a></div>
<?php } ?>

</div>

</div>
