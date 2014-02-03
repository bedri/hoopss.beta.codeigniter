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

if(isset($argv[1]))
{
	$keyword = $argv[1];
}
else 
{

	$keyword_que = $db->query("SELECT * FROM keywordbot");
	$counter = 1;
	while($keywords = $db->result($keyword_que))
	{
		$keyword = trim($keywords['keyword']);
		echo "\n$counter --> $keywords[keyword]\n";
		
		$url = "http://hoopss.com/search/searchResults/music/".$keywords['keyword'];
		//$curl_query = $curl->query($url);
		exec('curl "'.$url.'"');
	
		$url = "http://hoopss.com/search/searchResults/document/".$keywords['keyword'];
		//$curl_query = $curl->query($url);
		exec('curl "'.$url.'"');
			
		$url = "http://hoopss.com/search/searchResults/video/".$keywords['keyword'];
		//$curl_query = $curl->query($url);
		exec('curl "'.$url.'"');
			
		$url = "http://hoopss.com/search/searchResults/archive/".$keywords['keyword'];
		//$curl_query = $curl->query($url);
		exec('curl "'.$url.'"');
			
		$url = "http://hoopss.com/search/searchResults/image/".$keywords['keyword'];
		//$curl_query = $curl->query($url);
		exec('curl "'.$url.'"');
			
		$url = "http://hoopss.com/search/searchResults/andorid/".$keywords['keyword'];
		//$curl_query = $curl->query($url);
		exec('curl "'.$url.'"');
			
		$url = "http://hoopss.com/search/searchResults/torrent/".$keywords['keyword'];
		//$curl_query = $curl->query($url);
		exec('curl "'.$url.'"');
		$counter++;
	}
	
	echo "$counter keywords are cached";

}
?>

