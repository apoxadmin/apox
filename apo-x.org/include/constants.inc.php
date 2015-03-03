<?php
//these have been deprecated. Use database.inc.php::db_currentClass()
//$GLOBALS['TERM_START'] = '20080127210000'; // the moment active reqs due
//define('CURRENT_CLASS', 98);


$GLOBALS['PROFILE_WIDTH'] = 160;
$GLOBALS['PROFILE_HEIGHT'] = 200;

define('CHAPTER_NAME' , 'Chi' ); // chapter name for the forgot password (title of email)

define('SIGNUP_DAYS', 2); // minimum amount of time before Service events that you can remove yourself without finding a replacement
define('REMOVE_DAYS', 2); // minimum amount of time before Service events that you can sign up

//minimum amount of time before Interviews events needed to sign up/remove
define('INTERVIEWS_SIGNUP_DAYS', 2);
define('INTERVIEWS_REMOVE_DAYS', 2);

date_default_timezone_set("America/Los_Angeles");
define('NOW', strtotime('now')); // servers can be in different timezones

define('PROFILE_WIDTH', 160);
define('PROFILE_HEIGHT', 200);

define('STATUS_PLEDGE', 1);
define('STATUS_ADMINISTRATOR', 2);
define('STATUS_ALUMNI', 3);
define('STATUS_ASSOCIATE', 4);
define('STATUS_DEPLEDGE', 5);
define('STATUS_NEOPHYTE', 6);
define('STATUS_INACTIVE', 7);
define('STATUS_ACTIVE', 8);
define('STATUS_DEACTIVATED', 9);

define('USERID_SERVICE', 3);
define('USERID_PRESIDENT', 4);
define('USERID_MEMBERSHIP', 5);
define('USERID_FELLOWSHIP', 6);
define('USERID_FINANCE', 7);
define('USERID_PLEDGEPARENTS', 8);
define('USERID_CORSECS', 9);
define('USERID_RECSECS', 10);
define('USERID_HISTORIAN', 11);
define('USERID_SAA', 12);
define('USERID_ADMIN', 13);
define('USERID_INTERCHAPTER', 16);
define('USERID_ALUMSECS', 17);

define('FOURC_CHAPTER', 0);
define('FOURC_CAMPUS', 1);
define('FOURC_COMMUNITY', 2);
define('FOURC_COUNTRY', 3);

define('FAMILY_ALPHA', 1);
define('FAMILY_PHI', 2);
define('FAMILY_OMEGA', 3);

define('EVENTTYPE_SERVICE', 1);
define('EVENTTYPE_FELLOWSHIP', 2);
define('EVENTTYPE_LEADERSHIP', 7);
define('EVENTTYPE_CHAPTER_EVENT', 9);
define('EVENTTYPE_INTERVIEWS', 10);

?>