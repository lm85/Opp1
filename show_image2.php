<?php

//  http://operaplus.cz/show_image.php?cropWidth=100&cropHeight=100

//

require('dump.php');
require('simple_html_dom.php');
require('./wp-blog-header.php');
include_once('thumbnail.inc.php');


	$postID = (int) $_GET['id'];
    $post = get_post($postID);
    $title = $post->post_title;
     $content = $post->post_content;



    $pattern = '/<img[^>](.*?)NAHLEDOVY_OBRAZEK(.*?)+src[\\s=\'"]';
    $pattern .= '+([^"\'>\\s]+)/is';
    $more = 0;
    if(preg_match($pattern,$content,$match)) {
      //  $theImage =  "$link<img src=\"$match[3]\" class=\"$class\" alt=\"$title\" width=\"$w\" />$linkend\n\n";
      //  return $theImage;
       $pix = $match[3];

    }

  if (!$pix) {

    $pattern = '/<img[^>]+src[\\s=\'"]';
    $pattern .= '+([^"\'>\\s]+)/is';
    $more = 0;
    if(preg_match($pattern,$content,$match)) {
        //$theImage =  "<img class=\"recent__img\" src=\"$match[1]\" class=\"$class\" alt=\"$title\" width=\"$w\" />\n\n";
        $pix = $match[1];
    }
  }
   //echo $pix;exit;
 $pix = str_replace("http://operaplus.cz/", "", $pix);
 $pix = str_replace("/pix", "pix", $pix);
 //echo $pix;exit;
$mime = getimagesize($pix);

//print_r($mime);

$thumb = new Thumbnail($pix, $mime['mime']);
//$thumb->showThumb();exit;
if(isset($_GET['maxWidth']))
	$thumb->maxWidth = $_GET['maxWidth'];
if(isset($_GET['maxHeight']))
	$thumb->maxHeight = $_GET['maxHeight'];
if(isset($_GET['cropWidth']))
	$thumb->cropWidth = $_GET['cropWidth'];
if(isset($_GET['cropHeight']))
	$thumb->cropHeight = $_GET['cropHeight'];
    //print_r( $mime);exit;
$thumb->showThumb();
exit;