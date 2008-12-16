<?php 
define('ACCESS_INCLUDE',true);
require_once('common.php');
require_once('header.inc.php'); 
?>
<?php
$didPost=isset($_POST['Search']);
if($didPost && $_POST['Model']!="" && $_POST['Year']!=""):
  try{
	createBus($_POST['Model'],$_POST['Year']);
	outputSuccess("add success");
  }catch(Exception $e){
	outputError($e->getMessage());
  }
endif;
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
Model: <input type="text" name="Model" /><?  if($didPost && $_POST['Model']=="") outputError("please enter Model"); ?>
<br/>
Year: <input type="text" name="Year" maxlength="4"/><?  if($didPost && $_POST['Year']=="") echo outputError("please enter Year"); ?>
<br/>
<input type="submit" name="Search" value="Add Bus"/>
</form>

<?php require_once('footer.inc.php'); ?>