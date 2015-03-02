<?php if(!defined("PHORUM")) return; ?>
<div class="PhorumStdBlockHeader PhorumHeaderText" style="text-align: left;"><?php echo $PHORUM['DATA']['LANG']['UploadFile']; ?></div>
<form action="<?php echo $PHORUM['DATA']['URL']['ACTION']; ?>" method="POST" enctype="multipart/form-data">
<input type="hidden" name="forum_id" value="<?php echo $PHORUM['DATA']['PROFILE']['forum_id']; ?>" />
<input type="hidden" name="panel" value="<?php echo $PHORUM['DATA']['PROFILE']['PANEL']; ?>" />
<?php echo $PHORUM['DATA']['POST_VARS']; ?>
<div class="PhorumStdBlock PhorumFloatingText" style="text-align: left;">
<?php if(isset($PHORUM['DATA']['FILE_SIZE_LIMIT']) && !empty($PHORUM['DATA']['FILE_SIZE_LIMIT'])){ ?><?php echo $PHORUM['DATA']['FILE_SIZE_LIMIT']; ?><br /><?php } ?>
<?php if(isset($PHORUM['DATA']['FILE_TYPE_LIMIT']) && !empty($PHORUM['DATA']['FILE_TYPE_LIMIT'])){ ?><?php echo $PHORUM['DATA']['FILE_TYPE_LIMIT']; ?><br /><?php } ?>
<?php if(isset($PHORUM['DATA']['FILE_QUOTA_LIMIT']) && !empty($PHORUM['DATA']['FILE_QUOTA_LIMIT'])){ ?><?php echo $PHORUM['DATA']['FILE_QUOTA_LIMIT']; ?><br /><?php } ?>
<br />
<input type="file" name="newfile" size="30" /><br /><br />
<input class="PhorumSubmit" type="submit" value="<?php echo $PHORUM['DATA']['LANG']['Submit']; ?>" />
</div>
</form>

<form action="<?php echo $PHORUM['DATA']['URL']['ACTION']; ?>" method="POST">
<?php echo $PHORUM['DATA']['POST_VARS']; ?>
<input type="hidden" name="forum_id" value="<?php echo $PHORUM['DATA']['PROFILE']['forum_id']; ?>" />
<input type="hidden" name="panel" value="<?php echo $PHORUM['DATA']['PROFILE']['PANEL']; ?>" />
<table border="0" cellspacing="0" class="PhorumStdTable">
<tr>
<th align="left" class="PhorumTableHeader"><?php echo $PHORUM['DATA']['LANG']['Filename']; ?></th>
<th align="left" class="PhorumTableHeader"><?php echo $PHORUM['DATA']['LANG']['Filesize']; ?></th>
<th align="left" class="PhorumTableHeader"><?php echo $PHORUM['DATA']['LANG']['DateAdded']; ?></th>
<th align="center" class="PhorumTableHeader"><?php echo $PHORUM['DATA']['LANG']['Delete']; ?></th>
</tr>
<?php if(isset($PHORUM['DATA']['FILES']) && is_array($PHORUM['DATA']['FILES'])) foreach($PHORUM['DATA']['FILES'] as $PHORUM['TMP']['FILES']){ ?>
<tr>
<td class="PhorumTableRow"><a href="<?php echo $PHORUM['TMP']['FILES']['url']; ?>"><?php echo $PHORUM['TMP']['FILES']['filename']; ?></a></td>
<td class="PhorumTableRow"><?php echo $PHORUM['TMP']['FILES']['filesize']; ?></td>
<td class="PhorumTableRow"><?php echo $PHORUM['TMP']['FILES']['dateadded']; ?></td>
<td class="PhorumTableRow" align="center"><input type="checkbox" name="delete[]" value="<?php echo $PHORUM['TMP']['FILES']['file_id']; ?>" /></td>
</tr>
<?php } unset($PHORUM['TMP']['subscriptions']); ?>
<tr>
<th align="left" class="PhorumTableHeader"><?php echo $PHORUM['DATA']['LANG']['TotalFiles']; ?>: <?php echo $PHORUM['DATA']['TOTAL_FILES']; ?></th>
<th align="left" class="PhorumTableHeader"><?php echo $PHORUM['DATA']['LANG']['TotalFileSize']; ?>: <?php echo $PHORUM['DATA']['TOTAL_FILE_SIZE']; ?></th>
<th align="left" class="PhorumTableHeader">&nbsp;</th>
<th align="center" class="PhorumTableHeader"><input type="submit" class="PhorumSubmit" value="<?php echo $PHORUM['DATA']['LANG']['Delete']; ?>" /></th>
</tr>
</table>
</form>
