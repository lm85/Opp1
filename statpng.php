<?php
//http://miniaplikace.blueboard.cz/pocitadla-statistiky.php?id=310263 
 include_once('thumbnail.inc.php');                                                        
$url = "http://miniaplikace.blueboard.cz/chart-data2.php?typ=mesic&idk=310263&zobrazeni=&hodnoty=&hash=50e459a79a478";

$png = file_get_contents($url);

header('Content-Type: image/png'); 
echo $png;exit;
$mime = getimagesize($png);

//print_r($mime);

$thumb = new Thumbnail($png, $mime['mime']);
$thumb->showThumb();
                      $thumb->save("ss");
exit;