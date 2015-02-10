<?php 
include_once 'include/template.inc.php'; 
date_default_timezone_set('America/Los_Angeles');

$myid = $_SESSION['id'];
$myclass = $_SESSION['class'];
$action = $_REQUEST['action'];

// action = login
if($action=='login'):

    if(isset($_POST['username'],$_POST['password'])):
        include_once 'include/user.inc.php';
        $id = '';
        $id = user_getID($_POST['username'],$_POST['password']);
		// try to get from admin table
    
        if($id!='') 
        {
            $_SESSION['id'] = $id;
            if($_SESSION['id'])
                $user = db_select1("SELECT family_id, status_id, user_hidden FROM user WHERE user_id = '$id'");
            			
            if($user['status_id'] == STATUS_ADMINISTRATOR)
                $_SESSION['class'] = 'admin';
			else if($user['status_id'] == 10)
                $_SESSION['class'] = 'finance';
            else if ($user['status_id'] == STATUS_DEACTIVATED)
            {
				session_unset();
				show_note ("This account has been disabled.");
			}
			else
                $_SESSION['class'] = 'user';
				
			//if they're a hidden user and they login, change them to visible
			if($user['user_hidden'] && $user['status_id'] != STATUS_ADMINISTRATOR && $user['status_id'] != STATUS_DEACTIVATED)
			{
			$sql = "UPDATE user SET user_hidden=0 WHERE user_id='$id'";
			mysql_query($sql) or die("Couldn't make you visible again!");
			}
				
			//record login time in user table of database
			user_updateLastLogin($id);

            $_SESSION['family'] = $user['family_id'];
			$_SESSION['banner_num'] = rand(1,8); // pick a new banner on login
            setcookie('username', $_POST['username'], time() + 604800, "/", '.alluminati.org');
        }
        else
            show_note('Incorrect username/password!<br /><br />Did you forget your password, or are you a new member?  Click <a href="/forgetful/index.php">here</a>!');
    endif;
// action = logout
elseif($action=='logout'):
    session_unset();
elseif($action=='unsignup'):
    include_once dirname(__FILE__) . '/include/signup.inc.php';
    signup_delete($_POST['shift'],$myid);
elseif($action=='signupdate'):
    include_once dirname(__FILE__) . '/include/signup.inc.php';
    signup_update($_POST['shift'],$myid,
        isset($_POST['chair'])?1:0,
        isset($_POST['driving'])?1:0,
        isset($_POST['camera'])?1:0,
		isset($_POST['ride'])?1:0,
		$_POST['custom1'],
		$_POST['custom2'],
		$_POST['custom3'],
		$_POST['custom4'],
		$_POST['custom5']);
elseif($action=='signup'):
    include_once dirname(__FILE__) . '/include/signup.inc.php';
    // if any shifts are selected
    if(isset($_POST['shift']) && $myclass!="admin")
    {
        signup_add($_POST['shift'],$myid,
            isset($_POST['chair'])?1:0,
            isset($_POST['driving'])?1:0,
            isset($_POST['camera'])?1:0,
			isset($_POST['ride'])?1:0,
			$_POST['custom1'],
			$_POST['custom2'],
			$_POST['custom3'],
			$_POST['custom4'],
			$_POST['custom5']);
    }
    else{}
elseif($action=='request_replacement'):
    include_once dirname(__FILE__) . '/include/signup.inc.php';
    // toggles wants_replacement in signup table
    signup_request_replacement($_POST['shift'],$_POST['user']);
elseif($action=='replace'):
    include_once 'dirname(__FILE__) . /include/signup.inc.php';
    signup_replace($_POST['shift'],$_POST['user'],$myid);
elseif($action=='addcomment'):
	$timeComment = date("[M j, g:i A]");
	$timeComment .= " " . $_POST['comment'];
	
	$query = "INSERT INTO eventcomment(user_id,event_id,comment) VALUES ('{$_POST['user_id']}','{$_POST['event_id']}','{$timeComment}')";
	mysql_query($query) or die('Error adding comment to database');
elseif($action=='deletecomment'):
	// Check if comment belongs to user, or user is logged in as ExComm
	$query = "SELECT user_id FROM eventcomment WHERE eventcomment_id = {$_GET['eventcomment_id']}";
	$result = db_select1($query) or die('Error deleting comment');
	$comment_user_id = $result['user_id'];
	if ($myclass == 'admin' || ($myid == $comment_user_id)):
		$query = "DELETE FROM eventcomment WHERE eventcomment_id = {$_GET['eventcomment_id']} LIMIT 1";
		mysql_query($query) or die('Error deleting comment');
	endif;
elseif(!isset($action)):
    $_REQUEST['redirect'] = '/index.php';
endif;
header("Location: " . $_REQUEST['redirect']);
?>
