<?php if(!defined("PHORUM")) return; ?>
<?php if(isset($PHORUM['DATA']['ReportPost']) && !empty($PHORUM['DATA']['ReportPost'])){ ?>
<div class="PhorumUserError"><?php echo $PHORUM['DATA']['ReportPostMessage']; ?></div>
<?php } ?>

<div class="PhorumNavBlock" style="text-align: left;">
<div style="float: right;"><span class="PhorumNavHeading"><?php echo $PHORUM['DATA']['LANG']['GotoThread']; ?>:</span>&nbsp;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['NEWERTHREAD']; ?>"><?php echo $PHORUM['DATA']['LANG']['PrevPage']; ?></a>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['OLDERTHREAD']; ?>"><?php echo $PHORUM['DATA']['LANG']['NextPage']; ?></a></div>
<span class="PhorumNavHeading PhorumHeadingLeft"><?php echo $PHORUM['DATA']['LANG']['Goto']; ?>:</span>&nbsp;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['INDEX']; ?>"><?php echo $PHORUM['DATA']['LANG']['ForumList']; ?></a>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['TOP']; ?>"><?php echo $PHORUM['DATA']['LANG']['MessageList']; ?></a>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['POST']; ?>"><?php echo $PHORUM['DATA']['LANG']['NewTopic']; ?></a>&bull;<?php if(isset($PHORUM['DATA']['NEWPOLLURL']) && !empty($PHORUM['DATA']['NEWPOLLURL'])){ ?><a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['NEWPOLLURL']; ?>"><?php echo $PHORUM['DATA']['LANG']['mod_poll']['NewPoll']; ?></a>&bull;<?php } ?><a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['SEARCH']; ?>"><?php echo $PHORUM['DATA']['LANG']['Search']; ?></a>
</div>

<?php if(isset($PHORUM['DATA']['PAGES']) && !empty($PHORUM['DATA']['PAGES'])){ ?>
<div class="PhorumNavBlock" style="text-align: left;">
<div style="float: right;">
<span class="PhorumNavHeading"><?php echo $PHORUM['DATA']['LANG']['Pages']; ?>:</span>&nbsp;
<?php if(isset($PHORUM['DATA']['URL']['PREVPAGE']) && !empty($PHORUM['DATA']['URL']['PREVPAGE'])){ ?><a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['PREVPAGE']; ?>"><?php echo $PHORUM['DATA']['LANG']['PrevPage']; ?></a><?php } ?>
<?php if(isset($PHORUM['DATA']['URL']['FIRSTPAGE']) && !empty($PHORUM['DATA']['URL']['FIRSTPAGE'])){ ?><a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['FIRSTPAGE']; ?>"><?php echo $PHORUM['DATA']['LANG']['FirstPage']; ?>...</a><?php } ?>
<?php if(isset($PHORUM['DATA']['PAGES']) && is_array($PHORUM['DATA']['PAGES'])) foreach($PHORUM['DATA']['PAGES'] as $PHORUM['TMP']['PAGES']){ ?><a class="PhorumNavLink" href="<?php echo $PHORUM['TMP']['PAGES']['url']; ?>"><?php echo $PHORUM['TMP']['PAGES']['pageno']; ?></a><?php } unset($PHORUM['TMP']['PAGES']); ?>
<?php if(isset($PHORUM['DATA']['URL']['LASTPAGE']) && !empty($PHORUM['DATA']['URL']['LASTPAGE'])){ ?><a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['LASTPAGE']; ?>">...<?php echo $PHORUM['DATA']['LANG']['LastPage']; ?></a><?php } ?>
<?php if(isset($PHORUM['DATA']['URL']['NEXTPAGE']) && !empty($PHORUM['DATA']['URL']['NEXTPAGE'])){ ?><a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['NEXTPAGE']; ?>"><?php echo $PHORUM['DATA']['LANG']['NextPage']; ?></a><?php } ?>
</div>
<span class="PhorumNavHeading PhorumHeadingLeft"><?php echo $PHORUM['DATA']['LANG']['CurrentPage']; ?>:</span><?php echo $PHORUM['DATA']['CURRENTPAGE']; ?> <?php echo $PHORUM['DATA']['LANG']['of']; ?> <?php echo $PHORUM['DATA']['TOTALPAGES']; ?>
</div>
<?php } ?>

<?php if(isset($PHORUM['DATA']['MESSAGES']) && is_array($PHORUM['DATA']['MESSAGES'])) foreach($PHORUM['DATA']['MESSAGES'] as $PHORUM['TMP']['MESSAGES']){ ?>
<a name="msg-<?php echo $PHORUM['TMP']['MESSAGES']['message_id']; ?>"></a>
<div class="PhorumReadMessageBlock">
<table cellspacing="0" width="100%">
<tr><td style="width:80px;">
<img width="80" src="/images/profiles/<?php echo $PHORUM['TMP']['MESSAGES']['user_id']; ?>.jpg" />
</td>
<td >
<?php if(isset($PHORUM['TMP']['MESSAGES']['is_unapproved']) && !empty($PHORUM['TMP']['MESSAGES']['is_unapproved'])){ ?>
<div class="PhorumStdBlock">
<div class="PhorumReadBodyHead"><strong><?php echo $PHORUM['DATA']['LANG']['UnapprovedMessage']; ?></strong></div>
</div>
<?php } ?>
<div class="PhorumStdBlock">
<?php if(isset($PHORUM['TMP']['MESSAGES']['parent_id']) && $PHORUM['TMP']['MESSAGES']['parent_id']==0){ ?>
<div class="PhorumReadBodySubject"><?php echo $PHORUM['TMP']['MESSAGES']['subject']; ?></div>
<?php } else { ?>
<div class="PhorumReadBodyHead"><strong><?php echo $PHORUM['TMP']['MESSAGES']['subject']; ?></strong></div>
<?php } ?>
<div class="PhorumReadBodyHead"><?php echo $PHORUM['DATA']['LANG']['Postedby']; ?>: <strong><?php echo $PHORUM['TMP']['MESSAGES']['linked_author']; ?></strong> (<?php echo $PHORUM['TMP']['MESSAGES']['ip']; ?>)</div>
<div class="PhorumReadBodyHead"><?php echo $PHORUM['DATA']['LANG']['Date']; ?>: <?php echo $PHORUM['TMP']['MESSAGES']['datestamp']; ?></div>
<br />
<div class="PhorumReadBodyText"><?php echo $PHORUM['TMP']['MESSAGES']['body']; ?></div><br />
<?php if(isset($PHORUM['DATA']['ATTACHMENTS']) && !empty($PHORUM['DATA']['ATTACHMENTS'])){ ?>
<?php if(isset($PHORUM['TMP']['MESSAGES']['attachments']) && !empty($PHORUM['TMP']['MESSAGES']['attachments'])){ ?>
<?php echo $PHORUM['DATA']['LANG']['Attachments']; ?>: 
<?php $PHORUM["DATA"]['MESSAGE_ATTACHMENTS']=$PHORUM['TMP']['MESSAGES']['attachments']; ?>
<?php if(isset($PHORUM['DATA']['MESSAGE_ATTACHMENTS']) && is_array($PHORUM['DATA']['MESSAGE_ATTACHMENTS'])) foreach($PHORUM['DATA']['MESSAGE_ATTACHMENTS'] as $PHORUM['TMP']['MESSAGE_ATTACHMENTS']){ ?>
<a href="<?php echo $PHORUM['TMP']['MESSAGE_ATTACHMENTS']['url']; ?>"><?php echo $PHORUM['TMP']['MESSAGE_ATTACHMENTS']['name']; ?> (<?php echo $PHORUM['TMP']['MESSAGE_ATTACHMENTS']['size']; ?>)</a>&nbsp;&nbsp;
<?php } unset($PHORUM['TMP']['MESSAGE_ATTACHMENTS']); ?>
<?php } ?>
<?php } ?>
</div>
</td></tr></table>

<?php if(isset($PHORUM['DATA']['MODERATOR']) && $PHORUM['DATA']['MODERATOR']==true){ ?>
<div class="PhorumReadNavBlock" style="text-align: left;">
<span class="PhorumNavHeading PhorumHeadingLeft"><?php echo $PHORUM['DATA']['LANG']['Moderate']; ?>:</span>&nbsp;<?php if(isset($PHORUM['TMP']['MESSAGES']['threadstart']) && $PHORUM['TMP']['MESSAGES']['threadstart']==true){ ?>
<a class="PhorumNavLink" href="javascript:if(window.confirm('<?php echo $PHORUM['DATA']['LANG']['ConfirmDeleteThread']; ?>')) window.location='<?php echo $PHORUM['TMP']['MESSAGES']['delete_url2']; ?>';"><?php echo $PHORUM['DATA']['LANG']['DeleteThread']; ?></a>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['TMP']['MESSAGES']['move_url']; ?>"><?php echo $PHORUM['DATA']['LANG']['MoveThread']; ?></a><?php if(isset($PHORUM['TMP']['MESSAGES']['closed']) && $PHORUM['TMP']['MESSAGES']['closed']==false){ ?>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['TMP']['MESSAGES']['close_url']; ?>"><?php echo $PHORUM['DATA']['LANG']['CloseThread']; ?></a><?php } ?><?php if(isset($PHORUM['TMP']['MESSAGES']['closed']) && $PHORUM['TMP']['MESSAGES']['closed']==true){ ?>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['TMP']['MESSAGES']['reopen_url']; ?>"><?php echo $PHORUM['DATA']['LANG']['ReopenThread']; ?></a><?php } ?>
<?php } ?>
<?php if(isset($PHORUM['TMP']['MESSAGES']['threadstart']) && $PHORUM['TMP']['MESSAGES']['threadstart']==false){ ?>
<a class="PhorumNavLink" href="javascript:if(window.confirm('<?php echo $PHORUM['DATA']['LANG']['ConfirmDeleteMessage']; ?>')) window.location='<?php echo $PHORUM['TMP']['MESSAGES']['delete_url1']; ?>';"><?php echo $PHORUM['DATA']['LANG']['DeleteMessage']; ?></a>&bull;<a class="PhorumNavLink" href="javascript:if(window.confirm('<?php echo $PHORUM['DATA']['LANG']['ConfirmDeleteMessage']; ?>')) window.location='<?php echo $PHORUM['TMP']['MESSAGES']['delete_url2']; ?>';"><?php echo $PHORUM['DATA']['LANG']['DelMessReplies']; ?></a>
<?php } ?>
<?php if(isset($PHORUM['TMP']['MESSAGES']['is_unapproved']) && !empty($PHORUM['TMP']['MESSAGES']['is_unapproved'])){ ?> 
&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['TMP']['MESSAGES']['approve_url']; ?>"><?php echo $PHORUM['DATA']['LANG']['ApproveMessage']; ?></a>
<?php } else { ?>
&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['TMP']['MESSAGES']['hide_url']; ?>"><?php echo $PHORUM['DATA']['LANG']['HideMessage']; ?></a>
<?php } ?>
&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['TMP']['MESSAGES']['edit_url']; ?>"><?php echo $PHORUM['DATA']['LANG']['EditPost']; ?></a>
</div>
<?php } ?>

<div class="PhorumReadNavBlock" style="text-align: left;">
<span class="PhorumNavHeading PhorumHeadingLeft"><?php echo $PHORUM['DATA']['LANG']['Options']; ?>:</span>&nbsp;<a class="PhorumNavLink" href="<?php echo $PHORUM['TMP']['MESSAGES']['reply_url']; ?>"><?php echo $PHORUM['DATA']['LANG']['Reply']; ?></a>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['TMP']['MESSAGES']['quote_url']; ?>"><?php echo $PHORUM['DATA']['LANG']['QuoteMessage']; ?></a>&bull;<?php if(isset($PHORUM['DATA']['LOGGEDIN']) && !empty($PHORUM['DATA']['LOGGEDIN'])){ ?><a class="PhorumNavLink" href="<?php echo $PHORUM['TMP']['MESSAGES']['follow_url']; ?>"><?php echo $PHORUM['DATA']['LANG']['FollowThread']; ?></a>&bull;<?php } ?><a class="PhorumNavLink" href="javascript:if(window.confirm('<?php echo $PHORUM['DATA']['LANG']['ConfirmReportMessage']; ?>')) window.location='<?php echo $PHORUM['TMP']['MESSAGES']['report_url']; ?>';"><?php echo $PHORUM['DATA']['LANG']['Report']; ?></a><?php if(isset($PHORUM['TMP']['MESSAGES']['edit']) && $PHORUM['TMP']['MESSAGES']['edit']==1){ ?>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['TMP']['MESSAGES']['edituser_url']; ?>"><?php echo $PHORUM['DATA']['LANG']['EditPost']; ?></a><?php } ?>
</div>

</div>
<?php } unset($PHORUM['TMP']['MESSAGES']); ?>

<?php if(isset($PHORUM['DATA']['PAGES']) && !empty($PHORUM['DATA']['PAGES'])){ ?>
<div class="PhorumNavBlock" style="text-align: left;">
<div style="float: right;">
<span class="PhorumNavHeading"><?php echo $PHORUM['DATA']['LANG']['Pages']; ?>:</span>&nbsp;
<?php if(isset($PHORUM['DATA']['URL']['PREVPAGE']) && !empty($PHORUM['DATA']['URL']['PREVPAGE'])){ ?><a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['PREVPAGE']; ?>"><?php echo $PHORUM['DATA']['LANG']['PrevPage']; ?></a><?php } ?>
<?php if(isset($PHORUM['DATA']['URL']['FIRSTPAGE']) && !empty($PHORUM['DATA']['URL']['FIRSTPAGE'])){ ?><a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['FIRSTPAGE']; ?>"><?php echo $PHORUM['DATA']['LANG']['FirstPage']; ?>...</a><?php } ?>
<?php if(isset($PHORUM['DATA']['PAGES']) && is_array($PHORUM['DATA']['PAGES'])) foreach($PHORUM['DATA']['PAGES'] as $PHORUM['TMP']['PAGES']){ ?><a class="PhorumNavLink" href="<?php echo $PHORUM['TMP']['PAGES']['url']; ?>"><?php echo $PHORUM['TMP']['PAGES']['pageno']; ?></a><?php } unset($PHORUM['TMP']['PAGES']); ?>
<?php if(isset($PHORUM['DATA']['URL']['LASTPAGE']) && !empty($PHORUM['DATA']['URL']['LASTPAGE'])){ ?><a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['LASTPAGE']; ?>">...<?php echo $PHORUM['DATA']['LANG']['LastPage']; ?></a><?php } ?>
<?php if(isset($PHORUM['DATA']['URL']['NEXTPAGE']) && !empty($PHORUM['DATA']['URL']['NEXTPAGE'])){ ?><a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['NEXTPAGE']; ?>"><?php echo $PHORUM['DATA']['LANG']['NextPage']; ?></a><?php } ?>
</div>
<span class="PhorumNavHeading PhorumHeadingLeft"><?php echo $PHORUM['DATA']['LANG']['CurrentPage']; ?>:</span><?php echo $PHORUM['DATA']['CURRENTPAGE']; ?> <?php echo $PHORUM['DATA']['LANG']['of']; ?> <?php echo $PHORUM['DATA']['TOTALPAGES']; ?>
</div>
<?php } ?>
<br /><br />
