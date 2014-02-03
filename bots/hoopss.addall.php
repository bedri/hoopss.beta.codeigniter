#!/usr/bin/php
<?php

error_reporting(E_ALL);
@ini_set("display_errors","1");
@set_time_limit(0);

require_once("/var/www/vhosts/hoopss.com/httpdocs/kutuphane/curl_class_cli.php");

require_once("/var/www/vhosts/hoopss.com/httpdocs/kutuphane/get_links_class_cli.php");
$get_links = new GetLinks;

$curl = new CURL;
$db = new database;


if(!isset($argv[1]))
{
        $url = '';
        echo "Usage: php hoopss.addall.php <url>";
}
else $url = $argv[1];

if(isset($_REQUEST['keyword'])) $keyword = $_REQUEST['keyword'];
else $keyword = "";

$file_types_music = "mp3|MP3|wma|WMA|ogg|OGG|flac|FLAC|au|AU";
$file_types_document = "pdf|PDF|doc|DOC|mobi|MOBI|lit|LIT|docx|DOCX|txt|TXT|ps|PS|rtf|RTF|xls|XLS|ppt|PPT|pps|PPS|xlsx|XLSX|sql|SQL|sub|SUB|srt|SRT|djvu|DJVU|sit|SIT";
$file_types_video = "webm|WEBM|ogv|OGV|mp4|MP4|m4v|M4V|avi|AVI|flv|FLV|mkv|MKV|divx|DIVX|mpeg|MPEG|mpg|MPG|wmv|WMV|asf|ASF";
$file_types_archive = "zip|ZIP|rar|RAR|iso|ISO|nrg|NRG|mdb|MDB|cue|CUE|dwg|DWG";
$file_types_torrent = "torrent|TORRENT";
$file_types_android = "apk|APK";
$file_types_image = "jpg|JPG|gif|GIF|png|PNG|tiff|TIFF|bmp|BMP|psd|PSD|eps|EPS|ai|AI";

$file_types_array_music = explode("|",$file_types_music);
$file_types_array_document = explode("|",$file_types_document);
$file_types_array_video = explode("|",$file_types_video);
$file_types_array_archive = explode("|",$file_types_archive);
$file_types_array_torrent = explode("|",$file_types_torrent);
$file_types_array_android = explode("|",$file_types_android);
$file_types_array_image = explode("|",$file_types_image);

$get_links->start_record = 0;
$get_links->record_increment = 100;

$keyword = "";
$lang = "";

$directories = array();
$curl_query = $curl->query($url);
if($curl_query)
{
        $directories = $get_links->getDirectories($url);
        //echo "\n Directories \n";
        //print_r($directories);
        $file_links = $get_links->getFilesMusic($url,$file_types_array_music,$keyword);
        $file_links = $get_links->getFilesDocument($url,$file_types_array_document,$keyword);
        $file_links = $get_links->getFilesVideo($url,$file_types_array_video,$keyword);
        $file_links = $get_links->getFilesArchieve($url,$file_types_array_archive,$keyword);
        $file_links = $get_links->getFilesTorrent($url,$file_types_array_torrent,$keyword);
        $file_links = $get_links->getFilesAndroid($url,$file_types_array_android,$keyword);
//        $file_links = $get_links->getFilesImage($url,$file_types_array_image,$keyword);
}


foreach($directories as $key_dir => $value_dir)
{
        $file_links = $get_links->getFilesMusic($directories[$key_dir],$file_types_array_music,$keyword);
        $file_links = $get_links->getFilesDocument($directories[$key_dir],$file_types_array_document,$keyword);
        $file_links = $get_links->getFilesVideo($directories[$key_dir],$file_types_array_video,$keyword);
        $file_links = $get_links->getFilesArchieve($directories[$key_dir],$file_types_array_archive,$keyword);
        $file_links = $get_links->getFilesTorrent($directories[$key_dir],$file_types_array_torrent,$keyword);
        $file_links = $get_links->getFilesAndroid($directories[$key_dir],$file_types_array_android,$keyword);
//        $file_links = $get_links->getFilesImage($directories[$key_dir],$file_types_array_image,$keyword);
}

?>

