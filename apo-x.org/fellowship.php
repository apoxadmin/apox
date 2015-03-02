<?php
include_once('fellowshipInclude.php');
// some functions
/**
from http://www.linuxjournal.com/article/9585
Validate an email address.
Provide email address (raw input)
Returns true if the email address has the email 
address format and the domain exists.
*/
db_open();
function validEmail($email)
{
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
         // local part length exceeded
         $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         // domain part length exceeded
         $isValid = false;
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
         // local part starts or ends with '.'
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $local))
      {
         // local part has two consecutive dots
         $isValid = false;
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      {
         // character not valid in domain part
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $domain))
      {
         // domain part has two consecutive dots
         $isValid = false;
      }
      else if
(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
                 str_replace("\\\\","",$local)))
      {
         // character not valid in local part unless 
         // local part is quoted
         if (!preg_match('/^"(\\\\"|[^"])+"$/',
             str_replace("\\\\","",$local)))
         {
            $isValid = false;
         }
      }
      if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
      {
         // domain not found in DNS
         $isValid = false;
      }
   }
   return $isValid;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en-US" xml:lang="en-US" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Alpha Phi Omega Fall Fellowship 2011</title>
	<style type="text/css">
	html, body {
		height: 100%;
		background-color: #7733aa;
		font-family: Arial;
		background-image: url('banner.jpg');
		background-repeat: no-repeat;
		background-position: center top;
	}
	.emph {
		color: #ddd;
		text-align: center;
	}
	.error {
		font-size: 12px;
	}
	.error ul li {
		list-style: none;
		font-size: 14px;
	}

	#centeredcontent {
		width: 800px;
		text-align: center;
		position: relative;
		top: 145px;
		padding: 10px;
		margin: 0 auto;
	}
	#body {
		border: 1px solid #2f1a00;
		background-color: #222;
/*		background-image: url('content.png');*/
		color: #C9852D;
		font-weight: bold;
	}
	#body .title {
		background-color: #eeee66;
		line-height: 24px;
		letter-spacing: 2px;
		display: block;
		color: #552266;
	}
	#register {
		text-align: center;
	}
	#register div {
		display: table-row;
		padding-top: 2px;
		padding-bottom: 1px;
	}
	#register label {
		width: 160px;
		text-align: left;
		display: table-cell;
		padding-left: 40px;
		font-family: Arial;
		font-size: 11px;
		line-height: 26px;
	}
	#register input {
		width: 230px;
		margin-right: 2px;
		display: table-cell;
	}
	#banner .title {
		display: block;
		font-size: 21px;
		color: #552266;
		font-family: Arial;
	}
	#banner .title p {
		padding: 0;
	}
	#footer .subtext {
		font-size: 11px;
		font-family: Arial;
		color: #000;
	}
	#registered {
		display: none;
		font-size: 11px;
		letter-spacing: 1px;
	}
	#home {
		font-size: 11px;
		letter-spacing: 1px;
		display: block;
	}
	#home p {
		width: 760px;
		text-align: justify;
		text-indent: 10px;
		padding: 5px;
		line-height: 20px;
		font-size: 12px;
		font-family: Arial;
		margin: 0 auto;
	}
	#agenda {
		display: none;
		font-size: 11px;
		letter-spacing: 1px;
	}
	#agenda table {
		padding-top: 2px;
		padding-bottom: 2px;
	}
	#agenda tr {
		margin-bottom: 2px;
		line-height: 19px;
	}
	#agenda td {
		width: 140px;
	}
	#buttonSet {
		margin-top: 8px;
		padding: 7px;
	}
	#buttonSet a {
		border-radius: 10px;
		background-color: #eeee66;
		color: #552266;
		border: 0px;
		padding: 4px;
		margin: 2px;
	}
	#buttonSet a:hover {
		background-color: #ffff00;
		color: #111;
	}
	#buttonSet a .active {
		background-color: #ffff00;
		color: #111;
	}
	</style>
	<script type="text/javascript">
		var last="home"
		var lastButton="but1";
		function flip( a , s ) {
			if ( document.getElementById( last )!=null )
			{
				document.getElementById( last ).style.display = "none";
				document.getElementById( lastButton ).className = "active";
			}
			document.getElementById( a ).className = "";
			document.getElementById( s ).style.display = "block";
			last = s;
			lastButton = a;
		}
	</script>
</head>
<body>
	<div id="centeredcontent">
	<div id="banner" style="display: none">
		<span class="title" style="padding: 2px;">
			<div style="letter-spacing: 1px; font-size: 28px;line-height: 36px;">Alpha Phi Omega 2011</div>
			<div style="letter-spacing: 6px; font-size: 14px;line-height: 20px;color: #daab6d">Section IV Fall Fellowship</div>
		</span>
	</div>
	<div id="buttonSet">
		<a href="#" onclick="flip( 'but1' , 'home' )" id="but1">Home</a>
		<a href="#" onclick="flip( 'but2' , 'registered' )" id="but2">Register</a>
		<a href="#" onclick="flip( 'but3' , 'agenda' )" id="but3">Agenda</a>
	</div>
	<div id="body">
	
<?php
if ( isset( $_POST['first'] ) && isset( $_POST['last'] ) && isset( $_POST['email'] ) && isset( $_POST['phone'] ) && isset( $_POST['chapter'] ) )
{
	$first = $_POST['first'];
	$last = $_POST['last'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$chapter = $_POST['chapter'];
	$banquet = "FALSE";
	if ( $_POST['banquet']==1 )
		$banquet = "TRUE";
	$action = array();
	if ( !validEmail( $email ) )
	{
		$error = true;
		array_push( $action , "Invalid Email" );
	}
	if ( !preg_match("/^([1]-)?[0-9]{3}-[0-9]{3}-[0-9]{4}$/i", $phone) ) {
		$error = true;
		array_push( $action , "Phone Number is not in the format (x-xxx-xxx-xxxx)" );
	}
	if ( $error != true )
	{
		$query = "SELECT * FROM " . FELLOWSHIPNAME . "_registration WHERE FirstName='".$first."' AND LastName='".$last."' AND Phone='".$phone."' AND Email='".$email."'";
		$result = db_select1( $query );
		if ( $result['id'] )
		{
			$error = true;
			array_push( $action , "You already registered!" );
		} else {
			$query = "INSERT INTO " . FELLOWSHIPNAME . "_registration ( FirstName , LastName, Email, Phone , Chapter , Banquet ) VALUES ( '".$first."' , '".$last."' , '".$email."' , '".$phone."' , '".$chapter."' , ".$banquet." )";
			$result = mysql_query( $query );
			$register = true;
			$headers = 'From: no-reply@apo-x.org';
			mail( $email , EMAIL_TITLE , EMAIL_CONTENT , $headers );
		}
	}
}
if ( $error==true ) {?>
	<div class="error">Your registration could not be completed. It had the following errors:
	<ul>
	<? for ( $i=0; $i < count( $action ); $i++ )
	{
		echo "<li>" . $action[ $i ] . "</li>";
	}
?>
	</div>
<?
} else if ( $register==true )
{?>
	<div class="pop">Registration Completed!</div>
<?} ?>
	<div id="home">
		<span class="title">Home</span>
		<p class="emph">Fall Hell-O-Ship 2011</p>
		<p>Hello Brothers of Alpha Phi Omega,</p>
		<p>We hope you are all getting excited about Fall Hell-O-Ship: Get Ready to Scream hosted by Chi!  We just wanted to give you a few pieces of information in order to prepare for the event.  This year we are letting each chapter choose their theme.  Our only requirement is that it be Halloween related and creative!  It could be anything from a Halloween character, a movie, or anything spooky and fun.  We are asking that you respond to our email with your top 3 choices for your theme.  Each chapter will receive their theme on a first come first serve basis, so reply quickly to get your first choice!</p>
		<p>There will be a few CHAPTER CONTESTS throughout the day.  First, we will be having a PUMPKIN CARVING CONTEST where each chapter will have a chance to make a pumpkin masterpiece, so start brainstorming ideas for your piece of art and which members of your chapter will be your artists!  Second, throughout the day we will be searching for the chapter that has the MOST SPIRIT.  The chapter that is dubbed the most spirited will win the SPIRIT STAFF!!!!  Finally, at the end of the day there will be a COSTUME CONTEST.  So represent your chapter and bring outfits and supplies to dress up in your theme!</p>
		<p>We are very excited to see everyone's routines for roll call, this year we are limiting the length of each roll call routine to 5 minutes maximum so everything will run as smoothly as possible.  Please bring your music on a CD on the day of the event.</p>
		<p>A final reminder, during the day you will have a chance to participate in tie dying.  Please bring any article of clothing or item that you want to tie dye, as items will not be provided.</p>
		<p>We are very excited to reunite with our fellow IC Brothers and create new friendships!  We also encourage and invite all of our IC brothers to stay Saturday night with us to continue the fellowship festivities!  If you have any questions, or have chosen your theme choices, please contact us at fallfellowship@apo-x.org.  Thank you!</p>
	</div>
	<div id="agenda">
		<span class="title">Agenda</span>
		<table style="margin: 0 auto; text-align: center">
			<tr>
				<td>Registration</td>
				<td>8:00am-9:00am</td>
			</tr><tr>
				<td>Opening Ceremony</td>
				<td>9:00am-9:15am</td>
			</tr><tr>
				<td>Icebreakers</td>
				<td>9:30am-10:30am</td>
			</tr><tr>
				<td>Treasure Hunt</td>
				<td>10:45am-12:00pm</td>
			</tr><tr>
				<td>Lunch/Roll Call</td>
				<td>12:00pm-2:30pm</td>
			</tr><tr>
				<td>Open Activities</td>
				<td>2:45pm- 4:45pm</td>
			</tr><tr>
				<td>Zombie Invasion</td>
				<td>5:00pm-6:30pm</td>
			</tr><tr>
				<td>Snack</td>
				<td>6:45pm-7:00pm</td>
			</tr><tr>
				<td>Costume Contest</td>
				<td>7:00pm-8:00pm</td>
			</tr><tr>
				<td>Closing Contest</td>
				<td>8:00pm-8:30pm</td>
			</tr>
		</table>
	</div>
	<div id="registered">
		<span class="title">Registration</span>
		<form method="post" action="fellowship.php" id="register">
			<div><label for="first">First Name:</label><input type="text" name="first" value="<? echo $_POST['first'];?>" /></div>
			<div><label for="last">Last Name:</label><input type="text" name="last" value="<? echo $_POST['last'];?>" /></div>
			<div><label for="email">Email:</label><input type="text" name="email" value="<? echo $_POST['email'];?>" /></div>
			<div><label for="phone">Phone Number:</label><input type="text" name="phone" value="<? echo $_POST['phone'];?>" /></div>
			<div><label for="chapter">Chapter:</label><input type="text" name="chapter" value="<? echo $_POST['chapter'];?>" /></div>
			<div><label>Banquet:</label>No<input type="radio" name="banquet" value="0" style="display: inline; width: 50px" />Yes<input style="display: inline; width: 50px" type="radio" name="banquet" value="1" /></div>
			<div style="display: block"><input style="display: inline;width: 396px" type="submit" value="Register!" /></div>
		</form>
	</div>
	</div>
	<div id="footer">
		<span class="subtext">hosted by Chi chapter at UC Los Angeles</span>
	</div>
	</div>
	<?php
	if ( $error==true ) {?>
	<script type="text/javascript">
		flip( 'but2' , 'registered' );
	</script>
	<? } ?>
</body>
</html>