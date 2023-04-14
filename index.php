<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

session_start();
if(isset($_SESSION['junsonlicense'])) { 
	$junsonlicense=$_SESSION['junsonlicense']; 
} else { $junsonlicense=""; }
include_once('globalJunson.inc.php');
include_once($JUNSON_COMMON_INC);

?>
<HTML><HEAD>
<meta charset="utf-8">
</HEAD>
<body class="background">
<?php
if(empty($junsonlicense) or $junsonlicense=="") {
	header("Location: login.php");
  exit;
}else {
	echo "login ok";
}
?>
</body>
</HTML>
