<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	var $baseUrl;
	var $data;
	
	public function __construct()
	{
		// Call the CI_Controller constructor
		parent::__construct();
		
		// Load the Model
		$this->load->model("HoopssModel");
		
		// Load header and footer
		$this->baseUrl = base_url();
		$this->data = array("baseUrl"=>$this->baseUrl);
		
		$siteUrl = $this->config->site_url();
		$this->data['siteUrl'] = $siteUrl;
		
		$http_user_agent = $_SERVER['HTTP_USER_AGENT'];
		if(strstr($http_user_agent, "Firefox"))
		{
			$browser = "Firefox";
			$browser_version = str_replace("Firefox/","",strstr($http_user_agent,"Firefox"));
		}
		else if(strstr($http_user_agent, "Chromium"))
		{
			$browser = "Chromium";
			$browser_version = str_replace("Chromium/","",substr(strstr($http_user_agent,"Chromium"),0,13));
		}
		else if(strstr($http_user_agent, "Chrome"))
		{
			$browser = "Chrome";
			$browser_version = str_replace("Chrome/","",substr(strstr($http_user_agent,"Chrome"),0,18));
		}
		else if(strstr($http_user_agent, "Opera"))
		{
			$browser = "Opera";
			$browser_version = str_replace("Opera/","",substr(strstr($http_user_agent,"Opera"),0,11));
		}
		else if(strstr($http_user_agent, "Safari"))
		{
			$browser = "Safari";
			$browser_version = str_replace("Safari/","",substr(strstr($http_user_agent,"Safari"),0,15));
		}
		else if(strstr($http_user_agent,"MSIE"))
		{
		    $browser = "MSIE";
			$browser_version = str_replace("MSIE ","",substr(strstr($http_user_agent,"MSIE"),0,8));
		}
		
		//echo "$browser -> $browser_version";
		
		//Detect special conditions devices
		$iPod = strstr($_SERVER['HTTP_USER_AGENT'],"iPod");
		$iPhone = strstr($_SERVER['HTTP_USER_AGENT'],"iPhone");
		$iPad = strstr($_SERVER['HTTP_USER_AGENT'],"iPad");
		if(stripos($_SERVER['HTTP_USER_AGENT'],"Android") && stripos($_SERVER['HTTP_USER_AGENT'],"mobile")) {
			$Android = true;
		}
		else if(strstr($_SERVER['HTTP_USER_AGENT'],"Android")) {
			$Android = false;
			$AndroidTablet = true;
		}
		else {
			$Android = false;
			$AndroidTablet = false;
		}

		$webOS = strstr($_SERVER['HTTP_USER_AGENT'],"webOS");
		$BlackBerry = strstr($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
		$RimTablet= strstr($_SERVER['HTTP_USER_AGENT'],"RIM Tablet");
		//do something with this information
		if( $iPod || $iPhone ) {
			//were an iPhone/iPod touch -- do something here
		}
		else if($iPad) {
			$mobile = "iPad";
			//were an iPad -- do something here
		}
		else if($Android) {
			$mobile = "Android";
			//were an Android Phone -- do something here
		}
		else if($AndroidTablet) {
			$mobile = "Android Tablet";
			//were an Android Phone -- do something here
		}
		else if($webOS) {
			$mobile = "Google Phone";
			//were a webOS device -- do something here
		}
		else if($BlackBerry) {
			$mobile = "BlackBerry";
			//were a BlackBerry phone -- do something here
		}
		else if($RimTablet) {
			$mobile = "Rim Tablet";
			//were a RIM/BlackBerry Tablet -- do something here
		}
		//$browser = get_browser(null, true);
		//print_r($browser);
		$this->data['browser'] = $browser;
	}
	
	protected function generateKeywordString()
	{
		$keywords = $this->HoopssModel->generateKeywords();
		$keywordCount = 0;
		$keywordString = "";
		$keywordArray = array();
		foreach($keywords as $key=>$value)
		{
			if(!$keywordCount) $keywordString .= $value->keyword;
			else $keywordString .= ",".$value->keyword;
			$keywordCount++;
			array_push($keywordArray, $value->keyword);
		}
		
		return $keywordString;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */