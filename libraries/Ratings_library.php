<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Ratings Library
*
* @package		Social Igniter
* @subpackage	Ratings Library
* @author		Localhost
*
* Contains methods for Ratings App
*/

class Ratings_library
{
	function __construct()
	{
		// Global CodeIgniter instance
		$this->ci =& get_instance();
		
		$this->ci->load->model('ratings/ratings_model');		

	}
	
	/* Interact with Data_Model */
	/* Ratings */
	function get_ratings($content_id)
	{
		return $this->ci->ratings_model->get_ratings($content_id);
	}

	function get_ratings_view($parameter, $value)
	{
		return $this->ci->ratings_model->get_ratings_view($parameter, $value);
	}
	
	function get_ratings_likes_user($user_id)
	{
		return $this->ci->ratings_model->get_ratings_likes_user($user_id);
	}
	
	function check_rating($rating_data)
	{
		return $this->ci->ratings_model->check_rating($rating_data);
	}
	
	function add_rating($rating_data)
	{
		return $this->ci->ratings_model->add_rating($rating_data);
	}

}