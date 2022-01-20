<?php
error_reporting(0);

echo "[?] url: ";
$url = trim(fgets(STDIN))?: exit("null");

$temp_fileName = "tikvids/vid_".md5($url).".mp4";
$temp_video = getVideo($url);
$fileName = write_to_file($temp_video,$temp_fileName);
(filesize($temp_fileName) > 0)? print("[>] File saved! on ".$temp_fileName) : unlink($temp_fileName);

function getVideo($url,$timeout = 60){
    $ch = curl_init();
    $startTime = time();
    curl_setopt($ch, CURLOPT_URL, "http://34.125.190.190/APl/tikurl.php?tu=".$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, false);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $result = curl_exec($ch);
    if(time() > $startTime + $timeout) exit("[!] Timeout");
    $jdec = json_decode($result, true);
    curl_close($ch);
    if($jdec['error'] == true) exit("[!] $jdec[id]");
    return($result);
}

function write_to_file($text,$new_filename){
    if(!is_dir("tikvids")) mkdir("tikvids", 0777, true);
    $fp = fopen($new_filename, 'w');
    fwrite($fp, $text);
    fclose($fp);
}

?>
