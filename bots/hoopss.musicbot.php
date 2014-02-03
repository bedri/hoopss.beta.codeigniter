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

$file_types = "mp3|MP3|wma|WMA|ogg|OGG|flac|FLAC";

$file_types_array = explode("|",$file_types);

$get_links->start_record = 0;
$get_links->record_increment = 100;

$keyword = "";
$lang = "";

$google_sites_max_id = $db->result($db->query("SELECT MAX(id) as max_id FROM music_google_site_links ORDER BY id $asc;"));
$max_google_site_id = $google_sites_max_id['max_id'];

$last_checked_site_id_que = $db->query("SELECT * FROM last_checked_site_id;");
$last_checked_site_id = $db->result($last_checked_site_id_que);

if($last_checked_site_id['last_id'] == $max_google_site_id) $last_id = 0;
else $last_id = $last_checked_site_id['last_id'];

$site_que = $db->query("SELECT id,link FROM music_google_site_links WHERE ((enabled='1')) ORDER BY id $asc LIMIT $last_id,$limit;");
$site_count = $db->num_rows($site_que);
if(!$site_count) $db->query("UPDATE last_checked_site_id SET last_id=1;");

//echo "SELECT id,link FROM music_google_site_links WHERE ((enabled='1')) LIMIT $last_id,$limit;";
while($site = $db->result($site_que))
{
	echo "\n\n \033[32m[SITE]\033[37m \033[35m$site[link]\033[37m \n\n";
	$curl_query = $curl->query($site['link']);
	if($curl_query)
	{
       		$directories = $get_links->getDirectories($site['link']);
       		$file_links = $get_links->getFilesMusic($site['link'],$file_types_array,$keyword);
	}
	$db->query("UPDATE last_checked_site_id SET last_id='$site[id]';");
}



foreach($directories as $key_dir => $value_dir)
        $file_links = $get_links->getFilesMusic($directories[$key_dir],$file_types_array,$keyword);


?>

