<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
header ('Content-Type: text/html; charset=utf-8');
include_once('common.inc.php');
include_once('global.inc.php');
include_once('language/'.$JMORE_DEFAULT_LABGUAGE);

$data = GetInput();
if (isset($data['msg'])) { 
	$msg = urldecode($data['msg']); 
	echo $msg;
}else {
	echo $JMORE_NOMSG;
}
echo "<br><a href='index.php'>".$JMORE_BACK."</a>";
exit;
?>