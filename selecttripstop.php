<? define('ACCESS_INCLUDE',true);
require_once('common.php');
require_once('header.php');
require_once('selecttripstop.inc.php');  
if(isset($_POST['EditStop'])):
  $tripEdit=$_POST['whichedit'];
  $index=$_POST['whichselected'];
  if(isset($index)){
    $mysqli=getsqlconn();
    $query=sprintf("INSERT INTO actualtripstopinfo (OfferID, StopNumber, ActualStartTime, ActualArrivalTime, NumberOfPassengerIn, NumberOfPassengerOut) VALUES (%d, %d, '%s', '%s', %d, %d)",
	mysqlisafe($mysqli,$tripEdit[$index][0]),
	mysqlisafe($mysqli,$tripEdit[$index][1]),
	mysqlisafe($mysqli,$_POST["ActualStartTime"]),
	mysqlisafe($mysqli,$_POST["ActualArrivalTime"]),
	mysqlisafe($mysqli,$_POST["NumberOfPassengerIn"]),
	mysqlisafe($mysqli,$_POST["NumberOfPassengerOut"]));
    echo $query;
    $mysqli->query($query) or die("failed run the select query ".$mysqli->error);
    $mysqli->close(); /* Close the connection */ 
  }else{ outputError("please select a trip first"); }
endif;
?>
<?php include('footer.php'); ?>
