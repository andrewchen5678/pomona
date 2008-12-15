<?php
if (!defined('ACCESS_INCLUDE'))
{
	$selfname=$_SERVER['PHP_SELF'];
	die("direct access to $selfname denied");
}

if(get_magic_quotes_gpc()) {
  die('magic_quotes_gpc is on, please turn it off by setting "magic_quotes_gpc = Off" in php.ini or "php_flag magic_quotes_gpc Off" in .htaccess before running');
}
set_magic_quotes_runtime(0);
define("INCLUDE_DIR", "includes/");
define("LOAD_COMMON", TRUE);
require_once(INCLUDE_DIR.'dbconfig.php');
$mysqli=mysqli_connect($host, $dbuser, $dbpass, $database) or die("Connect failed: ".mysqli_connect_error());
require_once(INCLUDE_DIR.'functions.php'); 
?>