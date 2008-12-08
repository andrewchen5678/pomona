<? 
define('ACCESS_INCLUDE',true);
require_once('common.php');
require_once('header.php');
require_once('selecttrip.inc.php');  
if(isset($_POST['DisplayStop'])):
  $tripDisplay=$_POST['whichdisplay'];
  if(isset($tripDisplay)){
    $mysqli=getsqlconn() or die("Connect failed: ".mysqli_connect_error());
    //$query=sprintf("SELECT t.TripNumber,StartLocationName,DestinationName,ts.StopNumber,s.StopAddress,SequenceNumber,DrivingTime FROM TripStopInfo as ts,Stop as s, Trip as t where ts.StopNumber=s.StopNumber and ts.TripNumber=t.TripNumber and t.TripNumber='%d'",sqlsafe($tripDisplay));
	$query=sqlisafe($mysqli,"SELECT t.TripNumber,StartLocationName,DestinationName,ts.StopNumber,s.StopAddress,SequenceNumber,DrivingTime FROM TripStopInfo as ts,Stop as s, Trip as t where ts.StopNumber=s.StopNumber and ts.TripNumber=t.TripNumber and t.TripNumber='%d'",$tripDisplay);
	echo $query2;
    $result = $mysqli->query($query) or die("failed run the select query");
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
      $mysqli->close(); /* Close the connection */ 
  }else{ outputError("please select a trip first"); }
endif;
?>
<?php include('footer.php'); ?>