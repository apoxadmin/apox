<?php if(!defined("PHORUM")) return; ?>
<div class="PhorumNavBlock" style="text-align: left;">
<span class="PhorumNavHeading PhorumHeadingLeft"><?php echo $PHORUM['DATA']['LANG']['Goto']; ?>:</span>&nbsp;
<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['INDEX']; ?>"><?php echo $PHORUM['DATA']['LANG']['ForumList']; ?></a>&bull;
<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['TOP']; ?>"><?php echo $PHORUM['DATA']['LANG']['MessageList']; ?></a>&bull;
<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['POST']; ?>"><?php echo $PHORUM['DATA']['LANG']['NewTopic']; ?></a>&bull;
<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['SEARCH']; ?>"><?php echo $PHORUM['DATA']['LANG']['Search']; ?></a>
<?php if(isset($PHORUM['DATA']['LOGGEDIN']) && $PHORUM['DATA']['LOGGEDIN']==true){ ?>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['REGISTERPROFILE']; ?>"><?php echo $PHORUM['DATA']['LANG']['MyProfile']; ?></a>
<?php if(isset($PHORUM['DATA']['ENABLE_PM']) && !empty($PHORUM['DATA']['ENABLE_PM'])){ ?>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['PRIVATE_MESSAGES']['inbox_url']; ?>"><?php echo $PHORUM['DATA']['LANG']['PrivateMessages']; ?></a>
<?php } ?><?php } ?>
</div>

<div class="PhorumStdBlockHeader PhorumHeaderText" style="text-align: left;"><?php echo $PHORUM['DATA']['LANG']['Preview']; ?></div>

<div class="PhorumReadMessageBlock">
<div class="PhorumStdBlock">
<div class="PhorumReadBodySubject"><?php echo $PHORUM['DATA']['PREVIEW']['subject']; ?></div>
<div class="PhorumReadBodyHead"><?php echo $PHORUM['DATA']['LANG']['Postedby']; ?>: <strong><?php echo $PHORUM['DATA']['PREVIEW']['author']; ?></strong> (<?php echo $PHORUM['DATA']['PREVIEW']['ip']; ?>)</div>
<br />
<div class="PhorumReadBodyText"><?php echo $PHORUM['DATA']['PREVIEW']['body']; ?></div><br />
</div>
</div>
<br /><br />