<?php
if(session_id() == '') {
    session_start();
}
ob_start();
include_once 'database.inc.php';
define('SESSION_TABLE', 'session');
// open it if it's not open yet
db_open();
if(!function_exists('file_put_contents'))
{
    function file_put_contents($file, $string) {
       $f=fopen($file, 'a+');
       ftruncate($f, 0);
       fwrite($f, $string);
       fclose($f);
    }
}
/* Change the save_handler to use the class functions */
session_set_save_handler ('mysession_open',
                          'mysession_close',
                          'mysession_read',
                          'mysession_write',
                          'mysession_destroy',
                          'mysession_gc');
//header("Cache-control:private"); //IE6 Fix
/* Open session */
function mysession_open($path, $name) {
    return true;
}
/* Close session */
function mysession_close() {
    mysession_gc(0);
    return true;
}

/* Read session data from database */
function mysession_read($ses_id) {
    $session_sql = "SELECT * FROM " . SESSION_TABLE
                 . " WHERE ses_id = '$ses_id'";
    $session_res = @mysql_query($session_sql) or die('Session read failed.');

    if (@mysql_num_rows ($session_res) > 0) {
        $row = mysql_fetch_assoc ($session_res);
        return $row['ses_value'];
    }
    else
        return '';
}

/* Write new data to database */
function mysession_write($ses_id, $data)
{
    // get the user's id from the session
    if(preg_match('/id\|s\:[0-9]*\:\"([0-9]*)\"/', $data, $match))
        $id = $match[1];

    $now = strtotime('now');
    $data = addslashes($data);

    $session_sql = "UPDATE " . SESSION_TABLE
                 . " SET ses_time = '$now', ses_value = '$data', user_id = '$id' "
                 . " WHERE ses_id = '$ses_id'";
    $session_res = @mysql_query($session_sql);
    // how to debug since session_write is called after output ends
    //or file_put_contents('/tmp/debug.txt', 'Session write failed.' . mysql_error());
    
    // if update is successful, stop here
    if(mysql_affected_rows())
    {
        //file_put_contents('/tmp/debug.txt', 'Updated...'. $data);
        return true;
    }

    // session doesn't exist yet, make it
    $session_sql = "INSERT INTO " . SESSION_TABLE
                 . " (ses_id, ses_time, ses_start, ses_value, user_id)"
                 . " VALUES ('$ses_id', '$now', '$now', '$data', '$id')";
    $session_res = @mysql_query($session_sql);// or file_put_contents('/tmp/debug.txt', 'Session write failed 2.');

    return true;
}

/* Destroy session record in database */
function mysession_destroy($ses_id) {
    $session_sql = "DELETE FROM " . SESSION_TABLE
                 . " WHERE ses_id = '$ses_id'";
    $session_res = @mysql_query ($session_sql) or die('Session destroy failed.');

    return true;
}

/* Garbage collection, deletes old sessions */
function mysession_gc($life) {
    $ses_life = strtotime("-6 hours");

    $session_sql = "DELETE FROM " . SESSION_TABLE
                 . " WHERE ses_time < '$ses_life' ";
    $session_res = @mysql_query ($session_sql) or die('Session gc failed.');

    return true;
}

/*Required table

CREATE TABLE session (
   ses_id varchar(32) NOT NULL default '',
   ses_time int(11) NOT NULL default '0',
   ses_start int(11) NOT NULL default '0',
   ses_value text NOT NULL,
   user_id int(11) NOT NULL,
   PRIMARY KEY  (ses_id)
) TYPE=MyISAM;
*/

?>