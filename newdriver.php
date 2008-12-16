<?php
define('ACCESS_INCLUDE',true);
require_once('common.php');
require_once('header.inc.php'); 
?>
<?php
$didPost=isset($_POST['Search']);
if($didPost && $_POST['DriverName']!="" && $_POST['DriverPhone']!=""):
  try{
	createDriver($_POST['DriverName'],$_POST['DriverPhone']);
	outputSuccess("add success");
  }catch(Exception $e){
	outputError($e->getMessage());
  }
endif;
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
Driver Name: <input type="text" name="DriverName" /><?php if($didPost && $_POST['DriverName']=="") outputError("please enter name"); ?>
<br/>
Driver Phone: <input type="text" name="DriverPhone" /><?php if($didPost && $_POST['DriverPhone']=="") outputError("please enter phone"); ?>
<br/>
<input type="submit" name="Search" value="Add Driver"/>
</form>

<?php require_once('footer.inc.php'); ?>
