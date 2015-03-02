<?php if(!defined("PHORUM")) return; ?>
<div class="PhorumLargeFont"><?php echo $PHORUM['DATA']['LANG']['PrivateMessages']; ?> : <?php echo $PHORUM['DATA']['LANG']['INBOX']; ?></div>
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
        <th class="PhorumTableHeader" align="left" nowrap="nowrap" width="150"><?php echo $PHORUM['DATA']['LANG']['From']; ?>&nbsp;</th>
        <th class="PhorumTableHeader" align="left" nowrap="nowrap" width="150"><?php echo $PHORUM['DATA']['LANG']['Date']; ?>&nbsp;</th>
    </tr>
<?php if(isset($PHORUM['DATA']['INBOX']) && is_array($PHORUM['DATA']['INBOX'])) foreach($PHORUM['DATA']['INBOX'] as $PHORUM['TMP']['INBOX']){ ?>
    <tr>
        <td class="PhorumListTableRow"><input type="checkbox" name="to_delete[]" value="<?php echo $PHORUM['TMP']['INBOX']['message_id']; ?>" /></td>
        <td class="PhorumListTableRow"><a href="<?php echo $PHORUM['TMP']['INBOX']['read_url']; ?>"><?php echo $PHORUM['TMP']['INBOX']['subject']; ?></a><?php if(isset($PHORUM['TMP']['INBOX']['read']) && $PHORUM['TMP']['INBOX']['read']==0){ ?><span class="PhorumNewFlag">&nbsp;<?php echo $PHORUM['DATA']['LANG']['newflag']; ?></span><?php } ?></td>
        <td class="PhorumListTableRow" nowrap="nowrap" width="150"><a href="<?php echo $PHORUM['TMP']['INBOX']['profile_url']; ?>"><?php echo $PHORUM['TMP']['INBOX']['from']; ?></a>&nbsp;</td>
        <td class="PhorumListTableRowSmall" nowrap="nowrap" width="150"><?php echo $PHORUM['TMP']['INBOX']['date']; ?>&nbsp;</td>
    </tr>
<?php } unset($PHORUM['TMP']['INBOX']); ?>
</table>
<div class="PhorumNavBlock" style="text-align: left;">
<input type="submit" class="PhorumSubmit" value="<?php echo $PHORUM['DATA']['LANG']['Delete']; ?>" />
</div>
</form>
