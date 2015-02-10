<?php 
include_once dirname(dirname(__FILE__)) . '/include/mobiletemplate.inc.php';

show_loginheader();
?>


<div id="login">
	<div class="general">
	
						<?php 						
							if(isset($_SESSION['id'])):
							include_once 'user.inc.php'; ?>
							Hi <?php echo user_getUsername($_SESSION['id']),'!' ?> 
							[<a href="/input.php?action=logout&amp;redirect=/index.php">logout</a>]<br/> 
						<?php else: ?>
						<form method="post" action="/input.php">
							<input name="action" type="hidden" value="login" />
							<input name="redirect" type="hidden" value="mobile/index.php" />
							<label for="usernameinput">User Name:<br> <input type="text" name="username" id="usernameinput" size=8 onclick="this.select();" value="<?php echo $_COOKIE['username'] ?>" /></label><br><br>
							<label for="passwordinput">Password:<br> <input type="password" name="password" id="passwordinput" size=8 onclick="this.select();" /></label>
							<br>
							<br>
							<input type="submit" name="submit" value="Log In" />
						</form>
						<?php endif; ?>
					</div>
				
</div>
	
<?php
	
show_footer(); 
?> 
