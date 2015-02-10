<?php if(!defined("PHORUM")) return; ?>
<?php // ! --- defines are used by the engine and vars are used by the template ---  ?>

<?php // ! --- This is used to indent messages in threaded view ---  ?>
<?php $PHORUM["TMP"]['indentstring']='&nbsp;&nbsp;&nbsp;'; ?>

<?php // ! --- This is used to load the message-bodies in the message-list for that template if set to 1 ---  ?>
<?php $PHORUM["TMP"]['bodies_in_list']='0'; ?>

<?php // ! --- This is the marker for messages in threaded view ---  ?>
<?php $PHORUM["TMP"]['marker']='<img src="templates/default/images/carat.gif" border="0" width="8" height="8" alt="" style="vertical-align: middle;" />&nbsp;'; ?>

<?php // ! --- these are the colors used in the style sheet ---  ?>

<?php // ! --- you can use them or replace them in the style sheet ---  ?>

<?php // ! --- common body-colors ---  ?>
<?php $PHORUM["DATA"]['bodybackground']='#878787'; ?>
<?php $PHORUM["DATA"]['defaulttextcolor']=''; ?>
<?php $PHORUM["DATA"]['backcolor']='White'; ?>
<?php $PHORUM["DATA"]['forumwidth']='100%'; ?>
<?php $PHORUM["DATA"]['forumalign']='center'; ?>
<?php $PHORUM["DATA"]['newflagcolor']='#CC0000'; ?>
<?php $PHORUM["DATA"]['errorfontcolor']='Red'; ?>
<?php $PHORUM["DATA"]['okmsgfontcolor']='DarkGreen'; ?>

<?php // ! --- for the forum-list ... alternating colors ---  ?>
<?php $PHORUM["DATA"]['altbackcolor']='#EEE'; ?>
<?php $PHORUM["DATA"]['altlisttextcolor']='white'; ?>

<?php // ! --- common link-settings ---  ?>
<?php $PHORUM["DATA"]['linkcolor']='#000099'; ?>
<?php $PHORUM["DATA"]['activelinkcolor']='#FF6600'; ?>
<?php $PHORUM["DATA"]['visitedlinkcolor']='#000099'; ?>
<?php $PHORUM["DATA"]['hoverlinkcolor']='#FF6600'; ?>

<?php // ! --- for the Navigation ---  ?>
<?php $PHORUM["DATA"]['navbackcolor']='DarkGray'; ?>
<?php $PHORUM["DATA"]['navtextcolor']='white'; ?>
<?php $PHORUM["DATA"]['navhoverbackcolor']='DarkGray'; ?>
<?php $PHORUM["DATA"]['navhoverlinkcolor']='white'; ?>
<?php $PHORUM["DATA"]['navtextweight']='normal'; ?>
<?php $PHORUM["DATA"]['navfont']='Tahoma, sans-serif'; ?>
<?php $PHORUM["DATA"]['navfontsize']='small'; ?>

<?php // ! --- for the PhorumHead ... the list-header ---  ?>
<?php $PHORUM["DATA"]['headerbackcolor']='LightGrey'; ?>
<?php $PHORUM["DATA"]['headertextcolor']='Black'; ?>
<?php $PHORUM["DATA"]['headertextweight']='bold'; ?>
<?php $PHORUM["DATA"]['headerfont']='Tahoma, sans-serif'; ?>
<?php $PHORUM["DATA"]['headerfontsize']='small'; ?>



<?php $PHORUM["DATA"]['tablebordercolor']='Black'; ?>

<?php $PHORUM["DATA"]['listlinecolor']='#F2F2F2'; ?>

<?php $PHORUM["DATA"]['listpagelinkcolor']='#707070'; ?>
<?php $PHORUM["DATA"]['listmodlinkcolor']='#707070'; ?>



<?php // ! --- You can set the table width globaly here ... ONLY tables, no divs are changed---  ?>
<?php $PHORUM["DATA"]['tablewidth']='980px'; ?>
<?php $PHORUM["DATA"]['tablewidthsmall']='960px'; ?>
<?php $PHORUM["DATA"]['narrowtablewidth']='600px'; ?>



<?php // ! --- Some font stuff ---  ?>
<?php $PHORUM["DATA"]['defaultfont']='Verdana, sans-serif'; ?>
<?php $PHORUM["DATA"]['largefont']='Verdana, sans-serif'; ?>
<?php $PHORUM["DATA"]['tinyfont']='Verdana, sans-serif'; ?>
<?php $PHORUM["DATA"]['fixedfont']='Verdana, sans-serif'; ?>
<?php $PHORUM["DATA"]['defaultfontsize']='small'; ?>
<?php $PHORUM["DATA"]['largefontsize']='medium'; ?>
<?php $PHORUM["DATA"]['smallfontsize']='x-small'; ?>
<?php $PHORUM["DATA"]['tinyfontsize']='x-small'; ?>
