#!/usr/bin/php
<?php
$script_start = time();
	@error_reporting(E_ALL);
	@ini_set("display_errors",1);
	set_time_limit(0);


	require_once("/var/www/vhosts/hoopss.com/httpdocs/kutuphane/veritabani.php");
	$db = new Database;

	function strip_keywords_from_music_link($link)
	{
		$keyword_array = array();
		$keyword = trim(urldecode($link));
		echo "\n aaa ".urldecode($link)."\n";
		$keyword = str_replace("http://","",$keyword);
		$keyword = str_replace("ftp://","",$keyword);
		$keyword = str_replace("www.","",$keyword);
		$keyword = str_replace(".mp3","",$keyword);
		$keyword = str_replace(".wav","",$keyword);
		$keyword = str_replace(".MP3","",$keyword);
		$keyword = str_replace(".WAV","",$keyword);
		$keyword = str_replace(".com","",$keyword);
		$keyword = str_replace(".org","",$keyword);
		$keyword = str_replace(".net","",$keyword);
		$keyword = str_replace(".tr","",$keyword);
		$keyword = str_replace(".fr","",$keyword);
		$keyword = str_replace(".info","",$keyword);
		$keyword = str_replace(".",",",$keyword);
		$keyword = str_replace("(",",",$keyword);
		$keyword = str_replace(")",",",$keyword);
		$keyword = str_replace("-",",",$keyword);
		$keyword = str_replace("_",",",$keyword);
		$keyword = str_replace("]",",",$keyword);
		$keyword = str_replace("[",",",$keyword);
		$keyword = str_replace("#",",",$keyword);
		$keyword = str_replace("+",",",$keyword);
		$keyword = str_replace("/",",",$keyword);
		$keyword = str_replace("~",",",$keyword);
		$keyword = str_replace("@",",",$keyword);
		$keyword = str_replace(":",",",$keyword);
		$keyword = str_replace("{",",",$keyword);
		$keyword = str_replace("}",",",$keyword);
		$keyword = str_replace("'s",",",$keyword);
		$keyword = str_replace("'",",",$keyword);
		$keyword = str_replace('"',",",$keyword);
		$keyword = preg_replace("/[0-9]/i",",",$keyword);
		$mkeyword = explode("%20",$link);
		foreach($mkeyword AS $key_m=>$value_m)
		{
			$keyword_temp_array = explode(",",$keyword);
			foreach($keyword_temp_array AS $key_kta=>$value_kta)
			{
				if(!in_array($value_kta,$keyword_array) && !in_array($keyword, $keyword_array))
				{
					if(strlen($value_kta) >= 3) array_push($keyword_array, $value_kta); 
				}
			}
		}
		return $keyword_array;
	}

	function strip_keywords_from_youtube_title($title)
	{
		$keyword_array = array();
		$keyword = trim(urldecode($title));
		echo "\n aaa ".urldecode($title)."\n";
		$keyword = str_replace("http://","",$keyword);
		$keyword = str_replace("www.","",$keyword);
		$keyword = str_replace(".mp3","",$keyword);
		$keyword = str_replace(".wav","",$keyword);
		$keyword = str_replace(".MP3","",$keyword);
		$keyword = str_replace(".WAV","",$keyword);
		$keyword = str_replace(".com","",$keyword);
		$keyword = str_replace(".org","",$keyword);
		$keyword = str_replace(".net","",$keyword);
		$keyword = str_replace(".fr","",$keyword);
		$keyword = str_replace(".info","",$keyword);
		$keyword = str_replace(".",",",$keyword);
		$keyword = str_replace("(",",",$keyword);
		$keyword = str_replace(")",",",$keyword);
		$keyword = str_replace("-",",",$keyword);
		$keyword = str_replace("_",",",$keyword);
		$keyword = str_replace("]",",",$keyword);
		$keyword = str_replace("[",",",$keyword);
		$keyword = str_replace("#",",",$keyword);
		$keyword = str_replace("+",",",$keyword);
		$keyword = str_replace("/",",",$keyword);
		$keyword = str_replace("~",",",$keyword);
		$keyword = str_replace("@",",",$keyword);
		$keyword = str_replace(":",",",$keyword);
		$keyword = str_replace("{",",",$keyword);
		$keyword = str_replace("}",",",$keyword);
		$keyword = str_replace("'s",",",$keyword);
		$keyword = str_replace("'",",",$keyword);
		$keyword = str_replace('"',",",$keyword);
		$keyword = preg_replace("/[0-9]/i",",",$keyword);
		$mkeyword = explode("%20",$title);
		foreach($mkeyword AS $key_m=>$value_m)
		{
			$keyword_temp_array = explode(",",$keyword);
			foreach($keyword_temp_array AS $key_kta=>$value_kta)
			{
				if(!in_array($value_kta,$keyword_array) && !in_array($keyword, $keyword_array))
				{
					if(strlen($value_kta) >= 3) array_push($keyword_array, $value_kta); 
				}
			}
		}
		return $keyword_array;
	}

	$keyword_string = "";

	if(isset($argv[1])) $start = $argv[1];
	else $start = 1;
	if(isset($argv[2])) $limit = $argv[2];
	else $limit = 50000;

	$music_que = $db->query("SELECT DISTINCT * FROM music GROUP BY link ORDER BY id LIMIT $start,$limit;");
	while($music = $db->result($music_que))
	{
		$keyword_array = strip_keywords_from_music_link($music['link']);
		array_unique($keyword_array);
		foreach($keyword_array AS $key_ka=>$value_ka)
		{
			$time = time();
			$value_ka = addslashes($value_ka);
			$value_ka = trim($value_ka);
			$db->query("INSERT INTO keywordbot (`id`,`keyword`,`time`) VALUES ('','$value_ka','$time') ON DUPLICATE KEY UPDATE keyword='$value_ka';");
			echo "\033[0;32m[OK]\033[1;37m $value_ka\n";
		}
	}

	$youtube_que = $db->query("SELECT DISTINCT * FROM youtube GROUP BY link_title ORDER BY id LIMIT $start,$limit;");
	while($youtube = $db->result($youtube_que))
	{
		$keyword_array = strip_keywords_from_youtube_title($youtube['link_title']);
		array_unique($keyword_array);
		foreach($keyword_array AS $key_ka=>$value_ka)
		{
			$time = time();
			$value_ka = addslashes($value_ka);
			$value_ka = trim($value_ka);
			$db->query("INSERT INTO keywordbot (`id`,`keyword`,`time`) VALUES ('','$value_ka','$time') ON DUPLICATE KEY UPDATE keyword='$value_ka';");
			echo "\033[0;32m[OK]\033[1;37m $value_ka\n";
		}
	}

	$script_end = time();

	$time =  $script_end - $script_start;
	echo "Script time: ".	$time . " seconds (". $time/60 ." minutes)\n";
?>
