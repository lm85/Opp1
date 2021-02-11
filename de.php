<?php
                //    echo $_SERVER["HTTP_CF_IPCOUNTRY"];
                //    echo $_SERVER['REQUEST_URI'];
//if ($_SERVER['REQUEST_URI']=="/info/impressum/") echo "ff";
if ($country_code = $_SERVER["HTTP_CF_IPCOUNTRY"]=="DE"  && $_SERVER['REQUEST_URI']=="/info/impressum/")
{
Header("Location: https://operaplus.cz");
  die();}
?>