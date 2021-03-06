#!/usr/bin/php
<?php

error_reporting(E_ALL);
@ini_set("display_errors","1");
@set_time_limit(0);

require_once("../kutuphane/curl_class_cli.php");

require_once("../kutuphane/get_links_class_cli.php");
$get_links = new GetLinks;

$curl = new CURL;
$db = new database;


if(!isset($argv[1]))
{
	$url = '';
	echo "Usage: php add_music.php <url>";
}
else $url = $argv[1];

if(isset($_REQUEST['keyword'])) $keyword = $_REQUEST['keyword'];
else $keyword = "";

$file_types = "jpg|JPG|gif|GIF|png|PNG|tiff|TIFF|bmp|BMP|psd|PSD";

$file_types_array = explode("|",$file_types);

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
      	$file_links = $get_links->getFilesImage($url,$file_types_array,$keyword);
	//echo "\n Files \n";
	//print_r($file_links);
}


foreach($directories as $key_dir => $value_dir)
{

        $file_links = $get_links->getFilesImage($directories[$key_dir],$file_types_array,$keyword);
	//echo "\n Files \n";
	//print_r($file_links);
}

?>

