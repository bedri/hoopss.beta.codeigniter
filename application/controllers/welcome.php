<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends MY_Controller {

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
	}
	
	public function index()
	{	
		$randomKeyword = $this->HoopssModel->generateRandomKeyword();
		$this->data['randomKeyword'] = $randomKeyword[0]->keyword;

		$keywordString = $this->generateKeywordString();
		$this->data['keywordString'] = $keywordString;

		$this->data['keyword'] = "";
		
		$this->load->view("header",$this->data);
		$this->load->view('welcome',$this->data);
		$this->load->view("footer",$this->data);
	}
	
	}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */