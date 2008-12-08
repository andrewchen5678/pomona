<?
if (!defined('ACCESS_INCLUDE'))
{
	die("access denied");
}
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<?php
  $mysqli=getsqlconn() or die("Connect failed: ".mysqli_connect_error());
  $query=sprintf("SELECT ts.TripNumber,tf.Date,ScheduledStartTime,ts.StopNumber,ScheduledArrivalTime  FROM TripStopInfo as ts,Stop as s,TripOffering as tf where ts.StopNumber=s.StopNumber and tf.TripNumber=ts.TripNumber");
  $result = $mysqli->query($query) or die("failed run the select query".$mysqli->error);
  echo("Select Trip:<br/>");
  echo '<table><tr>';
  echo '<th>check</th>';

   while($fieldData=$result->fetch_field()){
        echo "<th>".$fieldData->name."</th>";
    }
    echo '</tr>';
    $k=0;
    while($row = $result->fetch_row()) {
      echo '<tr>';
	printf('<td><input type="radio" name="whichselected" value="'.$k.'"/></td>',htmlentities($row[0]));
	for($i=0;$i<$result->field_count;$i++){
	  echo "<td><input type='hidden' name='whichedit[".$k."][]' value='".htmlentities($row[$i])."' />".htmlentities($row[$i])."</td>";   
	}
      echo '</tr>';
      $k++;
    }
    echo '</table>';
      /* Destroy the result set and free the memory used for it */
      $result->close();
      $mysqli->close(); /* Close the connection */ 
?>
ActualStartTime:<input type="text" name="ActualStartTime" /><br/>
ActualArrivalTime:<input type="text" name="ActualArrivalTime" /><br/>
NumberOfPassengerIn:<input type="text" name="NumberOfPassengerIn" /><br/>
NumberOfPassengerOut:<input type="text" name="NumberOfPassengerOut" /><br/>
<input type="submit" name="EditStop" value="Add Info for Selected"/>
</form>