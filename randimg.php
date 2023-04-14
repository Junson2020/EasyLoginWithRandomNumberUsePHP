<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$today=getdate();
$starttime=mktime($today["hours"],$today["minutes"],$today["seconds"],$today["mon"],$today["mday"],$today["year"]);
session_start();

include_once('globalJunson.inc.php');
include_once($JUNSON_COMMON_INC);

mt_srand((double)microtime()*1000000);  //以時間當亂數種子

$rand1=mt_rand(2,25);
$rand2=mt_rand(0,1);
$rand3=mt_rand(2,25);
if($rand1 > $rand3) {
	$randpswd=$rand1-$rand3; $sign1="-"; 
}else {
	if($rand2==0) { $randpswd=$rand1+$rand3; $sign1="+"; } 
 	else { 
 		if($rand3 > 10) { $rand3=mt_rand(1,9); }
 		$randpswd=$rand1*$rand3; $sign1="x"; 
 	}
}

//if($junsonlicense=="") {
  $tmp=$starttime.$randpswd;
  $jmorelicense=md5($tmp);
  $_SESSION['junsonlicense']=$jmorelicense;
//}


$oldpswd=GetLicenseRandom($jmorelicense);
if($oldpswd!="NULL") {
	UptLicenseRandom($jmorelicense,$randpswd);
}else {
	InsLicenseRandom($jmorelicense,$randpswd);
}

$randstr=$rand1." ".$sign1." ".$rand3;
header("Content-type: image/PNG");
$image = imagecreate(80, 32);
$background_color = imagecolorallocate($image, 255, 255, 255);
imagefilledrectangle($image, 0, 0, 80, 30, $background_color);
$colors[0]= ImageColorAllocate($image, 0, 0, 0);
$colors[1]= ImageColorAllocate($image, 255, 0, 0);
$colors[2]= ImageColorAllocate($image, 255, 127, 80);
$colors[3]= ImageColorAllocate($image, 0, 0, 255);
$colors[4]= ImageColorAllocate($image, 222, 49, 99);
$colors[5]= ImageColorAllocate($image, 100, 149, 237);
$colors[6]= ImageColorAllocate($image, 31, 97, 141);
$colors[7]= ImageColorAllocate($image, 255, 0, 255);
$colors[8]= ImageColorAllocate($image, 146, 43, 33);
$colors[9]= ImageColorAllocate($image, 241, 196, 15);

/*
$vPos = 8;
$hPos = 8;
$fontSize = 5;
ImageString($image, $fontSize, $hPos, $vPos, $randstr, $black);
ImageString($image, $fontSize, $hPos+1, $vPos+1, $randstr, $black);
//imagettftext($image, 20, 0, 0, 0, $black, $font, $randstr);
*/

$k=mt_rand(5,10);
for($i=0;$i < $k;$i++) {
  $x1=mt_rand(0,22);
  $y1=mt_rand(0,32);
  $x2=mt_rand(50,80);
  $y2=mt_rand(0,32);
  $r1=mt_rand(152,255);
  $g1=mt_rand(152,255);
  $b1=mt_rand(152,255);
  $col=imagecolorallocate($image, $r1, $g1, $b1);
  imageline($image,$x1,$y1,$x2,$y2,$col);
}

$cols=mt_rand(0,9);
$vPos = 8;
$hPos = 8;
$fontSize = 5;
ImageString($image, $fontSize, $hPos, $vPos, $rand1, $colors[$cols]);
ImageString($image, $fontSize, $hPos+1, $vPos+1, $rand1, $colors[$cols]);

$cols=mt_rand(0,9);
$vPos = 8;
$hPos = 38;
$fontSize = 5;
ImageString($image, $fontSize, $hPos, $vPos, $rand3, $colors[$cols]);
ImageString($image, $fontSize, $hPos+1, $vPos+1, $rand3, $colors[$cols]);
/*
$vPos = 8;
$hPos = 28;
$fontSize = 5;
ImageString($image, $fontSize, $hPos, $vPos, $sign1, $colors[0]);
ImageString($image, $fontSize, $hPos+1, $vPos+1, $sign1, $colors[0]);
*/
$dx=mt_rand(-8,8);
$rotate = imagerotate($image, $dx, 0);

$vPos = 8;
$hPos = 28;
$fontSize = 5;
ImageString($rotate, $fontSize, $hPos, $vPos, $sign1, $colors[0]);
ImageString($rotate, $fontSize, $hPos+1, $vPos+1, $sign1, $colors[0]);

//imagepng($image);
//ImageDestroy($image);

imagepng($rotate);
ImageDestroy($rotate);

?>