<?php if(!defined("PHORUM")) return; ?>
<div class="PhorumNavBlock" style="text-align: left;">
<span class="PhorumNavHeading PhorumHeadingLeft"><?php echo $PHORUM['DATA']['LANG']['Goto']; ?>:</span>&nbsp;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['INDEX']; ?>"><?php echo $PHORUM['DATA']['LANG']['ForumList']; ?></a>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['POST']; ?>"><?php echo $PHORUM['DATA']['LANG']['NewTopic']; ?></a>&bull;<?php if(isset($PHORUM['DATA']['NEWPOLLURL']) && !empty($PHORUM['DATA']['NEWPOLLURL'])){ ?><a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['NEWPOLLURL']; ?>"><?php echo $PHORUM['DATA']['LANG']['mod_poll']['NewPoll']; ?></a>&bull;<?php } ?><a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['SEARCH']; ?>"><?php echo $PHORUM['DATA']['LANG']['Search']; ?></a><?php if(isset($PHORUM['DATA']['LOGGEDIN']) && $PHORUM['DATA']['LOGGEDIN']==true){ ?>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['REGISTERPROFILE']; ?>"><?php echo $PHORUM['DATA']['LANG']['MyProfile']; ?></a><?php if(isset($PHORUM['DATA']['ENABLE_PM']) && !empty($PHORUM['DATA']['ENABLE_PM'])){ ?>&bull;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['PRIVATE_MESSAGES']['inbox_url']; ?>"><?php echo $PHORUM['DATA']['LANG']['PrivateMessages']; ?></a><?php } ?><?php } ?>
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


<table border="0" cellspacing="0" class="PhorumStdTable">
<tr>
    <th class="PhorumTableHeader" align="left"><?php echo $PHORUM['DATA']['LANG']['Subject']; ?></th>
<?php if(isset($PHORUM['DATA']['VIEWCOUNT_COLUMN']) && !empty($PHORUM['DATA']['VIEWCOUNT_COLUMN'])){ ?>    <th class="PhorumTableHeader" align="center" width="40"><?php echo $PHORUM['DATA']['LANG']['Views']; ?></th><?php } ?>
    <th class="PhorumTableHeader" align="center" nowrap="nowrap" width="80"><?php echo $PHORUM['DATA']['LANG']['Posts']; ?>&nbsp;</th>
    <th class="PhorumTableHeader" align="left" nowrap="nowrap" width="150"><?php echo $PHORUM['DATA']['LANG']['StartedBy']; ?>&nbsp;</th>
    <th class="PhorumTableHeader" align="left" nowrap="nowrap" width="150"><?php echo $PHORUM['DATA']['LANG']['LastPost']; ?>&nbsp;</th>
</tr>
<?php
$rclass="Alt";
?>
<?php if(isset($PHORUM['DATA']['ROWS']) && is_array($PHORUM['DATA']['ROWS'])) foreach($PHORUM['DATA']['ROWS'] as $PHORUM['TMP']['ROWS']){ ?>
<?php
  if($rclass=="Alt")
    $rclass="";
  else
    $rclass="Alt";
?>
<tr>
    <td class="PhorumTableRow<?php echo $rclass;?>"><?php echo $PHORUM['TMP']['marker'] ?><?php if(isset($PHORUM['TMP']['ROWS']['sort']) && $PHORUM['TMP']['ROWS']['sort']==PHORUM_SORT_STICKY){ ?><span class="PhorumListSubjPrefix"><?php echo $PHORUM['DATA']['LANG']['Sticky']; ?>:</span><?php } ?><?php if(isset($PHORUM['TMP']['ROWS']['sort']) && $PHORUM['TMP']['ROWS']['sort']==PHORUM_SORT_ANNOUNCEMENT){ ?><span class="PhorumListSubjPrefix"><?php echo $PHORUM['DATA']['LANG']['Announcement']; ?>:</span><?php } ?><a href="<?php echo $PHORUM['TMP']['ROWS']['url']; ?>"><?php echo $PHORUM['TMP']['ROWS']['subject']; ?></a><?php if(isset($PHORUM['TMP']['ROWS']['new']) && !empty($PHORUM['TMP']['ROWS']['new'])){ ?>&nbsp;<span class="PhorumNewFlag"><?php echo $PHORUM['TMP']['ROWS']['new']; ?></span><?php } ?><?php if(isset($PHORUM['TMP']['ROWS']['pages']) && !empty($PHORUM['TMP']['ROWS']['pages'])){ ?><span class="PhorumListPageLink">&nbsp;&nbsp;&nbsp;<?php echo $PHORUM['DATA']['LANG']['Pages']; ?>: <?php echo $PHORUM['TMP']['ROWS']['pages']; ?></span><?php } ?><?php if(isset($PHORUM['DATA']['MODERATOR']) && $PHORUM['DATA']['MODERATOR']==true){ ?><br /><span class="PhorumListModLink"><a href="javascript:if(window.confirm('<?php echo $PHORUM['DATA']['LANG']['ConfirmDeleteThread']; ?>')) window.location='<?php echo $PHORUM['TMP']['ROWS']['delete_url2']; ?>';"><?php echo $PHORUM['DATA']['LANG']['DeleteThread']; ?></a>&nbsp;&#8226;&nbsp;<a href="<?php echo $PHORUM['TMP']['ROWS']['move_url']; ?>"><?php echo $PHORUM['DATA']['LANG']['MoveThread']; ?></a></span><?php } ?></td>
<?php if(isset($PHORUM['DATA']['VIEWCOUNT_COLUMN']) && !empty($PHORUM['DATA']['VIEWCOUNT_COLUMN'])){ ?>    <td class="PhorumTableRow<?php echo $rclass;?>" align="center"><?php echo $PHORUM['TMP']['ROWS']['viewcount']; ?>&nbsp;</td>    <?php } ?>
    <td class="PhorumTableRow<?php echo $rclass;?>" align="center" nowrap="nowrap"><?php echo $PHORUM['TMP']['ROWS']['thread_count']; ?>&nbsp;</td>
    <td class="PhorumTableRow<?php echo $rclass;?>" nowrap="nowrap"><?php echo $PHORUM['TMP']['ROWS']['linked_author']; ?>&nbsp;</td>
    <td class="PhorumTableRow<?php echo $rclass;?> PhorumSmallFont" nowrap="nowrap"><?php echo $PHORUM['TMP']['ROWS']['lastpost']; ?>&nbsp;<br /><span class="PhorumListSubText"><a href="<?php echo $PHORUM['TMP']['ROWS']['last_post_url']; ?>"><?php echo $PHORUM['DATA']['LANG']['LastPostLink']; ?></a> <?php echo $PHORUM['DATA']['LANG']['by']; ?> <?php echo $PHORUM['TMP']['ROWS']['last_post_by']; ?></span></td>
</tr>
<?php } unset($PHORUM['TMP']['ROWS']); ?>

</table>


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

<div class="PhorumNavBlock" style="text-align: left;">
<span class="PhorumNavHeading PhorumHeadingLeft"><?php echo $PHORUM['DATA']['LANG']['Options']; ?>:</span><?php if(isset($PHORUM['DATA']['LOGGEDIN']) && $PHORUM['DATA']['LOGGEDIN']==true){ ?>&nbsp;<a class="PhorumNavLink" href="<?php echo $PHORUM['DATA']['URL']['MARKREAD']; ?>"><?php echo $PHORUM['DATA']['LANG']['MarkRead']; ?></a><?php } ?>
</div>
