<?php
if (!defined('ACCESS_INCLUDE'))
{
	die("access denied");
}

if (!defined('LOAD_COMMON'))
{
	die("load common.php first before loading functions.php");
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

function mysqlisafe($link,$input){
        if(get_magic_quotes_gpc()) {
            return mysqli_real_escape_string($link,stripslashes($input));
        } else {
            return mysqli_real_escape_string($link,$input);
        }
}

// function sqlsafe2()
// {
    // $args = func_get_args();
    // if (count($args) < 2)
        // return false;
    // $query = array_shift($args);
    // $args = array_map('mysql_real_escape_string', $args);
    // array_unshift($args, $query);
    // $query = call_user_func_array('sprintf', $args);
    // return $query;
// }

// function sqlisafe($query) {
    // $args = func_get_args();
    // if (count($args) < 3)
        // return false;
	// $obj = array_shift($args);
	// $query = array_shift($args);
    // $args = array_map(array($obj,'real_escape_string'), $args);
    // array_unshift($args, $query);
    // $query = call_user_func_array('sprintf', $args);
    // return $query;
// }

function createDriver($name,$phone){
  //if(!preg_match("/^(1\s*[-\/\.]?)?(\((\d{3})\)|(\d{3}))\s*[-\/\.]?\s*(\d{3})\s*[-\/\.]?\s*(\d{4})\s*(([xX]|[eE][xX][tT])\.?\s*(\d+))*$/",$phone)) return ERR_INVALIDPHONE;
  $onlynums = preg_replace("/[^0-9]/","",$phone);
  //echo $onlynums;
  if(strlen($onlynums)==11 && $onlynums[0]!="1") throw new Exception("invalid phone");
  else if(strlen($onlynums)==11 && $onlynums[0]=="1") $onlynums=substr($onlynums,1);
  else if(strlen($onlynums)!=10) throw new Exception("invalid phone");
  //echo $onlynums;
  global $mysqli;
  $query=sprintf("insert into driver VALUES('%s','%s')",
    mysqlisafe($mysqli,$name),
    mysqlisafe($mysqli,$onlynums));
  if(!$mysqli->query($query)){
    if($mysqli->errno==1062) throw new Exception("driver name already exists");
    else die($mysqli->error." error code: ".$mysqli->errno);
  }
  //$mysqli->close();
  //return 0;
}

function createBus($model,$year){
  //if(!preg_match("/^(1\s*[-\/\.]?)?(\((\d{3})\)|(\d{3}))\s*[-\/\.]?\s*(\d{3})\s*[-\/\.]?\s*(\d{4})\s*(([xX]|[eE][xX][tT])\.?\s*(\d+))*$/",$phone)) return ERR_INVALIDPHONE;
  if(strlen($year)!=4) throw new Exception("invalid Year");
  if(!preg_match("/([0-9]{4})$/",$year)) throw new Exception("invalid Year");
  //echo $onlynums;
  global $mysqli;
  $query=sprintf("insert into bus (Model,BusYear) VALUES('%s','%s')",
  mysqlisafe($mysqli,$model),
  mysqlisafe($mysqli,$year));
  //echo $query;
  if(!$mysqli->query($query)){
    //if($mysqli->errno==1062) throw new Exception("bus already exists");
    die($mysqli->error." error code: ".$mysqli->errno);
  }
  //$mysqli->close();
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