#!/usr/bin/php
<?php
@error_reporting(E_ALL);
@ini_set("display_errors","1");

require_once("/var/www/vhosts/hoopss.com/httpdocs/kutuphane/veritabani.php");
$db = new Database;

while(1)
{
$music_count_array = $db->result($db->query("SELECT count(*) AS count FROM music WHERE enabled='1';"));
$music_count = $music_count_array[0];
$db->query("UPDATE counts SET music='$music_count';");

$video_count_array = $db->result($db->query("SELECT count(*) AS count FROM video WHERE enabled='1';"));
$video_count = $video_count_array[0];
$db->query("UPDATE counts SET video='$video_count';");

$doc_count_array = $db->result($db->query("SELECT count(*) AS count FROM document WHERE enabled='1';"));
$doc_count = $doc_count_array[0];
$db->query("UPDATE counts SET document='$doc_count';");

$arch_count_array = $db->result($db->query("SELECT count(*) AS count FROM archive WHERE enabled='1';"));
$arch_count = $arch_count_array[0];
$db->query("UPDATE counts SET archive='$arch_count';");

$youtube_count_array = $db->result($db->query("SELECT count(*) AS count FROM youtube WHERE enabled='1';"));
$youtube_count = $youtube_count_array[0];
$db->query("UPDATE counts SET youtube='$youtube_count';");

echo "\033[0;36mMusic: \033[0;37m$music_count\n";
echo "\033[0;36mDocument: \033[0;37m$doc_count\n";
echo "\033[0;36mVideo: \033[0;37m$video_count\n";
echo "\033[0;36mArchive: \033[0;37m$arch_count\n";
echo "\033[0;36mYoutube: \033[0;37m$youtube_count\n";

sleep(10);
}

?>
