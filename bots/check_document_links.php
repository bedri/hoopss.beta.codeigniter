#!/usr/bin/php
<?php

require_once("/var/www/vhosts/hoopss.com/httpdocs/kutuphane/veritabani.php");
$db = new database;

require_once("/var/www/vhosts/hoopss.com/httpdocs/kutuphane/curl_class_cli.php");
$curl = new CURL;

if($argc > 1 && isset($argv[1]))
{
	$url = $argv[1];
	$LIKE = " AND link LIKE '%$url%'";
}
else
{
	$url = "";
	$LIKE = "";
}

if(file_exists("/var/www/vhosts/hoopss.com/httpdocs/bots/logs/checked_document_sites.log"))
{
	$last_checked_id_array = file("/var/www/vhosts/hoopss.com/httpdocs/bots/logs/checked_document_sites.log");
	$last_checked_id = (int)$last_checked_id_array[0];
}
else
{
	$last_checked_id = 1;
}

$link_que = $db->query("SELECT * FROM document WHERE enabled='1' $LIKE;");
while($link = $db->result($link_que))
{
	$file_link = addslashes($link['link']);
	$filesize = $curl->getFileSize($file_link);
	if(!$filesize)
	{
		$db->query("UPDATE document SET enabled='0',filesize='$filesize' WHERE link='$file_link';");
		echo "\033[0;34m[Check Document Links]\033[0;32m[$last_checked_id]\033[31m[X]\033[37m $link[link] - Filesize: $filesize\n";
	}
	else
	{
		$db->query("UPDATE document SET enabled='1',filesize='$filesize' WHERE link='$file_link';");
		echo "\033[0;34m[Check Document Links]\033[0;32m[$last_checked_id]\033[0;37m\033[32m[OK]\033[37m $link[link] - Filesize: $filesize\n";
	}
	$last_checked_id++;
	file_put_contents("/var/www/vhosts/hoopss.com/httpdocs/bots/logs/checked_document_sites.log",$last_checked_id);
}


?>
