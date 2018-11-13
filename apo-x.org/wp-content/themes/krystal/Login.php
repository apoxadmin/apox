<?php /* Template Name: Login page*/
get_header();
ini_set( "display_errors", 0);

include_once($_SERVER['DOCUMENT_ROOT'] . '/include/database.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/include/constants.inc.php');
db_open();
include_once($_SERVER['DOCUMENT_ROOT'] . '/include/session.inc.php');
?>

<!DOCTYPE html>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php krystal_get_page_title(false,false,false,false); ?>
		
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
  <div class="form">
<form class="form-inline" method="post" action="/input.php">
    <input name="action" type="hidden" value="login" />
    <input name="redirect" type="hidden" value="<?php echo $_SERVER["REQUEST_URI"] ?>" />
   	<input type="text" name="username" placeholder="Your Name"  onclick="this.select();" value="<?php echo $_COOKIE['username'] ?>" /><br>
    <input type="password" name="password" placeholder="Password" onclick="this.select();" /><br>
   	<input type="submit" name="submit" value="Log In"  class="btn">
</form></div>
    		</main>
</div>
<?php get_footer() ?>