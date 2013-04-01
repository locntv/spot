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
class Home extends Front_Controller
{

	public function __construct()
	{
		parent::__construct();
		if(!isset($this->current_user)){
			Template::redirect("/login");
		}

	}//end __construct()

	/**
	 * Displays the spots page
	 *
	 * @return void
	 */
	public function index()
	{
		Template::set('page_title', 'Spots');
		Template::render();
	}//end spots()

	/**
	 * Displays the map page
	 *
	 * @return void
	 */
	public function map()
	{
		Template::set('page_title', 'Map');
		Template::set('refresh', true);
		Template::render('index_fullscreen');
	}//end map()

	/**
	 * Displays the people page
	 *
	 * @return void
	 */
	public function people( $place_id = 0 )
	{
		if ( $this->auth->is_logged_in() === FALSE ) {
			Template::redirect( '/dialog/index?type=register' );
		}
		$spot = $this->is_checked_in();
		if ( $spot === FALSE ) {
			Template::redirect( '/dialog/index?type=checkin' );
		} else {
			$place_id = $spot->spots_place_id;
		}

		//Checkout previous spot
		$query_str = "SELECT spots_place_id FROM sp_spots WHERE
					is_checkin = 1 AND spots_user_id = {$this->current_user->id}
					AND spots_place_id != {$place_id}";
		$query = $this->db->query($query_str);
		if ($query->num_rows() > 0)
		{
			foreach($query->result_array() as $row)
			{
				$this->checkout($row['spots_place_id'], $this->current_user->id);
			}
		}
		//

		$result = array();

		$query_str = "SELECT user.id,user.image,user.first_name,user.last_name,spot.checkin_status
			FROM sp_spots spot left join sp_users user on user.id = spot.spots_user_id
			WHERE spot.spots_place_id = {$place_id}
			AND spot.is_checkin = 1";
		$query = $this->db->query($query_str);
		if ($query->num_rows() > 0)
		{
			foreach($query->result_array() as $row)
			{
				$result[] = $row;
			}
		}

		Template::set('result', $result);
		Template::set('page_title', 'People');
		Template::render();
	}//end people()

	/**
	 * Displays the me page
	 *
	 * @return void
	 */
	public function me()
	{
		$this->load->helper('form');
		if ( $this->auth->is_logged_in() === FALSE ) {
			Template::redirect( '/dialog/index?type=register' );
		}
		$checkin = 0;
		$error = array();
		if ($this->input->post('submit')) {
			if(isset($_FILES['user_image']['name']) && $_FILES['user_image']['name'] !=''){
				$this->load->helper('file_upload');
				$file_upload_result = file_upload_image( $_FILES, 'user_image', 'user', 128, 128 );
				$thumb = $this->input->post('thumb');
				if ( empty( $file_upload_result["error"] ) ) {
					$data['user_image'] = $file_upload_result["data"];
					if ( $type == 'update' && !empty( $thumb ) ) {
						$thumb_arr = explode(".", $thumb);
						delete_file_upload( realpath("assets/images/user"), $thumb_arr[0] );
					}
				} else {
					$data['user_image'] = ( !empty( $thumb ) )?$this->input->post('thumb'):'';
					$error['image'] = $file_upload_result["error"];
				}
	
				if (!empty($data['user_image'])) {
					$this->user_model->update($this->current_user->id,
						array('image' => $data['user_image'])
					);
				}
			}
			$pass = trim($this->input->post('user-pass'));
			if( !empty($pass) ){
				if(strlen($pass) >= 8){
					$this->user_model->update($this->current_user->id,
							array('password' => $pass,'pass_confirm'=>$pass)
					);
				} else {
					$error['pass'] = 'Please input password from 8 characters';
				}
			}
		}

		$query_str = "SELECT count(history.id) as count
							FROM sp_users user, sp_spots as spot, sp_spots_history as history
							WHERE user.id = spot.spots_user_id
							AND spot.id = history.spots_id
							AND spot.spots_user_id = {$this->current_user->id}";
		$query = $this->db->query($query_str);
		if ($query->num_rows() > 0)
		{
			$checkin = $query->result();
		}
		Template::set('checkin', $checkin[0]);
		Template::set('user', $this->current_user);
		Template::set('error', $error);
		Template::set('page_title', 'Me');
		Template::render();
	}//end me()

	/**
	 * Displays the me page
	 *
	 * @return void
	 */
	public function pie_icon( $width, $height ) {
		$my_image = @imagecreatetruecolor($width, $height);

		$white = imagecolorallocate($my_image, 255, 255, 255);
		$red  = imagecolorallocate($my_image, 255, 0, 0);
		$green = imagecolorallocate($my_image, 0, 102, 0);
		$yellow = imagecolorallocate($my_image, 255, 255, 102);
		$black = imagecolorallocate($my_image, 0, 0, 0);

		// Make the background transparent
		imagecolortransparent($my_image, $black);

		imagefilledarc($my_image, $width/2 - 1, $height/2 - 1, $width - 1, $height - 1, 0, 90, $red, IMG_ARC_PIE);
		imagefilledarc($my_image, $width/2 - 1, $height/2 - 1, $width - 1, $height - 1, 90, 180 , $green, IMG_ARC_PIE);
		imagefilledarc($my_image, $width/2 - 1, $height/2 - 1, $width - 1, $height - 1, 180, 360 , $yellow, IMG_ARC_PIE);

		header("Content-type: image/png");
		imagepng($my_image);

		imagedestroy($my_image);
		Template::render('api');
	}//end me()
	//--------------------------------------------------------------------

/**
	 * checkin before access people page
	 * @return
	 *  0 : not checkin and distance is far than allowed
	 *  1 : not checkin and distance is allowed
	 *  2 : checked in and distance is allowed
	 */
	public function checkin(){
		$result = array();

		if ( $this->input->post('lat') && $this->input->post('lng') && $this->input->post('place_id') ) {
			$this->load->model('places/places_model', null, true);
			$this->load->library('utils');
			$place = $this->places_model->find($this->input->post('place_id'));
			$distance = $this->utils->get_distance_between_points(
					$this->input->post('lat'), $this->input->post('lng'),
					$place->places_latitude, $place->places_longitude, 'Mi' );
			$is_checkin = $this->is_checkin($this->input->post('place_id'), $this->current_user->id);
			//$this->current_user->id
			if($place !== FALSE){ // Place is not existed
				$result['place_name'] = $place->places_name;
				if($distance <= 1 && $is_checkin === TRUE){ // In allowed distance and has checked in
					$result['code'] = 2;
				} else if($distance > 1) {
					if($is_checkin === TRUE){
						$this->checkout($this->input->post('place_id'), $this->current_user->id);
					}
					$result['code'] = 0;
				} else if($distance <=1 && $is_checkin === FALSE){
					$result['code'] = 1;
				}
			}
		}
		echo json_encode($result);
		die;
		/*Template::set('result', json_encode($result));
		Template::set_view("ajax/index");
		Template::render('ajax');*/
	}

	//
	public function process_checkin(){
		if ( $this->input->post('checkin-status') && $this->input->post('place_id') ) {
			$this->load->model('places/spots_model', null, true);
			$this->load->model('places/spots_history_model', null, true);

			$spot = $this->spots_model->find_by( array(
					'spots_user_id' => $this->current_user->id,
					'spots_place_id' => $this->input->post('place_id'),
			));
			if ( $spot === FALSE ) {
				if($spot_id = $this->spots_model->insert(
						array(
								'spots_user_id' => $this->current_user->id,
								'spots_place_id'=> $this->input->post('place_id'),
								'checkin_status'=> $this->input->post('checkin-status'),
								'is_checkin'	=> 1,
								'checkin_time'	=> date('Y-m-d H:i:s'))) !== FALSE
						){
							//Insert spots history
							$this->spots_history_model->insert(
									array(
										'spots_id' => $spot_id,
										'checkin_status'=> $this->input->post('checkin-status'),
										'checkin_time'	=> date('Y-m-d H:i:s')
										)
							);
				}
			} else {
				$sql = "UPDATE sp_spots SET is_checkin = 1, checkin_time = NOW(),checkin_status = {$this->input->post('checkin-status')}
						WHERE spots_user_id = {$this->current_user->id} AND spots_place_id = {$this->input->post('place_id')}";
				$query = $this->db->query($sql);
				if ( $query === TRUE) {
				//Insert spots history
					$this->spots_history_model->insert(
							array(
									'spots_id' => $spot->id,
									'checkin_status'=> $this->input->post('checkin-status'),
									'checkin_time'	=> date('Y-m-d H:i:s')
							)
					);
				}
			}

			//Checkout previous spot
			/*$query_str = "SELECT spots_place_id FROM sp_spots WHERE
						is_checkin = 1 AND spots_user_id = {$this->current_user->id}
						AND spots_place_id != {$this->input->post('place_id')}";
			$query = $this->db->query($query_str);
			if ($query->num_rows() > 0)
			{
				foreach($query->result_array() as $row)
				{
					$this->checkout($row['spots_place_id'], $this->current_user->id);
				}
			}*/
			// Redirect to people page
			Template::redirect( '/home/people/'.$this->input->post('place_id') );
		}
	}

	public function is_checked_in(){
		$result = array();
		$this->load->model('places/spots_model', null, true);
		return $this->spots_model->find_by(
				array('spots_user_id'=>$this->current_user->id,'is_checkin' => 1)
		);
// 		if($spot = $this->spots_model->find_by(
// 				array('spots_user_id'=>$this->current_user->id,'is_checkin' => 1)
// 				) !== FALSE){
// 			$result['code'] = 1;
// 			$result['place_id'] = $spot->spots_place_id;
// 		} else {
// 			$result['code'] = 0;
// 		}

// 		echo json_encode($result);
// 		die;
	}

	private function is_checkin($place_id, $user_id){
		$this->load->model('places/spots_model', null, true);
		$spot = $this->spots_model->find_by(array(
					'spots_place_id' => $place_id,
					'spots_user_id'  => $user_id,
					'is_checkin'	=> 1));
		if($spot !== FALSE){
			return TRUE;
		} else {
			return FALSE;
		}
		return FALSE;
	}

	function checkout($place_id, $user_id){
		$this->load->model('places/spots_model', null, true);
		$this->load->model('places/spots_history_model', null, true);

		$spot = $this->spots_model->find_by(
					array(
						'spots_place_id' => $place_id,
						'spots_user_id' => $user_id
						)
				);
		if($spot !== FALSE){
			// Checkout spot
			$this->spots_model->update($spot->id,
							array('checkout_time' => date('Y-m-d H:i:s'),
								'is_checkin' => 0));
			// Update history
			$spot_history_id = $this->spots_history_model->select('id')->order_by('id','desc')->find_by('spots_id',$spot->id);
			if($spot_history_id !== FALSE){
				$spot_history_id = $spot_history_id->id;
				$this->spots_history_model->update($spot_history_id,array(
						'checkout_time'	=> date('Y-m-d H:i:s')
				));
			}
		}
	}


}//end class