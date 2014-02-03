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
	echo "\033[0;31mUsage:\033[0;34m php hoopss.add_torrent.php <url> [<limit>]\033[0;37m\n";
	exit();
}
else $url = $argv[1];

$host = parse_url($url,PHP_URL_HOST);
$url_que = $db->query("SELECT * FROM torrent WHERE link LIKE '%$host%';");
$url_count = $db->num_rows($url_que);

if(!$url_count)
{


if(isset($_REQUEST['keyword'])) $keyword = $_REQUEST['keyword'];
else $keyword = "";

$file_types = "torrent|TORRENT";

$file_types_array = explode("|",$file_types);

$get_links->start_record = 0;
$get_links->record_increment = 100;

$keyword = "";
$lang = "";


$curl_query = $curl->query($url);
if($curl_query)
{
	$directories = $get_links->getDirectories($url);
      	$file_links = $get_links->getFilesTorrent($url,$file_types_array,$keyword);
}


foreach($directories as $key_dir => $value_dir)
        $file_links = $get_links->getFilesTorrent($directories[$key_dir],$file_types_array,$keyword);

}
?>

