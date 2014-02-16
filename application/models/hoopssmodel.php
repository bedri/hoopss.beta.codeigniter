<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH."third_party/sphinxsearch/libraries/sphinxclient.php");
class HoopssModel extends CI_Model
{
	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	/**
	 * getUserData()
	 * Gets the userdata by $username from database
	 * @param string $username
	 * @return boolean|array
	 */
	public function getUserData($username)
	{
		$this->db->select('*')->from('users')->where('username',$username);
		$query = $this->db->get();
		return $query->result();
	}
	
	/**
	 * getCity
	 * Gets the city info by $cityId
	 * @param number $cityId
	 * @return boolean|array
	 */
	public function getCity($cityId)
	{
		$this->db->select('*')->from('cities')->where('id',$cityId);
		$query = $this->db->get();
		return $query->result();
	}
	
	/**
	 * getResults
	 * Search results
	 * @param string $searchType
	 * @param string $keyword
	 * @param number $offset
	 * @param number $limit
	 * @return boolean|array
	 */
	public function getResults($searchType, $keyword, $offset=0, $limit=15)
	{
		/* Sphinx Search Query */
		$cl = new SphinxClient ();
		
		$sql = "";
		$mode = SPH_MATCH_ALL;
		$host = "localhost";
		$port = 9312;
		$index = $searchType;
		$groupby = "";
		$groupsort = "@group desc";
		$filter = "link";
		$filtervals = array();
		$distinct = "";
		$sortby = "";
		$sortexpr = "";
		//$limit = 20;
		$ranker = SPH_RANK_PROXIMITY_BM25;
		$select = "";
		
		$cl->SetServer ( $host, $port );
		$cl->SetConnectTimeout ( 1 );
		$cl->SetArrayResult ( true );
		$cl->SetWeights ( array ( 100, 1 ) );
		$cl->SetMatchMode ( $mode );
		if ( count($filtervals) )	$cl->SetFilter ( $filter, $filtervals );
		if ( $groupby )				$cl->SetGroupBy ( $groupby, SPH_GROUPBY_ATTR, $groupsort );
		if ( $sortby )				$cl->SetSortMode ( SPH_SORT_EXTENDED, $sortby );
		if ( $sortexpr )			$cl->SetSortMode ( SPH_SORT_EXPR, $sortexpr );
		if ( $distinct )			$cl->SetGroupDistinct ( $distinct );
		if ( $select )				$cl->SetSelect ( $select );
		if ( $limit )				$cl->SetLimits ( $offset, $limit );
		$cl->SetRankingMode ( $ranker );
		$res = $cl->Query ( $keyword, $index );
				
		if ( $res===false )
		{
			//print "Query failed: " . $cl->GetLastError() . ".\n";
			return false;
		
		} else
		{
			if ( $cl->GetLastWarning() )
			{
				//print "WARNING: " . $cl->GetLastWarning() . "\n\n";
				return false;
			}
		
			$queryResults =  $res;
		}
		
		
		return $queryResults;
	}

	/**
	 * generateRandomKeyword()
	 * Random Keyword Generator
	 * @return boolean|array
	 */
	public function generateRandomKeyword()
	{
		$index = rand(0,1000);
		$this->db->select('keyword')->from('keywordbot')->limit(1, $index);
		$query = $this->db->get();
		
		return $query->result();
	}
	
	/**
	 * generateKeywords()
	 * Keyword Generator
	 * @return boolean|array
	 */
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
	
	/**
	 * keywordAutocomplete($term)
	 * Gets the autocomplete data for a string
	 * @param string $term
	 * @return boolean|array
	 */
	public function keywordAutocomplete($term)
	{
		$this->db->select("keyword,LENGTH(keyword) AS keylen, rank")->from("search_history")->where("((keyword LIKE '$term%') AND (LENGTH(keyword) > 3) AND (keyword IS NOT NULL))")->group_by("keyword")->order_by("rank")->limit("5");
		$keywordsQue = $this->db->get();
		$keywords = $keywordsQue->result();
		return $keywords;
	}
	
	/**
	 * setKeywordRank($keyword)
	 * Inserts the new keyword into search_history and if keyword exists updates the rank by increasing it by one
	 * @param string $keyword
	 */
	public function setKeywordRank($keyword)
	{
		$keyword = urldecode($keyword);
		$query = $this->db->simple_query("INSERT INTO search_history (keyword,rank) VALUES ('".$this->db->escape($keyword)."','1') ON DUPLICATE KEY UPDATE rank=rank+1;");
	}

}
