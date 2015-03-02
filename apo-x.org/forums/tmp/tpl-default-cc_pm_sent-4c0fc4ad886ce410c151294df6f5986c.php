<?php if(!defined("PHORUM")) return; ?>
<div class="PhorumLargeFont"><?php echo $PHORUM['DATA']['LANG']['PrivateMessages']; ?> : <?php echo $PHORUM['DATA']['LANG']['SentItems']; ?></div>
<br />
<form action="<?php echo $PHORUM['DATA']['ACTION']; ?>" method="post">
<?php echo $PHORUM['DATA']['POST_VARS']; ?>
<input type="hidden" name="panel" value="pm" />
<input type="hidden" name="forum_id" value="<?php echo $PHORUM['DATA']['FORUM_ID']; ?>" />
<input type="hidden" name="action" value="delete" />
<table border="0" cellspacing="0" class="PhorumStdTable">
    <tr>
        <th class="PhorumTableHeader" align="left">&nbsp;</th>
        <th class="PhorumTableHeader" align="left"><?php echo $PHORUM['DATA']['LANG']['Subject']; ?></th>
        <th class="PhorumTableHeader" align="left" nowrap="nowrap" width="150"><?php echo $PHORUM['DATA']['LANG']['To']; ?>&nbsp;</th>
        <th class="PhorumTableHeader" align="left" nowrap="nowrap" width="150"><?php echo $PHORUM['DATA']['LANG']['Date']; ?>&nbsp;</th>
        <th class="PhorumTableHeader" align="left" nowrap="nowrap" width="150"><?php echo $PHORUM['DATA']['LANG']['Received']; ?>&nbsp;</th>
    </tr>
<?php if(isset($PHORUM['DATA']['SENT']) && is_array($PHORUM['DATA']['SENT'])) foreach($PHORUM['DATA']['SENT'] as $PHORUM['TMP']['SENT']){ ?>
    <tr>
        <td class="PhorumListTableRow"><input type="checkbox" name="from_delete[]" value="<?php echo $PHORUM['TMP']['SENT']['message_id']; ?>" /></td>
        <td class="PhorumListTableRow"><a href="<?php echo $PHORUM['TMP']['SENT']['read_url']; ?>"><?php echo $PHORUM['TMP']['SENT']['subject']; ?></a></td>
        <td class="PhorumListTableRow" nowrap="nowrap" width="150"><a href="<?php echo $PHORUM['TMP']['SENT']['profile_url']; ?>"><?php echo $PHORUM['TMP']['SENT']['to']; ?></a>&nbsp;</td>
        <td class="PhorumListTableRowSmall" nowrap="nowrap" width="150"><?php echo $PHORUM['TMP']['SENT']['date']; ?>&nbsp;</td>
        <td class="PhorumListTableRowSmall" nowrap="nowrap" width="150"><?php if(isset($PHORUM['TMP']['SENT']['read']) && !empty($PHORUM['TMP']['SENT']['read'])){ ?><?php echo $PHORUM['DATA']['LANG']['Yes']; ?><?php } else { ?><?php echo $PHORUM['DATA']['LANG']['No']; ?><?php } ?></td>
    </tr>
<?php } unset($PHORUM['TMP']['SENT']); ?>
</table>
<div class="PhorumNavBlock" style="text-align: left;">
<input type="submit" class="PhorumSubmit" value="<?php echo $PHORUM['DATA']['LANG']['Delete']; ?>" />
</div>

</form>
