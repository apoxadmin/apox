<?php 
include_once dirname(dirname(__FILE__)) . '/include/template.inc.php'; 

$myid = $_SESSION['id'];
$myclass = $_SESSION['class'];
$action = $_REQUEST['action'];

if($action=='mail')
{
    include_once dirname(dirname(__FILE__)) . '/include/mail.inc.php';
    
    mail_mass($_POST['from'], $_POST['to'], $_POST['subject'], 
                str_replace("\n","<br />",$_POST['body']));
}
elseif($action=='removechair')
{
    extract($_POST);
    mysql_query("DELETE FROM chair WHERE event_id = '$event' AND user_id = '$user' ");
}
elseif($action=='addchair')
{
    extract($_POST);

    if($myclass == 'user')
        $user = array($myid);

    foreach($user as $u)
    {
        $query = "INSERT INTO chair(event_id, user_id) "
            . " VALUES ('$event', '$u')";
        mysql_query($query) or die("Query Failed; see input.php or inputAdmin.php");
    }
}
elseif($action=='removeinterest')
{
    extract($_POST);
    
    if($myclass == 'user')
        $user = $myid;
        
    mysql_query("DELETE FROM interest WHERE event_id = '$event' AND user_id = '$user' ");
}
elseif($action=='addinterest')
{
    extract($_POST);

    if($myclass == 'user')
        $user = array($myid);

    foreach($user as $u)
    {
        $query = "INSERT INTO interest(event_id, user_id) "
            . " VALUES ('$event', '$u')";
        mysql_query($query) or die("Query failed =(");
    }
}
?>
<HTML>
<HEAD>
<meta http-equiv="refresh" content="0;url=<?php echo $_REQUEST['redirect'] ?>">
</HEAD>
</HTML>
