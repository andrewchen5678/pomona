<?php
if (!defined('ACCESS_INCLUDE'))
{
	die("access denied");
}
if(defined('LOAD_COMMON')){
 //echo("closing sql connection");
 $mysqli->close(); /* Close the connection */ 
}
?>
</div>
</body>
</html>
