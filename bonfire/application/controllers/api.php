<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Bonfire
 *
 * An open source project to allow developers get a jumpstart their development of CodeIgniter applications
 *
 * @package   Bonfire
 * @author    Bonfire Dev Team
 * @copyright Copyright (c) 2011 - 2012, Bonfire Dev Team
 * @license   http://guides.cibonfire.com/license.html
 * @link      http://cibonfire.com
 * @since     Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Home controller
 *
 * The base controller which displays the homepage of the Bonfire site.
 *
 * @package    Bonfire
 * @subpackage Controllers
 * @category   Controllers
 * @author     Bonfire Dev Team
 * @link       http://guides.cibonfire.com/helpers/file_helpers.html
 *
 */
class Api extends Front_Controller
{

	/**
	 * Setup the required libraries etc
	 *
	 * @retun void
	 */
	public function __construct()
	{
		parent::__construct();
		$config =& get_config();
		
		$this->_log_path = APPPATH.'logs/api/';
		$this->load->model('places/places_model', null, true);
		$this->load->model('places/spots_model', null, true);
		$this->load->database();
		$this->load->library('users/auth');
	}//end __construct()
	
	/**
	 * Displays the homepage of the Bonfire app
	 *
	 * @return void
	 */
	public function index()
	{
		$records = $this->spots_model->find_all();
		
		$arr = array(
			0 => 'abc',
			1 => 'cdf'
		);
		Template::set('result', json_encode($records));
		Template::render('api');
	}//end index()
	
	/**
	 * Receive request from app to sign up
	 *
	 * @return void
	 */
	public function signup()
	{
		//Assign variable
		$this->write_log_for_request("signup");
		$result = array();
		
		//Process validate and save
		if(!isset($_POST['email']) || !isset($_POST['password'])){
			$result['code'] = '100';
		} else {
			$validate = $this->validate_signup($_POST['email'],$_POST['password']);
			if( $validate['status'] == 'error' ){
				$result['code'] = $validate['code'];
			} else {
				$data = array(
						'email'		=> $_POST['email'],
						'password'	=> $_POST['password'],
						'active'	=> 1
				);
				if($user_id = $this->user_model->insert($data)){
					$result['code'] = '200';
				}else {
					$result['code'] = '104';
				}
			}
		}
		
		//render json
		Template::set('result', json_encode($result));
		Template::set_view("api/index");
		Template::render('api');
	}//end index()
	
	/**
	 * Receive request from appp to login
	 *
	 * @return void
	 */
	public function signin()
	{	
		$this->write_log_for_request("signin");
		// dummy data
		$email = isset($_POST['email']) ? $_POST['email'] : '';
		$pass  = isset($_POST['password']) ? $_POST['password'] : '';
		$result = array();
		
		if($this->auth->login($email,$pass,false)){
			$result['code'] = 200;
		} else {
			$result['code'] = 100;
		}
		
		Template::set('result', json_encode($result));
		Template::set_view("api/index");
		Template::render('api');
	}//end index()
	
	/**
	 * Displays the homepage of the Bonfire app
	 *
	 * @return void
	 */
	public function spots()
	{
		$this->write_log_for_request("spots");
		/*SELECT latitude, longitude, SQRT(
				POW(69.1 * (latitude - [startlat]), 2) +
				POW(69.1 * ([startlng] - longitude) * COS(latitude / 57.3), 2)) AS distance
				FROM TableName HAVING distance < 25 ORDER BY distance;*/
		$query_str = "SELECT * FROM sp_places ";
		$email = 'me@home.com';
		$user_gender = $this->get_gender($email); // default is female
		$result = array();
		
		$query = $this->db->query($query_str);
		if ($query->num_rows() > 0)
            {
                foreach($query->result_array() as $row)
                {
                	$row['people'] = $this->get_list_user_in_venue($row['id'],$user_gender);
                    $result [] = $this->build_data_venue($row);
                }
            }
		Template::set('result', json_encode($result));
		Template::set_view("api/index");
		Template::render('api');
	}//end spots()
	
	
	public function people()
	{
		$this->write_log_for_request("people");
		// dummy data
		$user_id = '2';
		$places_id = '1';
		$status_checkin = '1';
		$gender	= '1';
		
		$result = array();
		if($spot_id = $this->spots_model->insert(array(
					'spots_user_id' => $user_id,
					'spots_place_id'=> $places_id,
					'checkin_status'=> $status_checkin,
					'is_checkin'	=> 1,
					'checkin_time'	=> date('Y-m-d H:i:s')	
				)) ){
			$query_str = "SELECT user.id,user.image,user.email  
						  FROM sp_users user, sp_spots spot 
						  WHERE user.id = spot.spots_user_id 
						  AND	spot.spots_place_id = {$places_id} 
						  AND	user.gender != {$gender}
						  AND 	user.id != {$user_id}";
			
			$query = $this->db->query($query_str);
			if ($query->num_rows() > 0)
			{
				foreach($query->result_array() as $row)
				{
					$result [] = $row;
				}
			}
		} else {
			
		}
		Template::set('result', json_encode($result));
		Template::set_view("api/index");
		Template::render('api');
	}//end people()

	public function profile()
	{
		$this->write_log_for_request("profile");
		// dummy data
		$user_id = '2';
		$checkin_times = $this->spots_model->count_by('spots_user_id',$user_id);	
		$result = array();
		$result['count'] = $checkin_times;
		Template::set('result', json_encode($result));
		Template::set_view("api/index");
		Template::render('api');
	}//end people()
	
	//--------------------------------------------------------------------

	/**
	 * Validate sign up 
	 * 
	 */
	private function validate_signup($email='', $password=''){
		return array(
				'status'=>'success'
			   ,'code' => '200');
	}
	
	/**
	 * Get list user in a venue, just get opposite gender 
	 * @param place_id : id of place
	 * @param gender   : gender of user
	 */
	private function get_list_user_in_venue($place_id='', $gender= 0){
		$result = array();
		$query_str = "SELECT email, image, checkin_status
					  FROM 	sp_users , sp_spots 
					  WHERE spots_place_id = {$place_id}
					  AND 	spots_user_id = sp_users.id
					  AND	sp_users.gender != {$gender}
					  AND 	is_checkin = 1";
		$query = $this->db->query($query_str);
		if( $query->num_rows() > 0 ){
			foreach ($query->result_array() as $row){
				$result [] = array(
						'email' 	=> $row['email'],
						'image'		=> $row['image'],
						'status'	=> $row['checkin_status']
				);
			}
		}
		
		return $result;
	}
	
	/**
	 * Build data from db to array based on JSON format 
	 * @param data : data from query database
	 */
	private function build_data_venue($data){
		return array(
					'name' 		=> $data['places_name'],
					'address'	=> $data['places_address'],
					'longtitude'=> $data['places_longtitude'],
					'latitude'	=> $data['places_latitude'],
					'type'		=> $data['places_type'],
					'image'		=> $data['places_image'],
					'people'	=> $data['people']
				);
	}
	
	private function get_gender($email){
		$user = $this->user_model->find_by('email',$email);
		if($user){
			return $user->gender;
		}
		return 0;
	}
	
	
	/**
	 * Write log for each request to api 
	 * @param funciton : name of api called
	 */
	private function write_log_for_request($function='index'){
		$message = "Receive request ". date('Y-m-d H:i:s');
		foreach( $_POST as $key=>$value){
			$message .= $key . "-" . $_POST[ $key ] ."\n";
		}
		$message .= "\n";
		$filepath = $this->_log_path. $function .'/' .date('Y-m-d').'.txt';
		$this->write_log($filepath,$message);
	}
	
	/**
	 * Write log to file 
	 * 
	 */
	private function write_log($filepath, $message){
		if(!file_exists($filepath)){//file not exist
			$info = pathinfo($filepath);
		
			@mkdir($info['dirname'], 0777, true);
		}
		$fh = fopen($filepath, 'a');

	    fwrite($fh, $message);
	    fclose($fh);
	}

}//end class