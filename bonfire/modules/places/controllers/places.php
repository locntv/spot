<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class places extends Front_Controller {

	//--------------------------------------------------------------------


	public function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('places_model', null, true);
		$this->lang->load('places');

	}

	//--------------------------------------------------------------------



	/*
		Method: index()

		Displays a list of form data.
	*/
	public function index()
	{

		$records = $this->places_model->find_all();

		Template::set('records', $records);
		Template::render();
	}

	/*
		Method: places_ajax()
		Displays a list of form data.
	*/
	public function places_ajax() {
		$flag = false;
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
		}

		Template::set('result', $places_json);
		Template::set_view("ajax/index");
		Template::render('ajax');
	}

	//--------------------------------------------------------------------
	private function count_opposite_in_place($place_id=''){
		$result = 0;
		$query_str = "SELECT count(sp_users.id) as count
		FROM sp_spots left join sp_users on sp_spots.spots_user_id = sp_users.id
		WHERE spots_place_id = {$place_id}
		AND sp_users.gender != {$this->current_user->gender}
		AND sp_spots.is_checkin = 1
		GROUP BY sp_users.id";
		$query = $this->db->query($query_str);
		if( $query->num_rows() > 0 ){
			foreach ($query->result_array() as $row){
				$result = $row['count'];
			}
		}

		return $result;
	}
}