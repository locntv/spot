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
class Dialog extends Front_Controller
{

	/**
	 * Displays the spots page
	 *
	 * @return void
	 */
	public function index()
	{
		$type = $this->input->get('type');
		switch ($type) {
			case 'register':
				$dialog = array(
					'content' => 'You have to login first before go to this page',
					'callback' => array(
						'name' => 'Go to home',
						'url' => 'home'
					),
					'goto' => array(
						'name' => 'Login',
						'url' => 'login'
					)
				);
				Template::set('dialog', $dialog);
				Template::set('dialog_title', 'Error');
				break;
			case 'checkin':
				$dialog = array(
						'content' => 'You have to check in one spot first before go to this page',
						'goto' => array(
								'name' => 'Back To Spots',
								'url' => 'home'
						)
				);
				Template::set('dialog', $dialog);
				Template::set('dialog_title', 'Notice');
			break;
			case 'add-spot':
				$dialog = array(
					'content' => 'Place created successfully',
					'goto' => array(
							'name' => 'Back To Spots',
							'url' => 'home'
					)
				);
				Template::set('dialog', $dialog);
				Template::set('dialog_title', 'Notice');
			break;
		}

		Template::set('page_title', 'Spots');
		Template::render('dialog');
	}//end spots()

	//--------------------------------------------------------------------


}//end class