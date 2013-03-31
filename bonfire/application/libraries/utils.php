<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Utils Class
 *
 * The Utils class works with utilities functionality of project.
 *
 * @package    Project lib
 * @subpackage Libraries
 * @category   Libraries
 * @author     Ronnie
 * @version    1.0
 *
 */
class Utils
{
    /**
     * For calculating the distance between two points
     *
     * @access public
     *
     * @param bool $include TRUE to include (default) or FALSE to exclude
     */
    public static function get_distance_between_points($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'Mi')
    {
        $theta = $longitude1 - $longitude2;
        $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
        $distance = acos($distance); $distance = rad2deg($distance);
        $distance = $distance * 60 * 1.1515;
        switch ( $unit ) {
            case 'Mi':
                break;
            case 'Km' :
                $distance = $distance * 1.609344;
        }
        return ( round( $distance, 2 ) );
    }//end get_distance_between_points()
}