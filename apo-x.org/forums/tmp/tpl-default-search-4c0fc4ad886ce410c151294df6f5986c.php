<?php if(!defined("PHORUM")) return; ?>
<div class="PhorumNavBlock" style="text-align: left;">
<span class="PhorumNavHeading PhorumHeadingLeft"><?php echo $PHORUM['DATA']['LANG']['Goto']; ?>:</span>&nbsp;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['INDEX']; ?>"><?php echo $PHORUM['DATA']['LANG']['ForumList']; ?></a>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['TOP']; ?>"><?php echo $PHORUM['DATA']['LANG']['MessageList']; ?></a>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['POST']; ?>"><?php echo $PHORUM['DATA']['LANG']['NewTopic']; ?></a><?php if(isset($PHORUM['DATA']['LOGGEDIN']) && $PHORUM['DATA']['LOGGEDIN']==true){ ?>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['REGISTERPROFILE']; ?>"><?php echo $PHORUM['DATA']['LANG']['MyProfile']; ?></a><?php if(isset($PHORUM['DATA']['ENABLE_PM']) && !empty($PHORUM['DATA']['ENABLE_PM'])){ ?>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['PRIVATE_MESSAGES']['inbox_url']; ?>"><?php echo $PHORUM['DATA']['LANG']['PrivateMessages']; ?></a><?php } ?><?php } ?></a>
</div>


<form action="<?php echo $PHORUM['DATA']['URL']['ACTION']; ?>" method="get" style="display: inline;">
<?php echo $PHORUM['DATA']['POST_VARS']; ?>
<input type="hidden" name="forum_id" value="<?php echo $PHORUM['DATA']['SEARCH']['forum_id']; ?>" />

<div class="PhorumStdBlockHeader PhorumHeaderText" style="text-align: left;"><?php echo $PHORUM['DATA']['LANG']['Search']; ?></div>

<div class="PhorumStdBlock" style="text-align: center;">
<div class="PhorumFloatingText">
<input type="text" name="search" size="30" maxlength="" value="<?php echo $PHORUM['DATA']['SEARCH']['safe_search']; ?>" />&nbsp;<input type="submit" value="<?php echo $PHORUM['DATA']['LANG']['Search']; ?>" />
</div>
<div class="PhorumFloatingText" align="center">
<table class="PhorumFormTable" cellspacing="0" border="0">
<tr>
    <td><select name="match_forum"><option value="ALL" <?php if(isset($PHORUM['DATA']['SEARCH']['match_forum']) && $PHORUM['DATA']['SEARCH']['match_forum']=="ALL"){ ?>selected<?php } ?>><?php echo $PHORUM['DATA']['LANG']['MatchAllForums']; ?></option><?php if(isset($PHORUM['DATA']['SEARCH']['allow_match_one_forum']) && !empty($PHORUM['DATA']['SEARCH']['allow_match_one_forum'])){ ?><option value="THISONE" <?php if(isset($PHORUM['DATA']['SEARCH']['match_forum']) && $PHORUM['DATA']['SEARCH']['match_forum']=="THISONE"){ ?>selected<?php } ?>><?php echo $PHORUM['DATA']['LANG']['MatchThisForum']; ?></option><?php } ?></select></td>
    <td>&nbsp;&nbsp;<input type="checkbox" name="body" <?php if(isset($PHORUM['DATA']['SEARCH']['body']) && !empty($PHORUM['DATA']['SEARCH']['body'])){ ?>checked<?php } ?> value="1" />&nbsp;<?php echo $PHORUM['DATA']['LANG']['SearchBody']; ?><br /></td>
</tr>
<tr>
    <td><select name="match_type"><option value="ALL" <?php if(isset($PHORUM['DATA']['SEARCH']['match_type']) && $PHORUM['DATA']['SEARCH']['match_type']=="ALL"){ ?>selected<?php } ?>><?php echo $PHORUM['DATA']['LANG']['MatchAll']; ?></option><option value="ANY" <?php if(isset($PHORUM['DATA']['SEARCH']['match_type']) && $PHORUM['DATA']['SEARCH']['match_type']=="ANY"){ ?>selected<?php } ?>><?php echo $PHORUM['DATA']['LANG']['MatchAny']; ?></option><option value="PHRASE" <?php if(isset($PHORUM['DATA']['SEARCH']['match_type']) && $PHORUM['DATA']['SEARCH']['match_type']=="PHRASE"){ ?>selected<?php } ?>><?php echo $PHORUM['DATA']['LANG']['MatchPhrase']; ?></option></select></td>
    <td>&nbsp;&nbsp;<input type="checkbox" name="author" <?php if(isset($PHORUM['DATA']['SEARCH']['author']) && !empty($PHORUM['DATA']['SEARCH']['author'])){ ?>checked<?php } ?> value="1" />&nbsp;<?php echo $PHORUM['DATA']['LANG']['SearchAuthor']; ?></td>
</tr>
<tr>
    <td><select name="match_dates"><option value="30" <?php if(isset($PHORUM['DATA']['SEARCH']['match_dates']) && $PHORUM['DATA']['SEARCH']['match_dates']==30){ ?>selected<?php } ?>><?php echo $PHORUM['DATA']['LANG']['Last30Days']; ?></option><option value="90" <?php if(isset($PHORUM['DATA']['SEARCH']['match_dates']) && $PHORUM['DATA']['SEARCH']['match_dates']==90){ ?>selected<?php } ?>><?php echo $PHORUM['DATA']['LANG']['Last90Days']; ?></option><option value="365" <?php if(isset($PHORUM['DATA']['SEARCH']['match_dates']) && $PHORUM['DATA']['SEARCH']['match_dates']==365){ ?>selected<?php } ?>><?php echo $PHORUM['DATA']['LANG']['Last365Days']; ?></option><option value="0" <?php if(isset($PHORUM['DATA']['SEARCH']['match_dates']) && $PHORUM['DATA']['SEARCH']['match_dates']==0){ ?>selected<?php } ?>><?php echo $PHORUM['DATA']['LANG']['AllDates']; ?></option></select><br /></td>
    <td>&nbsp;&nbsp;<input type="checkbox" name="subject" <?php if(isset($PHORUM['DATA']['SEARCH']['subject']) && !empty($PHORUM['DATA']['SEARCH']['subject'])){ ?>checked<?php } ?> value="1" />&nbsp;<?php echo $PHORUM['DATA']['LANG']['SearchSubject']; ?></td>
</tr>
</table>
</div>
</div>

</form>
<br />
<?php if(isset($PHORUM['DATA']['SEARCH']['noresults']) && !empty($PHORUM['DATA']['SEARCH']['noresults'])){ ?>
<div align="center">
<div class="PhorumStdBlockHeader PhorumNarrowBlock PhorumHeaderText" style="text-align: left;"><?php echo $PHORUM['DATA']['LANG']['NoResults']; ?></div>

<div class="PhorumStdBlock PhorumNarrowBlock" style="text-align: left;">
<div class="PhorumFloatingText"><?php echo $PHORUM['DATA']['LANG']['NoResults']; ?></div>
</div>
</div>
<?php } ?>

<?php if(isset($PHORUM['DATA']['SEARCH']['showresults']) && !empty($PHORUM['DATA']['SEARCH']['showresults'])){ ?>

<?php if(isset($PHORUM['DATA']['PAGES']) && !empty($PHORUM['DATA']['PAGES'])){ ?>
<div class="PhorumNavBlock" style="text-align: left;">
<div style="float: right;"><span class="PhorumNavHeading"><?php echo $PHORUM['DATA']['LANG']['Pages']; ?>:</span>&nbsp;
<?php if(isset($PHORUM['DATA']['URL']['PREVPAGE']) && !empty($PHORUM['DATA']['URL']['PREVPAGE'])){ ?><a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['PREVPAGE']; ?>"><?php echo $PHORUM['DATA']['LANG']['PrevPage']; ?></a><?php } ?>
<?php if(isset($PHORUM['DATA']['URL']['FIRSTPAGE']) && !empty($PHORUM['DATA']['URL']['FIRSTPAGE'])){ ?><a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['FIRSTPAGE']; ?>"><?php echo $PHORUM['DATA']['LANG']['FirstPage']; ?>...</a><?php } ?>
<?php if(isset($PHORUM['DATA']['PAGES']) && is_array($PHORUM['DATA']['PAGES'])) foreach($PHORUM['DATA']['PAGES'] as $PHORUM['TMP']['PAGES']){ ?><a class="PhorumNavLink" href="<?php echo $PHORUM['TMP']['PAGES']['url']; ?>"><?php echo $PHORUM['TMP']['PAGES']['pageno']; ?></a><?php } unset($PHORUM['TMP']['PAGES']); ?>
<?php if(isset($PHORUM['DATA']['URL']['LASTPAGE']) && !empty($PHORUM['DATA']['URL']['LASTPAGE'])){ ?><a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['LASTPAGE']; ?>">...<?php echo $PHORUM['DATA']['LANG']['LastPage']; ?></a><?php } ?>
<?php if(isset($PHORUM['DATA']['URL']['NEXTPAGE']) && !empty($PHORUM['DATA']['URL']['NEXTPAGE'])){ ?><a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['NEXTPAGE']; ?>"><?php echo $PHORUM['DATA']['LANG']['NextPage']; ?></a><?php } ?>
</div>
<span class="PhorumNavHeading PhorumHeadingLeft"><?php echo $PHORUM['DATA']['LANG']['CurrentPage']; ?>:</span><?php echo $PHORUM['DATA']['CURRENTPAGE']; ?> <?php echo $PHORUM['DATA']['LANG']['of']; ?> <?php echo $PHORUM['DATA']['TOTALPAGES']; ?>
</div>
<?php } ?>

<div class="PhorumStdBlockHeader" style="text-align: left;"><span class="PhorumHeadingLeft"><?php echo $PHORUM['DATA']['LANG']['Results']; ?> <?php echo $PHORUM['DATA']['RANGE_START']; ?> - <?php echo $PHORUM['DATA']['RANGE_END']; ?> <?php echo $PHORUM['DATA']['LANG']['of']; ?> <?php echo $PHORUM['DATA']['TOTAL']; ?></span></div>

<div class="PhorumStdBlock">
<?php if(isset($PHORUM['DATA']['MATCHES']) && is_array($PHORUM['DATA']['MATCHES'])) foreach($PHORUM['DATA']['MATCHES'] as $PHORUM['TMP']['MATCHES']){ ?>
<div class="PhorumRowBlock">
<div class="PhorumColumnFloatLarge"><?php echo $PHORUM['TMP']['MATCHES']['datestamp']; ?></div>
<div class="PhorumColumnFloatMedium"><?php echo $PHORUM['TMP']['MATCHES']['author']; ?></div>
<div style="margin-right: 370px" class="PhorumLargeFont"><?php echo $PHORUM['TMP']['MATCHES']['number']; ?>.&nbsp;<a href="<?php echo $PHORUM['TMP']['MATCHES']['url']; ?>"><?php echo $PHORUM['TMP']['MATCHES']['subject']; ?></a></div>
<div class="PhorumFloatingText"><?php echo $PHORUM['TMP']['MATCHES']['short_body']; ?><br /><?php echo $PHORUM['DATA']['LANG']['Forum']; ?>: <a href="<?php echo $PHORUM['TMP']['MATCHES']['forum_url']; ?>"><?php echo $PHORUM['TMP']['MATCHES']['forum_name']; ?></a></div>
</div>
<?php } unset($PHORUM['TMP']['MATCHES']); ?>
</div>

<?php if(isset($PHORUM['DATA']['PAGES']) && !empty($PHORUM['DATA']['PAGES'])){ ?>
<div class="PhorumNavBlock" style="text-align: left;">
<div style="float: right;"><span class="PhorumNavHeading"><?php echo $PHORUM['DATA']['LANG']['Pages']; ?>:</span>&nbsp;
<?php if(isset($PHORUM['DATA']['URL']['PREVPAGE']) && !empty($PHORUM['DATA']['URL']['PREVPAGE'])){ ?><a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['PREVPAGE']; ?>"><?php echo $PHORUM['DATA']['LANG']['PrevPage']; ?></a><?php } ?>
<?php if(isset($PHORUM['DATA']['URL']['FIRSTPAGE']) && !empty($PHORUM['DATA']['URL']['FIRSTPAGE'])){ ?><a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['FIRSTPAGE']; ?>"><?php echo $PHORUM['DATA']['LANG']['FirstPage']; ?>...</a><?php } ?>
<?php if(isset($PHORUM['DATA']['PAGES']) && is_array($PHORUM['DATA']['PAGES'])) foreach($PHORUM['DATA']['PAGES'] as $PHORUM['TMP']['PAGES']){ ?><a class="PhorumNavLink" href="<?php echo $PHORUM['TMP']['PAGES']['url']; ?>"><?php echo $PHORUM['TMP']['PAGES']['pageno']; ?></a><?php } unset($PHORUM['TMP']['PAGES']); ?>
<?php if(isset($PHORUM['DATA']['URL']['LASTPAGE']) && !empty($PHORUM['DATA']['URL']['LASTPAGE'])){ ?><a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['LASTPAGE']; ?>">...<?php echo $PHORUM['DATA']['LANG']['LastPage']; ?></a><?php } ?>
<?php if(isset($PHORUM['DATA']['URL']['NEXTPAGE']) && !empty($PHORUM['DATA']['URL']['NEXTPAGE'])){ ?><a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['NEXTPAGE']; ?>"><?php echo $PHORUM['DATA']['LANG']['NextPage']; ?></a><?php } ?>
</div>
<span class="PhorumNavHeading PhorumHeadingLeft"><?php echo $PHORUM['DATA']['LANG']['CurrentPage']; ?>:</span><?php echo $PHORUM['DATA']['CURRENTPAGE']; ?> <?php echo $PHORUM['DATA']['LANG']['of']; ?> <?php echo $PHORUM['DATA']['TOTALPAGES']; ?>
</div>
<?php } ?>

<div class="PhorumNavBlock" style="text-align: left;">
<span class="PhorumNavHeading PhorumHeadingLeft"><?php echo $PHORUM['DATA']['LANG']['Goto']; ?>:</span>&nbsp;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URLINDEX']; ?>"><?php echo $PHORUM['DATA']['LANG']['ForumList']; ?></a>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URLTOP']; ?>"><?php echo $PHORUM['DATA']['LANG']['MessageList']; ?></a>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URLPOST']; ?>"><?php echo $PHORUM['DATA']['LANG']['NewTopic']; ?></a><?php if(isset($PHORUM['DATA']['LOGGEDIN']) && $PHORUM['DATA']['LOGGEDIN']==true){ ?>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URLREGISTERPROFILE']; ?>"><?php echo $PHORUM['DATA']['LANG']['MyProfile']; ?></a>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URLLOGINOUT']; ?>"><?php echo $PHORUM['DATA']['LANG']['LogOut']; ?></a><?php } ?><?php if(isset($PHORUM['DATA']['LOGGEDIN']) && $PHORUM['DATA']['LOGGEDIN']==false){ ?>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URLLOGINOUT']; ?>"><?php echo $PHORUM['DATA']['LANG']['LogIn']; ?></a><?php } ?></a>
</div>
<?php } else { ?>
<div class="PhorumStdBlockHeader" style="text-align: left;">
    <span class="PhorumHeadingLeft">
    <?php echo $PHORUM['DATA']['LANG']['SearchTips']; ?>
    </span>
</div>
<div class="PhorumStdBlock">
<?php echo $PHORUM['DATA']['LANG']['SearchTip']; ?>
</div>

<?php } ?>
