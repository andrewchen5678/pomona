<?php
if (!defined('ACCESS_INCLUDE'))
{
	$selfname=$_SERVER['PHP_SELF'];
	die("direct access to $selfname denied");
}
if(defined('LOAD_COMMON')){
 //echo("closing sql connection");
 $mysqli->close(); /* Close the connection */ 
}
?>
</div>
</body>
</html>
