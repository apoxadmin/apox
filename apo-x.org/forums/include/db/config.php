<?php
/*  type: The type of database. Typically 'mysql'.
    name: The name of the database Phorum will be using.
    server: The address of the database server. Typically 'localhost'.
    user: Your username to connect to the database.
    password: Your password to connect to the database.
    table_prefix: This will be at the front of the name of tables Phorum creates. */

    if(!defined("PHORUM")) return;

include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/include/connection.inc.php';

    $PHORUM["DBCONFIG"]=array(
	
        "type"          =>  "mysql",
        "name"          =>  DB_NAME,
        "server"        =>  DB_HOST,
        "user"          =>  DB_USER,
        "password"      =>  DB_PASS,
        "table_prefix"  =>  "phorum"

    );

?>
