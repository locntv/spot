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
	
		if (!class_exists('User_model'))
		{
			$this->load->model('users/User_model', 'user_model');
		}
		
		if (!class_exists('Places_model'))
		{
			$this->load->model('places/Places_model', 'place_model');
		}
	
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
		$arr = array(
				0 => 'abc',
				1 => 'cdf'
		);
		Template::set('result', json_encode($arr));
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
		
		$email = "vqdat169@gmail.com";
		$pass  = "123456";
		
		$arr = array(
				0 => 'abc',
				1 => 'cdf'
		);
		Template::set('result', json_encode($arr));
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


}//end class