<?php
function mail_mass($from, $to, $subject, $body)
{
	$header  = "MIME-Version: 1.0\n";
	$header .= "Content-type: text/html; charset=iso-8859-1\n";
	$header .= "Content-Transfer-encoding: 8bit\n";
	$header .= "bcc: ".$to."\n";
	$header .= "From: ".$from."\n";
	$header .= "Reply-To: ".$from."\n";
	$header .= "Message-ID: <".md5(uniqid(time()))."@{$_SERVER['SERVER_NAME']}>\n";
	$header .= "Return-Path: ".$from."\n";           
	//$header .= "X-Priority: 1\n";
	//$header .= "X-MSmail-Priority: High\n";
	$header .= "X-Mailer: Microsoft Office Outlook, Build 11.0.5510\n"; //hotmail and others dont like PHP mailer.
	$header .= "X-MimeOLE: Produced By Microsoft MimeOLE V6.00.2800.1441\n";
	$header .= "X-Sender: ".$from."\n";
	$header .= "X-AntiAbuse: This is a solicited email for apo-x.org.\n";
	$header .= "X-AntiAbuse: Servername - {$_SERVER['SERVER_NAME']}\n";
	$header .= "X-AntiAbuse: User - ".$from."\n";
	
	$body = "<html>\n$body</html>";
	mail('aphio@iotaphi.org', $subject, $body, $header);
}

?>