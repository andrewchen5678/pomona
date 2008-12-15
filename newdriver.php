<? 
define('ACCESS_INCLUDE',true);
require_once('common.php');
require_once('header.inc.php'); 
?>
<?php
$didPost=isset($_POST['Search']);
if($didPost && $_POST['DriverName']!="" && $_POST['DriverPhone']!=""):
  $errorcode=createDriver($_POST['DriverName'],$_POST['DriverPhone']);
  if(!$errorcode){
    outputSuccess("add success");
  }else if($errorcode && $errorcode==ERR_INVALIDPHONE){
    outputError("invalid phone");
  }else if($errorcode && $errorcode==ERR_DUPLICATEKEY){
    outputError("driver name already exists");
  }else{
    outputError("other errors");
  }
endif;
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
Driver Name: <input type="text" name="DriverName" /><?  if($didPost && $_POST['DriverName']=="") outputError("please enter name"); ?>
<br/>
Driver Phone: <input type="text" name="DriverPhone" /><?  if($didPost && $_POST['DriverPhone']=="") echo outputError("please enter phone"); ?>
<br/>
<input type="submit" name="Search" value="Add Driver"/>
</form>

<?php require_once('footer.inc.php'); ?>
