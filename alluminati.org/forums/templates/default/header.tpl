<?php 
include_once 'template.inc.php';
include_once 'show.inc.php';
include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
get_header();

if($_SESSION['class']!='admin' && $_SESSION['class']!='user')
	show_note('You are not logged in!');

?>
<style type="text/css">
{include css}
div.PhorumReadMessageBlock > table {
width:979px;
}
.PhorumStdBlock {
	border:1px solid #ccc;
	}
</style>
<!--{if URL->REDIRECT}
<meta http-equiv="refresh" content="5; url={URL->REDIRECT}" />
{/if}
{LANG_META}
{HEAD_TAGS}
</head>
<body>-->
<div align="{forumalign}">
<div class="PDDiv">
{IF notice_all}
<div class="PhorumNotificationArea PhorumNavBlock">
{IF PRIVATE_MESSAGES->new}<a class="PhorumNavLink" href="{PRIVATE_MESSAGES->inbox_url}">{LANG->NewPrivateMessages}</a><br />{/IF}
{IF notice_messages}<a class="PhorumNavLink" href="{notice_messages_url}">{LANG->UnapprovedMessagesLong}</a><br />{/IF}
{IF notice_users}<a class="PhorumNavLink" href="{notice_users_url}">{LANG->UnapprovedUsersLong}</a><br />{/IF}
{IF notice_groups}<a class="PhorumNavLink" href="{notice_groups_url}">{LANG->UnapprovedGroupMembers}</a><br />{/IF}
</div>
{/IF}
<span class="PhorumTitleText PhorumLargeFont">
<!--{IF NAME}<a href="{URL->TOP}">{NAME}</a>&nbsp;:&nbsp;{/IF}{TITLE}--></span>
{IF DESCRIPTION}<div class="PhorumNavBlock"><div class="PhorumFloatingText" style="font-weight: bold;">{DESCRIPTION}</div></div>{/IF}
