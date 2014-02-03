#!/usr/bin/php
<?php
require_once("/var/www/vhosts/hoopss.com/httpdocs/kutuphane/curl_class_cli.php");
$curl = new CURL;

require_once("/var/www/vhosts/hoopss.com/httpdocs/kutuphane/veritabani.php");
$db = new database;

require_once("/var/www/vhosts/hoopss.com/httpdocs/kutuphane/ping_class.php");
$ping = new Ping;

require('/var/www/vhosts/hoopss.com/httpdocs/kutuphane/mp3_id3_class/error.inc.php');
require('/var/www/vhosts/hoopss.com/httpdocs/kutuphane/mp3_id3_class/id3.class.php');

$directories = array();
$files = array();

function getDirectories($url) {
	global $curl;
	global $db;
	global $directories;
	global $ping;
	
	$url_content = $curl->query("$url");
	$url_array = explode("\n",$url_content);
	array_pop($url_array);
	
	foreach($url_array as $key_ua => $value_ua)
	{
		$line_explode = explode(" ",$value_ua);
		if(strstr($value_ua,"<DIR>"))
		{
			$directory = $line_explode[count($line_explode) - 1];
			array_push($directories,$url.$directory."/");
			getDirectories($url.$directory."/");
			echo "\033[32m[OK][DIR]\033[37m ".$url.$directory."\n";

echo $ping_address['address'];
exit();
			$ping_address = $ping->getAddressPort($url);
			$ping_result = $ping->makePing($ping_address['address']);
			if(!$ping_result) $enabled = 0;
			else $enabled = 1;
			
			$time = time();
			$link = $url.$directory."/";
			//$db->query("INSERT INTO ftp_directories (id,link,ping,enabled,time) VALUES ('','$link','$ping_result','$enabled','$time');");
		}
	}
	return $directories;
}

function getFtpFileLinks($url,$file_extention,$pages=10) {
	global $curl;
	global $db;
	global $files;

	$music_extentions = array("mp3","MP3","wma","WMA","ogg","OGG","flac","FLAC");
	$document_extentions = array("pdf","PDF","doc","DOC","docx","DOCX","mobi","MOBI","lit","LIT","txt","TXT","rtf","RTF","ps","PS");
	$video_extentions = array("avi","AVI","mpg","MPG","mpeg","MPEG","mkv","MKV","divx","DIVX","flv","FLV","wmv","WMV");
	
	if(in_array($file_extention,$music_extentions))
	{
		$table_name = "music";
		$page_field = "music_page";
	}
	else if(in_array($file_extention,$document_extentions))
	{
		$table_name = "document";
		$page_field = "doc_page";
	}
	else if(in_array($file_extention,$video_extentions))
	{
		$table_name = "video";
		$page_field = "video_page";
	}
	else return 0;
	
	$ftp_file_links = array();
	$dot_file_extention = ".".$file_extention;
	
	//$db->query("UPDATE ftp_last_page SET $page_field='$i';");
	
	$url_content = $curl->query("$url");
	$url_array = explode("\n",$url_content);
	array_pop($url_array);
	
	foreach($url_array as $key_ua => $value_ua)
	{
		if(!strstr($value_ua,"<DIR>"))
		{
			
			$line_explode = explode(" ",$value_ua);
			$file = $line_explode[count($line_explode) - 1];
			
			$link = addslashes($url.$file);
			$control_count_que = $db->query("SELECT * FROM $table_name WHERE link='$link';");
			$control_count = $db->num_rows($control_count_que);
			if(!$control_count)
			{
				$extention_array = explode(".",$link);
				if($extention_array[count($extention_array) - 1] == $file_extention)
				{
					if($filesize = $curl->getFileSize($link))
					{
						if(($file_extention == "mp3") || ($file_extention == "MP3"))
						{
							/* Gettin MP3 ID3 information */
							$id3_info = getID3Tags($link);
							$artist = addslashes($id3_info['artist']);
							$title = addslashes($id3_info['title']);
							$album = addslashes($id3_info['album']);
							$track = addslashes($id3_info['track']);
							$year = addslashes($id3_info['year']);
							$gender = addslashes($id3_info['gender']);
						}
						
						$time = time();
	
						if(in_array($file_extention,$music_extentions))
						{
							$insert_query = "INSERT INTO music (id,link,file_type,filesize,enabled,artist,title,album,track,year,gender,time) VALUES ('','$link','$file_extention','$filesize','1','$artist','$title','$album','$track','$year','$gender','$time');";
						}
						else if(in_array($file_extention,$document_extentions))
						{
							$insert_query = "INSERT INTO document (id,link,file_type,filesize,enabled,time) VALUES ('','$link','$file_extention','$filesize','1','$time');";
						}
						else if(in_array($file_extention,$video_extentions))
						{
							$insert_query = "INSERT INTO video (id,link,file_type,filesize,enabled,time) VALUES ('','$link','$file_extention','$filesize','1','$time');";
						}
						else return 0;
						
						if(!$control_count) $db->query($insert_query);
						echo "\033[32m[FILE][OK]\033[37m ";
					}
					else echo "\033[31m[FILE][X]\033[37m";
					echo "$link \n\r";
					array_push($files,$link);
				}
			}
		}
	}
	return $files;
}

function getID3Tags($file) {
    $mp3_ID3_array = array();
	 $myId3 = new ID3($file);
	 if ($myId3->getInfo()){
		 $mp3_ID3_array['artist'] = $myId3->getArtist();
		 $mp3_ID3_array['title'] = $myId3->getTitle();
		 $mp3_ID3_array['album'] = $myId3->getAlbum();
		 $mp3_ID3_array['track'] = $myId3->getTrack();
		 $mp3_ID3_array['year'] = $myId3->getYear();
		 $mp3_ID3_array['gender'] = $myId3->getGender();

		 return($mp3_ID3_array);
   	}else{
    	//echo($errors[$myId3->last_error_num]);
   }

}



$url = $argv[1];
$file_type = $argv[2];

$directories_array = getDirectories($url);

foreach($directories_array as $key_da => $value_da)
{
	$files_array = getFtpFileLinks($value_da,$file_type);
	print_r($files_array);
}
$files_array = getFtpFileLinks($url,$file_type);

?>
