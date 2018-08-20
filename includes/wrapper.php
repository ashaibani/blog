<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
date_default_timezone_set('Europe/London');
include("./includes/database.php");
include("./includes/posthandler.php");
include("./includes/userhandler.php");
include("./includes/template.php");

define( 'DB_HOST', 'db.ashaibani.com' );
define( 'DB_USER', 'root' );
define( 'DB_PASS', 'Manchester208' );
define( 'DB_NAME', 'blog' );
define( 'DISPLAY_DEBUG', true );

$db = new DB();
$postHandler = new PostHandler($db);
$userHandler = new UserHandler($db);
?>