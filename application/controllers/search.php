<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends MY_Controller
{
	
	/**
	 * Search Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/search
	 *	- or -  
	 * 		http://example.com/index.php/search/index
	 *	- or -
	 * 		http://example.com/index.php/search/searchresults
	 *  - or -
	 *  	http://example.com/index.php/search/searchresults/music/pink+floyd
	 *  - or -
	 *  	http://example.com/index.php/search/searchresults/music/pink+floyd/2 
	 *  	(This last one has the paging part after keyword)
	 *  
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	var $userData = array();
	var $paginationLimit;
	
	public function __construct()
	{
		// Call the Hoopss constructor
		parent::__construct();
	}
	
	public function index()
	{

		$this->load->view("footer",$this->data);
	}
	
	/*
	 * Search database with a search type (music, document, archive, video, torrent) and a keyword 
	 * and arrange a paging system
	 */
	public function searchResults($searchType, $keyword="", $offset=0)
	{
		if(isset($keyword) && ($keyword != ""))
		{
			$this->HoopssModel->setKeywordRank($keyword);
			$keyword = urldecode($keyword);
			$this->data['bigMp3Size'] = "";
		}
		else
		{
			$randomKeyword = $this->HoopssModel->generateRandomKeyword();
			$keyword = urldecode($randomKeyword[0]->keyword);
			$this->data['randomKeyword'] = $randomKeyword[0]->keyword;
			$this->data['bigMp3Size'] = "3000000";
		}

		/* Pagination initialization */
		$this->paginationLimit = 10;
		
		$increment = $this->paginationLimit;
		$results = $this->HoopssModel->getResults($searchType,$keyword,$offset,$increment);
		$controlCount = (int)$results['total'];
		
		if($controlCount) 
		{
			$matches = $results['matches'];
			$this->data['searchResults'] = $matches;
		}
		
		$config['total_rows'] = $this->data['totalRows'] = $controlCount; //$this->HoopssModel->getResultsCount($searchType, $keyword);
		$config['base_url'] = site_url("search/searchResults/$searchType/$keyword");
		$config['per_page'] = $this->paginationLimit;
		$config['num_links'] = 10;
		$config['uri_segment'] = 5;
		$config['first_link'] = '<span class="paginationArrows"><b style="font-family: Georgia;">&nbsp;H&nbsp;</b></span>';
		$config['last_link'] = '<span class="paginationArrows"><b style="font-family: Georgia;">&nbsp;s&nbsp;</b></span>';
		$config['next_link'] = '<span class="paginationArrows">►</span>';
		$config['prev_link'] = '<span class="paginationArrows">◄</span>';
		$config['cur_tag_open'] = '<span class="paginationCurOpenTag">';
		$config['cur_tag_close'] = '</span>';
		
		$this->pagination->initialize($config);
		
		$this->data['pagination'] = $this->pagination->create_links();
	
		$this->data['searchType'] = $searchType;
		$this->data['keyword'] = $keyword;

		if(!$controlCount) $numberOfRecordsFound = "No";
		else $numberOfRecordsFound = $controlCount;

		$this->data['controlCount'] = $controlCount;
		$this->data['numberOfRecordsFound'] = $numberOfRecordsFound;
				
		$keywordString = $this->generateKeywordString();
		$this->data['keywordString'] = ""; //$keywordString;
		
		$this->load->view("header",$this->data);	
		$this->load->view("searchResults",$this->data);
		if($controlCount) $this->load->view("pager",$this->data);
		$this->load->view("footer",$this->data);

	}

        /*
         * Search database with a keyword for autocomplete function
         */
	function ajaxKeywordlist()
	{
		if(isset($_GET['term']) && ($_GET['term'] != '')) $term = $_GET['term'];
		else $term = "";


		$keyword_array = array();
		$id_array = array();
		$max_rank = 0;
		
		$length = 0;
		$keywords = $this->HoopssModel->keywordAutocomplete($term);
		foreach($keywords as $kkey=>$kvalue)
		{
		        if($kvalue->rank > $max_rank) (int)$max_rank = $kvalue->rank;
		        else array_push($keyword_array,strtolower($kvalue->keyword));
		}
		
		echo json_encode($keyword_array);
		exit();

	}
	
}



