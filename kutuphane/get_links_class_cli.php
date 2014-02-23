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


public function __construct() {
	$this->google_links = array();
	$this->links['directories'] = array();
	//$this->links['music'] = array();
	//$this->links['document'] = array();
	//$this->links['video'] = array();
	//$this->links['archive'] = array();
	//$this->links['image'] = array();
	$this->links['soundclick'] = array();
	$this->links['tamdinle'] = array();
	$this->links['torrent'] = array();
	$this->links['android'] = array();
	$this->total_record = 0;
	$this->start_record = 0;
	$this->record_increment = 100;
	$this->current_last_record = 0;
	$this->execute = array('/','-','\\','|');
	$this->baseUrl = "";
}

public function getLinkURLs($url) {


	$site_explode = explode("/",$url);
	$array_count = count($site_explode);


	global $curl;

	$matches = array();
	$directories = array();

	$site_get_text = $curl->get($url);

	$directories = $this->getDirectories($url);
}


public function getGoogleLinks($file_type="mp3",$keyword="",$lang="en",$ggl_start_record) {
	global $curl;

	// http://ftp.skazzka.com/%D0%98%D0%B3%D1%80%D1%8B/
	//if(isset($ggl_start_record)) $this->start_record = $ggl_start_record;
	//$google_url = "http://www.google.com/search?&q=-inurl:(htm|html|php|asp)+intitle:%22index+of%22+%2B%22last+modified%22+%2B%22parent+directory%22+%2Bdescription+%2Bsize+%2B($file_type)+$keyword&hl=en&num=$this->record_increment&start=$this->start_record";
	//$google_url = "http://www.google.com/search?q=parent-directory+description+size+intitle:index-of+%22last+modified+%22+$file_type+-inurl:htm+-inurl:html+-inurl:php&num=$this->record_increment&hl=$lang&lr=&prmd=ivns&ei=6XlgTZCFCIi84gbHiuQC&start=$this->start_record&sa=N";
	$duck_url = "https://duckduckgo.com/?q=$keyword";
	//$google_url = "http://www.google.de/search?q=parent-directory+description+size+intitle:index-of+%22last+modified+%22+$file_type+%22ftp://%22+-inurl:htm+-inurl:html+-inurl:php&num=$this->record_increment&hl=$lang&lr=&prmd=ivns&ei=6XlgTZCFCIi84gbHiuQC&start=$this->start_record&sa=N";
	$google_url = "https://www.google.com.tr/search?q=%22Index+of%22+AND+%22last+modified%22+AND+%22parent+directory%22+AND+description+AND+size+AND+(mp3%7Cwma%7Cogg%7Cflac%7Cau%7Cpdf%7Cdoc%7Cmobi%7Clit%7Cdocx%7Ctxt%7Cps%7Crtf%7Cxls%7Cppt%7Cpps%7Cxlsx%7Csql%7Csub%7Csrt%7Cdjvu%7Csit%7Cwebm%7Cogv%7Cmp4%7Cm4v%7Cavi%7Cflv%7Cmkv%7Cdivx%7Cmpeg%7Cmpg%7Cwmv%7Casf%7Cdwg%7Ctorrent%7Capk%7Cjpg%7Cgif%7Cpng%7Ctiff%7Cbmp%7Cpsd%7Ceps%7Cai)+AND+-php+AND+-html+AND+-asp+AND+-htm+AND+-mp3toss+AND+-wallywashis+AND+-beemp3s+AND+-index-of-mp3+AND+-girlshopes+AND+-theindexof+-plasamusic+-allcandl+-freewarefulldownload+-shexy+-hotbookee&oq=%22Index+of%22+AND+%22last+modified%22+AND+%22parent+directory%22+AND+description+AND+size+AND+(mp3%7Cwma%7Cogg%7Cflac%7Cau%7Cpdf%7Cdoc%7Cmobi%7Clit%7Cdocx%7Ctxt%7Cps%7Crtf%7Cxls%7Cppt%7Cpps%7Cxlsx%7Csql%7Csub%7Csrt%7Cdjvu%7Csit%7Cwebm%7Cogv%7Cmp4%7Cm4v%7Cavi%7Cflv%7Cmkv%7Cdivx%7Cmpeg%7Cmpg%7Cwmv%7Casf%7Cdwg%7Ctorrent%7Capk%7Cjpg%7Cgif%7Cpng%7Ctiff%7Cbmp%7Cpsd%7Ceps%7Cai)+AND+-php+AND+-html+AND+-asp+AND+-htm+AND+-mp3toss+AND+-wallywashis+AND+-beemp3s+AND+-index-of-mp3+AND+-girlshopes+AND+-theindexof+-plasamusic+-allcandl+-freewarefulldownload+-shexy+-hotbookee&aqs=chrome..69i57.531j0j1&sourceid=chrome&ie=UTF-8&start=$this->start_record&num=$this->record_increment";
	//$google_url = "http://www.google.com/search?q=last-modified+parent-directory+description+size+%22intitle:index+of+%22+$file_type+-inurl:htm+-inurl:html+-inurl:php&hl=en&num=$this->record_increment&lr=&ft=i&cr=&safe=images&tbs=&start=$this->start_record";
	//$google_url = "https://www.google.com/search?q=parent-directory+description+size+intitle:index-of+%22last+modified+%22+%22ftp://%22+-inurl:htm+-inurl:html+-inurl:php&hl=en&lr=&prmd=ivns&ei=6XlgTZCFCIi84gbHiuQC&start=1&sa=N#hl=en&lr=&psj=1&q=parent-directory+description+size+intitle:index-of+%22last+modified+%22+inurl:%22ftp://%22+(torrent%7Cmp3%7Capk%7Cpdf%7Cdoc%7Cxls%7Cdocx%7Cxlsx%7Cmobi%7Cogg%7Cavi%7Cwmv%7Crar%7Cwav%7Cmidi%7Cau%7Cppt)+-inurl:htm+-inurl:html+-inurl:php&start=260";

	$google_content = $curl->get($google_url);
	$duck_content = $curl->get($duck_url);


	preg_match_all("/(href\=\")([^\?\"]*)(\")/i", $google_content, $google_matches);
	preg_match_all("/(href\=\")([^\?\"]*)(\")/i", $duck_content, $duck_matches);

	//preg_match_all("/(bout)([^a-zA-Z[:punct:]]*)(results)/i", $google_content, $total_record_array);
//	print_r($total_record_array);
	//$total_record = trim($total_record_array[2][0]);
	//echo $this->total_record = 1280000;//(int)str_replace(",","",$total_record);

	$this->google_links = array();
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


public function getDirectories($url) {
	global $curl;
	global $db;

	$directories = array();

	$site_get_content = $curl->get($url);

	preg_match_all("/(href\=\")([^\?\"]*)(\/\")/i", $site_get_content, $directories);

	$directory_array = $directories[2];

	$counter = 1;
	foreach($directory_array as $key_da => $dir_links)
	{
		$lastIndex = count($this->links['directories']) -1;
		$urlArray = explode("/",$url);
		$hostAddress = $urlArray[2];
		if(!in_array($url.$dir_links,$this->links['directories']) && @!strstr($dir_links, '../') && @!strstr($dir_links, './') && @!strstr($dir_links, 'http') && @!strstr($this->links['directories'][$lastIndex], $dir_links) && @!strstr($this->links['directories'][$lastIndex], $url.$dir_links))
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

public function getBaseOpenDirectory($url) {
	global $curl;
	global $db;

	$webPageChecker = 0;
	$url = str_replace("&amp;","%26",$url);

	$site_get_content = $curl->get($url);
	$conditionApache = strstr($site_get_content, "Index of");
	$conditionApache = strstr($conditionApache, "Name</a>");
	$conditionApache = strstr($conditionApache, "Last modified</a>");
	$conditionApache = strstr($conditionApache, "Size</a>");
	$conditionApache = strstr($conditionApache, "Description</a>");
	$conditionApache = strstr($conditionApache, "Parent Directory</a>");
	
	$conditionApache2 = strstr($site_get_content, "Index of");
	$conditionApache2 = strstr($conditionApache2, "Name</A>");
	$conditionApache2 = strstr($conditionApache2, "Last modified</A>");
	$conditionApache2 = strstr($conditionApache2, "Size</A>");
	$conditionApache2 = strstr($conditionApache2, "Description</A>");
	$conditionApache2 = strstr($conditionApache2, "Parent Directory</A>");
	
	$conditionApache3 = strstr($site_get_content, "Index of");
	$conditionApache3 = strstr($conditionApache3, "Name");
	$conditionApache3 = strstr($conditionApache3, "Last modified");
	$conditionApache3 = strstr($conditionApache3, "Size");
	$conditionApache3 = strstr($conditionApache3, "Description");
	$conditionApache3 = strstr($conditionApache3, "Parent Directory");
	
	$conditionApache4 = strstr($site_get_content, "Index of");
	$conditionApache4 = strstr($conditionApache4, "Name</A>");
	$conditionApache4 = strstr($conditionApache4, "Last modified");
	$conditionApache4 = strstr($conditionApache4, "Size");
	$conditionApache4 = strstr($conditionApache4, "Description");
	$conditionApache4 = strstr($conditionApache4, "Parent Directory");
	
	$conditionOther = strstr($site_get_content, "Index of");
	$conditionOther = strstr($conditionOther, "../</a>");
	
	$conditionOther2 = strstr($site_get_content, "Index of");
	$conditionOther2 = strstr($conditionOther2, "Name                   Last modified     Size  Description");
	
	$conditionOther3 = strstr($site_get_content, "Index of");
	$conditionOther3 = strstr($conditionOther3, "/icons/back.gif");
	$conditionOther3 = strstr($conditionOther3, "[DIR]");
	$conditionOther3 = strstr($conditionOther3, "Parent Directory");
	
	if($conditionApache || $conditionApache2 || $conditionApache3 || $conditionApache4 || $conditionOther || $conditionOther2 || $conditionOther3 || strstr($site_get_content, "<address>Apache") || strstr($site_get_content, "<ADDRESS>Apache")) $webPageChecker = 1;
	
	do
	{
		$this->baseUrl = $url;
		
		$dirArray = explode("/",$url);
		array_pop($dirArray);
		$url = implode("/",$dirArray);
		//echo "$url\n";

		$site_get_content = $curl->get($url);
		$conditionApache = strstr($site_get_content, "Index of");
		$conditionApache = strstr($conditionApache, "Name</a>");
		$conditionApache = strstr($conditionApache, "Last modified</a>");
		$conditionApache = strstr($conditionApache, "Size</a>");
		$conditionApache = strstr($conditionApache, "Description</a>");
		$conditionApache = strstr($conditionApache, "Parent Directory</a>");
		
		$conditionApache2 = strstr($site_get_content, "Index of");
		$conditionApache2 = strstr($conditionApache2, "Name</A>");
		$conditionApache2 = strstr($conditionApache2, "Last modified</A>");
		$conditionApache2 = strstr($conditionApache2, "Size</A>");
		$conditionApache2 = strstr($conditionApache2, "Description</A>");
		$conditionApache2 = strstr($conditionApache2, "Parent Directory</A>");
	
		$conditionApache3 = strstr($site_get_content, "Index of");
		$conditionApache3 = strstr($conditionApache3, "Name");
		$conditionApache3 = strstr($conditionApache3, "Last modified");
		$conditionApache3 = strstr($conditionApache3, "Size");
		$conditionApache3 = strstr($conditionApache3, "Description");
		$conditionApache3 = strstr($conditionApache3, "Parent Directory");
		
		$conditionApache4 = strstr($site_get_content, "Index of");
		$conditionApache4 = strstr($conditionApache4, "Name</A>");
		$conditionApache4 = strstr($conditionApache4, "Last modified");
		$conditionApache4 = strstr($conditionApache4, "Size");
		$conditionApache4 = strstr($conditionApache4, "Description");
		$conditionApache4 = strstr($conditionApache4, "Parent Directory");
	
		$conditionOther = strstr($site_get_content, "Index of");
		$conditionOther = strstr($conditionOther, "../</a>");

		$conditionOther2 = strstr($site_get_content, "Index of");
		$conditionOther2 = strstr($conditionOther2, "Name                   Last modified     Size  Description");
		
		$conditionOther3 = strstr($site_get_content, "Index of");
		$conditionOther3 = strstr($conditionOther3, "/icons/back.gif");
		$conditionOther3 = strstr($conditionOther3, "[DIR]");
		$conditionOther3 = strstr($conditionOther3, "Parent Directory");
		
	} while( $conditionApache || $conditionApache2 || $conditionApache3 || $conditionApache4 || $conditionOther || $conditionOther2 || $conditionOther3 || strstr($site_get_content, "<address>Apache") || strstr($site_get_content, "<ADDRESS>Apache") );

	/*
	$site_get_content = $curl->get($url);
	if( (strstr($site_get_content, "<address>") && strstr($site_get_content, "</address>")) || (strstr($site_get_content, "<ADDRESS>") && strstr($site_get_content, "</ADDRESS>")) && (strstr($site_get_content, "<title>Index of") || strstr($site_get_content, "<TITLE>Index of")) && (strstr($site_get_content, "Name</a>") || strstr($site_get_content, "Name</A>")) && (strstr($site_get_content, "Last modified</a>") || strstr($site_get_content, "Last modified</A>")) && (strstr($site_get_content, "Size</a>") || strstr($site_get_content, "Size</A>")) && (strstr($site_get_content, "Description</a>") || strstr($site_get_content, "Description</A>")) && (strstr($site_get_content, "Parent Directory</a>") || strstr($site_get_content, "Parent Directory</A>")) )
	{
		$this->baseUrl = $url;
		$dirArray = explode("/",$url);
		array_pop($dirArray);
		$url = implode("/",$dirArray);
		//echo "\n{$this->baseUrl}\n";
		$url = $this->getBaseOpenDirectory($url);
	}
	else
	{
		return $this->baseUrl;
	}
	*/
	if(substr($this->baseUrl, -1) != '/') $this->baseUrl .=  '/';
	
	if($webPageChecker) return $this->baseUrl;
	else return false;
}

public function getFilesSoundClick($url) {
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

				echo "\033[32m[$file_extention]\033[37m $link --> Filesize: $filesize\n\r";
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

public function getFilesTamDinle($url) {
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
				if($filesize = (int)$curl->remoteFileExists($url.$files_links))
				{
				$timestamp = time();

				echo "\033[32m[$file_extention]\033[37m $link --> Filesize: $filesize\n\r";
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
				echo "\033[36m[DISABLED]\033[37m $link --> Filesize: $filesize\n\r";
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



public function getFilesMusic($url,$file_types,$keyword="") {
	global $curl;
	global $db;

	//$this->links['music'] = array();
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
			//array_push($this->links['music'],$link);
			$music_que = $db->query("SELECT id FROM music WHERE link='$link';");
			$record_check = $db->num_rows($music_que);

			if(!$record_check && !strstr($link,"'") && !strstr($link,"%27"))
			{
			/* Checking if file exists */
				
				if($filesize = $curl->remoteFileExists($url.$files_links))
				{
					$timestamp = time();
					$filesize = (int)$curl->getFileSize($url.$files_links);

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
						echo "\033[32m[$file_extention]\033[37m $link --> Filesize: $filesize\n\r";
				}
				else
				{
					echo "\033[36m[DISABLED]\033[37m $link --> Filesize: $filesize\n\r";
					$db->query("UPDATE music SET enabled='0',filesize='$filesize',link='$link' WHERE link='$link';");
				}
			}
			else
			{
				echo "\033[36m[FILE EXISTS]\033[37m $link --> Extention: $file_extention\n\r";
				$index = $key_fa%4;
				echo "\033[36m".$this->execute[$index]."\033[37m\r";
			}

			//echo " $url$files_links --> Extention: $file_extention\n\r";
		}
	}

	//return $this->links['music'];
}

public function getID3Tags($file) {
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

public function getFilesDocument($url,$file_types,$keyword="") {
	global $curl;
	global $db;

	//$this->links['document'] = array();
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
					//array_push($this->links['document'],$link);

					/* Checking if file exists */
					if($filesize = (int)$curl->remoteFileExists($url.$files_links))
					{
						$timestamp = time();

						/* Check database records and if link does not exist insert else update enabled */

						$document_que = $db->query("SELECT id FROM document WHERE link='$link';");
						$record_check = $db->num_rows($document_que);


						if(!$record_check && !strstr($link,"'") && !strstr($link,"%27"))
						{

							$db->query("INSERT INTO document (id,link,file_type,enabled,filesize,time) VALUES ('','$link','$file_extention','1','$filesize','$timestamp') ON DUPLICATE KEY UPDATE link='$link';");
						}
						else $db->query("UPDATE document SET enabled='1',link='$link',filesize='$filesize' WHERE link='$link';");
						echo "\033[32m[$file_extention]\033[37m $link --> Filesize: $filesize\n\r";
					}
					else
					{
						echo "\033[36m[DISABLED]\033[37m $link --> Filesize: $filesize\n\r";;
						$db->query("UPDATE document SET enabled='0' WHERE link='$link';");
					}
				}
			}
			else
			{
				echo "\033[36m[FILE EXISTS]\033[37m $link --> Extention: $file_extention\n\r";
				$index = $key_fa%4;
				echo "\033[36m".$this->execute[$index]."\033[37m\r";
			}
		}

	//return $this->links['document'];
}


public function getFilesVideo($url,$file_types,$keyword="") {
	global $curl;
	global $db;

	//$this->links['video'] = array();
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
					//array_push($this->links['video'],$link);

					/* Checking if file exists */
					if($filesize = (int)$curl->remoteFileExists($url.$files_links))
					{
						$timestamp = time();

						/* Check database records and if link does not exist insert else update enabled */

						$video_que = $db->query("SELECT id FROM video WHERE link='$link';");
						$record_check = $db->num_rows($video_que);


						if(!$record_check && !strstr($link,"'") && !strstr($link,"%27"))
						{
							$db->query("INSERT INTO video (id,link,file_type,enabled,filesize,time) VALUES ('','$link','$file_extention','1','$filesize','$timestamp') ON DUPLICATE KEY UPDATE link='$link';");
						}
						else $db->query("UPDATE video SET enabled='1',link='$link',filesize='$filesize' WHERE link='$link';");
						echo "\033[32m[$file_extention]\033[37m $link --> Filesize: $filesize\n\r";
					}
					else
					{
						echo "\033[36m[DISABLED]\033[37m $link --> Filesize: $filesize\n\r";
						$db->query("UPDATE video SET enabled='0' WHERE link='$link';");
					}
				}
			}
			else
			{
				echo "\033[36m[FILE EXISTS]\033[37m $link --> Extention: $file_extention\n\r";
				$index = $key_fa%4;
				echo "\033[36m".$this->execute[$index]."\033[37m\r";
			}
		}

	//return $this->links['video'];
}


public function getFilesArchieve($url,$file_types,$keyword="") {
	global $curl;
	global $db;

	//$this->links['archive'] = array();
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
					//array_push($this->links['archive'],$link);

					/* Checking if file exists */
					if($filesize = (int)$curl->remoteFileExists($url.$files_links))
					{
						$timestamp = time();

						/* Check database records and if link does not exist insert else update enabled */

						$archive_que = $db->query("SELECT id FROM archive WHERE link='$link';");
						$record_check = $db->num_rows($archive_que);


						if(!$record_check && !strstr($link,"'") && !strstr($link,"%27"))
						{


							$db->query("INSERT INTO archive (id,link,file_type,enabled,filesize,time) VALUES ('','$link','$file_extention','1','$filesize','$timestamp') ON DUPLICATE KEY UPDATE link='$link';");
						}
						else $db->query("UPDATE archive SET enabled='1',link='$link',filesize='$filesize' WHERE link='$link';");
						echo "\033[32m[$file_extention]\033[37m $link --> Filesize: $filesize\n\r";
					}
					else
					{
						echo "\033[36m[DISABLED]\033[37m $link --> Filesize: $filesize\n\r";
						$db->query("UPDATE archive SET enabled='0' WHERE link='$link';");
					}
				}
			}
			else
			{
				echo "\033[36m[FILE EXISTS]\033[37m $link --> Extention: $file_extention\n\r";
				$index = $key_fa%4;
				echo "\033[36m".$this->execute[$index]."\033[37m\r";
			}
		}

	//return $this->links['archive'];
}


public function getFilesImage($url,$file_types,$keyword="") {
	global $curl;
	global $db;

	//$this->links['image'] = array();
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
				//array_push($this->links['image'],$url.$files_links);

				/* Checking if file exists */
				if($filesize = (int)$curl->remoteFileExists($url.$files_links))
				{
					echo "\033[32m[$file_extention]\033[37m";
					$timestamp = time();

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
					echo "\033[32m[$file_extention]\033[37m $link --> Filesize: $filesize\n\r";
				}
				else
				{
					echo "\033[36m[DISABLED]\033[37m $link --> Filesize: $filesize\n\r";
					$db->query("UPDATE image SET enabled='0' WHERE link='$link';");
				}

				//echo " $url$files_links --> Extention: $file_extention\n\r";
			}
		}

	//return $this->links['image'];
}


public function getFilesTorrent($url,$file_types,$keyword="") {
	global $curl;
	global $db;

	$this->links['torrent'] = array();
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
					if($filesize = (int)$curl->remoteFileExists($url.$files_links))
					{
						$timestamp = time();

						/* Check database records and if link does not exist insert else update enabled */

						$torrent_que = $db->query("SELECT id FROM torrent WHERE link='$link';");
						$record_check = $db->num_rows($torrent_que);


						if(!$record_check && !strstr($link,"'") && !strstr($link,"%27"))
						{

							$db->query("INSERT INTO torrent (id,link,file_type,enabled,filesize,time) VALUES ('','$link','$file_extention','1','$filesize','$timestamp') ON DUPLICATE KEY UPDATE link='$link';");
						}
						else $db->query("UPDATE torrent SET enabled='1',link='$link',filesize='$filesize' WHERE link='$link';");
						echo "\033[32m[$file_extention]\033[37m $link --> Filesize: $filesize\n\r";
					}
					else
					{
						echo "\033[36m[DISABLED]\033[37m $link --> Filesize: $filesize\n\r";;
						$db->query("UPDATE torrent SET enabled='0' WHERE link='$link';");
					}
				}
			}
			else
			{
				echo "\033[36m[FILE EXISTS]\033[37m $link --> Extention: $file_extention\n\r";
				$index = $key_fa%4;
				echo "\033[36m".$this->execute[$index]."\033[37m\r";
			}
		}

	return $this->links['torrent'];
}


public function getFilesAndroid($url,$file_types,$keyword="") {
	global $curl;
	global $db;

	//$this->links['android'] = array();
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
				if($filesize = (int)$curl->remoteFileExists($url.$files_links))
				{
					$timestamp = time();

					/* Check database records and if link does not exist insert else update enabled */

					$torrent_que = $db->query("SELECT id FROM android WHERE link='$link';");
					$record_check = $db->num_rows($torrent_que);


					if(!$record_check && !strstr($link,"'") && !strstr($link,"%27"))
					{

						$db->query("INSERT INTO android (id,link,file_type,enabled,filesize,time) VALUES ('','$link','$file_extention','1','$filesize','$timestamp') ON DUPLICATE KEY UPDATE link='$link';");
					}
					else $db->query("UPDATE android SET enabled='1',link='$link',filesize='$filesize' WHERE link='$link';");
					echo "\033[32m[$file_extention]\033[37m $link --> Filesize: $filesize\n\r";
				}
				else
				{
					echo "\033[36m[DISABLED]\033[37m $link --> Filesize: $filesize\n\r";
					$db->query("UPDATE android SET enabled='0' WHERE link='$link';");
				}
			}
		}
		else
		{
			echo "\033[36m[FILE EXISTS]\033[37m $link --> Extention: $file_extention\n\r";
			$index = $key_fa%4;
			echo "\033[36m".$this->execute[$index]."\033[37m\r";
		}
	}

				return $this->links['android'];
}




}


?>

