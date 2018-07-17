<?php

$maxFileAge = 7;//seconds

$search = new A_search($_REQUEST['chat'],$GLOBALS['db']);

//check validity of location
if(count($search->get_results()) < 1) die("false");
    //does not work at unclaimed property
$dir = $search->get_real_path();

$file = $dir."/chat.json";

echo " ";

if(isset($_REQUEST['ice']) && $_REQUEST['ice'] != ""){
            $newIce = trim($_REQUEST['ice']);
            file_put_contents($dir."/chat.json",$newIce,LOCK_EX);
            echo $newIce;
}elseif(is_file($file) && (time()-filemtime($dir."/chat.json")) < $maxFileAge){
        echo file_get_contents($dir."/chat.json");
}

yo_exit();
