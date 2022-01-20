<?php
#author : bimagates
error_reporting(0);

echo "[?] url: ";
$url = trim(fgets(STDIN))?: exit("null");
echo "[?] file type [a. mp4 b. mp3]: ";
$type = trim(fgets(STDIN))?: exit("null");
$ext = ($type == "a") ? "mp4" : "mp3";

$temp_fileName = "tikvids/vid_".md5(uniqid()).$ext;
$temp_video = getVideo($url, $ext);
$fileName = saveFile($temp_video,$temp_fileName);
(filesize($temp_fileName) > 0)? print("[>] File saved! on ".$temp_fileName) : unlink($temp_fileName);

function getVideo($url,$type,$timeout = 60){
    $ch = curl_init();
    $startTime = time();
    curl_setopt($ch, CURLOPT_URL, "http://34.125.190.190/APl/tikurl2.php?tu=".$url."&op=".$type);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_AUTOREFERER, false);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    $result = curl_exec($ch);
    if(time() > $startTime + $timeout) exit("[!] Timeout");
    $jdec = json_decode($result, true);
    curl_close($ch);
    if($jdec['error'] == true) exit("[!] $jdec[id]");
    return($result);
}

function saveFile($text,$filename){
    if(!is_dir("tikvids")) mkdir("tikvids", 0777, true);
    $fp = fopen($filename, 'w');
    fwrite($fp, $text);
    fclose($fp);
}

?>
