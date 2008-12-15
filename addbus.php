<? 
define('ACCESS_INCLUDE',true);
require_once('common.php');
require_once('header.inc.php'); 
?>
<?php
$didPost=isset($_POST['Search']);
if($didPost && $_POST['Model']!="" && $_POST['Year']!=""):
  $errorcode=createBus($_POST['Model'],$_POST['Year']);
  if(!$errorcode){
    outputSuccess("add success");
  }else if($errorcode && $errorcode==ERR_INVALIDYEAR){
    outputError("invalid Year");
  }else{
    outputError("other errors");
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