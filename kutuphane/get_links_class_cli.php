<?php

error_reporting(E_ALL);
@ini_set("display_errors","0");

require_once("curl_class_cli.php");
$curl = new CURL;

require_once("veritabani.php");
$db = new database;

require('mp3_id3_class/error.inc.php');
require('mp3_id3_class/id3.class.php');


class GetLinks {

/* Class variables */
var $links = array();


function __construct() {
	$this->google_links = array();
	$this->links['directories'] = array();
	$this->links['music'] = array();
	$this->links['document'] = array();
	$this->links['video'] = array();
	$this->links['archive'] = array();
	$this->links['image'] = array();
	$this->links['soundclick'] = array();
	$this->links['tamdinle'] = array();
	$this->links['torrent'] = array();
	$this->links['android'] = array();
	$this->total_record = 0;
	$this->start_record = 0;
	$this->record_increment = 0;
	$this->current_last_record = 0;
	$this->execute = array('/','-','\\','|');
}

function getLinkURLs($url) {


	$site_explode = explode("/",$url);
	$array_count = count($site_explode);


	global $curl;

	$matches = array();
	$directories = array();

	$site_get_text = $curl->get($url);

	//preg_match_all("/(a href\=\")([^\?\"]*)(\")/i", $site_get_text, $matches);
	//preg_match_all("/(a href\=\")([^\?\"]*)(mp3\")/i", $site_get_text, $mp3_matches);
	//preg_match_all("/(a href\=\")([^\?\"]*)(\/\")/i", $site_get_text, $directories);
	$directories = $this->getDirectories($url);

	//print_r($this->links['directories']);
}


function getGoogleLinks($file_type="mp3",$keyword="",$lang="en",$ggl_start_record) {
	global $curl;
// http://ftp.skazzka.com/%D0%98%D0%B3%D1%80%D1%8B/
	if(isset($ggl_start_record)) $this->start_record = $ggl_start_record;
	//$google_url = "http://www.google.com/search?&q=-inurl:(htm|html|php|asp)+intitle:%22index+of%22+%2B%22last+modified%22+%2B%22parent+directory%22+%2Bdescription+%2Bsize+%2B($file_type)+$keyword&hl=en&num=$this->record_increment&start=$this->start_record";
	//$google_url = "http://www.google.com/search?q=parent-directory+description+size+intitle:index-of+%22last+modified+%22+$file_type+-inurl:htm+-inurl:html+-inurl:php&num=$this->record_increment&hl=$lang&lr=&prmd=ivns&ei=6XlgTZCFCIi84gbHiuQC&start=$this->start_record&sa=N";
	$duck_url = "https://duckduckgo.com/?q=$keyword";
	$google_url = "http://www.google.de/search?q=parent-directory+description+size+intitle:index-of+%22last+modified+%22+$file_type+%22ftp://%22+-inurl:htm+-inurl:html+-inurl:php&num=$this->record_increment&hl=$lang&lr=&prmd=ivns&ei=6XlgTZCFCIi84gbHiuQC&start=$this->start_record&sa=N";
	//$google_url = "http://www.google.com/search?q=last-modified+parent-directory+description+size+%22intitle:index+of+%22+$file_type+-inurl:htm+-inurl:html+-inurl:php&hl=en&num=$this->record_increment&lr=&ft=i&cr=&safe=images&tbs=&start=$this->start_record";
	//$google_url = "https://www.google.com/search?q=parent-directory+description+size+intitle:index-of+%22last+modified+%22+%22ftp://%22+-inurl:htm+-inurl:html+-inurl:php&hl=en&lr=&prmd=ivns&ei=6XlgTZCFCIi84gbHiuQC&start=1&sa=N#hl=en&lr=&psj=1&q=parent-directory+description+size+intitle:index-of+%22last+modified+%22+inurl:%22ftp://%22+(torrent%7Cmp3%7Capk%7Cpdf%7Cdoc%7Cxls%7Cdocx%7Cxlsx%7Cmobi%7Cogg%7Cavi%7Cwmv%7Crar%7Cwav%7Cmidi%7Cau%7Cppt)+-inurl:htm+-inurl:html+-inurl:php&start=260";

	$google_content = $curl->get($google_url);
	$duck_content = $curl->get($duck_url);


	preg_match_all("/(href\=\")([^\?\"]*)(\")/i", $google_content, $google_matches);
	preg_match_all("/(href\=\")([^\?\"]*)(\")/i", $duck_content, $duck_matches);

	preg_match_all("/(bout)([^a-zA-Z[:punct:]]*)(results)/i", $google_content, $total_record_array);
//	print_r($total_record_array);
	$total_record = trim($total_record_array[2][0]);
	//echo $this->total_record = 1280000;//(int)str_replace(",","",$total_record);

	$google_links = array();
	foreach($google_matches[2] as $key_gm => $value_gm)
	{
        	if(!strstr($value_gm,"google") && strstr($value_gm,"http://"))
        	{
                	if(!strstr("'",$value_gm)) array_push($this->google_links,$value_gm);
                	echo "\n\033[0;32m[SITE]\033[0;37m $value_gm \n";
        	}
	}

	return $this->google_links;
}


function getDirectories($url) {
	global $curl;
	global $db;

	$directories = array();

	$site_get_content = $curl->get($url);

	preg_match_all("/(href\=\")([^\?\"]*)(\/\")/i", $site_get_content, $directories);

	$directory_array = $directories[2];

	$counter = 1;
	foreach($directory_array as $key_da => $dir_links)
	{
		if(!strstr($this->links['directories'][count($this->links['directories'])-1],$dir_links) && !strstr("'",$dir_links) && !empty($dir_links) && $key_da && ($dir_links != $directory_array[$key_da-1]) && !strstr($dir_links,"././") && !strstr($dir_links,"../../")&& !strstr($dir_links,"../") && !strstr(strstr($dir_links,"http"),"../") && !in_array($dir_links,$this->links['directories']) && $counter < 101)
			{
				echo "\n\033[0;32m[DIR]\033[0;37m $url$dir_links \n";
				array_push($this->links['directories'],$url.$dir_links."/");
				$this->getDirectories($url.$dir_links."/");
				$time = time();
				$url_links = $url.$dir_links;
				$url_links = addslashes($url_links);
				//if(!strstr($url_links, "'") && !strstr($url_links,'"')) $db->query("INSERT INTO directories (`id`,`link`,`enabled`,`time`) VALUES ('','$url_links','1','$time');");
			}
		$counter++;
	}

	return $this->links['directories'];
}


function getFilesSoundClick($url) {
	global $curl;
	global $db;

	$songids = array();

	$site_get_content = $curl->get($url);

	preg_match_all('/(songid\=)(.*)(&q\=hi)/i', $site_get_content, $songids);
 
	$songids_array = $songids[2];
	array_unique($songids_array);

	foreach($songids_array as $key_fa => $songids_links)
	{
			unset($this->links['soundclick']);
			$this->links['soundclick'] = array();
			array_push($this->links['soundclick'],$songids_links);

			/* Check database records and if link does not exist insert else update enabled */

				// Get the file_url
				$xml_content = $curl->query("http://www.soundclick.com/util/xmlsong.cfm?songid=$songids_links");
				preg_match_all('/(<cdnFilename>)(.*)(<\/cdnFilename>)/i', $xml_content, $file_links);
				array_unique($file_links);

			foreach($file_links[2] as $key_fl=>$value_fl)
			{
			$link = urldecode($value_fl);
			$link = addslashes($link);
			$soundclick_que = $db->query("SELECT count(id) FROM music WHERE link='$link';");
			$record_check_array = $db->result($soundclick_que);
			$record_check = (int)$record_check_array[0];

			if(!$record_check && !strstr($link,"'") && !strstr($link,"%27"))
			{
			/* Checking if file exists */
				$filesize = (int)$curl->getFileSize($link);
				if(isset($filesize) && $filesize)
				{
				$timestamp = time();

				echo "\033[32m[$file_extention]\033[37m $link\n\r";
						/* Gettin MP3 ID3 information */
						$id3_info = $this->getID3Tags($link);
						$artist = addslashes($id3_info['artist']);
						$title = addslashes($id3_info['title']);
						$album = addslashes($id3_info['album']);
						$track = addslashes($id3_info['track']);
						$year = addslashes($id3_info['year']);
						$gender = addslashes($id3_info['gender']);


				$db->query("INSERT INTO music (id,link,file_type,filesize,enabled,artist,title,album,track,year,gender,time) VALUES ('','$link','mp3','$filesize','1','$artist','$title','$album','$track','$year','$gender','$timestamp') ON DUPLICATE KEY UPDATE link='$link';");
			}
			else
			{
				echo "\033[36m[DISABLED]\033[37m $link\n\r";
				$db->query("UPDATE music SET enabled='0',filesize='$filesize',link='$link' WHERE link='$link';");
			}
			}
			else
			{
				echo "\033[36m[FE]\033[37m $link\n\r";
			}
		}
	}

	return $this->links['soundclick'];
}

function getFilesTamDinle($url) {
	global $curl;
	global $db;

	$songids = array();

	$site_get_content = $curl->get($url);

	preg_match_all('/(<item>)(.*)(;)/i', $site_get_content, $songids);
 
	$song_links = $songids[2];
	array_unique($song_links);

	foreach($song_links as $key_sl => $link)
	{
			unset($this->links['tamdinle']);
			$this->links['tamdinle'] = array();
			array_push($this->links['tamdinle'],$link);

			/* Check database records and if link does not exist insert else update enabled */

			$link = urldecode($link);
			$link = addslashes($link);
			$tamdinle_que = $db->query("SELECT count(id) FROM music WHERE link='$link';");
			$record_check_array = $db->result($tamdinle_que);
			$record_check = (int)$record_check_array[0];

			if(!$record_check && !strstr($link,"'") && !strstr($link,"%27"))
			{
			/* Checking if file exists */
				$filesize = (int)$curl->getFileSize($link);
				echo "$filesize\n";
				if(isset($filesize) && $filesize)
				{
				$timestamp = time();

				echo "\033[32m[$file_extention]\033[37m $link\n\r";
						/* Gettin MP3 ID3 information */
						$id3_info = $this->getID3Tags($link);
						$artist = addslashes($id3_info['artist']);
						$title = addslashes($id3_info['title']);
						$album = addslashes($id3_info['album']);
						$track = addslashes($id3_info['track']);
						$year = addslashes($id3_info['year']);
						$gender = addslashes($id3_info['gender']);


				$db->query("INSERT INTO music (id,link,file_type,filesize,enabled,artist,title,album,track,year,gender,time) VALUES ('','$link','mp3','$filesize','1','$artist','$title','$album','$track','$year','$gender','$timestamp') ON DUPLICATE KEY UPDATE link='$link';");
			}
			else
			{
				echo "\033[36m[DISABLED]\033[37m $link\n\r";
				$db->query("UPDATE music SET enabled='0',filesize='$filesize',link='$link' WHERE link='$link';");
			}
			}
			else
			{
				echo "\033[36m[FE]\033[37m $link\n\r";
			}

			echo "";
	}

	return $this->links['tamdinle'];
}



function getFilesMusic($url,$file_types,$keyword="") {
	global $curl;
	global $db;

	$files = array();

	$site_get_content = $curl->get($url);

	preg_match_all("/(href\=\")([^\?\"]*)(\")/i", $site_get_content, $files);
	if(empty($files)) preg_match_all("/(HREF\=\")([^\?\"]*)(\")/i", $site_get_content, $files);
	
 
	$files_array = $files[2];

	foreach($files_array as $key_fa => $files_links)
	{
		$filename_array = explode(".",$files_links);
		$file_extention = $filename_array[count($filename_array)-1];

		if($key_fa && in_array($file_extention,$file_types))
		{

			/* Check database records and if link does not exist insert else update enabled */

			$link = addslashes($url.$files_links);
			array_push($this->links['music'],$link);
			$music_que = $db->query("SELECT id FROM music WHERE link='$link';");
			$record_check = $db->num_rows($music_que);

			if(!$record_check && !strstr($link,"'") && !strstr($link,"%27"))
			{
			/* Checking if file exists */
				$filesize = (int)$curl->getFileSize($url.$files_links);
				if(isset($filesize) && $filesize)
				{
					$timestamp = time();
				

				//echo "\033[32m[$file_extention]\033[37m";
					if(($file_extention == "mp3") || ($file_extention == "MP3"))
					{
						/* Gettin MP3 ID3 information */
						$id3_info = $this->getID3Tags($url.$files_links);
						$artist = addslashes($id3_info['artist']);
						$title = addslashes($id3_info['title']);
						$album = addslashes($id3_info['album']);
						$track = addslashes($id3_info['track']);
						$year = addslashes($id3_info['year']);
						$gender = addslashes($id3_info['gender']);
					}
					else
					{	
						/* Gettin MP3 ID3 information */
						$id3_info = "";
						$artist = "";
						$title = "";
						$album = "";
						$track = "";
						$year = "";
						$gender = "";
					}



					$db->query("INSERT INTO music (id,link,file_type,filesize,enabled,artist,title,album,track,year,gender,time) VALUES ('','$link','$file_extention','$filesize','1','$artist','$title','$album','$track','$year','$gender','$timestamp') ON DUPLICATE KEY UPDATE link='$link';");
						echo "\033[32m[$file_extention]\033[37m $link\n\r";
				}
				else
				{
					echo "\033[36m[DISABLED]\033[37m $link --> Extention: $file_extention\n\r";
					$db->query("UPDATE music SET enabled='0',filesize='$filesize',link='$link' WHERE link='$link';");
				}
			}
			else
			{
				//echo "\033[36m[FILE EXISTS]\033[37m $link --> Extention: $file_extention\n\r";
				$index = $key_fa%4;
				echo "\033[36m".$this->execute[$index]."\033[37m\r";
			}

			//echo " $url$files_links --> Extention: $file_extention\n\r";
		}
	}

	return $this->links['music'];
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

function getFilesDocument($url,$file_types,$keyword="") {
	global $curl;
	global $db;

	$files = array();

	$site_get_content = $curl->get($url);

	preg_match_all("/(href\=\")([^\?\"]*)(\")/i", $site_get_content, $files);
	if(empty($files)) preg_match_all("/(HREF\=\")([^\?\"]*)(\")/i", $site_get_content, $files);
	
	//if(strstr($site_get_content,"href=")) preg_match_all("/(href\=\")([^\?\"]*)(\/\")/i", $site_get_content, $files);
	//else if(strstr($site_get_content,"HREF=")) preg_match_all("/(HREF\=\")([^\?\"]*)(\/\")/i", $site_get_content, $files);
 
	$files_array = $files[2];

		foreach($files_array as $key_fa => $files_links)
		{
			$filename_array = explode(".",$files_links);
			$file_extention = $filename_array[count($filename_array)-1];

			$link = addslashes($url.$files_links);
			$doc_que = $db->query("SELECT id FROM document WHERE link='$link';");
			$record_check = $db->num_rows($doc_que);

			if(!$record_check && !strstr($link,"'") && !strstr($link,"%27"))
			{
			/* Checking if file exists */

				if($key_fa && in_array($file_extention,$file_types))
				{
					array_push($this->links['document'],$link);

					/* Checking if file exists */
					if($curl->remoteFileExists($url.$files_links))
					{
						$timestamp = time();
						$filesize = $curl->getFileSize($url.$files_links);

						/* Check database records and if link does not exist insert else update enabled */

						$document_que = $db->query("SELECT id FROM document WHERE link='$link';");
						$record_check = $db->num_rows($document_que);


						if(!$record_check && !strstr($link,"'") && !strstr($link,"%27"))
						{

							$db->query("INSERT INTO document (id,link,file_type,enabled,filesize,time) VALUES ('','$link','$file_extention','1','$filesize','$timestamp') ON DUPLICATE KEY UPDATE link='$link';");
						}
						else $db->query("UPDATE document SET enabled='1',link='$link',filesize='$filesize' WHERE link='$link';");
						echo "\033[32m[$file_extention]\033[37m $link\n\r";
					}
					else
					{
						echo "\033[36m[DISABLED]\033[37m $link --> Extention: $file_extention\n\r";;
						$db->query("UPDATE document SET enabled='0' WHERE link='$link';");
					}
				}
			}
			else
			{
				//echo "\033[36m[FILE EXISTS]\033[37m $link --> Extention: $file_extention\n\r";
				$index = $key_fa%4;
				echo "\033[36m".$this->execute[$index]."\033[37m\r";
			}
		}

	return $this->links['document'];
}


function getFilesVideo($url,$file_types,$keyword="") {
	global $curl;
	global $db;

	$files = array();

	$site_get_content = $curl->get($url);

	preg_match_all("/(href\=\")([^\?\"]*)(\")/i", $site_get_content, $files);
	if(empty($files)) preg_match_all("/(HREF\=\")([^\?\"]*)(\")/i", $site_get_content, $files);
	
 
	$files_array = $files[2];

		foreach($files_array as $key_fa => $files_links)
		{
			$filename_array = explode(".",$files_links);
			$file_extention = $filename_array[count($filename_array)-1];

			$link = addslashes($url.$files_links);
			$video_que = $db->query("SELECT id FROM video WHERE link='$link';");
			$record_check = $db->num_rows($video_que);

			if(!$record_check && !strstr($link,"'") && !strstr($link,"%27"))
			{
			/* Checking if file exists */

				if($key_fa && in_array($file_extention,$file_types))
				{
					array_push($this->links['video'],$link);

					/* Checking if file exists */
					if($curl->remoteFileExists($url.$files_links))
					{
						$timestamp = time();
						$filesize = $curl->getFileSize($url.$files_links);

						/* Check database records and if link does not exist insert else update enabled */

						$video_que = $db->query("SELECT id FROM video WHERE link='$link';");
						$record_check = $db->num_rows($video_que);


						if(!$record_check && !strstr($link,"'") && !strstr($link,"%27"))
						{
							$db->query("INSERT INTO video (id,link,file_type,enabled,filesize,time) VALUES ('','$link','$file_extention','1','$filesize','$timestamp') ON DUPLICATE KEY UPDATE link='$link';");
						}
						else $db->query("UPDATE video SET enabled='1',link='$link',filesize='$filesize' WHERE link='$link';");
						echo "\033[32m[$file_extention]\033[37m $link\n\r";
					}
					else
					{
						echo "\033[36m[DISABLED]\033[37m $link --> Extention: $file_extention\n\r";
						$db->query("UPDATE video SET enabled='0' WHERE link='$link';");
					}
				}
			}
			else
			{
				//echo "\033[36m[FILE EXISTS]\033[37m $link --> Extention: $file_extention\n\r";
				$index = $key_fa%4;
				echo "\033[36m".$this->execute[$index]."\033[37m\r";
			}
		}

	return $this->links['video'];
}


function getFilesArchieve($url,$file_types,$keyword="") {
	global $curl;
	global $db;

	$files = array();

	$site_get_content = $curl->get($url);

	preg_match_all("/(href\=\")([^\?\"]*)(\")/i", $site_get_content, $files);
	if(empty($files)) preg_match_all("/(HREF\=\")([^\?\"]*)(\")/i", $site_get_content, $files);
	
 
	$files_array = $files[2];

		foreach($files_array as $key_fa => $files_links)
		{
			$filename_array = explode(".",$files_links);
			$file_extention = $filename_array[count($filename_array)-1];

			$link = addslashes($url.$files_links);
			$arch_que = $db->query("SELECT id FROM archive WHERE link='$link';");
			$record_check = $db->num_rows($arch_que);

			if(!$record_check && !strstr($link,"'") && !strstr($link,"%27"))
			{
			/* Checking if file exists */

				if($key_fa && in_array($file_extention,$file_types))
				{
					array_push($this->links['archive'],$link);

					/* Checking if file exists */
					if($curl->remoteFileExists($url.$files_links))
					{
						$timestamp = time();
						$filesize = $curl->getFileSize($url.$files_links);

						/* Check database records and if link does not exist insert else update enabled */

						$archive_que = $db->query("SELECT id FROM archive WHERE link='$link';");
						$record_check = $db->num_rows($archive_que);


						if(!$record_check && !strstr($link,"'") && !strstr($link,"%27"))
						{


							$db->query("INSERT INTO archive (id,link,file_type,enabled,filesize,time) VALUES ('','$link','$file_extention','1','$filesize','$timestamp') ON DUPLICATE KEY UPDATE link='$link';");
						}
						else $db->query("UPDATE archive SET enabled='1',link='$link',filesize='$filesize' WHERE link='$link';");
						echo "\033[32m[$file_extention]\033[37m $link\n\r";
					}
					else
					{
						echo "\033[36m[DISABLED]\033[37m $link --> Extention: $file_extention\n\r";
						$db->query("UPDATE archive SET enabled='0' WHERE link='$link';");
					}
				}
			}
			else
			{
				//echo "\033[36m[FILE EXISTS]\033[37m $link --> Extention: $file_extention\n\r";
				$index = $key_fa%4;
				echo "\033[36m".$this->execute[$index]."\033[37m\r";
			}
		}

	return $this->links['archive'];
}


function getFilesImage($url,$file_types,$keyword="") {
	global $curl;
	global $db;

	$files = array();

	$site_get_content = $curl->get($url);

	preg_match_all("/(href\=\")([^\?\"]*)(\")/i", $site_get_content, $files);
	if(empty($files)) preg_match_all("/(HREF\=\")([^\?\"]*)(\")/i", $site_get_content, $files);
	
 
	$files_array = $files[2];

		foreach($files_array as $key_fa => $files_links)
		{
			$filename_array = explode(".",$files_links);
			$file_extention = $filename_array[count($filename_array)-1];

			if($key_fa && in_array($file_extention,$file_types))
			{
				array_push($this->links['image'],$url.$files_links);

				/* Checking if file exists */
				if($curl->remoteFileExists($url.$files_links))
				{
					echo "\033[32m[$file_extention]\033[37m";
					$timestamp = time();
					$filesize = $curl->getFileSize($url.$files_links);

					/* Check database records and if link does not exist insert else update enabled */

					$link = urldecode($url.$files_links);
					$link = addslashes($link);
					$link = str_replace("'","",$link);
					$video_que = $db->query("SELECT id FROM image WHERE link='$link';");
					$record_check = $db->num_rows($video_que);


					if(!$record_check && !strstr($link,"'") && !strstr($link,"%27"))
					{


						$db->query("INSERT INTO image (id,link,file_type,enabled,filesize,time) VALUES ('','$link','$file_extention','1','$filesize','$timestamp') ON DUPLICATE KEY UPDATE link='$link';");
					}
					else $db->query("UPDATE image SET enabled='1',link='$link',filesize='$filesize' WHERE link='$link';");
					echo "\033[32m[$file_extention]\033[37m $url$files_links\n\r";
				}
				else
				{
					echo "\033[36m[DISABLED]\033[37m";
					$db->query("UPDATE image SET enabled='0' WHERE link='$link';");
				}

				//echo " $url$files_links --> Extention: $file_extention\n\r";
			}
		}

	return $this->links['image'];
}


function getFilesTorrent($url,$file_types,$keyword="") {
	global $curl;
	global $db;

	$files = array();

	$site_get_content = $curl->get($url);

	preg_match_all("/(href\=\")([^\?\"]*)(\")/i", $site_get_content, $files);
	if(empty($files)) preg_match_all("/(HREF\=\")([^\?\"]*)(\")/i", $site_get_content, $files);
	
	//if(strstr($site_get_content,"href=")) preg_match_all("/(href\=\")([^\?\"]*)(\/\")/i", $site_get_content, $files);
	//else if(strstr($site_get_content,"HREF=")) preg_match_all("/(HREF\=\")([^\?\"]*)(\/\")/i", $site_get_content, $files);
 
	$files_array = $files[2];

		foreach($files_array as $key_fa => $files_links)
		{
			$filename_array = explode(".",$files_links);
			$file_extention = $filename_array[count($filename_array)-1];

			$link = addslashes($url.$files_links);
			$doc_que = $db->query("SELECT id FROM torrent WHERE link='$link';");
			$record_check = $db->num_rows($doc_que);

			if(!$record_check && !strstr($link,"'") && !strstr($link,"%27"))
			{
			/* Checking if file exists */

				if($key_fa && in_array($file_extention,$file_types))
				{
					array_push($this->links['torrent'],$link);

					/* Checking if file exists */
					if($curl->remoteFileExists($url.$files_links))
					{
						$timestamp = time();
						$filesize = $curl->getFileSize($url.$files_links);

						/* Check database records and if link does not exist insert else update enabled */

						$torrent_que = $db->query("SELECT id FROM torrent WHERE link='$link';");
						$record_check = $db->num_rows($torrent_que);


						if(!$record_check && !strstr($link,"'") && !strstr($link,"%27"))
						{

							$db->query("INSERT INTO torrent (id,link,file_type,enabled,filesize,time) VALUES ('','$link','$file_extention','1','$filesize','$timestamp') ON DUPLICATE KEY UPDATE link='$link';");
						}
						else $db->query("UPDATE torrent SET enabled='1',link='$link',filesize='$filesize' WHERE link='$link';");
						echo "\033[32m[$file_extention]\033[37m $link\n\r";
					}
					else
					{
						echo "\033[36m[DISABLED]\033[37m $link --> Extention: $file_extention\n\r";;
						$db->query("UPDATE torrent SET enabled='0' WHERE link='$link';");
					}
				}
			}
			else
			{
				//echo "\033[36m[FILE EXISTS]\033[37m $link --> Extention: $file_extention\n\r";
				$index = $key_fa%4;
				echo "\033[36m".$this->execute[$index]."\033[37m\r";
			}
		}

	return $this->links['torrent'];
}


function getFilesAndroid($url,$file_types,$keyword="") {
	global $curl;
	global $db;

	$files = array();

	$site_get_content = $curl->get($url);

	preg_match_all("/(href\=\")([^\?\"]*)(\")/i", $site_get_content, $files);
	if(empty($files)) preg_match_all("/(HREF\=\")([^\?\"]*)(\")/i", $site_get_content, $files);

	$files_array = $files[2];

	foreach($files_array as $key_fa => $files_links)
	{
		$filename_array = explode(".",$files_links);
		$file_extention = $filename_array[count($filename_array)-1];

		$link = addslashes($url.$files_links);
		$doc_que = $db->query("SELECT id FROM android WHERE link='$link';");
		$record_check = $db->num_rows($doc_que);

		if(!$record_check && !strstr($link,"'") && !strstr($link,"%27"))
		{
			/* Checking if file exists */

			if($key_fa && in_array($file_extention,$file_types))
			{
				array_push($this->links['android'],$link);

				/* Checking if file exists */
				if($curl->remoteFileExists($url.$files_links))
				{
					$timestamp = time();
					$filesize = $curl->getFileSize($url.$files_links);

					/* Check database records and if link does not exist insert else update enabled */

					$torrent_que = $db->query("SELECT id FROM android WHERE link='$link';");
					$record_check = $db->num_rows($torrent_que);


					if(!$record_check && !strstr($link,"'") && !strstr($link,"%27"))
					{

						$db->query("INSERT INTO android (id,link,file_type,enabled,filesize,time) VALUES ('','$link','$file_extention','1','$filesize','$timestamp') ON DUPLICATE KEY UPDATE link='$link';");
					}
					else $db->query("UPDATE android SET enabled='1',link='$link',filesize='$filesize' WHERE link='$link';");
					echo "\033[32m[$file_extention]\033[37m $link\n\r";
				}
				else
				{
					echo "\033[36m[DISABLED]\033[37m $link --> Extention: $file_extention\n\r";;
					$db->query("UPDATE android SET enabled='0' WHERE link='$link';");
				}
			}
		}
		else
		{
			//echo "\033[36m[FILE EXISTS]\033[37m $link --> Extention: $file_extention\n\r";
				$index = $key_fa%4;
				echo "\033[36m".$this->execute[$index]."\033[37m\r";
		}
	}

				return $this->links['android'];
}




}


?>

