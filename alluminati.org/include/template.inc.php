<?php
include_once 'session.inc.php';
include_once 'database.inc.php';
include_once 'constants.inc.php';
include($_SERVER['DOCUMENT_ROOT']. '/wp-load.php');

db_open();

function get_style()
{
	if (!isset($_SESSION['class'])) {
		return "original2";
	}
	$sql = "SELECT style_id FROM user WHERE user_id='{$_SESSION['id']}'";
	$result = mysql_query($sql) or die("Query Failed (get_style)! ". mysql_error());
	$styleArray = mysql_fetch_assoc($result);
	$styleNum = $styleArray['style_id'];

	if(!is_numeric($styleNum)) $styleName = "original2";
	else if($styleNum==2)
	{
		switch($_SESSION['family'])
		{
			case 1: $styleName = "Alpha"; break;
			case 2: $styleName = "Phi"; break;
			case 3: $styleName = "Omega"; break;
			default: $styleName = "original"; break;
		}
	} else {
		$sql = "SELECT style_file FROM style WHERE style_id='{$styleNum}'";
		$result = mysql_query($sql) or die("Query Failed (get_style)! ". mysql_error());
		$styleArray = mysql_fetch_assoc($result);
		$styleName = $styleArray['style_file'];
	}
	return $styleName;
}

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
	$css = '/style/'.$styleFilename.'.css';
	
		// pick a banner to show
	if (!isset($_SESSION['banner_num']))
		$_SESSION['banner_num'] = rand(1,8);	
	$top_style="background-image: url('/images/{$styleFilename}/banner{$_SESSION['banner_num']}.jpg');";
		
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Alpha Phi Omega, Chi Chapter - University of California, Los Angeles</title>
<!--		<script type="text/javascript" src="jquery-1.6.1.min.js"></script>	-->
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="Pragma" name="Cache-Control" content="no-cache"/>
		<meta http-equiv="Cache-Control" name="Cache-Control" content="no-cache"/>
		<style type="text/css" media="screen">
			@import url(<?php echo $css ?>);
		</style> 
		<script src="/script/format.js" language="javascript" type="text/javascript"></script>
		<script src="/script/swfobject.js" language="javascript" type="text/javascript"></script>
		<?php echo $head ?>
	</head>
	
<body onload="<?php echo $onload ?>">
	
	
					
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


function show_calhead($head = '', $onload = '')
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
	$css = '/style/'.$styleFilename.'.css';
	
		// pick a banner to show
	if (!isset($_SESSION['banner_num']))
		$_SESSION['banner_num'] = rand(1,8);	
	$top_style="background-image: url('/images/{$styleFilename}/banner{$_SESSION['banner_num']}.jpg');";
		
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Alpha Phi Omega, Chi Chapter</title>
<!--		<script type="text/javascript" src="jquery-1.6.1.min.js"></script>	-->
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="Pragma" name="Cache-Control" content="no-cache"/>
		<meta http-equiv="Cache-Control" name="Cache-Control" content="no-cache"/>
		<style type="text/css" media="screen">
			@import url(<?php echo $css ?>);
		</style> 
		<script src="/script/format.js" language="javascript" type="text/javascript"></script>
		<script src="/script/swfobject.js" language="javascript" type="text/javascript"></script>
		<?php echo $head ?>
	</head>

<body onload="<?php echo $onload ?>">
	
<?php get_header(); ?>
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
</div>
</div><!-- #container -->
		<!--<div id="bottom_background"></div>-->

<!-- DIV used for calendar popup -->
<div id="calendardiv" style="position:absolute;visibility:hidden;margin:0px;padding:0px;"></div>
<div id="loading" style="position: absolute; top: 0px; display:none; width: 150px; height: 50px; background: #f00;">Loading</div>
<img src="/images/original/banner6.jpg" style="position: absolute; top: -10000px; left: -10000px;" />
</body>
</html>
</div>
	<div id="footer" role="contentinfo">
					<div id="login">
					
					</div>
					
						<div id="copyright">
		 &copy; All Copyright Reserved |  Alpha Phi Omega - University of California, Los Angeles
		 	</div>
		
		</div><!-- Footer -->


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
