<?php /* Template Name: Login page*/
get_header();
ini_set( "display_errors", 0);

include_once($_SERVER['DOCUMENT_ROOT'] . '/include/database.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/include/constants.inc.php');
db_open();
include_once($_SERVER['DOCUMENT_ROOT'] . '/include/session.inc.php');
?>

<!DOCTYPE html>
<head>
<style>
.form {
	max-width: 300px;
  text-align: center;
	margin: 0 auto;
	margin-bottom: 100px;
}
.form input[type="text"],input[type="password"] {
  outline: 0;
  width: 100%;
	height: 50px;
  border: 0;
  margin: 0 0 10px;
  padding: 15px;
  box-sizing: border-box;
  font-size: 14px;
	font-weight: 400;
	border-bottom: 2px solid #555;  
	border-radius: 0px;
}
input[type="submit"]{
	width: 100%;
    background: none;
    border-radius: 45px;
    border: 1px solid #555;
    color: #555;
    padding: 15px 40px;
    transition: all 0.3s ease-in-out; 
    outline: 0 !important;
    -webkit-appearance: none;
}
</style></head>
<body>
		<div id="primary" class="<?php echo hestia_boxed_layout_header(); ?> page-header header-small">
		<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1 text-center">
					<?php single_post_title( '<h1 class="hestia-title">', '</h1>' ); ?>
				</div>
			</div>
		</div>
		<?php hestia_output_wrapper_header_background( false ); ?>
	</div>
</header>
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
	<body>
  <div class="form">
<form class="form-inline" method="post" action="/input.php">
    <input name="action" type="hidden" value="login" />
    <input name="redirect" type="hidden" value="<?php echo $_SERVER["REQUEST_URI"] ?>" />
   	<input type="text" name="username" placeholder="Your Name"  onclick="this.select();" value="<?php echo $_COOKIE['username'] ?>" /><br>
    <input type="password" name="password" placeholder="Password" onclick="this.select();" /><br>
   	<input type="submit" name="submit" value="Log In"  class="btn">
</form></div></body>
    	
<?php get_footer() ?>