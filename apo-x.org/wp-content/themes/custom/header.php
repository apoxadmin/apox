
<?php
ini_set( "display_errors", 0);

include_once($_SERVER['DOCUMENT_ROOT'] . '/include/database.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/include/constants.inc.php');
db_open();
include_once($_SERVER['DOCUMENT_ROOT'] . '/include/session.inc.php');
?>
<!DOCTYPE html>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title>Alpha Phi Omega | Chi</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<script src="/script/bootstrap.min.js"></script>
<script type="text/javascript">
</script>
<?php if ( !is_user_logged_in() ){ ?>
	    <style>
            #wpadminbar{ display:none; }
	    html { margin-top: 28px !important}
            </style>
		<?php } ?>
<?php
	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
</head>

<body>
	<header>
	<!-- Modified 02/15/2014
		Added this to give the sectionals page special viewing privileges
	-->
	<?php if(is_page('sectionals')){
			echo '<div id="header" class="container">'				
			.'<a href="http://www.apo-x.org/sectionals"><img src="/images/crest.png" alt="Alpha Phi Omega Crest" /></a>'
	    	.'<div id="access" role="navigation" >';
	      }
	      else{
	      	echo '<div id="header" class="container">'				
			.'<a href="http://www.apo-x.org"><img src="/images/crest.png" alt="Alpha Phi Omega Crest" /></a>'
			.'<div id="access" role="navigation" >';
	      }
	?>
						
	<?php
	/* adding the menu swap here */
	if($_SESSION['class'] == 'admin') { 
		 wp_nav_menu( array( 'container_class' => 'menu-header', 'menu' => 'Excomm' , 'theme_location' => 'primary' ) );
	}
	elseif(isset($_SESSION['id'])) {
	 // if they are logged in
	 wp_nav_menu( array( 'container_class' => 'menu-header', 'menu' => 'Logged_In' , 'theme_location' => 'primary' ) );
	} 
	///// Added 02/15/2014
	elseif(is_page('sectionals')){ //check the current page you are viewing and see if it is the one specified
	 //if they are viewing the sectionals page
	 wp_nav_menu( array( 'container_class' => 'menu-header', 'menu' => 'Sectionals' , 'theme_location' => 'primary' ) );
	}
	/////
	else {
	 // they are not logged in
	 wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) );
	}
	
	?>
	</div>
	<?php 						
			if(isset($_SESSION['id'])):
			include_once 'user.inc.php'; 
	?>
			 <a class="btn btn-small btn-danger" href="/input.php?action=logout&amp;redirect=index.php">logout</a>
		    <?php elseif(is_page('sectionals')): ?>
		    <?php else: ?>		
	<a href="#myModal" role="button" class="btn btn-small" data-toggle="modal">Login</a>
                <?php endif; ?>
	</div>	
	
		</header>
<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <h3 id="myModalLabel">Alpha Phi Omega | Chi - Log In</h3>
  </div>
  <div class="modal-body">
    <p>	    	
    	<form class="form-inline" method="post" action="/input.php">
    		<input name="action" type="hidden" value="login" />
    		<input name="redirect" type="hidden" value="<?php echo $_SERVER["REQUEST_URI"] ?>" />
    		<input type="text" name="username"  class="input-small" placeholder="Your Name"  onclick="this.select();" value="<?php echo $_COOKIE['username'] ?>" />
    		<input type="password" name="password" class="input-small" placeholder="Password" onclick="this.select();" />
    		<button type="submit" name="submit" value="Log In"  class="btn"/>Sign In</button>
    	</form>
    	</p>
  </div>
</div>
<!-- cy -->
<div id="container" class="container" >
