<?php
$do = $_REQUEST['do'];
     
define('WP_USE_THEMES', false);    
require('dump.php');
require('simple_html_dom.php');
require('./wp-blog-header.php');
         
if ($do == "ANKETADISP") { 
    $nazev = $_REQUEST['anketa'];
    echo anketa_display($nazev);
                
}

if ($do == "SAVE_ANKETA_BID") { 
    $kategorie = $_REQUEST['kategorie']; 
    $anketa = $_REQUEST['anketa']; 
    $ucastnik = $_REQUEST['ucastnik']; 
    $ip = $_SERVER['REMOTE_ADDR'];
    
    $sql = "SELECT * FROM anketa WHERE kategorie='$kategorie' AND anketa='$anketa' AND ip='$ip'";
    $res = mysql_query($sql) or die(mysql_error());
    if (mysql_num_rows($res) > 0) {
        echo "hlasovano";
    }
    
    $sql = "INSERT INTO anketa (kategorie, ucastnik, anketa, date_add, ip) VALUES ('$kategorie', '$ucastnik', '$anketa', NOW(), '$ip')";
    $sql = "INSERT INTO anketa (kategorie, ucastnik, anketa, date_add, ip) VALUES ('$kategorie', '$ucastnik', '$anketa', NOW(), '$ip')";
    mysql_query($sql) or die(mysql_error());                                                                             
}


if ($do == "SEND_TO_FRIEND") {
	
	$email = $_REQUEST['email'];
	$emailFrom = $_REQUEST['emailFrom'] !="" ? $_REQUEST['emailFrom']:"info@operaplus.cz";
	$odd = $_REQUEST['name']!="" ? $_REQUEST['name']:"OperaPlus";
	$article_ID = $_REQUEST['article_ID'];
	$vzkaz = $_REQUEST['vzkaz']!="" ? "Vzkaz: " . $_REQUEST['vzkaz']:"";
     // echo "s".$emailFrom;exit;
    $ip = $_SERVER['REMOTE_ADDR']; 
	$sql = "INSERT INTO archive_send_article (id_object, email, cas,ip) VALUES ('$article_ID', '$email', NOW(), '$ip')";
	mysql_query($sql) or die(mysql_error());
	$p = get_post($article_ID);
	print_r($p->post_title);
	  
	$message = "$odd Vám doporučuje článek <a href='".get_permalink($article_ID)."'>{$p->post_title}</a><br />$vzkaz<br /><br />Operaplus.cz";
	$headers = 'From: '.$odd.' <'.$emailFrom.'>' . "\r\n";
   
   
  // $email = "brozjakub@seznam.cz";
	add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));

	wp_mail( $email, "Odkaz na článek Operaplus.cz - ". $p->post_title, $message, $headers );
}

