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
       
//$_post = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts"));
$posts = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type='vyroci' ORDER BY ID");
   

//$postmeta = $wpdb->get_results("SELECT * FROM $wpdb->postmeta");
 foreach ($posts as $post) {
	if ($post->ID < 36396) {     // 2012
		$koncovka = 2;
	}
	
	if ($post->ID >= 36396) {
		$koncovka = 3; 
	}

	$sql = "DELETE FROM $wpdb->postmeta WHERE meta_key='perioda_koncovka' AND post_id=".$post->ID;
	mysql_query($sql) or die(mysql_error()  . "  " . $sql);
	
	$sql = "INSERT INTO $wpdb->postmeta (meta_key, post_id, meta_value) VALUES ('perioda_koncovka', ".$post->ID.",'$koncovka')";
	mysql_query($sql) or die(mysql_error()  . "  " . $sql);
	
	//dump($post);exit;
	 
 }  

 exit;
   
   
function tourl($s){
    static $tbl = array("\xc3\xa1"=>"a","\xc3\xa4"=>"a","\xc4\x8d"=>"c","\xc4\x8f"=>"d","\xc3\xa9"=>"e","\xc4\x9b"=>"e","\xc3\xad"=>"i","\xc4\xbe"=>"l","\xc4\xba"=>"l","\xc5\x88"=>"n","\xc3\xb3"=>"o","\xc3\xb6"=>"o","\xc5\x91"=>"o","\xc3\xb4"=>"o","\xc5\x99"=>"r","\xc5\x95"=>"r","\xc5\xa1"=>"s","\xc5\xa5"=>"t","\xc3\xba"=>"u","\xc5\xaf"=>"u","\xc3\xbc"=>"u","\xc5\xb1"=>"u","\xc3\xbd"=>"y","\xc5\xbe"=>"z","\xc3\x81"=>"A","\xc3\x84"=>"A","\xc4\x8c"=>"C","\xc4\x8e"=>"D","\xc3\x89"=>"E","\xc4\x9a"=>"E","\xc3\x8d"=>"I","\xc4\xbd"=>"L","\xc4\xb9"=>"L","\xc5\x87"=>"N","\xc3\x93"=>"O","\xc3\x96"=>"O","\xc5\x90"=>"O","\xc3\x94"=>"O","\xc5\x98"=>"R","\xc5\x94"=>"R","\xc5\xa0"=>"S","\xc5\xa4"=>"T","\xc3\x9a"=>"U","\xc5\xae"=>"U","\xc3\x9c"=>"U","\xc5\xb0"=>"U","\xc3\x9d"=>"Y","\xc5\xbd"=>"Z");
    $temp = strtr($s, $tbl);
    return upravSEO($temp) ;
} 
    
function upravSEO ($str) {
  $str=  @iconv('WINDOWS-1250', 'UTF-8', $str);   // blafy v kategoriich
  $str = iconv("utf-8", "us-ascii//TRANSLIT", $str);
  $str = preg_replace("~[^\w\d]+~", '-', strtolower($str));
  $str = trim($str, "-");
  $str = preg_replace('~[^-\w\d]+~', '', $str);
  return $str;
}                            //  %e2%80%93 - (Wiener Festwochen – Alban Berg: Wozzeck) 4610, http://opera-plus.cz/cardillac-umelec-%E2%80%93-vrah-%E2%80%93-hrdina/  | %e2%80%a6 …

if (false) {    // ODKAZY
    echo "POSTS = ".count($posts)."</br>";  
    
    define("PIX_DIR_ABS", "/data/web/virtuals/12060/virtual/www/pix/");
    define("PIX_DIR_HTML", "/pix/");
     $i=1;
    foreach($posts as $post) {    
        $doit=false;
        if (!strpos($post->post_name, "revision") && !strpos($post->post_name, "autosave")) {
            $imgs = array();
            $i++;                
            $html = str_get_html($post->post_content);
            foreach($html->find('a') as $a) {                                              
                $href = $a->href;                                        
                if ( (strpos($href, "operaplus")) && (strpos(strtolower($href), "html")) ) {
                    $hledat = explode("/", $href); 
                     $hledat = $hledat[3] ."/". $hledat[4]."/".$hledat[5] ;
                     $sql = "SELECT * FROM $wpdb->postmeta WHERE meta_key='blogger_permalink' AND meta_value = '/$hledat'";
                    $dest = $wpdb->get_results($sql);
                    
                    if ($dest[0]->post_id!="") {
                        $doit=true;
                        $perma = get_permalink($dest[0]->post_id);
                        $hrefs[$post->ID][$href] = $perma;  
                    }
                     

                }
            }                
            $html->clear(); unset($html);  
        }
        if ($doit)  {
            foreach (@$hrefs[$post->ID] as $change=>$href) {
                $newcontent = $post->post_content;
                $newcontent = str_replace($change, $href, $newcontent) ;
                echo $newcontent;
                
                //
                $newcontent = addslashes($newcontent); 
                //update [table_name] set [field_name] = replace([field_name],'[string_to_find]','[string_to_replace]');
                //echo $newcontent;exit;
                $sql = "UPDATE $wpdb->posts SET post_content='$newcontent' WHERE ID=".$post->ID;   
                $res = $wpdb->get_results($sql); 
                //exit;
                
            }
        //exit; 
        }
        
        
    }
    dump($hrefs);
}
if (false) {
    echo "POSTS = ".count($posts)."</br>";  
    
    define("PIX_DIR_ABS", "/data/web/virtuals/12060/virtual/www/pix/");
    define("PIX_DIR_HTML", "/pix/");
     $i=1;
    foreach($posts as $post) {    
        echo $post->ID . "<br>";    
        
        if (!strpos($post->post_name, "revision") && !strpos($post->post_name, "autosave")) {
                $imgs = array();
                $i++;
                //echo $post->post_content;
                $html = str_get_html($post->post_content);
                
                foreach($html->find('a') as $a) {                                              
                    $href = $a->href;                                        
                    if ( (strpos($href, "blogspot")) && (strpos(strtolower($href), "jpg")) ) {
                        $imgs[$href] = str_replace("-h/", "/", $href);
                        /*$ig = str_get_html($href);
                        foreach($html->find('img') as $img2) {                                              
                            $imgs[] = $img2->src;
                        }
                        $ig->clear(); unset($ig);  
                        */
                    }
                }
                
                foreach($html->find('img') as $img) {                                              
                    $href = $img->src;                                        
                    if ( (strpos($href, "blogspot")) && (strpos(strtolower($href), "jpg")) ) $imgs[$href] = $href;
                }
                
                if (count($imgs)>0) {
                    //dump($post);                    dump($imgs);exit;
                    $n=0;      
                    $newcontent = $post->post_content;
                    $doit=false;
                    foreach ($imgs as $key=>$img)      {
                        $doit=true; 
                        $n++;
                        $dest_abs = PIX_DIR_ABS . $post->ID . "-". $post->post_name."-$n.jpg"; 
                        $dest_html = PIX_DIR_HTML .  $post->ID . "-" . $post->post_name. "-$n.jpg"; 
                        //unlink($dest_abs);
                        echo "download $img to $dest_abs ($dest_html)<br/>";
                        $soubor = file_get_contents($img);                        
                        if (strlen($soubor)>500) {
                            $fp2 = FOpen ($dest_abs, "w"); 
                            if ($fp2){ FWrite ($fp2, $soubor); FClose ($fp2); }                                                         
                            $newcontent = str_replace($key, $dest_html, $newcontent);    
                        } else {
                            echo "<b>malinkaty obrazek u ". $post->ID. " NEZAPSANO</b>";
                            $doit=false; 
                            break;
                        }                        
                    }
                    if ($doit) {
                        $newcontent = addslashes($newcontent); 
                        //update [table_name] set [field_name] = replace([field_name],'[string_to_find]','[string_to_replace]');
                        $sql = "UPDATE $wpdb->posts SET post_content='$newcontent' WHERE ID=".$post->ID;   
                        $res = $wpdb->get_results($sql);  
                        //dump($res);
                        //echo "X";dump($imgs);exit; //http://opera-plus.cz/wp-admin/post.php?post=7788&action=edit
                      // exit;
                    }
                    
                }
                //dump();
                
                $html->clear(); unset($html);  
                //$sql = "UPDATE $wpdb->posts SET post_date='$newdate' WHERE ID=".$post->ID;
                
                //$res = $wpdb->get_results($sql);
                if ($i>2000) exit;
            }
           
    }
}

if (false) {
    echo "POSTS = ".count($posts)."</br>";  
     $i=1;
    foreach($posts as $post) {    
            if (!strpos($post->post_name, "revision") && !strpos($post->post_name, "autosave")) {
                //dump($post);
                $date = mysql2date('U', $post->post_date);
                if ($date > 1319925600 ) {
                     $date =  $date + (3600 * 1);
                } else {
                      $date = $date + (2 * 3600 * 1);
                }
                $newdate = date("Y-m-d H:i:s",$date);
                echo $post->ID . " | " . $post->post_title ." | " . $post->post_name . " | " . $post->post_date . "|  ".date("j.n.Y H:i:s",$date). " | $newdate<br />";
                $sql = "UPDATE $wpdb->posts SET post_date='$newdate' WHERE ID=".$post->ID;
                //$res = $wpdb->get_results($sql);
                $i++;
            }
    }
}

if (false) {
    echo "POSTS = ".count($posts)."</br>";  
     $i=1;
    foreach($posts as $post) {  
             //echo $post->post_content;
             /*
            if (substr($post->post_name,0,20)=="operni-panorama-hele11111111") {
                //dump($post);
                $newtitle  =$post->post_title . " ($i)";
                echo $post->post_date . " | " . $post->ID." | " . $post->post_title ." | " . $post->post_name . " $newtitle<br />";
                
                $sql = "UPDATE $wpdb->posts SET post_title='$newtitle' WHERE ID=".$post->ID;
                $res = $wpdb->get_results($sql);
                
                //echo   $post->post_title;  
                $i++;
            }
    }
}

if (false) {
    echo "POSTS = ".count($posts)."</br>";  
    foreach($posts as $post) {    
            echo $post->ID."<br />";
       
            $con1 = substr($post->post_content, 0, 1);
            if ($con1==">") {        
                echo $post->ID." CONTENT<br />";
                $sql = "UPDATE $wpdb->posts SET post_content='".addslashes(substr($post->post_content, 1))."' WHERE ID=".$post->ID;
                $res = $wpdb->get_results($sql);
            } 
            
            
            $title1 = substr($post->post_title, 0, 1);   
            if ($title1==">") {
                echo $post->ID." TITLE<br />";
                $sql = "UPDATE $wpdb->posts SET post_title='".addslashes(substr($post->post_title, 1))."' WHERE ID=".$post->ID;
                $res = $wpdb->get_results($sql);
            }
                
            if (substr($post->post_content, 0, 4)=="&gt;") {
                echo $post->ID." CONTENT GT<br />";
                $sql = "UPDATE $wpdb->posts SET post_content='".addslashes(substr($post->post_content, 4))."' WHERE ID=".$post->ID;
                $res = $wpdb->get_results($sql);
            }            
            
            if (substr($post->post_title, 0, 4)=="&gt;") {
                echo $post->ID." TITLE GT<br />";
                $sql = "UPDATE $wpdb->posts SET post_title='".addslashes(substr($post->post_title, 4))."' WHERE ID=".$post->ID;
                $res = $wpdb->get_results($sql);
            }   */   
        

            if (strpos($post->post_content, "font-size:130;")) {
                
                echo $post->ID." font-size:130%; <br />";
                
                $nahrada = addslashes(str_replace("font-size:130%;", "", $post->post_content));
                $sql = "UPDATE $wpdb->posts SET post_content='$nahrada' WHERE ID=".$post->ID;
                $res = $wpdb->get_results($sql);
                //exit;    
               
            }
            
            if (strpos($post->post_content, "font-size: 130%")) {
                echo $post->ID." font-size: 130%; <br />";
                $nahrada = addslashes(str_replace("font-size: 130%;", "", $post->post_content));
                $sql = "UPDATE $wpdb->posts SET post_content='$nahrada' WHERE ID=".$post->ID;
                $res = $wpdb->get_results($sql);
            }            
            
            

    }
}

if (false) {           // komentare
    echo "COMMENTS = ".count($comments)."</br>"; 
    foreach($comments as $comment) {    
        $con1 = substr($comment->comment_content, 0, 1);
        if ($con1==">") {        
            echo $comment->comment_ID." ><br />";
            $sql = "UPDATE $wpdb->comments SET comment_content='".addslashes(substr($comment->comment_content, 1))."' WHERE comment_ID=".$comment->comment_ID;
            $res = $wpdb->get_results($sql);            
        } 
    }   
}

if (false) {         // autor
    $sql = "SELECT * FROM temp_postmeta WHERE meta_key='blogger_author'";
    $res = $wpdb->get_results($sql);  
    foreach ($res as $p) {
        
        $author = explode("noreply", $p->meta_value);
        $author = explode("http", $author[0]);
        $author = str_replace("Opera Plus","redakce", $author[0]);
       
       
        $authorarray = explode(" ", $author);
        $jm = $authorarray[0];
        $pr = $authorarray[1];
        $authorarray[0] = $pr;
        $authorarray[1] = $jm;
        $author = implode(" ", $authorarray);
        $author= $author==" redakce" ? "redakce":$author;
        //echo "-".$author . "-<Br>" ;
    
        $sql = "SELECT * FROM wp_terms JOIN wp_term_taxonomy ON wp_term_taxonomy.term_id = wp_terms.term_id WHERE wp_terms.name='$author' AND wp_term_taxonomy.taxonomy='autori'";
        $res = $wpdb->get_results($sql);  
        $object_id = $p->post_id;
        
       
        if ( true ) {
            //dump($res);
             if (count($res)==0) {              // NOVY autor
                echo "POST_ID:" . $object_id . " $author (zalozi se taxonomie)";
                $slug = tourl($author);
                
                $sql = "SELECT * FROM wp_terms WHERE wp_terms.name='$author'";
                $r2 = $wpdb->get_results($sql);  
                if ($r2[0]->term_id!="") {
                    $term_id = $r2[0]->term_id;
                } else {
                    $sql = "INSERT INTO wp_terms (name, slug, term_group) VALUES ('$author', '$slug', '0')";    
                    $res = $wpdb->get_results($sql);
                    $term_id = mysql_insert_id();              
                }
                echo "<br>";
                $sql = "INSERT INTO wp_term_taxonomy (term_id, taxonomy, count) VALUES ('$term_id', 'autori', '1')";    
                $res = $wpdb->get_results($sql);              
                $term_taxonomy_id = mysql_insert_id();
            } else {                            // AUTOR PRITOMEN
                echo "POST_ID:" . $object_id . " $author (je v DB)";
                $term_taxonomy_id = $res[0]->term_taxonomy_id;
                
            }
            echo " term_taxonomy_id=$term_taxonomy_id => $object_id <br>";
            $sql = "INSERT INTO wp_term_relationships (term_taxonomy_id, object_id) VALUES ('$term_taxonomy_id', '$object_id')";    
            $res = $wpdb->get_results($sql);  

        }
       //exit;
    }
    
    //INSERT INTO     term_id    taxonomy    description    parent    count
    //$sql = "UPDATE $wpdb->comments SET comment_content='".addslashes(substr($comment->comment_content, 1))."' WHERE comment_ID=".$comment->comment_ID;
    //$res = $wpdb->get_results($sql);            
    
}
