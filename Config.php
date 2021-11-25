<?php
session_start(); //start the session

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'ocawbms');
 
$link = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, ); //connect to the database
 
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

?>