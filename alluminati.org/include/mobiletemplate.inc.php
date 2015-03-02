<?php
//something to keep note. I did multiple headers in order to get the main nav to alternate. If you find a better more efficient way, CHANGE IT its a lot of code, but it seemed the simplest way for now.-->

ob_start();
include_once 'database.inc.php';
include_once 'constants.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

//session_start();

db_open();
include_once 'session.inc.php';

function get_style()
{
	if (!isset($_SESSION['class'])) {
		return "mobile";
	}
	$sql = "SELECT style_id FROM user WHERE user_id='{$_SESSION['id']}'";
	$result = mysql_query($sql) or die("Query Failed (get_style)! ". mysql_error());
	$styleArray = mysql_fetch_assoc($result);
	$styleNum = $styleArray['style_id'];

	if(!is_numeric($styleNum)) $styleName = "mobile";
	else if($styleNum==2)
	{
		switch($_SESSION['family'])
		{
			case 1: $styleName = "mobile"; break;
			case 2: $styleName = "mobile"; break;
			case 3: $styleName = "mobile"; break;
			default: $styleName = "mobile"; break;
		}
	} else {
		$sql = "SELECT style_file FROM style WHERE style_id='{$styleNum}'";
		$result = mysql_query($sql) or die("Query Failed (get_style)! ". mysql_error());
		$styleArray = mysql_fetch_assoc($result);
		$styleName = $styleArray['style_file'];
	}
	return $styleName;
}

//REQS HEADER!!!!!

function show_reqsheader($head = '', $onload = '')
{
	// to avoid recursive calling
	if( defined('HEAD') )
		return;
	define('HEAD', true);
	
	// set variables that tell us if we're logged in and what type of user is logged in
	$set = isset($_SESSION['class']);
	$user = $_SESSION['class']=='user';
	$admin = $_SESSION['class']=='admin';
	
	// if not logged in, focus cursor on username input
	if (!$user && !$admin)
		$cursor_onload = 'document.getElementById(\'usernameinput\').focus();'
                       . 'document.getElementById(\'usernameinput\').select();';
		
	// URI given in order to access this page
	$_SESSION['page'] = $_SERVER['REQUEST_URI'];
	
	// load stylesheet according to user prefs
	$styleFilename = get_style();
	$css = '/style/mobile.css';
	
		// pick a banner to show
/*	if (!isset($_SESSION['banner_num']))
		$_SESSION['banner_num'] = rand(1,8);	
	$top_style="background-image: url('/images/mobile/header.jpg');";
	*/	
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Alpha Phi Omega, Chi Chapter - University of California, Los Angeles</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="Pragma" name="Cache-Control" content="no-cache"/>
		<meta http-equiv="Cache-Control" name="Cache-Control" content="no-cache"/>
		<!--For iphone -->
         <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
		<script type="text/javascript" charset="utf-8">
				addEventListener('load', function() {
						setTimeout(hideAddressBar, 0);
				}, false);
			function hideAddressBar() {
					window.scrollTo(0, 1);
						}
				</script>
		<!--------------------------------> 
				
		
		<style type="text/css" media="screen">
			@import url(<?php echo $css ?>);
		</style>
		<script src="/script/format.js" language="javascript" type="text/javascript"></script>
		<script src="/script/swfobject.js" language="javascript" type="text/javascript"></script>

		<?php echo $head ?>
	</head>
	
<body onload="<?php echo $onload ?>">	
		<div id="all">
	
			<a href="/mobile">
				<div id="top"><img src="http://www.iotaphi.org/images/mobile/header.jpg"/></div>	
			</a>
			
			<div id="main_nav">
					<?php if (!$set) { // Nav menu to show if not logged in ?>
						<ul>													
						     
				<li> <a style="font-size:20px; padding:0px 15px 0px 0px; " href="/mobile/index.php ">Home</a></li>	
							<li class="spacer"></span>
		
		<span id='unselected' > <a style='font-size:20px;padding:0px 10px 0px 8px;' href='calendar.php'>Calendar</a></li> <li class='spacer'></span>
			
						<span id="unselected" ><a style="font-size:20px; padding:0px 10px 0px 10px;" href="login.php">Log In</a></li>
						</ul>
						
				<?php } else { // Nav menu to show if logged in ?>
						<ul>													
							<span id='unselected' > <a href="/mobile/index.php">Home</a></span>
							<li class="spacer"></li>
							
							<li> <a href="/mobile/mine.php">Reqs</a></li><li class="spacer"></li>
							
							<span id='unselected' ><a href="/mobile/calendar.php">Calendar</a>	</span>					
							
							<li class="spacer"></li>
	
							<span id='unselected' ><a href="/mobile/roster.php">Roster</a></span>								
							</ul>										
					<?php } ?>
				
				<div id="logout">
						<?php 						
							if(isset($_SESSION['id'])):
							include_once 'user.inc.php'; ?>
							[<a href="/input.php?action=logout&amp;redirect=/mobile/index.php">logout</a>]<br/> 
						<?php endif; ?>
					</div>
							
					</div>	

			<div id="content">
			
				<?php
				
				if($_SESSION['class'] == 'user')
				{
					$sql = "SELECT user_id FROM `update` WHERE user_id = '{$_SESSION['id']}' ";
					if(db_select1($sql) === false)
					{
						echo '<div class="notice">Please update your contact information.</div>';
						include $_SERVER['DOCUMENT_ROOT'] . '/people/myrosterinfo.php';
						exit();
					}
				}
				
				if(isset($_SESSION['confirmation']))
				{
					echo "<div class=\"general\"><h3>{$_SESSION['confirmation']}</h3></div><br/>";
					unset($_SESSION['confirmation']);
				}
					
				echo "\n<!-- End Header -->\n";
}


// LOGIN HEADER

function show_loginheader($head = '', $onload = '')
{
	// to avoid recursive calling
	if( defined('HEAD') )
		return;
	define('HEAD', true);
	
	// set variables that tell us if we're logged in and what type of user is logged in
	$set = isset($_SESSION['class']);
	$user = $_SESSION['class']=='user';
	$admin = $_SESSION['class']=='admin';
	
	// if not logged in, focus cursor on username input
	if (!$user && !$admin)
		$cursor_onload = 'document.getElementById(\'usernameinput\').focus();'
                       . 'document.getElementById(\'usernameinput\').select();';
		
	// URI given in order to access this page
	$_SESSION['page'] = $_SERVER['REQUEST_URI'];
	
	// load stylesheet according to user prefs
	$styleFilename = get_style();
	$css = '/style/mobile.css';
	
		// pick a banner to show
/*	if (!isset($_SESSION['banner_num']))
		$_SESSION['banner_num'] = rand(1,8);	
	$top_style="background-image: url('/images/mobile/header.jpg');";
	*/	
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Alpha Phi Omega, Chi Chapter - University of California, Los Angeles</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="Pragma" name="Cache-Control" content="no-cache"/>
		<meta http-equiv="Cache-Control" name="Cache-Control" content="no-cache"/>
		<!--For iphone -->
         <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
		<script type="text/javascript" charset="utf-8">
				addEventListener('load', function() {
						setTimeout(hideAddressBar, 0);
				}, false);
			function hideAddressBar() {
					window.scrollTo(0, 1);
						}
				</script>
		
		<!--------------------------------> 
				
		
		<style type="text/css" media="screen">
			@import url(<?php echo $css ?>);
		</style>
		<script src="/script/format.js" language="javascript" type="text/javascript"></script>
		<script src="/script/swfobject.js" language="javascript" type="text/javascript"></script>

		<?php echo $head ?>
	</head>
	
<body onload="<?php echo $onload ?>">	
		<div id="all">
	
			<a href="/mobile">
				<div id="top"><img src="http://www.iotaphi.org/images/mobile/header.jpg"/></div>	
			</a>
			
			<div id="main_nav">
					<?php if (!$set) { // Nav menu to show if not logged in ?>
						<ul>													
						     
	<span id='unselected' ><a style="font-size:20px; padding:0px 15px 0px 15px; " href="/mobile/index.php ">Home</a></span>
							<li class="spacer"></li>
		
			<span id='unselected' ><a style='font-size:20px;padding:0px 10px 0px 8px;' href='calendar.php'>Calendar</a></span>
			
			 <li class='spacer'></li>
			
						<li><a style="font-size:20px; padding:0px 10px 0px 10px;" href="login.php">Log In</a></li>
						</ul>
						
					<?php } else { // Nav menu to show if logged in ?>
						<ul>													
							<li><a href="/mobile/index.php">Home</a>
							</li>												<li class="spacer"></li>
							<li><a href="/mobile/mine.php">Reqs</a></li><li class="spacer"></li>
							<li><a href="/mobile/calendar.php">Calendar</a>		
							<!--	<ul>
									<li><a href="/tracking">Tracking</a></li>									
								</ul> -->
							</li>												<li class="spacer"></li>
							<li><a href="/mobile/roster.php">Roster</a>
								<ul>
								</ul>
							</li>												<li class="spacer"></li>
						<!--	<li><a href="/photos.php">Photos</a></li>	-->
							<li><a href="/mobile/download.php">Docs</a>
								<ul>
							<!--		<li><a href="/comms">Committee List</a></li> -->
								<!--	<li><a href="/money">Budget</a></li> -->
								</ul>
							</li>												<li class="spacer"></li>
				
										
					<?php } ?>
			
				
				<div id="logout">
						<?php 						
							if(isset($_SESSION['id'])):
							include_once 'user.inc.php'; ?>
							[<a href="/input.php?action=logout&amp;redirect=/mobile/index.php">logout</a>]<br/> 
						<?php endif; ?>
					</div>
							
					</div>	

			<div id="content">
			
				<?php
				
				if($_SESSION['class'] == 'user')
				{
					$sql = "SELECT user_id FROM `update` WHERE user_id = '{$_SESSION['id']}' ";
					if(db_select1($sql) === false)
					{
						echo '<div class="notice">Please update your contact information.</div>';
						include $_SERVER['DOCUMENT_ROOT'] . '/people/myrosterinfo.php';
						exit();
					}
				}
				
				if(isset($_SESSION['confirmation']))
				{
					echo "<div class=\"general\"><h3>{$_SESSION['confirmation']}</h3></div><br/>";
					unset($_SESSION['confirmation']);
				}
					
				echo "\n<!-- End Header -->\n";
}

//ROSTER HEADER!!!!!

function show_rosterheader($head = '', $onload = '')
{
	// to avoid recursive calling
	if( defined('HEAD') )
		return;
	define('HEAD', true);
	
	// set variables that tell us if we're logged in and what type of user is logged in
	$set = isset($_SESSION['class']);
	$user = $_SESSION['class']=='user';
	$admin = $_SESSION['class']=='admin';
	
	// if not logged in, focus cursor on username input
	if (!$user && !$admin)
		$cursor_onload = 'document.getElementById(\'usernameinput\').focus();'
                       . 'document.getElementById(\'usernameinput\').select();';
		
	// URI given in order to access this page
	$_SESSION['page'] = $_SERVER['REQUEST_URI'];
	
	// load stylesheet according to user prefs
	$styleFilename = get_style();
	$css = '/style/mobile.css';
	
		// pick a banner to show
/*	if (!isset($_SESSION['banner_num']))
		$_SESSION['banner_num'] = rand(1,8);	
	$top_style="background-image: url('/images/mobile/header.jpg');";
	*/	
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Alpha Phi Omega, Chi Chapter - University of California, Los Angeles</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="Pragma" name="Cache-Control" content="no-cache"/>
		<meta http-equiv="Cache-Control" name="Cache-Control" content="no-cache"/>
		<!--For iphone -->
         <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
		
		<script type="text/javascript" charset="utf-8">
				addEventListener('load', function() {
						setTimeout(hideAddressBar, 0);
				}, false);
			function hideAddressBar() {
					window.scrollTo(0, 1);
						}
				</script>
		<!--------------------------------> 
				
		
		<style type="text/css" media="screen">
			@import url(<?php echo $css ?>);
		</style>
		<script src="/script/format.js" language="javascript" type="text/javascript"></script>
		<script src="/script/swfobject.js" language="javascript" type="text/javascript"></script>

		<?php echo $head ?>
	</head>
	
<body onload="<?php echo $onload ?>">	
		<div id="all">
	
		<a href="/mobile">
				<div id="top"><img src="http://www.iotaphi.org/images/mobile/header.jpg"/></div>	
			</a>
			
			<div id="main_nav">
					<?php if (!$set) { // Nav menu to show if not logged in ?>
						<ul>													
						     
				<span id='unselected' ><a style="font-size:20px; padding:0px 15px 0px 0px; " href="/mobile/index.php ">Home</a></li>	
							<li class="spacer"></span>
		
			<li ><a style='font-size:20px;padding:0px 10px 0px 8px;' href='calendar.php'>Calendar</a></li> <li class='spacer'></li>
			
						<span id="unselected" ><a style="font-size:20px; padding:0px 10px 0px 10px;" href="login.php">Log In</a></li>
						</ul>
						
				<?php } else { // Nav menu to show if logged in ?>
						<ul>													
							<span id='unselected' ><a href="/mobile/index.php">Home</a>
							<li class="spacer"></li>
							
							<span id='unselected' ><a href="/mobile/mine.php">Reqs</a></span><li class="spacer"></li>
							
							<span id='unselected' ><a href="/mobile/calendar.php">Calendar</a>	</span>					
							
							<li class="spacer"></li>
	
							<li><a href="/mobile/roster.php">Roster</a></li>							
					
							</ul>										
					<?php } ?>
				
				<div id="logout">
						<?php 						
							if(isset($_SESSION['id'])):
							include_once 'user.inc.php'; ?>
							[<a href="/input.php?action=logout&amp;redirect=/mobile/index.php">logout</a>]<br/> 
						<?php endif; ?>
					</div>
							
					</div>	

			<div id="content">
			
				<?php
				
				if($_SESSION['class'] == 'user')
				{
					$sql = "SELECT user_id FROM `update` WHERE user_id = '{$_SESSION['id']}' ";
					if(db_select1($sql) === false)
					{
						echo '<div class="notice">Please update your contact information.</div>';
						include $_SERVER['DOCUMENT_ROOT'] . '/people/myrosterinfo.php';
						exit();
					}
				}
				
				if(isset($_SESSION['confirmation']))
				{
					echo "<div class=\"general\"><h3>{$_SESSION['confirmation']}</h3></div><br/>";
					unset($_SESSION['confirmation']);
				}
					
				echo "\n<!-- End Header -->\n";
}


//CALENDAR HEADER!!!!!

function show_calendarheader($head = '', $onload = '')
{
	// to avoid recursive calling
	if( defined('HEAD') )
		return;
	define('HEAD', true);
	
	// set variables that tell us if we're logged in and what type of user is logged in
	$set = isset($_SESSION['class']);
	$user = $_SESSION['class']=='user';
	$admin = $_SESSION['class']=='admin';
	
	// if not logged in, focus cursor on username input
	if (!$user && !$admin)
		$cursor_onload = 'document.getElementById(\'usernameinput\').focus();'
                       . 'document.getElementById(\'usernameinput\').select();';
		
	// URI given in order to access this page
	$_SESSION['page'] = $_SERVER['REQUEST_URI'];
	
	// load stylesheet according to user prefs
	$styleFilename = get_style();
	$css = '/style/mobile.css';
	
		// pick a banner to show
/*	if (!isset($_SESSION['banner_num']))
		$_SESSION['banner_num'] = rand(1,8);	
	$top_style="background-image: url('/images/mobile/header.jpg');";
	*/	
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html  xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head style= "background: url('http://banana.iotaphi.org/images/mobile/calbgdown.jpg') bottom repeat-x"  >
		<title>Alpha Phi Omega, Chi Chapter - University of California, Los Angeles</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="Pragma" name="Cache-Control" content="no-cache"/>
		<meta http-equiv="Cache-Control" name="Cache-Control" content="no-cache"/>
		<!--For iphone -->
         <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
		<script type="text/javascript" charset="utf-8">
				addEventListener('load', function() {
						setTimeout(hideAddressBar, 0);
				}, false);
			function hideAddressBar() {
					window.scrollTo(0, 1);
						}
				</script>
		<!--------------------------------> 
				
		
		<style type="text/css" media="screen">
			@import url(<?php echo $css ?>);
		</style>
		<script src="/script/format.js" language="javascript" type="text/javascript"></script>
		<script src="/script/swfobject.js" language="javascript" type="text/javascript"></script>

		<?php echo $head ?>
	</head>
	
<body onload="<?php echo $onload ?>">	
		<div id="all">
	
<a href="/mobile">
				<div id="top"><img src="http://www.iotaphi.org/images/mobile/header.jpg"/></div>	
			</a>
			
			<div id="main_nav">
					<?php if (!$set) { // Nav menu to show if not logged in ?>
						<ul>													
						     
				<span id='unselected' ><a style="font-size:20px; padding:0px 10px 0px 10px;"  href="/mobile/index.php ">Home</a></li>	
							<li class="spacer"></span>
		
			<li ><a style="font-size:20px; padding:0px 10px 0px 10px;"  href='calendar.php'>Calendar</a></li> <li class='spacer'></li>
			
						<span id="unselected" ><a style="font-size:20px; padding:0px 10px 0px 10px;" href="login.php">Log In</a></li>
						</ul>
						
				<?php } else { // Nav menu to show if logged in ?>
						<ul>													
							<span id='unselected' ><a  href="/mobile/index.php">Home</a>
							<li class="spacer"></li>
							
							<span id='unselected' ><a href="/mobile/mine.php">Reqs</a></span><li class="spacer"></li>
							
							<li><a href="/mobile/calendar.php">Calendar</a>	</li>							
							
							<li class="spacer"></li>
	
							<span id='unselected' ><a href="/mobile/roster.php">Roster</a></span>								
						<!--	<li><a href="/photos.php">Photos</a></li>	-->
							</ul>										
					<?php } ?>
				
				<div id="logout">
						<?php 						
							if(isset($_SESSION['id'])):
							include_once 'user.inc.php'; ?>
							[<a href="/input.php?action=logout&amp;redirect=/mobile/index.php">logout</a>]<br/> 
						<?php endif; ?>
					</div>
							
					</div>	

			<div id="content">
			
				<?php
				
				if($_SESSION['class'] == 'user')
				{
					$sql = "SELECT user_id FROM `update` WHERE user_id = '{$_SESSION['id']}' ";
					if(db_select1($sql) === false)
					{
						echo '<div class="notice">Please update your contact information.</div>';
						include $_SERVER['DOCUMENT_ROOT'] . '/people/myrosterinfo.php';
						exit();
					}
				}
				
				if(isset($_SESSION['confirmation']))
				{
					echo "<div class=\"general\"><h3>{$_SESSION['confirmation']}</h3></div><br/>";
					unset($_SESSION['confirmation']);
				}
					
				echo "\n<!-- End Header -->\n";
}


//NORMAL HEADER!!!!!

function show_header($head = '', $onload = '')
{
	// to avoid recursive calling
	if( defined('HEAD') )
		return;
	define('HEAD', true);
	
	// set variables that tell us if we're logged in and what type of user is logged in
	$set = isset($_SESSION['class']);
	$user = $_SESSION['class']=='user';
	$admin = $_SESSION['class']=='admin';
	
	// if not logged in, focus cursor on username input
	if (!$user && !$admin)
		$cursor_onload = 'document.getElementById(\'usernameinput\').focus();'
                       . 'document.getElementById(\'usernameinput\').select();';
		
	// URI given in order to access this page
	$_SESSION['page'] = $_SERVER['REQUEST_URI'];
	
	// load stylesheet according to user prefs
	$styleFilename = get_style();
	$css = '/style/mobile.css';
	
		// pick a banner to show
/*	if (!isset($_SESSION['banner_num']))
		$_SESSION['banner_num'] = rand(1,8);	
	$top_style="background-image: url('/images/mobile/header.jpg');";
	*/	
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Alpha Phi Omega, Chi Chapter - University of California, Los Angeles</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="Pragma" name="Cache-Control" content="no-cache"/>
		<meta http-equiv="Cache-Control" name="Cache-Control" content="no-cache"/>
		<!--For iphone -->
         <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
		<script type="text/javascript" charset="utf-8">
				addEventListener('load', function() {
						setTimeout(hideAddressBar, 0);
				}, false);
			function hideAddressBar() {
					window.scrollTo(0, 1);
						}
				</script>
		<!--------------------------------> 
				
		
		<style type="text/css" media="screen">
			@import url(<?php echo $css ?>);
		</style>
		<script src="/script/format.js" language="javascript" type="text/javascript"></script>
		<script src="/script/swfobject.js" language="javascript" type="text/javascript"></script>
		

		<?php echo $head ?>
	</head>
	
<body onload="<?php echo $onload ?>">	
		<div id="all">
	
<a href="/mobile">
				<div id="top"><img src="http://www.iotaphi.org/images/mobile/header.jpg"/></div>	
			</a>
			
			<div id="main_nav">
					<?php if (!$set) { // Nav menu to show if not logged in ?>
						<ul>													
						     
				<li> <a style="font-size:20px; padding:0px 15px 0px 10px; " href="/mobile/index.php ">Home</a></li>	
							<li class="spacer"></li>
		
		<span id='unselected' > <a style='font-size:20px;padding:0px 10px 0px 8px;' href='calendar.php'>Calendar</a></span> 
		<li class='spacer'></li>
			
						<span id="unselected" ><a style="font-size:20px; padding:0px 10px 0px 10px;" href="login.php">Log In</a></li>
						</ul>
						
				<?php } else { // Nav menu to show if logged in ?>
						<ul>													
							<li> <a href="/mobile/index.php">Home</a>
							</li>
							
							<li class="spacer"></li>
							
							<span id='unselected' ><a href="/mobile/mine.php">Reqs</a></span><li class="spacer"></li>
							
							<span id='unselected' ><a href="/mobile/calendar.php">Calendar</a>	</span>					
							
							<li class="spacer"></li>
	
							<span id='unselected' ><a href="/mobile/roster.php">Roster</a></span>								
						<!--	<li><a href="/photos.php">Photos</a></li>	-->
							</ul>										
					<?php } ?>
				
				<div id="logout">
						<?php 						
							if(isset($_SESSION['id'])):
							include_once 'user.inc.php'; ?>
							[<a href="/input.php?action=logout&amp;redirect=/mobile/index.php">logout</a>]<br/> 
						<?php endif; ?>
					</div>
							
					</div>	

			<div id="content">
			
				<?php
				
				if($_SESSION['class'] == 'user')
				{
					$sql = "SELECT user_id FROM `update` WHERE user_id = '{$_SESSION['id']}' ";
					if(db_select1($sql) === false)
					{
						echo '<div class="notice">Please update your contact information.</div>';
						include $_SERVER['DOCUMENT_ROOT'] . '/people/myrosterinfo.php';
						exit();
					}
				}
				
				if(isset($_SESSION['confirmation']))
				{
					echo "<div class=\"general\"><h3>{$_SESSION['confirmation']}</h3></div><br/>";
					unset($_SESSION['confirmation']);
				}
					
				echo "\n<!-- End Header -->\n";
}

function show_footer()
{ 
	// to avoid recursive calling
	if( defined('FOOT') )
		return;
	define('FOOT', true);

?>

<!-- Start Footer -->
			</div> <!-- end #content div -->				
			<div style="clear: both;"></div>			
			<div id="bottom">
				<span class="copyright">&copy; &#913; &#934  &#937 , Chi &nbsp;&nbsp; | &nbsp;&nbsp;
				<a href="http://www.apo-x.org/tracking/mine.php">Normal Site</a> 
				</span>
			</div>
		</div> <!-- end #all div -->
	

<!-- DIV used for calendar popup -->
<div id="calendardiv" style="position:absolute;visibility:hidden;margin:0px;padding:0px;"></div>
<div id="loading" style="position: absolute; top: 0px; display:none; width: 150px; height: 50px; background: #f00;">Loading</div>
</body>
</html>
<?php 
// close session first so we can close the db
session_write_close();
db_close();
}

function show_note($note)
{
	if(HEAD !== true)
		show_header();
	echo '<div class="notice">',$note,'</div>';
	show_footer();
	exit();
}

?>
