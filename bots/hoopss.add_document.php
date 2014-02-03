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

if(isset($argv[2])) $limit = $argv[2];
else $limit = 10;

if(!isset($argv[1]))
{
	echo "\033[0;31mUsage:\033[0;34m php add_document.php <url> [<limit>]\033[0;37m\n";
	exit();
}
else $url = $argv[1];


if(isset($_REQUEST['keyword'])) $keyword = $_REQUEST['keyword'];
else $keyword = "";

$file_types = "pdf|PDF|doc|DOC|mobi|MOBI|lit|LIT|docx|DOCX|txt|TXT|ps|PS|rtf|RTF|xls|XLS|ppt|PPT|pps|PPS|xlsx|XLSX|sql|SQL|epub|EPUB";

$file_types_array = explode("|",$file_types);

$get_links->start_record = 0;
$get_links->record_increment = 100;

$keyword = "";
$lang = "";


$curl_query = $curl->query($url);
if($curl_query)
{
	$directories = $get_links->getDirectories($url);
      	$file_links = $get_links->getFilesDocument($url,$file_types_array,$keyword);
}


foreach($directories as $key_dir => $value_dir)
        $file_links = $get_links->getFilesDocument($directories[$key_dir],$file_types_array,$keyword);

?>

