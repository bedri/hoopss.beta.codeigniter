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

$file_types = ".pdf+OR+.PDF+OR+.doc+OR+.DOC+OR+.mobi+OR+.MOBI+OR+.lit+OR+.LIT+OR+.txt+OR+.TXT+OR+.rtf+OR+.RTF+OR+.docx+OR+.DOCX+OR+.ps+OR+.PS+OR+.odt+OR+.ODT+OR+.gp3+OR+.GP3";

$file_extentions = str_replace(".","",$file_types);
$file_types_array = explode("|",$file_extentions);

$get_links->start_record = 0;
$get_links->record_increment = 100;

$keyword = "";
$lang = "";

$time = time();

$counter = 0;

do {

$google_links = $get_links->getGoogleLinks($file_types,$keyword,$lang);


foreach($google_links as $key_gl => $value_gl)
{
	$query = $curl->query($value_gl);
	if($query && (strstr($query,"<address>") || strstr($query,"<ADDRESS>"))) $enabled = "1";
	else $enabled = "0";

	echo "$value_gl\n";
	$site_check_que = $db->query("SELECT link FROM document_google_site_links WHERE link LIKE '$value_gl%';");
	$site_check = (int) $db->num_rows($site_check_que);

	$ping_address = $ping->getAddressPort($value_gl);
	$ping_result = $ping->makePing($ping_address['address']);

	echo "$site_check\n";
	if(!$site_check)
	{
		$db->query("INSERT INTO document_google_site_links (id,link,enabled,ping,time) VALUES ('','$value_gl','$enabled','$ping_result','$time');");
    }
	else
	{
		//$db->query("UPDATE document_google_site_links SET enabled='$enabled',ping='$ping_result',time='$time' WHERE link='$value_gl';");
	}

}


$get_links->start_record = $get_links->start_record + $get_links->record_increment;

$counter++;
} while($get_links->start_record < $get_links->total_record);

echo "$counter sites scanned out of $total_record\n";
?>

