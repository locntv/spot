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

}