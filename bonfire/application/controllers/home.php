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
		Template::render();
	}//end map()

	/**
	 * Displays the people page
	 *
	 * @return void
	 */
	public function people()
	{
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
		Template::set('page_title', 'Me');
		Template::render();
	}//end me()
	//--------------------------------------------------------------------


}//end class