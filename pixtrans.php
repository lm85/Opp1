<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk"> 
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
        <style>
            * {font-size:10px; font-family:Verdana}
            h1 {font-size:16px;}
        </style>

<?php

define('WP_USE_THEMES', false);
require('./wp-blog-header.php');
require('dump.php');
require('simple_html_dom.php');
       
//$_post = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_content LIKE %223-odkazy-debatni-fora-blogy-1.jpg%"));

$path='/data/web/virtuals/12060/virtual/www/pix';
if ($handle = opendir($path)) {
    while ($entry = readdir($handle)) {
        if (end(explode(".", $entry))=="jpg") {
            $pix[] = $entry;
        }
    }

    closedir($handle);
}   
asort($pix); 

$i = 0;
foreach ($pix as $pic) {
      $toFind = '/pix/'.$pic.'';
   
      $id = explode("-", $pic);
      $newdir =  implode('/', str_split($id[0]));
      $toReplace = '/pix/'.$newdir.'/'.$pic.'';
     
      @mkdir($path . '/'. $newdir, 0755, true);
   // echo $path .'/'.$pic . "=>" . $newdir . '/'. $pic;
       rename($path .'/'.$pic ,$path . '/'. $newdir .'/'. $pic);
     
      echo $sql =  "UPDATE $wpdb->posts SET post_content=REPLACE(post_content, '$toFind','$toReplace')  ";//exit;
       //  $sql =  "SELECT * FROM  $wpdb->posts WHERE post_content LIKE '%$toFind%'";//exit;
    $posts = $wpdb->get_results($sql);
   
    
    foreach ($posts as $post) {
        echo "<b>" .$post->post_title."</b> " .$post->ID ." = $pic <br>"; 
    }
    if ($i>20) break;
    $i++;
    echo "<hr>";
 
}          
                exit;
  //dump($pix);
  exit;
   
 $image_dir =  implode('/', str_split($img_id));
            $image_prefix = $image_dir . '/' . $img_id;
            
            @mkdir($image_dir, 0755, true);
         
