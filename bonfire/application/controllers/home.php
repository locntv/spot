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
		//Call auto checkout
		$this->auto_checkout();
		Template::set('is_spot', true);
		Template::set('page_title', 'Spots');
		Template::render();
	}//end spots()


	/**
	 * Displays the spots page
	 *
	 * @return void
	 */
	public function new_spot()
	{
		$this->load->library('form_validation');

		if ($this->input->post('check_address')) {
			$this->load->model('places/places_model', null, true);
			if ($insert_id = $this->save_places()) {
				//Template::redirect('/home');
				Template::redirect( '/dialog/index?type=add-spot' );
			} else {
				//Template::set('file_error', true);
				Template::set_message(lang('places_create_failure') . $this->places_model->error, 'error');
			}
		}

		// Read our current settings from the application config
		Template::set('spot_type', config_item('spot.type'));
		Template::set('is_new', true);
		Template::set('page_title', 'New spot');
		Template::render();
	}//end spots()

	/**
	 * Displays the map page
	 *
	 * @return void
	 */
	public function map()
	{
		//Call auto checkout
		$this->auto_checkout();
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
		//Call auto checkout
		$this->auto_checkout();

		if ( empty( $place_id ) ){
			$spot = $this->is_checked_in();
			if ( $spot === FALSE ) {
				Template::redirect( '/dialog/index?type=checkin' );
			} else {
				$place_id = $spot->spots_place_id;
			}
		} else {
			$this->load->model('places/spots_model', null, true);

			$this->db->join('places', 'places.id = spots.spots_place_id', 'left');
			$spot = $this->spots_model->select('spots.spots_place_id, spots.is_checkin, places.places_longitude, places.places_latitude')
								->find_by(array(
									'spots_user_id' => $this->current_user->id,
									'spots_place_id' => $place_id
								)
			);
		}

		//Checkout previous spot
		$query_str = "SELECT spots_place_id FROM sp_spots WHERE
					is_checkin = 1 AND spots_user_id = " . $this->current_user->id .
					" AND spots_place_id != {$place_id}";
		$query = $this->db->query($query_str);
		if ($query->num_rows() > 0)
		{
			foreach($query->result_array() as $row)
			{
				$this->checkout($row['spots_place_id'], $this->current_user->id);
			}
		}
		//

		/*$result = array();
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
		Template::set('result', $result);*/
		Template::set('spot', $spot);
		Template::set('page_title', 'People');
		Template::render();
	}//end people()

	/*
		Method: people_ajax()
		Displays a list of form data.
	*/
	public function people_ajax( $place_id = 0 ) {

		$result = array();
		$location_json = '';
		if ( !empty( $place_id ) ) {
			$query_str = "SELECT user.id,user.image,user.first_name,user.last_name,spot.checkin_status
				FROM sp_spots spot left join sp_users user on user.id = spot.spots_user_id
				WHERE spot.spots_place_id = {$place_id}
				AND spot.is_checkin = 1";
			$query = $this->db->query($query_str);
			if ( $query->num_rows() > 0 ) {
				foreach ( $query->result_array() as $row ) {
					$result[] = $row;
				}
			}
			$people_json = json_encode($result);
		}

		/*$flag = false;
		$records = array();
		$location_json = '';
		if ( $this->input->post('lat') && $this->input->post('lng') ) {
			$flag = true;
			$query_str = "SELECT
								id,places_name,places_address,places_type,places_latitude, places_longitude,places_image,
								3956 * 2 * ASIN(SQRT(POWER(SIN(({$this->input->post('lat')}- places_latitude) * pi()/180 / 2), 2) +COS({$this->input->post('lat')} * pi()/180) *COS(places_latitude * pi()/180) *POWER(SIN(({$this->input->post('lng')} -places_longitude) * pi()/180 / 2), 2) )) as distance
							FROM sp_places HAVING distance < 25 ORDER BY distance;";
			$query = $this->db->query($query_str);

			$places = array();
			if ( $query->num_rows() > 0 ) {
				foreach ( $query->result_array() as $row ) {
					$row['distance'] = round($row['distance'],3, PHP_ROUND_HALF_UP);
					$row['people'] = $this->count_opposite_in_place($row['id']);
					$places[] = $row;
				}
				$places_json = json_encode($places);
			}
		}*/

		Template::set('result', $people_json);
		Template::set_view("ajax/index");
		Template::render('ajax');
	}

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
		$this->current_user = $this->user_model->find($this->auth->user_id());
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
	public function pie_icon( $width, $height, $place_id ) {

		//$pie_image = @imagecreatetruecolor($width, $height);
		//$pie_image = @imagecreatetruecolor($width, $height);

		$query_str = "SELECT spot.checkin_status, count(spot.checkin_status) as count
					FROM sp_spots spot, sp_users user
					WHERE spot.spots_place_id = {$place_id}
					AND user.id = spot.spots_user_id
					AND spot.is_checkin = 1
					GROUP BY spot.checkin_status";
		$query = $this->db->query($query_str);
		$checkin_status = array();
		$total = $query->num_rows();
		if ( $total > 0 ) {
			$total_percent = 0;
			$num = 0;
			foreach ( $query->result_array() as $row ) {
				$num++;
				if ( $num == $total ) {
					$checkin_status[$row['checkin_status']] = 100-$total_percent;
				}
				$checkin_status[$row['checkin_status']] = $row['count'] / $total * 100;
			}
		} else {
			$checkin_status[0] = 100;
		}
//var_dump($checkin_status);die;
		/*$arun = 0;
		$a1 = $a2 = $a3 = $a4 = $a5 = 0;
		$white = imagecolorallocate($my_image, 255, 255, 255);
		if ( isset( $checkin_status[1] ) ) {
			$a1 = $arun;
			$a2 = $a1 + ($checkin_status[1]*360/100);
			$red = imagecolorallocate($my_image, 255, 0, 0);
		}
		if ( isset( $checkin_status[2] ) ) {
			if ( $a1 == 0 ) {
				$a1 = $arun;
			}
			$yellow = imagecolorallocate($my_image, 255, 255, 102);
		}
		if ( isset( $checkin_status[3] ) ) {
			$green = imagecolorallocate($my_image, 0, 102, 0);
		}

		$black = imagecolorallocate($my_image, 0, 0, 0);

		// Make the background transparent
		imagecolortransparent($my_image, $black);

		imagefilledarc($my_image, $width/2 - 1, $height/2 - 1, $width - 1, $height - 1, $a1, $a2, $red, IMG_ARC_PIE);
		imagefilledarc($my_image, $width/2 - 1, $height/2 - 1, $width - 1, $height - 1, $a3, $a4 , $yellow, IMG_ARC_PIE);
		imagefilledarc($my_image, $width/2 - 1, $height/2 - 1, $width - 1, $height - 1, $a5, $a6 , $green, IMG_ARC_PIE);


		header("Content-type: image/png");
		imagepng($my_image);

		imagedestroy($my_image);*/
		$this->draw_pie($width, $height, $checkin_status);

		Template::render('api');
	}//end me()

	private function draw_pie($width, $height, $dataArr) {

		$pie_image = imagecreate($width, $height);

		$x = round($width/2)-1;
		$y = round($height/2)-1;
		$total = array_sum($dataArr);
		$angle_start = 0;
		$ylegend = 2;
		$black = imagecolorallocate($pie_image, 0, 0, 0);
		$is_empty = true;

		foreach ( $dataArr as $label => $value ) {

			if ( $label == 1 ) { // red
				$color = imagecolorallocate($pie_image, 255, 0, 0);
			} elseif ($label == 2) { // yellow
				$color = imagecolorallocate($pie_image, 255, 255, 102);
			} elseif ($label == 3) { // green
				$color = imagecolorallocate($pie_image, 128, 255, 0);
			} else { // light blue 173-216-230
				$color = imagecolorallocate($pie_image, 173, 216, 230);
			}
			$angle_done = ($value/$total) * 360; /** angle calculated for 360 degrees */
			$perc       = round(($value/$total) * 100, 1); /** percentage calculated */
			imagefilledarc($pie_image, $x, $y, $width-1, $height-1, $angle_start, $angle_done+= $angle_start, $color, IMG_ARC_PIE);
			$ylegend += 4;
			$angle_start = $angle_done;
		}

		imagecolortransparent($pie_image, $black);
		header("Content-type: image/png");
		imagepng($pie_image);

		imagedestroy($pie_image);
	}
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

		$this->db->join('places', 'places.id = spots.spots_place_id', 'left');
		return $this->spots_model->select('spots.spots_place_id, spots.is_checkin, places.places_longitude, places.places_latitude')
								->find_by(array(
									'spots_user_id' => $this->current_user->id,
									'is_checkin' => 1
								)
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

	public function checkout($place_id){
		$this->load->model('places/spots_model', null, true);
		$this->load->model('places/spots_history_model', null, true);

		$spot = $this->spots_model->find_by(
					array(
						'spots_place_id' => $place_id,
						'spots_user_id' => $this->current_user->id
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


	/**
	 * Auto checkout user after 1 day
	 *
	 */
	private function auto_checkout(){
		if($this->current_user){
			$this->load->model('places/spots_model', null, true);
			$this->load->model('places/spots_history_model', null, true);
			$this->load->helper("date");
			$spot = $this->spots_model->find_by(
					array(
							'is_checkin' => 1,
							'spots_user_id' => $this->current_user->id
					)
			);
			if($spot !== FALSE){
				if(time() > strtotime($spot->checkin_time . " +24 hours" )){
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
		}
	}

	private function save_places($type='insert', $id=0) {

		if ($type == 'update') {
			$_POST['id'] = $id;
		}

		$this->form_validation->set_rules('places_name','Name','required|unique[sp_places.places_name,sp_places.id]|max_length[255]');
		$this->form_validation->set_rules('places_address','Address','required|unique[sp_places.places_address,sp_places.id]|max_length[255]');
		$this->form_validation->set_rules('places_type','Type','required|max_length[255]');
		$this->form_validation->set_rules('places_longitude','longitude','required|max_length[25]');
		$this->form_validation->set_rules('places_latitude','Latitude','required|max_length[25]');

		$is_image = FALSE;
		$is_image_uploaded = TRUE;
		if ($this->form_validation->run() === FALSE )
		{
			return FALSE;
		}

		$data = array();
		$data['places_name']        = $this->input->post('places_name');
		$data['places_address']        = $this->input->post('places_address');
		$data['places_type']        = $this->input->post('places_type');
		$data['places_longitude']        = $this->input->post('places_longitude');
		$data['places_latitude']        = $this->input->post('places_latitude');
		$data['places_image']      = '';
		if( isset($_FILES['places_image']['name']) && $_FILES['places_image']['name'] != ''){
			$this->load->helper('file_upload');
			$file_upload_result = file_upload_image( $_FILES, 'places_image', 'venue', 160, 160 );
			$thumb = $this->input->post('thumb');
			if ( empty( $file_upload_result["error"] ) ) {
				$data['places_image'] = $file_upload_result["data"];
				if ( $type == 'update' && !empty( $thumb ) ) {
					$thumb_arr = explode(".", $thumb);
					delete_file_upload( realpath("assets/images/venue"), $thumb_arr[0] );
				}
			} else {
				return;
				$data['places_image'] = ( !empty( $thumb ) )?$this->input->post('thumb'):'';
			}
		}
		

		if ($type == 'insert')
		{
			$id = $this->places_model->insert($data);

			if (is_numeric($id))
			{
				$return = $id;
			} else
			{
				$return = FALSE;
			}
		}
		else if ($type == 'update')
		{
			$return = $this->places_model->update($id, $data);
		}


		return $return;
	}

}//end class