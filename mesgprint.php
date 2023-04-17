<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
header ('Content-Type: text/html; charset=utf-8');
include_once('globalJunson.inc.php');
include_once($JUNSON_COMMON_INC);


$data = GetInput();
if (isset($data['msg'])) { 
	$msg = urldecode($data['msg']); 
	echo $msg;
}else {
	echo "Empty Message~";
}
echo "<br><a href='index.php'>Home</a>";
if($data['msg']=="License Timeout") {
	echo "<br><a href='logout.php'>Logout</a>";
}
exit;
?>