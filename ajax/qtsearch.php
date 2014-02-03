<?='<?xml version="1.0" encoding="UTF-8" ?>'."\n";?>
<results>
<?php
/**
	This is a webservice for getting results in XML format for search on Hoops
	Usage: http://hoopss.com/ajax/qtsearch.php?keyword=sezen+aksu&search_type=music&os=Windows+7&file_type=ogg&page=2&increment=15
	
	The single spaces for the keywords such as "pink floyd" should be replaced by "+" sign and then located in the query string (i.e. &keyword=pink+floyd)
	
	@file_type string: search_type=music için mp3, ogg, wav, au, flac ya da wmv (for document pdf, doc; for video avi, mpeg, mkv etc. and for archive zip, rar, tar, gz, bz2). If there isn't any search_type in the query string, all results will be returned.
	
	@page int: A number between 0 and max. If given a number greater than max then max number of pages will be returne. If omitted 0 will be returned.
	
	@increment int: Defines how many records will be returned. If ommited the default value of 15 records will be returned.
	
	@os string: This field is for information purposes and what is sent will be returned.
*/
require_once("../kutuphane/veritabani.php");
$db = new Database;

require_once("../kutuphane/php_functions.php");

		if(isset($_REQUEST['keyword'])) $keyword = $_REQUEST['keyword'];
		else
		{
			do {
				$keyword_que = $db->query("SELECT keyword,FLOOR(1 + (RAND() * 3000)) FROM keywordbot WHERE id=FLOOR(1 + (RAND() * 3000));");
				$keyword_count = (int)$db->num_rows($keyword_que);
				$keyword_array = $db->result($keyword_que);
				$keyword = $keyword_array[0];
			} while($keyword_count != 1);
		}

		if($_REQUEST['search_type'] == "youtube") $link = "link_title";
		else $link = "link";

		if(isset($_REQUEST['search_type'])) $search_type = $_REQUEST['search_type'];
		else $search_type = "music";

		if(isset($_REQUEST['file_type']))
		{
			$file_type = $_REQUEST['file_type'];
			$file_where = " AND (file_type='$file_type')";
		}
		else
		{
			$file_type = "";
			$file_where = "";
		}

		if(isset($_REQUEST['page'])) $page = (int)$_REQUEST['page'];
		else $page = 1;

		if(isset($_REQUEST['increment'])) $increment = (int)$_REQUEST['increment'];
		else $increment = 15;

		if($page <= 1) $min = 0;
		else $min = (($page - 1) * $increment) - 1;


		if(isset($_REQUEST['os'])) $os = $_REQUEST['os'];
		else $os = "Unknown Operation System";

		if(isset($_SERVER['REMOTE_ADDR'])) $ip = $_SERVER['REMOTE_ADDR'];
		else $ip = "0.0.0.0";

		$search_id = md5(microtime());

?>
<search id="<?=$search_id;?>" type="<?=$search_type;?>" keyword="<?=$keyword;?>"></search>
<client os="<?=$os;?>" ip="<?=$ip;?>"></client>
<?php

		$keyword_space_explode = explode(" ",$keyword);
		$keyword_plus_explode = explode("+",$keyword);


		$WHERE_LIKE = " ";
		if(!strstr($keyword,"'") || !strstr($keyword,'"'))
		{
			if(count($keyword_space_explode) > 1)
			{
				$WHERE_LIKE = "(";
				foreach($keyword_space_explode as $key_kse => $value_kse)
				{
					$value_kse_no_dash = str_replace("-","",$value_kse);
					if(!$key_kse && !strstr($value_kse,"-")) $WHERE_LIKE .= " ($link LIKE '%$value_kse%') ";
					else if($key_kse && !strstr($value_kse,"-")) $WHERE_LIKE .= " AND (link LIKE '%$value_kse%') ";
					else $WHERE_LIKE .= " AND ($link NOT LIKE '%$value_kse_no_dash%') ";
				}
				$WHERE_LIKE .= ") OR ";
			}

			if(count($keyword_plus_explode) > 1)
			{
				$WHERE_LIKE .= "(";
				foreach($keyword_plus_explode as $key_kse => $value_kse)
				{
					if(!$key_kse) $WHERE_LIKE .= " ($link LIKE '%$value_kse%') ";
					else $WHERE_LIKE .= " AND ($link LIKE '%$value_kse%') ";
				}
				$WHERE_LIKE .= ") OR ";
			}
		}
	
		$keyword_no_dash = str_replace("-","",$keyword);
		$WHERE_LIKE .= " ($link='$keyword_no_dash') ";
		//echo $WHERE_LIKE;

		$keyword_filename_search = urlencode($keyword);
		if($search_type != "music") $query = "SELECT count(*) FROM $search_type WHERE ((enabled='1') AND ( $WHERE_LIKE OR ($link LIKE '%$keyword_filename_search%')) $file_where);";
		else if(isset($search_type)) $query = "SELECT count(*) FROM $search_type WHERE ((enabled='1') AND ( $WHERE_LIKE OR ($link LIKE '%$keyword_filename_search%') OR (artist LIKE '%$keyword%') OR (title LIKE '%$keyword%') OR (album LIKE '%$keyword%')) $file_where);";
		else $query = "SELECT count(*) FROM music WHERE ((enabled='1') AND ( $WHERE_LIKE OR ($link LIKE '%$keyword_filename_search%')) $file_where);";

		$control_que = $db->query($query);
		$control = $db->result($control_que);
		$control_count = (int)$control[0];


		$number_of_pages = ceil($control_count / $increment);
		$number_of_last_page_records = $control_count % $increment;

		if(($page <= $number_of_pages) && ($page > 0)) $current_page = (int)$page;
		else if($page > $number_of_pages) $current_page = $number_of_pages;
		else $current_page = 1;

		if($current_page == 1) $previous_page = 1;
		else $previous_page = $current_page - 1;

		if($current_page == $number_of_pages) $next_page = $current_page;
		else $next_page = $current_page + 1;



		if(!$control_count) $number_of_records_found = 0;
		else $number_of_records_found = $control_count;

if($_REQUEST['search_type'] == "music")
{
	$music_file_types =  array("mp3","MP3","wma","WMA","ogg","OGG","flac","FLAC","au","AU");
		$music_que = $db->query("SELECT * FROM (SELECT * FROM music WHERE ((enabled='1') AND ( $WHERE_LIKE OR (link LIKE '%$keyword_filename_search%') OR (artist LIKE '%$keyword%') OR (title LIKE '%$keyword%') OR (album LIKE '%$keyword%')) $file_where) ORDER BY artist DESC) as T1 LIMIT $min,$increment ;");
		$music_control = $db->num_rows($music_que);
		$counter = 0;
		$playlist = "";
		$titles = "";
		while($music = $db->result($music_que))
		{
			$file_type = strtolower($music['file_type']);
			$artist = just_clean(addslashes($music['artist']));
			$title = just_clean(addslashes($music['title']));
			$album = just_clean(addslashes($music['album']));
			$year = just_clean(addslashes($music['year']));
?>
	<record id="<?=$music['id'];?>">
		<filesize unit="byte"><?=$music['filesize'];?></filesize>
		<filetype><?=$file_type;?></filetype>
		<filelink><?=$music['link'];?></filelink>
<?php
		if(($music['artist'] != "") && ($file_type == "mp3") && ($music['title'] != ""))
		{
?>
		<idtag>
			<artist><?=$artist;?></artist>
			<title><?=$title;?></title>
			<album><?=$album;?></album>
			<year><?=$year;?></year>
		</idtag>
<?php
		}
?>
	</record>
<?php
		}

}
else
{
/* Other Search Results */
		$que = $db->query("SELECT * FROM 
		(SELECT * FROM $search_type
			WHERE ((enabled='1') AND ( $WHERE_LIKE OR (link LIKE '%$keyword_filename_search%')))) as T1 
			ORDER BY filesize
		LIMIT $min,$increment;");
		$control = $db->num_rows($que);
		while($res = $db->result($que))
		{
			$file_type = strtolower($res['file_type']);

?>
	<record id="<?=$res['id'];?>">
		<filesize unit="byte"><?=$res['filesize'];?></filesize>
		<filetype><?=$file_type;?></filetype>
		<filelink><?=$res['link'];?></filelink>
	</record>
<?php
		}
}


?>

<paging>
	<page><?=$page;?></page>
	<increment><?=$increment;?></increment>
</paging>

</results>
