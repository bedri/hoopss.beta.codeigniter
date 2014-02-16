<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/Login
	 *	- or -  
	 * 		http://example.com/index.php/Login/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/Login/<method_name>
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
		$jsonArray = array("success"=>0, "data"=> "", "message"=>"");
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		$results = $this->HoopssModel->getUserData($username);
		if($results[0]->password == $password && $results[0]->enabled)
		{
			$jsonArray['success'] = 1;
			$city = $this->HoopssModel->getCity($results[0]->city_id);
			$userdata = array(
					'username'  => $username,
					'name'     => $results[0]->name,
					'surname'     => $results[0]->surname,
					'sex'     => $results[0]->sex,
					'date_of_birth'     => $results[0]->date_of_birth,
					'phone'     => $results[0]->phone,
					'address'     => $results[0]->address,
					'postcode'     => $results[0]->postcode,
					'city'     => $city[0]->name,
					'logged_in' => TRUE
			);
			$jsonArray['data'] = array(
					'username'  => $username,
					'name'     => $results[0]->name,
					'surname'     => $results[0]->surname,
					'sex'     => $results[0]->sex,
					'date_of_birth'     => $results[0]->date_of_birth,
					'phone'     => $results[0]->phone,
					'address'     => $results[0]->address,
					'postcode'     => $results[0]->postcode,
					'city'     => $city[0]->name
			);
			
			$this->session->set_userdata($userdata);
		}
		echo json_encode($jsonArray);
		exit();
	}
	
}

/* End of file Login.php */
/* Location: ./application/controllers/login.php */