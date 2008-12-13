<?php
$mysqli=getsqlconn() or die("Connect failed: ".mysqli_connect_error());
$result = $mysqli->query("SELECT t.TripNumber,StartLocationName,DestinationName,Date,ScheduledStartTime,ScheduledArrivalTime,DriverName,tt.BusID,Model,Year FROM trip as t,tripoffering as tt,bus where t.TripNumber=tt.TripNumber and bus.BusID=tt.BusID") or die("failed run the select query");
    echo("Info:<br/>");
//     /* Fetch the results of the query */
//     while( $row = $result->fetch_row()){
// 	echo($row[0]." ".$row[1]." ".$row[2]." ".$row[3]." ".$row[4]." ".$row[5]." ".$row[6]." ".$row[7]." ".$row[8]." ".$row[9]);
//         //printf("%s (%s)\n", $row['Name'], $row['Population']);
//     }
if($result->num_rows>0){
  $row = $result->fetch_assoc();
  echo '<table><tr>';
  foreach($row as $name => $value) {
  echo "<th>$name</th>";
  }
  echo '</tr>';
  while($row) {
  echo '<tr>';
  foreach($row as $value) {
  echo "<td>$value</td>";
  }
  echo '</tr>';
  $row = $result->fetch_row();
  }
  echo '</table>';
}else{
  echo "nothing to show!";
}
    /* Destroy the result set and free the memory used for it */
    $result->close();
$mysqli->close(); /* Close the connection */ 
?>
