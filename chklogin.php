<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
header ('Content-Type: text/html; charset=utf-8');

session_start();
if(isset($_SESSION['junsonlicense'])) {
	$junsonlicense=$_SESSION['junsonlicense']; 
} else { $junsonlicense=""; }

include_once('globalJunson.inc.php');
include_once($JUNSON_COMMON_INC);

$data = GetInput();
if(isset($data['uAccount'])) { $username = $data['uAccount']; } else { $username=""; }
if(isset($data['upswd'])) { $password = $data['upswd']; } else { $password=""; }
if(isset($data['randpswd'])) { $randpswd = $data['randpswd']; } else { $randpswd=""; }

$ErrCode="";

$stepOne=CheckAccountLogin($username,$password);
if($stepOne!="NULL") {
	$tmpRet=explode(",",$stepOne);
	if(isset($tmpRet[0])) { $uName=$tmpRet[0]; }
	if(isset($tmpRet[1])) { $uGroup=$tmpRet[1]; }
	if(isset($tmpRet[2])) { $uLanguage=$tmpRet[2]; }
	$stepTwo=CheckRandomLogin($junsonlicense,$randpswd);
	if($stepTwo!="NULL") {
		$today=getdate();
    $starttime=mktime($today["hours"],$today["minutes"],$today["seconds"],$today["mon"],$today["mday"],$today["year"]);
    $endtime=$starttime+(3600*$JUNSON_DEFAULT_SESSION_TIMEOUT); 
		InsSuccessLogin($username,$uName,$junsonlicense,$endtime,$uGroup,$uLanguage);
		echo "OK";
	}else {
		echo "Randnumber";
	}
}else {
	echo "Error";
}

?>