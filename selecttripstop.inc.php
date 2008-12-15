<?
if (!defined('ACCESS_INCLUDE'))
{
	die("access denied");
}
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<?php
  $mysqli=getsqlconn();
  $query=sprintf("SELECT tf.OfferID, ts.TripNumber,tf.OfferDate,ScheduledStartTime,ts.StopNumber,ScheduledArrivalTime  FROM tripstopinfo as ts,stop as s,tripoffering as tf where ts.StopNumber=s.StopNumber and tf.TripNumber=ts.TripNumber");
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
	echo('<td><input type="radio" name="whichselected" value="'.$k.'"/>'."<input type='hidden' name='whichedit[".$k."][0]' value='".htmlentities($row[0])."' />"."<input type='hidden' name='whichedit[".$k."][1]' value='".htmlentities($row[4])."' />".'</td>');
	for($i=0;$i<$result->field_count;$i++){
	  echo "<td>".htmlentities($row[$i])."</td>";   
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
