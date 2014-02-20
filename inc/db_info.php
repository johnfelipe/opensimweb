<?php
if (!defined('OSW_IN_SYSTEM')) {
exit;	
}

define('SYSTEM_INSTALLED', true);

$db_host = "localhost"; // ip / address to your database
$db_port = "3306"; // port number to your database, default is 3306
$db_user = "root"; // username to your db
$db_pass = "l0v3sux"; // password to your db
$db_name = "site"; // database name for your website
$db_type = "MySQLi"; // type of database, if using MySQL which is default for Robust, please set this to MySQLi
$db_prefix = "osw_"; // prefix for opensimweb tables, default is osw_
$db_perst = false; // no real idea what this does yet
?>