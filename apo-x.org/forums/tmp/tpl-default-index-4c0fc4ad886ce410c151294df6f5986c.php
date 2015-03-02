<?php if(!defined("PHORUM")) return; ?>
<div class="PhorumNavBlock">
<span class="PhorumNavHeading"><?php echo $PHORUM['DATA']['LANG']['Goto']; ?>:</span>&nbsp;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['INDEX']; ?>"><?php echo $PHORUM['DATA']['LANG']['ForumList']; ?></a>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['SEARCH']; ?>"><?php echo $PHORUM['DATA']['LANG']['Search']; ?></a><?php if(isset($PHORUM['DATA']['LOGGEDIN']) && $PHORUM['DATA']['LOGGEDIN']==true){ ?>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['REGISTERPROFILE']; ?>"><?php echo $PHORUM['DATA']['LANG']['MyProfile']; ?></a><?php if(isset($PHORUM['DATA']['ENABLE_PM']) && !empty($PHORUM['DATA']['ENABLE_PM'])){ ?>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['PRIVATE_MESSAGES']['inbox_url']; ?>"><?php echo $PHORUM['DATA']['LANG']['PrivateMessages']; ?></a><?php } ?><?php } ?>
</div>

<div class="PhorumStdBlockHeader PhorumHeaderText">
<div class="PhorumColumnFloatLarge"><?php echo $PHORUM['DATA']['LANG']['LastPost']; ?></div>
<div class="PhorumColumnFloatSmall"><?php echo $PHORUM['DATA']['LANG']['Posts']; ?></div>
<div class="PhorumColumnFloatSmall"><?php echo $PHORUM['DATA']['LANG']['Threads']; ?></div>
<div style="margin-right: 425px"><?php echo $PHORUM['DATA']['LANG']['Forums']; ?></div>
</div>
<?php
$rclass="Alt";
?>
<div class="PhorumStdBlock">
<?php if(isset($PHORUM['DATA']['FORUMS']) && is_array($PHORUM['DATA']['FORUMS'])) foreach($PHORUM['DATA']['FORUMS'] as $PHORUM['TMP']['FORUMS']){ ?>
<?php
  if($rclass=="Alt")
    $rclass="";
  else
    $rclass="Alt";
?>
<div class="PhorumRowBlock<?php echo $rclass;?>">
<?php if(isset($PHORUM['TMP']['FORUMS']['folder_flag']) && !empty($PHORUM['TMP']['FORUMS']['folder_flag'])){ ?>
<div class="PhorumColumnFloatXLarge"><?php echo $PHORUM['DATA']['LANG']['ForumFolder']; ?></div>
<?php } else { ?>
<div class="PhorumColumnFloatLarge"><?php echo $PHORUM['TMP']['FORUMS']['last_post']; ?>&nbsp;</div>
<div class="PhorumColumnFloatSmall"><?php echo $PHORUM['TMP']['FORUMS']['message_count']; ?><?php if(isset($PHORUM['TMP']['FORUMS']['new_messages']) && !empty($PHORUM['TMP']['FORUMS']['new_messages'])){ ?> (<span class="PhorumNewFlag"><?php echo $PHORUM['TMP']['FORUMS']['new_messages']; ?> <?php echo $PHORUM['DATA']['LANG']['newflag']; ?></span>)<?php } ?></div>
<div class="PhorumColumnFloatSmall"><?php echo $PHORUM['TMP']['FORUMS']['thread_count']; ?><?php if(isset($PHORUM['TMP']['FORUMS']['new_threads']) && !empty($PHORUM['TMP']['FORUMS']['new_threads'])){ ?> (<span class="PhorumNewFlag"><?php echo $PHORUM['TMP']['FORUMS']['new_threads']; ?> <?php echo $PHORUM['DATA']['LANG']['newflag']; ?></span>)<?php } ?></div>
<?php } ?>
<div style="margin-right: 425px" class="PhorumLargeFont"><a href="<?php echo $PHORUM['TMP']['FORUMS']['url']; ?>"><?php echo $PHORUM['TMP']['FORUMS']['name']; ?></a></div>
<div style="margin-right: 425px" class="PhorumFloatingText"><?php echo $PHORUM['TMP']['FORUMS']['description']; ?> (<a href="<?php echo $PHORUM['TMP']['FORUMS']['rss']; ?>">RSS</a>)</div>
</div>
<?php } unset($PHORUM['TMP']['FORUMS']); ?>
</div>
