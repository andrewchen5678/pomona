<?
if (!defined('ACCESS_INCLUDE'))
{
	die("access denied");
}
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<?php
  //$mysqli=getsqlconn() or die("Connect failed: ".mysqli_connect_error());
  $query=sprintf("select * from trip");
//   echo $query;
//   echo mysql_real_escape_string($_POST["StartLocationName"]);
//   echo htmlentities($_POST["DestinationName"]);
  $result = $mysqli->query($query) or die("failed run the select query".$mysqli->error);
      echo("Select Trip:<br/>");
  //$statement->bind_result($result);
//$numfield=$mysqli->field_count;
    echo '<table><tr>';
  echo '<th>check</th>';
// for($i=0;$i<$numfield;$i++) {
//   echo "<th>".htmlentities($mysqli->field_name($result,$i))."</th>";
// }
   while($fieldData=$result->fetch_field()){
        echo "<th>".$fieldData->name."</th>";
    }
    echo '</tr>';
//     $row = $result->fetch_assoc();
//     while($row) {
//       echo '<tr>';
// 	echo '<td><input type="checkbox" /></td>';
// 	foreach($row as $value) {
// 	echo "<td>".htmlentities($value)."</td>";
// 	}
//       echo '</tr>';
//       $row = $result->fetch_row();
//     }
    while($row = $result->fetch_row()) {
      echo '<tr>';
	printf('<td><input type="radio" name="whichdisplay" value="%d"/></td>',htmlentities($row[0]));
	for($i=0;$i<$result->field_count;$i++){
	  echo "<td>".htmlentities($row[$i])."</td>";	   
	}
      echo '</tr>';
    }
    echo '</table>';
      /* Destroy the result set and free the memory used for it */
      $result->close();
?>
<input type="submit" name="DisplayStop" value="Display Stop for Selected"/>
</form>
