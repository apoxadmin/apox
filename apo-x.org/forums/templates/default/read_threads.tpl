{IF ReportPost}
<div class="PhorumUserError">{ReportPostMessage}</div>
{/IF}

<div class="PhorumNavBlock" style="text-align: left;">
<!--<div style="float: right;"><span class="PhorumNavHeading">{LANG->GotoThread}:</span>&nbsp;<a class="PhorumNavLink" href="{URL->NEWERTHREAD}">{LANG->PrevPage}</a>&bull;<a class="PhorumNavLink" href="{URL->OLDERTHREAD}">{LANG->NextPage}</a></div>-->
<span class="PhorumNavHeading PhorumHeadingLeft">{LANG->Goto}:</span>&nbsp;<a class="PhorumNavLink" href="{URL->INDEX}">{LANG->ForumList}</a>&bull;<a class="PhorumNavLink" href="{URL->TOP}">{LANG->MessageList}</a>&bull;<a class="PhorumNavLink" href="{URL->POST}">{LANG->NewTopic}</a>&bull;{IF NEWPOLLURL}<a class="PhorumNavLink" href="{NEWPOLLURL}">{LANG->mod_poll->NewPoll}</a>&bull;{/IF}<a class="PhorumNavLink" href="{URL->SEARCH}">{LANG->Search}</a>
</div>
{IF MESSAGE->is_unapproved}
<div class="PhorumStdBlock">
<div class="PhorumReadBodyHead"><strong>{LANG->UnapprovedMessage}</strong></div>
</div>
{/IF}
<div class="PhorumStdBlock">
<div class="PhorumReadBodySubject">{MESSAGE->subject}</div>
<div class="PhorumReadBodyHead">{LANG->Postedby}: <strong>{MESSAGE->linked_author}</strong> ({MESSAGE->ip})</div>
<div class="PhorumReadBodyHead">{LANG->Date}: {MESSAGE->datestamp}</div>
<br />
<div class="PhorumReadBodyText">{MESSAGE->body}</div><br />
{IF ATTACHMENTS}
{IF MESSAGE->attachments}
{LANG->Attachments}: 
{ASSIGN MESSAGE_ATTACHMENTS MESSAGE->attachments}
{LOOP MESSAGE_ATTACHMENTS}
<a href="{MESSAGE_ATTACHMENTS->url}">{MESSAGE_ATTACHMENTS->name} ({MESSAGE_ATTACHMENTS->size})</a>&nbsp;&nbsp;
{/LOOP MESSAGE_ATTACHMENTS}
{/IF}
{/IF}
</div>

{IF MODERATOR true}
<div class="PhorumReadNavBlock" style="text-align: left;">
<span class="PhorumNavHeading PhorumHeadingLeft">{LANG->Moderate}:</span>&nbsp;{IF MESSAGE->threadstart true}
<a class="PhorumNavLink" href="javascript:if(window.confirm('{LANG->ConfirmDeleteThread}')) window.location='{MESSAGE->delete_url2}';">{LANG->DeleteThread}</a>&bull;<a class="PhorumNavLink" href="{MESSAGE->move_url}">{LANG->MoveThread}</a>{IF MESSAGE->closed false}&bull;<a class="PhorumNavLink" href="{MESSAGE->close_url}">{LANG->CloseThread}</a>{/IF}{IF MESSAGE->closed true}&bull;<a class="PhorumNavLink" href="{MESSAGE->reopen_url}">{LANG->ReopenThread}</a>{/IF}
{/IF}
{IF MESSAGE->threadstart false}
<a class="PhorumNavLink" href="javascript:if(window.confirm('{LANG->ConfirmDeleteMessage}')) window.location='{MESSAGE->delete_url1}';">{LANG->DeleteMessage}</a>&bull;<a class="PhorumNavLink" href="javascript:if(window.confirm('{LANG->ConfirmDeleteMessage}')) window.location='{MESSAGE->delete_url2}';">{LANG->DelMessReplies}</a>
{/IF}
{if MESSAGE->is_unapproved} 
&bull;<a class="PhorumNavLink" href="{MESSAGE->approve_url}">{LANG->ApproveMessage}</a>
{else}
&bull;<a class="PhorumNavLink" href="{MESSAGE->hide_url}">{LANG->HideMessage}</a>
{/if}
&bull;<a class="PhorumNavLink" href="{MESSAGE->edit_url}">{LANG->EditPost}</a>
</div>
{/IF}

<div class="PhorumNavBlock">
<div style="float: right;"><span class="PhorumNavHeading">{LANG->Navigate}:</span>&nbsp;<a class="PhorumNavLink" href="{MESSAGE->prev_url}">{LANG->PreviousMessage}</a>&bull;<a class="PhorumNavLink" href="{MESSAGE->next_url}">{LANG->NextMessage}</a></div>
<span class="PhorumNavHeading PhorumHeadingLeft">{LANG->Options}:</span>&nbsp;<a class="PhorumNavLink" href="{MESSAGE->reply_url}">{LANG->Reply}</a>&bull;<a class="PhorumNavLink" href="{MESSAGE->quote_url}">{LANG->QuoteMessage}</a>{IF LOGGEDIN}&bull;<a class="PhorumNavLink" href="{MESSAGE->follow_url}">{LANG->FollowThread}</a>{/IF}{IF LOGGEDIN}&bull;<a class="PhorumNavLink" href="javascript:if(window.confirm('{LANG->ConfirmReportMessage}')) window.location='{MESSAGE->report_url}';">{LANG->Report}</a>{/IF}{if MESSAGE->edit 1}&bull;<a class="PhorumNavLink" href="{MESSAGE->edituser_url}">{LANG->EditPost}</a>{/if}
</div>

<br />
<br />

<table class="PhorumStdTable" cellspacing="0">
<tr>
    <th class="PhorumTableHeader" align="left">{LANG->Subject}</th>
{IF VIEWCOUNT_COLUMN}    <th class="PhorumTableHeader" align="center">{LANG->Views}</th>{/IF}
    <th class="PhorumTableHeader" align="left" nowrap>{LANG->WrittenBy}</th>
    <th class="PhorumTableHeader" align="left" nowrap>{LANG->Posted}</th>
</tr>
<?php
$rclass="Alt";
?>
{LOOP MESSAGES}
<?php
  if($rclass=="Alt")
    $rclass="";
  else
    $rclass="Alt";
?>
<tr>
    <td class="PhorumTableRow<?php echo $rclass;?>">{MESSAGES->indent}
    <?php 
    if($PHORUM['TMP']['MESSAGES']['message_id'] == $PHORUM['DATA']['MESSAGE']['message_id']) {
      echo "<b>". $PHORUM['TMP']['MESSAGES']['subject']."</b>";
    } else {
    ?>
    <a href="{MESSAGES->url}">{MESSAGES->subject}</a>
    <span class="PhorumNewFlag">{MESSAGES->new}</span>
    <?php } ?>
{IF MESSAGES->is_unapproved} ({LANG->UnapprovedMessage}){/IF}</td>
{IF VIEWCOUNT_COLUMN}    <td class="PhorumTableRow<?php echo $rclass;?>" nowrap="nowrap" align="center" width="80">{MESSAGES->viewcount}</td>{/IF}
    <td class="PhorumTableRow<?php echo $rclass;?>" nowrap="nowrap" width="150">{MESSAGES->linked_author}</td>
    <td class="PhorumTableRow<?php echo $rclass;?> PhorumSmallFont" nowrap="nowrap" width="150">{MESSAGES->short_datestamp}</td>
</tr>
{/LOOP MESSAGES}
</table>
<br />
<br />
