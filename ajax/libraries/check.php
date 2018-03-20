<?php
function check($path){
ob_start();
global $pdo;
    
        // set php runtime to unlimited
ignore_user_abort(true);
set_time_limit(0);
$counter = 0;
    
// main loop
while (true) {
    require('../libraries/connect.php');
    require_once('../libraries/display.php');

    // if ajax request has send a timestamp, then $last_ajax_call = timestamp, else $last_ajax_call = null
    if(isset($_POST['data'])){
        $post = $_POST['data'];
    }else{
        $post = null;
    }

    // PHP caches file data, like requesting the size of a file, by default. clearstatcache() clears that cache
    clearstatcache();
    // get timestamp of when file has been changed the last time
    $content = include($path);

    // if no timestamp delivered via ajax or data.txt has been changed SINCE last ajax timestamp
    if ($post == null || $content != $post) {

        // get content of data.txt
        $result = $content;

        echo $result;

        // leave this loop step
        $pdo = NULL;
        break;

    } else {

        if($counter >= 30 || connection_aborted()){
            echo $content;
            $pdo = NULL;
            ob_flush();
            flush();
            break;
        } else {
            // wait for 1 sec (not very sexy as this blocks the PHP/Apache process, but that's how it goes)
            $pdo = NULL;
            sleep( 1 );
            $counter++;
            $pdo = NULL;
            ob_flush();
            flush();
            continue;
        }
    }
}
}
?>