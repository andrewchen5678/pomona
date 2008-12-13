<? define('ACCESS_INCLUDE',true);
require_once('common.php');
require_once('header.php');
require_once('selecttripstop.inc.php');  
if(isset($_POST['EditStop'])):
  $tripEdit=$_POST['whichedit'];
  $index=$_POST['whichselected'];
  if(isset($index)){
    $mysqli=getsqlconn() or die("Connect failed: ".mysqli_connect_error());
    $query=sprintf("INSERT INTO actualtripstopinfo (TripNumber, Date, ScheduledStartTime, StopNumber, ScheduledArrivalTime, ActualStartTime, ActualArrivalTime, NumberOfPassengerIn, NumberOfPassengerOut) VALUES (%d, '%s', '%s', %d, '%s', '%s', '%s', %d, %d)",sqlsafe($tripEdit[$index][0]),sqlsafe($tripEdit[$index][1]),sqlsafe($tripEdit[$index][2]),sqlsafe($tripEdit[$index][3]),sqlsafe($tripEdit[$index][4]),sqlsafe($_POST["ActualStartTime"]),sqlsafe($_POST["ActualArrivalTime"]),sqlsafe($_POST["NumberOfPassengerIn"]), sqlsafe($_POST["NumberOfPassengerOut"]));
    echo $query;
    $mysqli->query($query) or die("failed run the select query ".$mysqli->error);
    $mysqli->close(); /* Close the connection */ 
  }else{ outputError("please select a trip first"); }
endif;
?>
<?php include('footer.php'); ?>
