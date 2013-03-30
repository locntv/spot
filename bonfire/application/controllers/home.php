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
		/*$result = array();
		if(!isset($_POST['place_id']) || !is_numeric($_POST['place_id'])
				|| !isset($_POST['user_id']) || !is_numeric($_POST['user_id'])){
			$result['code'] = '100';
		} else {
			$user = $this->user_model->find($_POST['user_id']);
			if($user !== FALSE){
				$query_str = "SELECT user.id,user.image,user.first_name,user.last_name,spot.checkin_status
					FROM sp_users user, sp_spots spot
					WHERE user.id = spot.spots_user_id
					AND	spot.spots_place_id = {$_POST['place_id']}
					AND user.id != {$_POST['user_id']}";
				$query = $this->db->query($query_str);
				if ($query->num_rows() > 0)
				{
					foreach($query->result_array() as $row)
					{
						$result ['data'][] = $row;
					}
					$result['code'] = '200';
				} else {
					$result['code'] = '102';
				}
			} else {
				$result['code'] = '101';
			}
		}*/


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
		if ( $this->auth->is_logged_in() === FALSE ) {
			Template::redirect( '/dialog/index?type=register' );
		}
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


}//end class