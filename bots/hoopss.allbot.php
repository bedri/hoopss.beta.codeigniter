#!/usr/bin/php
<?php

error_reporting(E_ALL);
@ini_set("display_errors","0");
@set_time_limit(0);

require_once("/var/www/vhosts/hoopss.com/httpdocs/kutuphane/curl_class_cli.php");


require_once("/var/www/vhosts/hoopss.com/httpdocs/kutuphane/get_links_class_cli.php");
$get_links = new GetLinks;

$curl = new CURL;
$db = new database;

if(isset($argv[1])) $limit = $argv[1];
else $limit = 100;

if(isset($argv[2]) && ($argv[2] == "reverse")) $asc = "desc";
else $asc = "asc";

if(isset($_REQUEST['keyword'])) $keyword = $_REQUEST['keyword'];
else $keyword = "";

$file_types_music = "mp3|MP3|wma|WMA|ogg|OGG|flac|FLAC|au|AU";
$file_types_document = "pdf|PDF|doc|DOC|mobi|MOBI|lit|LIT|docx|DOCX|txt|TXT|ps|PS|rtf|RTF|xls|XLS|ppt|PPT|pps|PPS|xlsx|XLSX|sql|SQL|sub|SUB|srt|SRT|djvu|DJVU";
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

$last_checked_site_id_que = $db->query("SELECT last_id FROM last_checked_site_id;");
$last_checked_site_id = $db->result($last_checked_site_id_que);

$counter = 1;
/* Music */
$site_que = $db->query("SELECT id,link FROM music_google_site_links WHERE ((enabled='1')) ORDER BY id $asc ;");
$site_count = $db->num_rows($site_que);
if(!$site_count) $db->query("UPDATE last_checked_site_id SET last_id=1;");
while($site = $db->result($site_que))
{
	echo "\n\n \033[32m[SITE]\033[37m \033[35m$site[link]\033[37m \n\n";
	$curl_query = $curl->query($site['link']);
	if($curl_query)
	{
		$directories = $get_links->getDirectories($site['link']);
       		$get_links->getFilesMusic($site['link'],$file_types_array_music,$keyword);
       		$get_links->getFilesDocument($site['link'],$file_types_array_document,$keyword);
       		$get_links->getFilesVideo($site['link'],$file_types_array_video,$keyword);
       		$get_links->getFilesArchieve($site['link'],$file_types_array_archive,$keyword);
       		$get_links->getFilesTorrent($site['link'],$file_types_array_torrent,$keyword);
       		$get_links->getFilesAndroid($site['link'],$file_types_array_android,$keyword);
		//$get_links->getFilesImage($site['link'],$file_types_array_image,$keyword);
	}
	$db->query("UPDATE last_checked_site_id SET last_id='$site[id]';");
}



foreach($directories as $key_dir => $value_dir)
{
        $get_links->getFilesMusic($directories[$key_dir],$file_types_array_music,$keyword);
        $get_links->getFilesDocument($directories[$key_dir],$file_types_array_document,$keyword);
        $get_links->getFilesVideo($directories[$key_dir],$file_types_array_video,$keyword);
        $get_links->getFilesArchieve($directories[$key_dir],$file_types_array_archive,$keyword);
        $get_links->getFilesTorrent($directories[$key_dir],$file_types_array_torrent,$keyword);
        $get_links->getFilesAndroid($directories[$key_dir],$file_types_array_android,$keyword);
        //$get_links->getFilesImage($directories[$key_dir],$file_types_array_image,$keyword);
}


/* Document */
$site_que = $db->query("SELECT id,link FROM document_google_site_links WHERE ((enabled='1')) ORDER BY id $asc;");
$site_count = $db->num_rows($site_que);
if(!$site_count) $db->query("UPDATE last_checked_site_id SET doc_last_id=1;");
while($site = $db->result($site_que))
{
	echo "\n\n \033[32m[SITE]\033[37m \033[35m$site[link]\033[37m \n\n";
	$curl_query = $curl->query($site['link']);
	if($curl_query)
	{
		$directories = $get_links->getDirectories($site['link']);
        $get_links->getFilesMusic($site['link'],$file_types_array_music,$keyword);
        $get_links->getFilesDocument($site['link'],$file_types_array_document,$keyword);
        $get_links->getFilesVideo($site['link'],$file_types_array_video,$keyword);
        $get_links->getFilesArchieve($site['link'],$file_types_array_archive,$keyword);
        $get_links->getFilesTorrent($site['link'],$file_types_array_torrent,$keyword);
        $get_links->getFilesAndroid($site['link'],$file_types_array_android,$keyword);
        //$get_links->getFilesImage($site['link'],$file_types_array_image,$keyword);
	}
	$db->query("UPDATE last_checked_site_id SET last_id='$site[id]';");
}



foreach($directories as $key_dir => $value_dir)
{
        $get_links->getFilesMusic($directories[$key_dir],$file_types_array_music,$keyword);
        $get_links->getFilesDocument($directories[$key_dir],$file_types_array_document,$keyword);
        $get_links->getFilesVideo($directories[$key_dir],$file_types_array_video,$keyword);
        $get_links->getFilesArchieve($directories[$key_dir],$file_types_array_archive,$keyword);
        $get_links->getFilesTorrent($directories[$key_dir],$file_types_array_torrent,$keyword);
        $get_links->getFilesAndroid($directories[$key_dir],$file_types_array_android,$keyword);
        //$get_links->getFilesImage($directories[$key_dir],$file_types_array_image,$keyword);
}



/* Video */
$site_que = $db->query("SELECT id,link FROM video_google_site_links WHERE ((enabled='1')) ORDER BY id $asc LIMIT;");
$site_count = $db->num_rows($site_que);
if(!$site_count) $db->query("UPDATE last_checked_site_id SET video_last_id=1;");
while($site = $db->result($site_que))
{
	echo "\n\n \033[32m[SITE]\033[37m \033[35m$site[link]\033[37m \n\n";
	$curl_query = $curl->query($site['link']);
	if($curl_query)
	{
		$directories = $get_links->getDirectories($site['link']);
        $get_links->getFilesMusic($site['link'],$file_types_array_music,$keyword);
        $get_links->getFilesDocument($site['link'],$file_types_array_document,$keyword);
        $get_links->getFilesVideo($site['link'],$file_types_array_video,$keyword);
        $get_links->getFilesArchieve($site['link'],$file_types_array_archive,$keyword);
        $get_links->getFilesTorrent($site['link'],$file_types_array_torrent,$keyword);
        $get_links->getFilesAndroid($site['link'],$file_types_array_android,$keyword);
        //$get_links->getFilesImage($site['link'],$file_types_array_image,$keyword);
	}
	$db->query("UPDATE last_checked_site_id SET last_id='$site[id]';");
}



foreach($directories as $key_dir => $value_dir)
{
        $get_links->getFilesMusic($directories[$key_dir],$file_types_array_music,$keyword);
        $get_links->getFilesDocument($directories[$key_dir],$file_types_array_document,$keyword);
        $get_links->getFilesVideo($directories[$key_dir],$file_types_array_video,$keyword);
        $get_links->getFilesArchieve($directories[$key_dir],$file_types_array_archive,$keyword);
        $get_links->getFilesTorrent($directories[$key_dir],$file_types_array_torrent,$keyword);
        $get_links->getFilesAndroid($directories[$key_dir],$file_types_array_android,$keyword);
        //$get_links->getFilesImage($directories[$key_dir],$file_types_array_image,$keyword);
}



/* Archive */
$site_que = $db->query("SELECT id,link FROM archive_google_site_links WHERE ((enabled='1')) ORDER BY id $asc;");
$site_count = $db->num_rows($site_que);
if(!$site_count) $db->query("UPDATE last_checked_site_id SET archive_last_id=1;");
while($site = $db->result($site_que))
{
	echo "\n\n \033[32m[SITE]\033[37m \033[35m$site[link]\033[37m \n\n";
	$curl_query = $curl->query($site['link']);
	if($curl_query)
	{
		$directories = $get_links->getDirectories($site['link']);
        $get_links->getFilesMusic($site['link'],$file_types_array_music,$keyword);
        $get_links->getFilesDocument($site['link'],$file_types_array_document,$keyword);
        $get_links->getFilesVideo($site['link'],$file_types_array_video,$keyword);
        $get_links->getFilesArchieve($site['link'],$file_types_array_archive,$keyword);
        $get_links->getFilesTorrent($site['link'],$file_types_array_torrent,$keyword);
        $get_links->getFilesAndroid($site['link'],$file_types_array_android,$keyword);
        //$get_links->getFilesImage($site['link'],$file_types_array_image,$keyword);
	}
	$db->query("UPDATE last_checked_site_id SET last_id='$site[id]';");
}



foreach($directories as $key_dir => $value_dir)
{
        $get_links->getFilesMusic($directories[$key_dir],$file_types_array_music,$keyword);
        $get_links->getFilesDocument($directories[$key_dir],$file_types_array_document,$keyword);
        $get_links->getFilesVideo($directories[$key_dir],$file_types_array_video,$keyword);
        $get_links->getFilesArchieve($directories[$key_dir],$file_types_array_archive,$keyword);
        $get_links->getFilesTorrent($directories[$key_dir],$file_types_array_torrent,$keyword);
        $get_links->getFilesAndroid($directories[$key_dir],$file_types_array_android,$keyword);
        //$get_links->getFilesImage($directories[$key_dir],$file_types_array_image,$keyword);
}



/* Torrent */
$site_que = $db->query("SELECT id,link FROM torrent_google_site_links WHERE ((enabled='1')) ORDER BY id $asc;");
$site_count = $db->num_rows($site_que);
if(!$site_count) $db->query("UPDATE last_checked_site_id SET torrent_last_id=1;");
while($site = $db->result($site_que))
{
	echo "\n\n \033[32m[SITE]\033[37m \033[35m$site[link]\033[37m \n\n";
	$curl_query = $curl->query($site['link']);
	if($curl_query)
	{
		$directories = $get_links->getDirectories($site['link']);
        $get_links->getFilesMusic($site['link'],$file_types_array_music,$keyword);
        $get_links->getFilesDocument($site['link'],$file_types_array_document,$keyword);
        $get_links->getFilesVideo($site['link'],$file_types_array_video,$keyword);
        $get_links->getFilesArchieve($site['link'],$file_types_array_archive,$keyword);
        $get_links->getFilesTorrent($site['link'],$file_types_array_torrent,$keyword);
        $get_links->getFilesAndroid($site['link'],$file_types_array_android,$keyword);
        //$get_links->getFilesImage($site['link'],$file_types_array_image,$keyword);
	}
	$db->query("UPDATE last_checked_site_id SET torrent_last_id='$site[id]';");
}



foreach($directories as $key_dir => $value_dir)
{
        $get_links->getFilesMusic($directories[$key_dir],$file_types_array_music,$keyword);
        $get_links->getFilesDocument($directories[$key_dir],$file_types_array_document,$keyword);
        $get_links->getFilesVideo($directories[$key_dir],$file_types_array_video,$keyword);
        $get_links->getFilesArchieve($directories[$key_dir],$file_types_array_archive,$keyword);
        $get_links->getFilesTorrent($directories[$key_dir],$file_types_array_torrent,$keyword);
        $get_links->getFilesAndroid($directories[$key_dir],$file_types_array_android,$keyword);
        //$get_links->getFilesImage($directories[$key_dir],$file_types_array_image,$keyword);
}



/* Android */
$site_que = $db->query("SELECT id,link FROM android_google_site_links WHERE ((enabled='1')) ORDER BY id $asc;");
$site_count = $db->num_rows($site_que);
if(!$site_count) $db->query("UPDATE last_checked_site_id SET android_last_id=1;");
while($site = $db->result($site_que))
{
	echo "\n\n \033[32m[SITE]\033[37m \033[35m$site[link]\033[37m \n\n";
	$curl_query = $curl->query($site['link']);
	if($curl_query)
	{
		$directories = $get_links->getDirectories($site['link']);
        $get_links->getFilesMusic($site['link'],$file_types_array_music,$keyword);
        $get_links->getFilesDocument($site['link'],$file_types_array_document,$keyword);
        $get_links->getFilesVideo($site['link'],$file_types_array_video,$keyword);
        $get_links->getFilesArchieve($site['link'],$file_types_array_archive,$keyword);
        $get_links->getFilesTorrent($site['link'],$file_types_array_torrent,$keyword);
        $get_links->getFilesAndroid($site['link'],$file_types_array_android,$keyword);
        //$get_links->getFilesImage($site['link'],$file_types_array_image,$keyword);
	}
	$db->query("UPDATE last_checked_site_id SET android_last_id='$site[id]';");
}



foreach($directories as $key_dir => $value_dir)
{
        $get_links->getFilesMusic($directories[$key_dir],$file_types_array_music,$keyword);
        $get_links->getFilesDocument($directories[$key_dir],$file_types_array_document,$keyword);
        $get_links->getFilesVideo($directories[$key_dir],$file_types_array_video,$keyword);
        $get_links->getFilesArchieve($directories[$key_dir],$file_types_array_archive,$keyword);
        $get_links->getFilesTorrent($directories[$key_dir],$file_types_array_torrent,$keyword);
        $get_links->getFilesAndroid($directories[$key_dir],$file_types_array_android,$keyword);
        //$get_links->getFilesImage($directories[$key_dir],$file_types_array_image,$keyword);
}



?>

