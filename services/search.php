<?php

require_once("../kutuphane/veritabani.php");
$db = new Database();

$music_que = $db->query("SELECT link FROM music WHERE ((enabled='1') AND (link LIKE '%$_GET[keyword]%') AND (file_type='mp3') AND (filesize<>'0')) LIMIT 10;");
while($music = $db->result($music_que))
{
	echo $music['link']."\n";
}

exit();

?>
