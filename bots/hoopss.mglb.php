#!/usr/bin/php
<?php

error_reporting(E_ALL);
@ini_set("display_errors","1");
@set_time_limit(0);

require_once("/var/www/vhosts/hoopss.com/httpdocs/kutuphane/curl_class_cli.php");

require_once("/var/www/vhosts/hoopss.com/httpdocs/kutuphane/ping_class.php");
$ping = new Ping;

require_once("/var/www/vhosts/hoopss.com/httpdocs/kutuphane/get_links_class_cli.php");
$get_links = new GetLinks;

$curl = new CURL;
$db = new database;

if(isset($_REQUEST['keyword'])) $keyword = $_REQUEST['keyword'];
else $keyword = "";

if(isset($argv[1])) $start_record = $argv[1];
else $start_record = 0;

$file_types = ".mp3+OR+.MP3+OR+.wma+OR+.WMA+OR+.ogg+OR+.OGG+OR+.flac+OR+.FLAC+OR+.au+OR+.AU";

$file_extentions = str_replace(".","",$file_types);
$file_types_array = explode("|",$file_extentions);

$get_links->start_record = 0;
$get_links->record_increment = 100;

$keyword = "";
$lang = "en";

$time = time();

$counter = 0;

do {

$google_links = $get_links->getGoogleLinks($file_types,$keyword,$lang,$start_record);


foreach($google_links as $key_gl => $value_gl)
{
	$query = $curl->query($value_gl);
	if($query && (strstr($query,"<address>") || strstr($query,"<ADDRESS>"))) $enabled = "1";
	else $enabled = "0";

	$value_gl = mysql_real_escape_string($value_gl);
	$site_check_que = $db->query("SELECT link FROM music_google_site_links WHERE link LIKE '$value_gl%';");
	$site_check = (int) $db->num_rows($site_check_que);
	echo "                                                                                                                             \r";
	echo "$value_gl\r";

	$ping_address = $ping->getAddressPort($value_gl);
	//$ping_result = $ping->makePing($ping_address['address']);
	$ping_result_que = exec("ping -w 3 -c 1 $ping_address[address]");
	if(strstr($ping_result_que , "time=")) $ping_result = 1;
	else $ping_result = 0;

	//echo "$site_check\n";
	if(!$site_check)
	{
		echo "\n[OK]\r";
		$db->query("INSERT INTO music_google_site_links (id,link,enabled,ping,time) VALUES ('','$value_gl','$enabled','$ping_result','$time');");
        }
	else
	{
		//$db->query("UPDATE music_google_site_links SET enabled='$enabled',ping='$ping_result',time='$time' WHERE link='$value_gl';");
	}
}


$get_links->start_record = $get_links->start_record + $get_links->record_increment;

$counter++;
} while($get_links->start_record < 1000000);

echo "$counter site scanned out of $total_record\n";
?>

