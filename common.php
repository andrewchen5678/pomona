<?php
if(get_magic_quotes_gpc()) {
  die('magic_quotes_gpc is on, please turn it off by setting "magic_quotes_gpc = Off" in php.ini or "php_flag magic_quotes_gpc Off" in .htaccess before running');
}
set_magic_quotes_runtime(0);
require_once('functions.php'); 
?>
