<? 
define('ACCESS_INCLUDE',true);
require_once('common.php');
require_once('header.php'); 
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
StartLocationName: <input type="text" name="StartLocationName" />
Destination Name: <input type="text" name="DestinationName" />
<input type="submit" name="Search" />
</form>
<?php
if(isset($_POST['Search'])):
  $mysqli=getsqlconn() or die("Connect failed: ".mysqli_connect_error());
  if($_POST["StartLocationName"]=="" && $_POST["DestinationName"]==""){
    $query="select * from Trip,TripOffering where Trip.TripNumber=TripOffering.TripNumber";
  }
  else {
    $query=sqlisafe($mysqli,"select * from Trip,TripOffering where Trip.TripNumber=TripOffering.TripNumber and StartLocationName='%s' and DestinationName='%s'",$_POST["StartLocationName"],$_POST["DestinationName"]);
  }
//   echo $query;
//   echo mysql_real_escape_string($_POST["StartLocationName"]);
//   echo htmlentities($_POST["DestinationName"]);
  $result = $mysqli->query($query) or die("failed run the select query");
      echo("Result:<br/>");
  //$statement->bind_result($result);
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
    $mysqli->close(); /* Close the connection */ 
endif;
?>
<?php include('footer.php'); ?>
