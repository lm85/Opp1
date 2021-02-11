<?php
define("MAX_WIDTH", 430);
define("HEIGHT", 10);
function create_bar($progress) {
    $im = imagecreatetruecolor(MAX_WIDTH , HEIGHT);
    $white = imagecolorallocate($im, 100, 100, 255);
    $bck = imagecolorallocate($im, 240, 240, 240);
    imagefilledrectangle($im, 0, 0, MAX_WIDTH , HEIGHT , $bck);
    imagefilledrectangle($im, 0, 0, MAX_WIDTH * $progress , HEIGHT , $white);
     header('Content-Type: image/png'); 
    imagepng($im); 
 }
create_bar((int) $_REQUEST['p'] / 100);