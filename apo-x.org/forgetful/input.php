<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/template.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/forms.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

get_header();

$myid = $_SESSION['id'];
$myclass = $_SESSION['class'];
$action = $_REQUEST['action'];

function genToken( $len = 32, $md5 = true ) {
    # Seed random number generator
    # Only needed for PHP versions prior to 4.2
    mt_srand( (double)microtime()*1000000 );
 
    # Array of characters, adjust as desired
    $chars = array(
        'Q', '@', '8', 'y', '%', '^', '5', 'Z', '(', 'G', '_', 'O', '`',
        'S', '-', 'N', '<', 'D', '{', '}', '[', ']', 'h', ';', 'W', '.',
        '/', '|', ':', '1', 'E', 'L', '4', '&', '6', '7', '#', '9', 'a',
        'A', 'b', 'B', '~', 'C', 'd', '>', 'e', '2', 'f', 'P', 'g', ')',
        '?', 'H', 'i', 'X', 'U', 'J', 'k', 'r', 'l', '3', 't', 'M', 'n',
        '=', 'o', '+', 'p', 'F', 'q', '!', 'K', 'R', 's', 'c', 'm', 'T',
        'v', 'j', 'u', 'V', 'w', ',', 'x', 'I', '$', 'Y', 'z', '*'
    );
 
    # Array indice friendly number of chars; empty token string
    $numChars = count($chars) - 1; $token = '';
 
    # Create random token at the specified length
    for ( $i=0; $i<$len; $i++ )
        $token .= $chars[ mt_rand(0, $numChars) ];
 
    # Should token be run through md5?
    if ( $md5 ) {
 
        # Number of 32 char chunks
        $chunks = ceil( strlen($token) / 32 ); $md5token = '';
 
        # Run each chunk through md5
        for ( $i=1; $i<=$chunks; $i++ )
            $md5token .= md5( substr($token, $i * 32 - 32, 32) );
 
        # Trim the token
        $token = substr($md5token, 0, $len);
 
    } return $token;
}

function getUser($email)
{
	$sql = 'SELECT user_id AS id , user_name AS name , user_password as password , user_email AS email '
	. " FROM user WHERE LOWER(user_email) = LOWER('$email') ";
	return db_select1($sql);
}

function sendInfo( $id , $username , $password , $email )
{	
	$token = genToken( );
	// 45 minutes * 60 seconds so the window to reset is only 30 minutes long
	$expiration = time()+(50*60);
	$sql = 'SELECT * FROM actions WHERE user_id=' . $id . ' AND value3=\'forgot\'';
	$check = db_select1( $sql );
	if ( $check )
	{
		$sql = 'UPDATE actions SET value=\''.$token.'\' , value2=\''.$expiration.'\' WHERE user_id=' . $id;
		mysql_query( $sql );
	} else {
		$sql = 'INSERT INTO actions ( user_id , value , value2 , value3 ) VALUES ( \''.$id. ' \', \'' . $token. '\' , \'' . $expiration . '\' , \'forgot\' )';
		mysql_query( $sql );
	}
	$link = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'] . '?id=' . $id . '&token=' . $token;
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
	$headers .= 'From: no-reply@'.substr( $_SERVER['SERVER_NAME'] , 4 ) . "\r\n";
	$body .= "<p>This email is being sent because you, $username, forgot your password. If this is not the case, please ignore this email.</p>";
	$body .= "<p><a href='$link'>Click here to reset your password</a>. If you do not see a link, copy and paste the following into your browser. ($link)</p>";
	$body .= "<p>Have a nice day!</p>";
	$body .= "<p>- The ".CHAPTER_NAME." Robot</p>";
	mail( $email , CHAPTER_NAME.' password reset' , $body , $headers );
}

if($action=='mailpassword')
{
	$user = getUser($_POST['email']);
	if($user)
	{
		sendInfo($user['id'],$user['name'], $user['password'], $user['email']);
		$redirect = "/forgetful/index.php?name={$user['name']}";
	}
	else
		$redirect = '/forgetful/index.php?name=failure';
	$htmlOut = "<meta http-equiv=\"refresh\" content=\"0;url=$redirect\">";
} else {
	$htmlOut = "<div class=\"general\">";
	if ( isset( $_POST['token'] ) && isset( $_POST['password'] ) && isset( $_POST['id'] ) )
	{
		$id = htmlentities( $_POST['id'] , ENT_QUOTES );
		$token = htmlentities( $_POST['token'] , ENT_QUOTES );
		// check once again for a valid token
		$sql = 'SELECT * FROM actions WHERE user_id=' . $id . ' AND value=\'' . $token . '\' AND value2>\''.time().'\' AND value3=\'forgot\'';
		$check = db_select1( $sql );
		$password = htmlentities( $_POST['password'] , ENT_QUOTES );
		if ( $check ) {
			// stop them from using the same reset token multiple times
			$sql = 'DELETE FROM actions WHERE user_id=' . $id . ' AND value=\'' . $token . '\' AND value2>\''.time().'\' AND value3=\'forgot\'';
			db_select( $sql );
			$sql = 'UPDATE user SET user_password=\'' . md5( $password ) . '\' WHERE user_id=' . $id;
			db_select( $sql );
			$htmlOut .= "<p>Your password has been changed!</p>";
		} else {
			$htmlOut .= "<p>There seems to be a problem. Try again</p>";
		}
	} else if ( isset( $_GET['id'] ) && isset( $_GET['token'] ) ) {
		$id = htmlentities( $_GET['id'] , ENT_QUOTES );
		$token = htmlentities( $_GET['token'] , ENT_QUOTES );
		// check if the token is valid
		$sql = 'SELECT * FROM actions WHERE user_id=' . $id . ' AND value=\'' . $token . '\' AND value2>\''.time().'\' AND value3=\'forgot\'';
		$check = db_select1( $sql );
		if ( $check ) {
			// this means they are resetting
			$htmlOut .= <<<EOT
			<script type="text/javascript">
				function ResetPassword() {
					if ( document.getElementById('password').value != document.getElementById('confirmPassword').value ) {
						document.getElementById("status").innerHTML = "<p>You seemed to have typed in two different passwords. Try again</p>";
						return;
					}
					document.getElementById("status").innerHTML = "<p>Submitting...</p>";
					document.getElementById("reset").submit();
				}
			</script>
			<div id="status"></div>
			<form method="post" action="/forgetful/input.php" id="reset">
				<input type="hidden" value="$id" name="id" />
				<input type="hidden" value="$token" name="token" />
				<div>New Password: <input type="password" name="password" id="password" /></div>
				<div>Confirm Password: <input type="password" id="confirmPassword" /></div>
				<input type="button" value="Change My Password!" onClick="ResetPassword()" />
			</form>
EOT;
		} else {
			// totally faked the reset
			$htmlOut .= "<p>There was an error reseting your password. Try again. The password reset link is only valid for 50 minutes.</p>";
		}
	} else {
		$htmlOut .= "<p>You should not be seeing this.</p>";
		$redirect = '../';
	$htmlOut = "<meta http-equiv=\"refresh\" content=\"0;url=$redirect\">";
	}
	$htmlOut .= "</div>";
}
echo $htmlOut;
show_footer();
?>