<?php

require_once("../kutuphane/veritabani.php");
$db = new Database;

$keyword = $_REQUEST['term'];
$keyword_array = array();
$id_array = array();
$maxrank = 0;

$length = 0;
$db_que = $db->query("SELECT keyword,LENGTH(keyword) AS keylen FROM search_history WHERE ((keyword LIKE '$keyword%') AND (LENGTH(keyword) > 3) AND (keyword IS NOT NULL)) GROUP BY keyword ORDER BY keyword LIMIT 5;");
while($res = $db->result($db_que))
{ 
	if($res['rank'] > $max_rank) (int)$max_rank = $res['rank'];
	else if($res['rank'] > $max_rank - 6) array_push($keyword_array,strtolower($res['keyword']));
	else array_push($keyword_array,strtolower($res['keyword']));
}

$db_que = $db->query("SELECT keyword,LENGTH(keyword) AS keylen FROM keywordbot WHERE ((keyword LIKE '$keyword%') AND (LENGTH(keyword) > 3) AND (keyword IS NOT NULL)) GROUP BY keyword ORDER BY keyword LIMIT 5;");
while($res = $db->result($db_que))
{
	if($res['rank'] > $max_rank) (int)$max_rank = $res['rank'];
	else if($res['rank'] > $max_rank - 6) array_push($keyword_array,strtolower($res['keyword']));
	else if($res['keyword'] != '') array_push($keyword_array,strtolower($res['keyword']));
}

echo json_encode($keyword_array);

?>
