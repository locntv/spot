<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class content extends Admin_Controller {

	//--------------------------------------------------------------------


	public function __construct()
	{
		parent::__construct();

		$this->auth->restrict('Places.Content.View');
		$this->load->model('places_model', null, true);
		$this->lang->load('places');

		Template::set_block('sub_nav', 'content/_sub_nav');
	}

	//--------------------------------------------------------------------



	/*
		Method: index()

		Displays a list of form data.
	*/
	public function index()
	{

		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$result = $this->places_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('places_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('places_delete_failure') . $this->places_model->error, 'error');
				}
			}
		}

		$records = $this->places_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Places');
		Template::render();
	}

	//--------------------------------------------------------------------



	/*
		Method: create()

		Creates a Places object.
	*/
	public function create()
	{
		$this->auth->restrict('Places.Content.Create');

		if ($this->input->post('save'))
		{
			if ($insert_id = $this->save_places())
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('places_act_create_record').': ' . $insert_id . ' : ' . $this->input->ip_address(), 'places');

				Template::set_message(lang('places_create_success'), 'success');
				Template::redirect(SITE_AREA .'/content/places');
			}
			else
			{
				Template::set_message(lang('places_create_failure') . $this->places_model->error, 'error');
			}
		}
		Assets::add_module_js('places', 'places.js');
		Template::set( 'folder_name', 'venue' );
		Template::set('google_map', true);
		Template::set('toolbar_title', lang('places_create') . ' Places');
		Template::render();
	}

	//--------------------------------------------------------------------



	/*
		Method: edit()

		Allows editing of Places data.
	*/
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('places_invalid_id'), 'error');
			redirect(SITE_AREA .'/content/places');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Places.Content.Edit');

			if ($this->save_places('update', $id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('places_act_edit_record').': ' . $id . ' : ' . $this->input->ip_address(), 'places');

				Template::set_message(lang('places_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('places_edit_failure') . $this->places_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Places.Content.Delete');

			if ($this->places_model->delete($id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('places_act_delete_record').': ' . $id . ' : ' . $this->input->ip_address(), 'places');

				Template::set_message(lang('places_delete_success'), 'success');

				redirect(SITE_AREA .'/content/places');
			} else
			{
				Template::set_message(lang('places_delete_failure') . $this->places_model->error, 'error');
			}
		}
		Template::set('places', $this->places_model->find($id));
		Assets::add_module_js('places', 'places.js');
		Template::set( 'folder_name', 'venue' );
		Template::set('toolbar_title', lang('places_edit') . ' Places');
		Template::render();
	}

	//--------------------------------------------------------------------


	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------

	/*
		Method: save_places()

		Does the actual validation and saving of form data.

		Parameters:
			$type	- Either "insert" or "update"
			$id		- The ID of the record to update. Not needed for inserts.

		Returns:
			An INT id for successful inserts. If updating, returns TRUE on success.
			Otherwise, returns FALSE.
	*/
	private function save_places($type='insert', $id=0)
	{
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
			$data['places_image'] = ( !empty( $thumb ) )?$this->input->post('thumb'):'';
		}

		/*else {
			if(isset($_FILES['places_image']['name']) && $_FILES['places_image']['name'] != ''){
				$is_image = TRUE;
				$config['upload_path'] 	= ASSET_PATH.'images/venue';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size']	= '1024';
				$config['max_width']  = '1024';
				$config['max_height']  = '768';

				$this->load->library('upload', $config);
				if(!$this->upload->do_upload("places_image")){
					$error = array('errors' => $this->upload->display_errors());
					//$this->load->view('upload', $error);
					Template::set('image_error', $error);
					return FALSE;
				}
			}
		}*/

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

	//--------------------------------------------------------------------



}