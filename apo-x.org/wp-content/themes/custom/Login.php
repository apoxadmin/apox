<?php /* Template Name: Login page*/
get_header();
ini_set( "display_errors", 0);

include_once($_SERVER['DOCUMENT_ROOT'] . '/include/database.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/include/constants.inc.php');
db_open();
include_once($_SERVER['DOCUMENT_ROOT'] . '/include/session.inc.php');
?>

<!DOCTYPE html>
<body>
<?php
	if($_SESSION['class'] == 'admin') { 
	// if logged in as admin
	echo '<script>window.location = "/";</script>';
	}
	elseif(isset($_SESSION['id'])) {
	// if logged in as a member
	echo '<script>window.location = "/";</script>';
	}
?>

<form class="form-inline" method="post" action="/input.php">
    <input name="action" type="hidden" value="login" />
    <input name="redirect" type="hidden" value="<?php echo $_SERVER["REQUEST_URI"] ?>" />
   	<input type="text" name="username"  class="input-small" placeholder="Your Name"  onclick="this.select();" value="<?php echo $_COOKIE['username'] ?>" />
    <input type="password" name="password" class="input-small" placeholder="Password" onclick="this.select();" />
   	<button type="submit" name="submit" value="Log In"  class="btn"/>Sign In</button>
	</form>
    	
<?php get_footer() ?>