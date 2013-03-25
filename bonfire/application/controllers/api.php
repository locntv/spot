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
		
		$this->red_status 		= 1;
		$this->yellow_status 	= 2;
		$this->green_status		= 3;	
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
		if(    !isset($_POST['email']) || empty($_POST['email'])
			|| !isset($_POST['password']) || empty($_POST['password'])
			|| !isset($_POST['first_name']) || empty($_POST['first_name'])
			|| !isset($_POST['last_name']) || empty($_POST['last_name'])
			|| !isset($_POST['gender']) ){
			$result['code'] = '100';
		} else {
			$validate = $this->validate_signup($_POST['email'],$_POST['password']);
			if( $validate['status'] == 'error' ){
				$result['code'] = $validate['code'];
			} else {
				$is_image_uploaded = TRUE;
				$is_image		   = FALSE;
				if($_FILES['image']['name'] != ''){
					$is_image 				= TRUE;
					$config['upload_path'] 	= ASSET_PATH.'images/user';
					$config['allowed_types']= 'gif|jpg|png';
					$config['max_size']		= '1024';
					$config['max_width']  	= '128';
					$config['max_height']  	= '128';
				
					$this->load->library('upload', $config);
					if(!$this->upload->do_upload("image")){
						//$error = array('errors' => $this->upload->display_errors());
						$is_image_uploaded = FALSE;
					}
				}
				$data = array(
						'first_name'=> $_POST['first_name'],
						'last_name'	=> $_POST['last_name'],
						'email'		=> $_POST['email'],
						'password'	=> $_POST['password'],
						'gender'	=> $_POST['gender'],
						'active'	=> 1
				);
				if($is_image_uploaded == FALSE){
					$result['code'] = '103';
				} else {
					if($user_id = $this->user_model->insert($data)){
						$image_name = $user_id."_imageprofile.png";
						$command = "mv {$config['upload_path']}/{$_FILES['image']['name']}  {$config['upload_path']}/{$image_name}";
						@shell_exec($command);
 						//Assets::assets_url('image')."/user/".$user_id."_imageprofile.png";
						if($this->user_model->update($user_id, array(
								'image' => Assets::assets_url('image')."/user/".$user_id."_imageprofile.png")
											  ) ){
							$result['code'] = '200';
							$result['user_id'] = $user_id;
						} else {
							$result['code'] = '102';
						}
					}else {
						$result['code'] = '102';
					}
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
			$result['user_id'] = $this->auth->user_id();
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
		$result = array();
		if(!isset($_POST['longitude']) || !isset($_POST['latitude'])
			|| !isset($_POST['user_id']) ){
			$result['code'] = '100';
		} else {
			$user = $this->user_model->find($_POST['user_id']);
			if( $user !== FALSE){
				$query_str = "SELECT
								id,places_name,places_address,places_type,places_latitude, places_longitude,places_image,
								SQRT( POW(69.1 * (places_latitude - {$_POST['latitude']}), 2) +
									  POW(69.1 * ({$_POST['longitude']} - places_longitude) * COS(places_latitude / 57.3), 2)
								) AS distance
							  FROM sp_places HAVING distance < 0.1 ORDER BY distance;";
				$user_gender = $user->gender; // default is female
				$result = array();
					
				$query = $this->db->query($query_str);
				if ($query->num_rows() > 0)
				{
					foreach($query->result_array() as $row)
					{
						//$row['people'] = $this->get_list_user_in_venue($row['id'],$user_gender);
						$row['people'] = $this->get_status_in_venue($_POST['user_id'], $row['id'], $user_gender);
						$result [] = $this->build_data_venue($row);
					}
					$result['code'] = 200;
				}
			} else {
				$result['code'] = '101';
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
	
	public function checkout(){
		$this->write_log_for_request("profile");
		
		$user_id = '1';
		$place_id = '1';
		$curtime = date('Y-m-d H:i:s');
		$sql	= "UPDATE sp_spots SET is_checkin =0,checkout_time='{$curtime}'
					WHERE spots_user_id = {$user_id} AND spots_user_id = {$place_id}";
		$query = $this->db->query($sql);
		Template::set('result', json_encode($query));
		Template::set_view("api/index");
		Template::render('api');
	}
	
	//--------------------------------------------------------------------

	/**
	 * Validate sign up 
	 * 
	 */
	private function validate_signup($email='', $password=''){
		$user = $this->user_model->find_by('email', $_POST['email']);
		if($user !== FALSE){ // user has existed
			return array(
				'status'=>'error'
			   ,'code' => '101'); 
		}
		return array(
				'status'=>'success');
	}
	
	/**
	 * Get list user in a venue, just get opposite gender 
	 * @param place_id : id of place
	 * @param gender   : gender of user
	 */
	private function get_list_user_in_venue($place_id='', $gender= 0){
		$result = array();
		$query_str = "SELECT sp_users.id, sp_spots.checkin_status
					  FROM 	sp_users , sp_spots 
					  WHERE spots_place_id = {$place_id}
					  AND (	
					  		(spots_user_id = sp_users.id) 
					  		OR
					  		(sp_users.gender != {$gender} AND is_checkin = 1)
					  	)";
		$query = $this->db->query($query_str);
		if( $query->num_rows() > 0 ){
			foreach ($query->result_array() as $row){
				$result [] = array(
						'user_id' 	=> $row['id'],
						//'image'		=> $row['image'],
						'status'	=> $row['checkin_status']
				);
			}
		}
		
		return $result;
	}
	
	/**
	 * Get list user in a venue, just get opposite gender
	 * @param place_id : id of place
	 * @param gender   : gender of user
	 */
	private function get_status_in_venue($user_id, $place_id='', $gender= 0){
		$result = array();
		$result['red'] = 0;
		$result['yellow'] = 0;
		$result['green'] = 0;
		$query_str = "SELECT checkin_status, count(checkin_status)
						FROM 	sp_spots , sp_users
						WHERE spots_place_id = {$place_id}
						AND sp_users.id = spots_user_id
						AND spots_user_id != {$user_id}
						AND sp_users.gender != {$gender} 
						AND is_checkin = 1
						GROUP BY checkin_status
					";
		$query = $this->db->query($query_str);
		if( $query->num_rows() > 0 ){
			foreach ($query->result_array() as $row){
				switch ($row['checkin_status'] ){
					case $this->red_status:
						$result['red']++;
						break;
					case $this->yellow_status:
						$result['yellow']++;
						break;
					case $this->green_status:
						$result['green']++;
						break;
				}
				
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
					'longitude' => $data['places_longitude'],
					'latitude'	=> $data['places_latitude'],
					'type'		=> $data['places_type'],
					'image'		=> $data['places_image'],
					'people'	=> $data['people']
				);
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