<?php if(!defined("PHORUM")) return; ?>
<div align="center">

<div class="PhorumNavBlock PhorumNarrowBlock" style="text-align: left;">
<span class="PhorumNavHeading PhorumHeadingLeft"><?php echo $PHORUM['DATA']['LANG']['Goto']; ?>:</span>&nbsp;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['INDEX']; ?>"><?php echo $PHORUM['DATA']['LANG']['ForumList']; ?></a>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['TOP']; ?>"><?php echo $PHORUM['DATA']['LANG']['MessageList']; ?></a>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['SEARCH']; ?>"><?php echo $PHORUM['DATA']['LANG']['Search']; ?></a><?php if(isset($PHORUM['DATA']['LOGGEDIN']) && $PHORUM['DATA']['LOGGEDIN']==true){ ?>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['REGISTERPROFILE']; ?>"><?php echo $PHORUM['DATA']['LANG']['MyProfile']; ?></a><?php if(isset($PHORUM['DATA']['ENABLE_PM']) && !empty($PHORUM['DATA']['ENABLE_PM'])){ ?>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['PRIVATE_MESSAGES']['inbox_url']; ?>"><?php echo $PHORUM['DATA']['LANG']['PrivateMessages']; ?></a><?php } ?><?php } ?></a>
</div>

<form method="POST" action="<?php echo $PHORUM['DATA']['URL']['ACTION']; ?>">
<?php echo $PHORUM['DATA']['POST_VARS']; ?>
<input type="hidden" name="forum_id" value="<?php echo $PHORUM['DATA']['FORM']['forum_id']; ?>" />
<input type="hidden" name="thread" value="<?php echo $PHORUM['DATA']['FORM']['thread_id']; ?>" />
<input type="hidden" name="mod_step" value="<?php echo $PHORUM['DATA']['FORM']['mod_step']; ?>" />

<div class="PhorumStdBlockHeader PhorumNarrowBlock" style="text-align: left;"><span class="PhorumHeadingLeft"><?php echo $PHORUM['DATA']['LANG']['MoveThread']; ?></span></div>
<div class="PhorumStdBlock PhorumNarrowBlock" style="text-align: left;">
<div class="PhorumFloatingText">
  <?php echo $PHORUM['DATA']['LANG']['MoveThreadTo']; ?>:<br />
  <select name="moveto">
  <option value="0"><?php echo $PHORUM['DATA']['LANG']['SelectForum']; ?></option>
  <?php if(isset($PHORUM['DATA']['FORUMS']) && is_array($PHORUM['DATA']['FORUMS'])) foreach($PHORUM['DATA']['FORUMS'] as $PHORUM['TMP']['FORUMS']){ ?>
  <option value="<?php echo $PHORUM['TMP']['FORUMS']['forum_id']; ?>"><?php echo $PHORUM['TMP']['FORUMS']['name']; ?></option>
  <?php } unset($PHORUM['TMP']['FORUMS']); ?>
  </select>
  <input type="submit" class="PhorumSubmit" name="move" value="<?php echo $PHORUM['DATA']['LANG']['MoveThread']; ?>" />
</div>
</div>

</form>

</div>
