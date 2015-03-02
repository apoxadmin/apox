<?php if(!defined("PHORUM")) return; ?>
<div align="center">

<div class="PhorumNavBlock PhorumNarrowBlock" style="text-align: left;">
<span class="PhorumNavHeading"><?php echo $PHORUM['DATA']['LANG']['Goto']; ?>:</span>&nbsp;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['INDEX']; ?>"><?php echo $PHORUM['DATA']['LANG']['ForumList']; ?></a>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['TOP']; ?>"><?php echo $PHORUM['DATA']['LANG']['MessageList']; ?></a>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['SEARCH']; ?>"><?php echo $PHORUM['DATA']['LANG']['Search']; ?></a><?php if(isset($PHORUM['DATA']['LOGGEDIN']) && $PHORUM['DATA']['LOGGEDIN']==true){ ?>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['REGISTERPROFILE']; ?>"><?php echo $PHORUM['DATA']['LANG']['MyProfile']; ?></a><?php if(isset($PHORUM['DATA']['ENABLE_PM']) && !empty($PHORUM['DATA']['ENABLE_PM'])){ ?>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['PRIVATE_MESSAGES']['inbox_url']; ?>"><?php echo $PHORUM['DATA']['LANG']['PrivateMessages']; ?></a><?php } ?><?php } ?></a>
</div>


<form action="<?php echo $PHORUM['DATA']['URL']['ACTION']; ?>" method="post" style="display: inline;">
<?php echo $PHORUM['DATA']['POST_VARS']; ?>
<input type="hidden" name="forum_id" value="<?php echo $PHORUM['DATA']['FORUM_ID']; ?>" />
<input type="hidden" name="thread" value="<?php echo $PHORUM['DATA']['THREAD']; ?>" />
<div class="PhorumStdBlock PhorumNarrowBlock">

<div class="PhorumFloatingText">
<?php echo $PHORUM['DATA']['LANG']['YouWantToFollow']; ?>
<div class="PhorumLargeFont"><?php echo $PHORUM['DATA']['SUBJECT']; ?></div><br />
<?php echo $PHORUM['DATA']['LANG']['FollowExplination']; ?><br /><br />
<input type="checkbox" name="send_email" checked="checked" />&nbsp;<?php echo $PHORUM['DATA']['LANG']['FollowWithEmail']; ?><br /><br />
<input type="submit" value="<?php echo $PHORUM['DATA']['LANG']['Submit']; ?>" />
</div>

</div>
</form>

</div>
