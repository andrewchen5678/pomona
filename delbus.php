<? 
define('ACCESS_INCLUDE',true);
require_once('common.php');
require_once('header.php'); 
  //$mysqli=getsqlconn() or die("Connect failed: ".mysqli_connect_error());
  $didPost=isset($_POST['DeleteBus']);
  $listDel=$_POST['whichdel'];
  if($didPost && isset($listDel)):
    foreach ($listDel as $d)
    {
      $dsafe=intval($d);
      //echo $dsafe;
      $query="delete from bus where BusID='".$dsafe."'";
      $mysqli->query($query) or die("failed run the delete query on Bus ".$mysqli->error);
      $query2="delete from tripoffering where BusID='".$dsafe."'";
      $mysqli->query($query2) or die("failed run the delete query on TripOffering ".$mysqli->error);
      outputSuccess("delete success");
    //end fix the out of sync bug
    }
  elseif($didPost && !isset($listDel)):
    outputError("select buses to delete first");
  endif;
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<?php
  $query=sprintf("select * from bus");
//   echo $query;
//   echo mysql_real_escape_string($_POST["StartLocationName"]);
//   echo htmlentities($_POST["DestinationName"]);
  $result = $mysqli->query($query) or die("failed run the select query".$mysqli->error);
      echo("Bus:<br/>");
  //$statement->bind_result($result);
//$numfield=$mysqli->field_count;
   echo '<table><tr>';
   echo '<th>check</th>';

   while($fieldData=$result->fetch_field()){
        echo "<th>".$fieldData->name."</th>";
    }
    echo '</tr>';
    while($row = $result->fetch_row()) {
      echo '<tr>';
	echo '<td><input type="checkbox" name="whichdel[]" value="'.htmlentities($row[0]).'"/></td>';
	for($i=0;$i<$result->field_count;$i++){
	  echo "<td>".htmlentities($row[$i])."</td>";	   
	}
      echo '</tr>';
    }
    echo '</table>';
      /* Destroy the result set and free the memory used for it */
      $result->close();
?>
<input type="submit" name="DeleteBus" value="Delete Selected"/>
</form>
<?php include('footer.php'); ?>
