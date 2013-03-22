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
		$this->load->model('places/places_model', null, true);
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
		$records = $this->places_model->find_all();
		
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
		$result = array();
		
		//Process validate and save
		if(!isset($_GET['email']) || !isset($_GET['password'])){
			$result['code'] = '100';
		} else {
			$validate = $this->validate_signup($_GET['email'],$_GET['password']);
			if( $validate['status'] == 'error' ){
				$result['code'] = $validate['code'];
			} else {
				$data = array(
						'email'		=> $_GET['email'],
						'password'	=> $_GET['password'],
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
		// dummy data
		$email = isset($_GET['email']) ? $_GET['email'] : '';
		$pass  = isset($_GET['password']) ? $_GET['password'] : '';
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
	public function get_image()
	{
		$arr = array(
				0 => 'kdkd',
				1 => 'fdsdfs'
		);
		Template::set('result', json_encode($arr));
		Template::set_view("api/index");
		Template::render('api');
	}//end index()

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

}//end class