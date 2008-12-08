<?php
if (!defined('ACCESS_INCLUDE'))
{
	die("access denied");
}

require_once('constants.php'); 

function redir301($url){
  Header( "HTTP/1.1 301 Moved Permanently" );
  Header( "Location: ".$url ); 
  die();
}

function redir($url){
  Header( "Location: ".$url ); 
  die();
}

function sqlsafe($input){
        if(get_magic_quotes_gpc()) {
            return mysql_real_escape_string(stripslashes($input));
        } else {
            return mysql_real_escape_string($input);
        }
}

function sqlsafe2()
{
    $args = func_get_args();
    if (count($args) < 2)
        return false;
    $query = array_shift($args);
    $args = array_map('mysql_real_escape_string', $args);
    array_unshift($args, $query);
    $query = call_user_func_array('sprintf', $args);
    return $query;
}

function sqlisafe($query) {
    $args = func_get_args();
    if (count($args) < 3)
        return false;
	$obj = array_shift($args);
	$query = array_shift($args);
    $args = array_map(array($obj,'real_escape_string'), $args);
    array_unshift($args, $query);
    $query = call_user_func_array('sprintf', $args);
    return $query;
}

function getsqlconn(){
  include('dbconfig.php'); 
  return new mysqli($host, $dbuser, $dbpass, $database);
}

function createDriver($name,$phone){
  //if(!preg_match("/^(1\s*[-\/\.]?)?(\((\d{3})\)|(\d{3}))\s*[-\/\.]?\s*(\d{3})\s*[-\/\.]?\s*(\d{4})\s*(([xX]|[eE][xX][tT])\.?\s*(\d+))*$/",$phone)) return ERR_INVALIDPHONE;
  $onlynums = preg_replace("/[^0-9]/","",$phone);
  echo $onlynums;
  if(strlen($onlynums)==11 && $onlynums[0]!="1") return ERR_INVALIDPHONE;
  else if(strlen($onlynums)==11 && $onlynums[0]=="1") $onlynums=substr($onlynums,1);
  else if(strlen($onlynums)!=10) return ERR_INVALIDPHONE;
  //echo $onlynums;
  $mysqli=getsqlconn() or die("Connect failed: ".mysqli_connect_error());
  $query=sprintf("insert into Driver VALUES('%s','%s')",sqlsafe($name),sqlsafe($onlynums));
  if(!$mysqli->query($query)){
    if($mysqli->errno==1062) return ERR_DUPLICATEKEY;
    else die($mysqli->error." error code: ".$mysqli->errno);
  }
  $mysqli->close();
  return 0;
}

function createBus($model,$year){
  //if(!preg_match("/^(1\s*[-\/\.]?)?(\((\d{3})\)|(\d{3}))\s*[-\/\.]?\s*(\d{3})\s*[-\/\.]?\s*(\d{4})\s*(([xX]|[eE][xX][tT])\.?\s*(\d+))*$/",$phone)) return ERR_INVALIDPHONE;
  if(strlen($year)!=4) return ERR_INVALIDYEAR;
  if(!preg_match("/([0-9]{4})$/",$year)) return ERR_INVALIDYEAR;
  //echo $onlynums;
  $mysqli=getsqlconn() or die("Connect failed: ".mysqli_connect_error());
  $query=sprintf("insert into Bus (Model,Year) VALUES('%s','%s')",sqlsafe($model),sqlsafe($year));
  if(!$mysqli->query($query)){
    if($mysqli->errno==1062) return ERR_DUPLICATEKEY;
    else die($mysqli->error." error code: ".$mysqli->errno);
  }
  $mysqli->close();
  return 0;
}

function outputError($str){
    echo "<span style=\"background-color:#ff0000;\">";
    echo htmlentities($str);
    echo "</span>";
}

function outputSuccess($str){
    echo "<span style=\"background-color:#00ff00;\">";
    echo htmlentities($str);
    echo "</span>";
}

?>
