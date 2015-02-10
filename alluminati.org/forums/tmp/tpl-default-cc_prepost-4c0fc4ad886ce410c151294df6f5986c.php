<?php if(!defined("PHORUM")) return; ?>
<table border="0" cellspacing="0" class="PhorumStdTable">
<?php if(isset($PHORUM['DATA']['PREPOST']) && is_array($PHORUM['DATA']['PREPOST'])) foreach($PHORUM['DATA']['PREPOST'] as $PHORUM['TMP']['PREPOST']){ ?>
<?php if(isset($PHORUM['TMP']['PREPOST']['checkvar']) && $PHORUM['TMP']['PREPOST']['checkvar']==1){ ?>
    <tr>
      <th class="PhorumTableHeader" align="left" colspan="3">
      <div class="PhorumLargeFont">
      <?php echo $PHORUM['DATA']['LANG']['UnapprovedMessages']; ?>&nbsp;:&nbsp;<?php echo $PHORUM['TMP']['PREPOST']['forumname']; ?>
      </div>      
      </th>
    </tr>
    <tr>
        <th class="PhorumTableHeader" align="left"><?php echo $PHORUM['DATA']['LANG']['Subject']; ?></th>
        <th class="PhorumTableHeader" align="left" nowrap="nowrap" width="150"><?php echo $PHORUM['DATA']['LANG']['Author']; ?>&nbsp;</th>
        <th class="PhorumTableHeader" align="left" nowrap="nowrap" width="150"><?php echo $PHORUM['DATA']['LANG']['Date']; ?>&nbsp;</th>
    </tr>
<?php } ?>
    <tr>
        <td class="PhorumListTableRow"><?php echo $PHORUM['TMP']['marker'] ?><a href="<?php echo $PHORUM['TMP']['PREPOST']['url']; ?>" target="_blank"><?php echo $PHORUM['TMP']['PREPOST']['subject']; ?></a><br /><span class="PhorumListModLink">&nbsp;&nbsp;&nbsp;&nbsp;<a class="PhorumListModLink" href="<?php echo $PHORUM['TMP']['PREPOST']['delete_url']; ?>"><?php echo $PHORUM['DATA']['LANG']['DeleteMessage']; ?></a>&nbsp;&bull;&nbsp;<a class="PhorumListModLink" href="<?php echo $PHORUM['TMP']['PREPOST']['approve_url']; ?>"><?php echo $PHORUM['DATA']['LANG']['ApproveMessage']; ?></a>&nbsp;&bull;&nbsp;<a class="PhorumListModLink" href="<?php echo $PHORUM['TMP']['PREPOST']['approve_tree_url']; ?>"><?php echo $PHORUM['DATA']['LANG']['ApproveMessageReplies']; ?></a></span></td>
        <td class="PhorumListTableRow" nowrap="nowrap" width="150"><?php echo $PHORUM['TMP']['PREPOST']['linked_author']; ?>&nbsp;</td>
        <td class="PhorumListTableRowSmall" nowrap="nowrap" width="150"><?php echo $PHORUM['TMP']['PREPOST']['short_datestamp']; ?>&nbsp;</td>
    </tr>
<?php } unset($PHORUM['TMP']['PREPOST']); ?>
</table>