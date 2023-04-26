<?php

include_once('global.inc.php');

/* 連結資料庫 */
function GetDBH() {
	global $JUNSON_DB_USER;
	global $JUNSON_DB_ACCOUNT;
	global $JUNSON_DB_PASSWORD;
	global $JUNSON_DB_HOST;
	
  $arg_list = func_get_args();
  $db = '';
  if(isset($arg_list[0])) { $db = trim($arg_list[0]); }

  if(preg_match("/^(".$JUNSON_DB_USER.")$/i", $db)) {
    $dbuser = $JUNSON_DB_ACCOUNT;
    $dbpwd  = $JUNSON_DB_PASSWORD;
    $dbname = strtolower($JUNSON_DB_USER);
  }else {
  	$dbuser="";
  	$dbpwd="";
  	$dbname="";
  }
  
  if($dbname!="") {
  	$dbh = new mysqli($JUNSON_DB_HOST, $dbuser, $dbpwd, $dbname);
  	if ($dbh->connect_error) {
  	  PrintMesg('DB Connect Error: ['.$db.']');
  	}
    $dbh->set_charset("utf8mb4");
  }else {
    PrintMesg('Please Setup DB Name'.$db);
  }
  return $dbh;
}

/* 傳回 $_GET 或 $_POST 的值, 並且過濾不合法字元 */
function GetInput() {
  return strfilter(!empty($_POST) ? $_POST : (!empty($_GET) ? $_GET : ''));
}

/* 過濾不當字元 */
function strfilter($val) {
  return is_array($val) ? array_map('strfilter', $val) : trim(preg_replace('/[<>"\']/', '', $val));
}

/* 訊息畫面, 並且離開程式 */
function PrintMesg($mesg) {
  //echo $mesg . "\n";
  $mesg=urlencode($mesg);
  header("Location: mesgprint.php?msg=".$mesg);
  exit;  
}

function GetAccountByLicense($userlicense) {
	global $JUNSON_DB_USER;
	$account="";
	$mydbh=GetDBH($JUNSON_DB_USER);
  $myresult = $mydbh->prepare("select u_account from `userlicenseall` where `licensenumber`=?");
  $myresult->bind_param("s", $userlicense);
  $myresult->execute();
  $myresult->store_result();
  $myresult->bind_result($userAccount);
  if ($myresult->num_rows > 0) {	
	  $row = $myresult->fetch();
	  $account=$userAccount;
  }else { $account="NULL"; }
  mysqli_close($mydbh);
  return $account;
}

function CheckAccountLogin($uaccount,$upswd) {
	global $JUNSON_DB_USER;
	$mydbh=GetDBH($JUNSON_DB_USER);
  $myresult = $mydbh->prepare("select u_name,u_group,u_language from userinfo where u_account=? and u_pswd=? and stopyn ='N'");
  $myresult->bind_param("ss", $uaccount,$upswd);
  $myresult->execute();
  $myresult->store_result();
  $myresult->bind_result($uname,$ugroup,$ulanguage);
  if ($myresult->num_rows > 0) {
	  $row = $myresult->fetch();
	  $retD=$uname.",".$ugroup.",".$ulanguage;
  }else { $retD="NULL"; }
  mysqli_close($mydbh);
  return $retD;
}

function CheckRandomLogin($ulicense,$randpswd) {
	global $JUNSON_DB_USER;
	$mydbh=GetDBH($JUNSON_DB_USER);
  $myresult = $mydbh->prepare("select pswd from randpswd where licensenumber=?");
  $myresult->bind_param("s", $ulicense);
  $myresult->execute();
  $myresult->store_result();
  $myresult->bind_result($unumber);
  if ($myresult->num_rows > 0) {
	  $row = $myresult->fetch();
	  if($unumber==$randpswd) {
	  	$ret="PASS";
	  }else{
	  	$retD="NULL";
	  }
  }else { $retD="NULL"; }
  mysqli_close($mydbh);
  return $retD;
}

function InsSuccessLogin($username,$uName,$stepTwo,$endtime,$uGroup,$uLanguage) {
	global $JUNSON_DB_USER;
	$mydbh=GetDBH($JUNSON_DB_USER);
  $InsSQL="insert into userlicenseall (ulid,u_account,u_name,licensenumber,endtime,u_group,u_language) values (NULL,'$username','$uName','$stepTwo','$endtime','$uGroup','$uLanguage')";	
  try {
    $myst = $mydbh->prepare($InsSQL);
    $myst->execute();
  }catch (Exception $e) {
		PrintMesg("ERROR: SQL:".$e->getMessage());
	}
	mysqli_close($mydbh);
}

function GetLicenseRandom($userlicense) {
	global $JUNSON_DB_USER;
	$account="";
	$mydbh=GetDBH($JUNSON_DB_USER);
  $myresult = $mydbh->prepare("select pswd from `randpswd` where `licensenumber`=?");
  $myresult->bind_param("s", $userlicense);
  $myresult->execute();
  $myresult->store_result();
  $myresult->bind_result($userPswd);
  if ($myresult->num_rows > 0) {	
	  $row = $myresult->fetch();
	  $pswd=$userPswd;
  }else { $pswd="NULL"; }
  mysqli_close($mydbh);
  return $pswd;
}

function InsLicenseRandom($userlicense,$randpswd) {
	global $JUNSON_DB_USER;
	$mydbh=GetDBH($JUNSON_DB_USER);
  $InsSQL="insert into randpswd (licensenumber,pswd) values ('$userlicense','$randpswd')";	
  try {
    $myst = $mydbh->prepare($InsSQL);
    $myst->execute();
  }catch (Exception $e) {
		PrintMesg("ERROR: SQL:".$e->getMessage());
	}
	mysqli_close($mydbh);
}

function UptLicenseRandom($userlicense,$randpswd) {
	global $JUNSON_DB_USER;
	$mydbh=GetDBH($JUNSON_DB_USER);
  $uptSQL="update randpswd set pswd= '$randpswd' where licensenumber='$userlicense'";
  try {
    $myst = $mydbh->prepare($uptSQL);
    $myst->execute();
  }catch (Exception $e) {
		PrintMesg("ERROR: SQL:".$e->getMessage());
	}
	mysqli_close($mydbh);
}

function GetKeyByRand($rkey) {
	global $JUNSON_DB_USER;
	$keyitem="";
	$mydbh=GetDBH($JUNSON_DB_USER);
  $myresult = $mydbh->prepare("select keyitem from `randkey` where `randsn`=? order by addtime desc");
  $myresult->bind_param("s", $rkey);
  $myresult->execute();
  $myresult->store_result();
  $myresult->bind_result($keytmp);
  if ($myresult->num_rows > 0) {
    $row = $myresult->fetch();
    $keyitem=$keytmp;
  }
  mysqli_close($mydbh);
  return $keyitem;
}

function CheckTimeoutByLicense($userlicense) {
	global $JUNSON_DB_USER;
	$mydbh=GetDBH($JUNSON_DB_USER);
	$today=getdate(); $nowtime=mktime($today["hours"],$today["minutes"],$today["seconds"],$today["mon"],$today["mday"],$today["year"]);
	try {
    $myresult = $mydbh->prepare("select endtime from `userlicenseall` where `licensenumber`=?");
    $myresult->bind_param("s", $userlicense);
    $myresult->execute();
    $myresult->store_result();
    $myresult->bind_result($endtime);
    if ($myresult->num_rows > 0) {
	    $row = $myresult->fetch();
	    $etime=$endtime;
    }else { $etime=""; }
  }catch (Exception $e) {
		PrintMesg('Check Timeout Fail: '.$e->getMessage());
	}
  mysqli_close($mydbh);
  if($etime < $nowtime or $etime=="") {
    PrintMesg('License Timeout');
  }else {
  }
  return $nowtime.",".$etime;
}


function log2db($s,$func) {
	global $JUNSON_DB_WEB;
	$mydbh=GetDBH($JUNSON_DB_WEB);
	$today=getdate();
  $logtime=mktime($today["hours"],$today["minutes"],$today["seconds"],$today["mon"],$today["mday"],$today["year"]);
  try {
    $myst = $mydbh->prepare("insert into `logdata` (`logid`,`logtext`,`logtime`,`logfrom`) values (NULL,?,?,?)");
    $myst->bind_param("sss", $s,$logtime,$func);
    $myst->execute();	
	}catch (Exception $e) {
		PrintMesg($e->getMessage());
	}
  mysqli_close($mydbh);
}

?>
