<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class HoopssModel extends CI_Model
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	public function getUserData()
	{
		return array("username"=>"bedri", "name"=> "Bedri Özgür Güler", "age"=>"37");
	}
	
	private function prepareQuery($keyword)
	{
		$keyword_space_explode = explode(" ",$keyword);
		$keyword_plus_explode = explode("+",$keyword);

		$keywordNoDashArray = array();
		$WHERE_LIKE = " ";

		if(count($keyword_space_explode) > 1)
		{
			$like = "";
			$WHERE_LIKE = " (";
			foreach($keyword_space_explode as $key_kse => $value_kse)
			{
				$value_kse_no_dash = str_replace("-","",$value_kse);
				if(!$key_kse && !strstr($value_kse,"-")) $like .= "%$value_kse%";
				else if($key_kse && !strstr($value_kse,"-")) $like .= "%$value_kse%";
				else if(strstr($value_kse,"-"))
				{
					$WHERE_LIKE .= " (link NOT LIKE '%$value_kse_no_dash%') AND ";
				}
				if(!strstr($value_kse,"-")) array_push($keywordNoDashArray,$value_kse);
			}
			$WHERE_LIKE .= " (link LIKE '$like') ";
			$WHERE_LIKE .= ") OR ";
		}
	
		if(count($keyword_plus_explode) > 1)
		{
			$WHERE_LIKE .= "(";
			foreach($keyword_plus_explode as $key_kse => $value_kse)
			{
				if(!$key_kse) $WHERE_LIKE .= " (link LIKE '%$value_kse%') ";
				else $WHERE_LIKE .= " AND (link LIKE '%$value_kse%') ";
			}
			$WHERE_LIKE .= ") OR ";
		}
	
		$keyword_no_dash = str_replace("-","",$keyword);
		$keywordNoDashedWord = implode(" ",$keywordNoDashArray);
		$WHERE_LIKE .= " (link='$keywordNoDashedWord') ";
		$this->db->where("($WHERE_LIKE)", NULL, FALSE);
	}
	
	public function getResults($searchType, $keyword, $limit=15, $offset=0)
	{
		//$this->benchmark->mark('code_start');
		
		if(strstr($keyword," ") || strstr($keyword,'+')) $this->prepareQuery($keyword);
		else $this->db->like('link', $keyword);
		$this->db->where('enabled',1);
		$this->db->order_by('filesize','desc');
		if($searchType == "music") $this->db->order_by('title','asc');
		$query = $this->db->get($searchType, $limit, $offset);
		//echo $this->db->last_query();

		//$this->benchmark->mark('code_end');
		
		//echo "<span style='font: 10px Verdana;'><center>" . $this->benchmark->elapsed_time('code_start', 'code_end') . " s.</center></span>";
		$queryResults = $query->result();
		return $queryResults;
	}

	public function getResultsCount($searchType, $keyword)
	{
		if(strstr($keyword," ") || strstr($keyword,'+')) $this->prepareQuery($keyword);
		else $this->db->like('link', $keyword);
		$this->db->where("enabled","1");
		$this->db->from($searchType);
		return $this->db->count_all_results();
	}
	
	/*
	 * Random Keyword Generator
	 */
	public function generateRandomKeyword()
	{
		$index = rand(0,1000);
		$this->db->select('keyword')->from('keywordbot')->limit(1, $index);
		$query = $this->db->get();
		
		return $query->result();
	}
	
	public function generateKeywords()
	{
		$this->db->select('COUNT(1)')->from('keywordbot');
		$countQuery = $this->db->get();
		$keywordCount = (int)$countQuery->result();
		
		if($keywordCount > 100) $maxOffset = $keywordCount-100;
		else $maxOffset = 100;
		$offset = rand(0,$maxOffset);
		$this->db->select('keyword')->from('keywordbot')->limit($offset,99);
		$keywordsQue = $this->db->get();
		$keywords = $keywordsQue->result();
		return $keywords;
	}
	
	public function keywordAutocomplete($term)
	{
		//$db_que = $db->query("SELECT keyword,LENGTH(keyword) AS keylen FROM search_history WHERE ((keyword LIKE '$keyword%') AND (LENGTH(keyword) > 3) AND (keyword IS NOT NULL)) GROUP BY keyword ORDER BY keyword LIMIT 5;");
		$this->db->select("keyword,LENGTH(keyword) AS keylen, rank")->from("search_history")->where("((keyword LIKE '$term%') AND (LENGTH(keyword) > 3) AND (keyword IS NOT NULL))")->group_by("keyword")->order_by("rank")->limit("5");
		$keywordsQue = $this->db->get();
		$keywords = $keywordsQue->result();
		return $keywords;
	}
	
	public function setKeywordRank($keyword)
	{
		$keyword = urldecode($keyword);
		$query = $this->db->simple_query("INSERT INTO search_history (keyword,rank) VALUES ('".$this->db->escape($keyword)."','1') ON DUPLICATE KEY UPDATE rank=rank+1;");
	}

}
