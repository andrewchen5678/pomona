<?php
define('ACCESS_INCLUDE',true);
require_once('common.php');
require_once('header.inc.php'); 
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
StartLocationName: <input type="text" name="StartLocationName" />
Destination Name: <input type="text" name="DestinationName" />
<input type="submit" name="Search" />
</form>
<?php
if(isset($_POST['Search'])):
	if($_POST["StartLocationName"]=="" && $_POST["DestinationName"]==""){
		$query="select * from trip,tripoffering where trip.TripNumber=tripoffering.TripNumber";
	} else {
		$query=sprintf("select * from trip,tripOffering where trip.TripNumber=tripOffering.TripNumber and StartLocationName LIKE '%%%s%%' and DestinationName LIKE '%%%s%%'",
		mysqlisafe($mysqli,$_POST["StartLocationName"]),
		mysqlisafe($mysqli,$_POST["DestinationName"]));
		//echo $query;	
	}
	$result = $mysqli->query($query) or die("failed run the select query ".($mysqli->error));
	echo("Result:<br/>");
	echo '<table><tr>';
	while($fieldData=$result->fetch_field()){
	echo "<th>".$fieldData->name."</th>";
	}
	echo '</tr>';
	while($row = $result->fetch_row()) {
	  echo '<tr>';
	for($i=0;$i<$result->field_count;$i++){
	  echo "<td>".htmlentities($row[$i])."</td>";	   
	}
	  echo '</tr>';
	}
	echo '</table>'; 
	/* Destroy the result set and free the memory used for it */
	$result->close();
endif;
?>
<?php require_once('footer.inc.php'); ?>